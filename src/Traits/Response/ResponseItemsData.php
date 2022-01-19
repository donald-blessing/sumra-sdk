<?php

namespace Sumra\SDK\Traits\Response;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait ResponseItemsData
{
    public static function transform($data, $columnsMap, $withObject = false)
    {
        // Transform items collection
        $data->getCollection()->transform(function ($object) use (&$columnsMap, $withObject) {
            if (isset($object->status)) {
                $object->status = (bool)$object->status;
            }

            // Loop object attributes and Transform relations
            $objectFields = $object->getAttributes();
            foreach ($objectFields as $fieldKey => $fieldValue) {
                // Find id's fields
                if (Str::endsWith($fieldKey, '_id')) {

                    if (!$withObject) {
                        $relation = str_replace('_id', '', $fieldKey);
                        $newKey = $relation . '_value';

                        $object->setAttribute($newKey, !is_null($object->$relation) ? $object->$relation->name : '');
                        if (isset($columnsMap[$fieldKey])) {
                            $columnsMap[$newKey] = $columnsMap[$fieldKey];
                            unset($columnsMap[$fieldKey]);
                        }
                        unset($object->$relation);
                    }
                }

                // Prepare date field
                if (Str::endsWith($fieldKey, '_at')) {
                    $object->setAttribute($fieldKey, !is_null($fieldValue) ? Carbon::parse($fieldValue)->format('Y-m-d H:i:s') : '');
                }
            }

            return $object;
        });

        $fields = [];
        foreach ($columnsMap as $key => $label) {
            $fields[] = (object)[
                'key' => $key,
                'label' => Str::ucfirst($label),
                //'_classes' => 'font-weight-bold'
            ];
        }

        return array_merge(['fields' => $fields], json_decode($data->toJson(), true));
    }
}
