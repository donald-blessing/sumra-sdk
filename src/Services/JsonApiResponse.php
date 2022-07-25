<?php

namespace Sumra\SDK\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Traversable;

class JsonApiResponse extends JsonResponse
{
    protected array $included = [];

    /**
     * JsonApiResponse constructor.
     *
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param int $options
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
        // Serialize data
        $data = $this->serializeData($data);

        if(isset($data['errors'])){
            $error = collect($data['errors'])->first();

            $data['title'] = $error['title'];
            $data['message'] = $error['message'];

            unset($data['errors']);
        }

        // Check and add response info
        $data = $this->setResponseInfo($data);

        // Set data to parrent response
        return parent::setData($data);
    }

    /**
     * @param array|Collection|Model $data
     *
     * @return mixed
     */
    protected function serializeData($data)
    {
        // If input data of Model
        if ($data instanceof Model) {
            $output = [
                'data' => $this->serializeModel($data)
            ];

            return $this->mergeIncluded($output);
        }

        // If input data of Paginator
        if ($data instanceof AbstractPaginator) {
            return $this->serializePaginator($data);
        }

        // If simple array or Traversable class
        if (is_array($data) || $data instanceof Traversable) {
            // Wrap to data atribute if input has 'data' key and object
            if (!isset($data['data']) && ($data instanceof Collection || $data instanceof AbstractPaginator)) {
                $data = [
                    'data' => $data
                ];
            }

            // fix problem with pagination
            if (isset($data['data']) && $data['data'] instanceof AbstractPaginator) {
                $data = array_merge($data, $this->serializePaginator($data['data']));
            }

            // Processing array of data
            $data = $this->serializeCollection($data);

            // Add included and return
            return $this->mergeIncluded($data);
        }

        // Return inputed data, e.g. string
        return $data;
    }

    /**
     * Convert Model to JSON:API format
     *
     * @param Model $data
     *
     * @return array
     */
    protected function serializeModel(Model $data): array
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

                    $this->addInclude($temp);

                    $result['relationships'][$key]['data'] = [
                        'type' => $temp['type'],
                        'id' => $temp['id'],
                    ];
                } elseif ($relation) {
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
    protected function serializeCollection(iterable $collection): array
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

    /**
     * @param $include
     *
     * @todo
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
     * @return array
     */
    protected function serializePaginator(AbstractPaginator $paginator): array
    {
        return [
            'data' => $this->serializeData($paginator->items()),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'path' => $paginator->path(),
                'first_item' => $paginator->firstItem(),
                'last_item' => $paginator->lastItem(),

                'prev' => $paginator->currentPage() > 1 ? [
                    'href' => $paginator->previousPageUrl(),
                    'page' => $paginator->currentPage() - 1
                ] : null,

                'first' => [
                    'href' => $paginator->url(1),
                    'page' => 1
                ],

                'links' => $paginator->links(),

                'last' => [
                    'href' => $paginator->url($paginator->lastPage()),
                    'page' => $paginator->lastPage()
                ],

                'next' => $paginator->lastPage() > $paginator->currentPage() ? [
                    'href' => $paginator->nextPageUrl(),
                    'page' => $paginator->currentPage() + 1
                ] : null,
            ]
        ];
    }

    /**
     * @param $output
     * @param $data
     * @return array
     */
    protected function setResponseInfo($output): array
    {
        if (!isset($output['message'])) {
            $output = array_merge(['message' => ''], $output);
        }

        if (!isset($output['title'])) {
            $output = array_merge(['title' => ''], $output);
        }

        if (!isset($output['type'])) {
            $code = $this->getStatusCode();

            switch ($code) {
                case 200:
                case 201:
                    $type = 'success';
                    break;

                case 400:
                case 401:
                case 500:
                    $type = 'danger';
                    break;

                case 404:
                case 405:
                case 422:
                    $type = 'warning';
                    break;

                default:
                    $type = 'info';
            }

            $output = array_merge(['type' => $type], $output);
        }

        return $output;
    }
}
