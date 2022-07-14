<?php

namespace Sumra\SDK\Traits;

/**
 *
 */
trait ResponseTrait
{
    public function processPaginator($message, $paginator)
    {
        $meta = [
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'next_page_url' => $paginator->nextPageUrl(),
            'previous_page_url' => $paginator->previousPageUrl(),
            'first_item' => $paginator->firstItem(),
            'last_item' => $paginator->lastItem(),
        ];

        return response()->jsonApi([
            'type' => 'success',
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => $meta
        ]);
    }

    public function createdResponse($message, $data)
    {
        return response()->jsonApi([
            'type' => 'success',
            'message' => $message,
            'data' => $data
        ], 201);
    }

    public function errorResponse($message)
    {
        return response()->jsonApi([
            'type' => 'danger',
            'message' => $message
        ], 500);
    }

    public function okResponse($title, $message, $data = null)
    {
        return response()->jsonApi([
            'type' => 'success',
            'title' => $title,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}
