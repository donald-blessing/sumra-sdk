<?php

namespace Sumra\SDK;

use App\Api\V1\Resources\CategoryResource;
use App\Model\GetIp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use JsonSerializable;
use Traversable;

class JsonApiResponse extends JsonResponse
{
    protected array $included = [];

    /**
     * JsonApiResponse constructor.
     *
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     */
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $headers['Content-Type'] = 'application/vnd.api+json';

        parent::__construct($data, $status, $headers, $options);
    }

    /**
     * Sets the data to be sent as API JSON.
     *
     * @param array $data
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setData($data = [])
    {
        $data = $this->serializeData($data);

        return parent::setData($data);
    }

    /**
     * @param array|Collection|Model $data
     *
     * @return mixed
     */
    public function serializeData($data)
    {
        /*$output = [
            'code' => $this->getStatusCode(),
        ];*/

        if (is_array($data) && isset($data['error'])) {
            if ($data['error'] instanceof JsonSerializable) {
                $error = $data['error']->jsonSerialize();
                $error['status'] = $this->getStatusCode();
                $output['errors'] = [$error];

                return $output;
            }

            if (is_string($data['error'])) {
                $output['status'] = !is_int($this->getStatusCode()) ? $this->getStatusCode() : false;
                $output['error']['message'] = $data['error'];

                return $output;
            }
        } elseif (is_array($data) && isset($data['errors'])) {
            if ($data['errors'] instanceof JsonSerializable) {
                $error = $data['error']->jsonSerialize();
                $error['status'] = $this->getStatusCode();
                $output['errors'] = [$error];

                return $output;
            }

            if (is_string($data['errors'])) {
                $output['errors']['message'] = $data['errors'];
                $output['status'] = !is_int($this->getStatusCode()) ? $this->getStatusCode() : false;

                return $output;
            }
        } elseif ($data instanceof Model) {
            $output['data'] = $this->serializeModel($data);

            return $this->mergeIncluded($output);
        } elseif ($data instanceof AbstractPaginator) {
            return $this->serializePaginator($data);

        } elseif (is_array($data) || $data instanceof Traversable) {
            if (isset($data['data'])) {
                if ($data['data'] instanceof LengthAwarePaginator) {
                    // fix problem with pagination
                    $output = $this->serializeData($data['data']);
                    $output['success'] = true;

                    return $this->mergeIncluded($output);
                }

                $output = $this->serializeCollection($data);
            } else {
                $output['data'] = $this->serializeCollection($data);
            }

            return $this->mergeIncluded($output);
        }

        return $data;
    }

    /**
     * Convert Model to JSON:API format
     *
     * @param Model $data
     *
     * @return array
     */
    public function serializeModel(Model $data): array
    {
        // TODO
        $attributes = $data->attributesToArray();

        $relations = $data->getRelations();

//        $result = [
//            // The table can have different primary key
//            // TODO Optimize
//            'type' => $data->getTable(),
//            'id' => $data->id,
//            'attributes' => $attributes,
//        ];

        $result = $attributes;

        // TODO
        if (!empty($relations)) {
            foreach ($relations as $key => $relation) {
                // TODO Does the response contain pivot data?
                if ($relation instanceof Pivot) {
                    continue;
                }

                if (is_iterable($relation)) {
                    foreach ($this->serializeCollection($relation) as $key => $temp) {
                        $this->addInclude($temp);
                        $result['relationships'][$key]['data'][] = [
                            'type' => $temp['type'],
                            'id' => $temp['id'],
                        ];
                    }
                } elseif ($relation instanceof Model) {
                    $temp = $this->serializeModel($relation);
                    // $this->included[$key][] = $temp;
                    $this->addInclude($temp);
                    $result['relationships'][$key]['data'] = [
                        'type' => $temp['type'],
                        'id' => $temp['id'],
                    ];
                } elseif ($relation) {
                    //$this->included[$key][] = $relation;
                    $this->addInclude($relation);
                }
            }
        }

        return $result;
    }

    /**
     * Convert collection to JSON:API format
     *
     * @param $collection
     *
     * @return array
     */
    public function serializeCollection(iterable $collection): array
    {
        $result = [];
        foreach ($collection as $key => $item) {
            if (is_iterable($item)) {
                $result[$key] = $this->serializeCollection($item);
            } elseif ($item instanceof Model) {
                $result[$key] = $this->serializeModel($item);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }

    /*protected function addIncludeScalar($type, $include) {
        $this->included[$type]
    }*/

    /**
     * @param $include
     *
     * @todo
     *
     */
    protected function addInclude($include)
    {
        $type = $include['type'];
        $id = $include['id'];
        if (!array_key_exists($type, $this->included) || !array_key_exists($id, $this->included[$type])) {
            $this->included[$type][$id] = $include;
        } else {
            $this->included[$type][$id] = array_merge($this->included[$type][$id], $include);
        }
    }

    /**
     * @param $output
     *
     * @return mixed
     */
    protected function mergeIncluded($output)
    {
        foreach ($this->included as $items) {
            foreach ($items as $key => $item) {
                // The table can have different primary key
                // TODO Optimize
                $output['included'][] = $item;
            }
        }

        return $output;
    }

    /**
     * @param AbstractPaginator $paginator
     *
     * @return array
     */
    public function serializePaginator(AbstractPaginator $paginator): array
    {
        /*$result= [
            'current_page' => $paginator->currentPage(),
            //'data' => $paginator->items->toArray(),
            //'data' => $this->serializeData($paginator->items()),
            'first_page_url' => $paginator->url(1),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'last_page_url' => $paginator->url($paginator->lastPage()),
            'next_page_url' => $paginator->nextPageUrl(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];*/

        $links = [
            'links' => [
                'current_page'=>$paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->count(),
                'first' => [
                    'href' => $paginator->url(1),
                    'meta' => [
                        'page' => 1,
                    ]
                ],
                'last' => [
                    'href' => $paginator->url($paginator->lastPage()),
                    'meta' => [
                        'page' => $paginator->lastPage(),
                    ]
                ],
                'prev' => $paginator->currentPage() > 1 ? [
                    'href' => $paginator->previousPageUrl(),
                    'meta' => [
                        'page' => $paginator->currentPage() - 1
                    ]
                ] : null,
                'next' => $paginator->lastPage() > $paginator->currentPage() ? [
                    'href' => $paginator->nextPageUrl(),
                    'meta' => [
                        'page' => $paginator->currentPage() + 1
                    ]
                ] : null,
            ]
        ];

        $output = $this->serializeData($paginator->items());

        return array_merge($links, $output);
    }

    public function serializeResource($resource)
    {

    }
}
