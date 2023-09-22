<?php

namespace App\Core\Controller\Traits;

trait Meta
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $item
     * @return array
     */
    protected function metaItem($item): array
    {
        return [
            'meta' => [
                'allowed_includes' => $this->getProperty($item, 'allowed_includes'),
                'default_includes' => $this->getProperty($item, 'default_includes'),
            ]
        ];
    }

    /**
     * @param $collection
     * @param $sortFields
     * @param null $filterFiels
     * @return array
     */
    protected function metaCollection($collection, $sortFields, $filterFiels = null): array
    {
        return [
            'meta' => [
                'allowed_filters' => isset($filterFiels) ? $this->getAllowedFilterFields($collection, $filterFiels) : $this->getProperty($collection, 'allowed_filters', true) ,
                'allowed_sorts' => $this->getProperty($collection, 'allowed_sorts', true),
                'allowed_appends' => $this->getProperty($collection, 'allowed_appends'),
                'allowed_fields' => $this->getProperty($collection, 'allowed_fields'),
                'allowed_includes' => $this->getProperty($collection, 'allowed_includes'),
                'default_includes' => $this->getProperty($collection, 'default_includes'),
                'optional_get_vars' => [
                    'sortBy' => $this->getAllowedSortFields($collection, $sortFields),
                    'sortOrder' => ['asc', 'desc'],
                    'pageSize' => [
                        0 => "?pageSize=0",
                        15 => "?pageSize=15",
                        50 => "?pageSize=50",
                        100 => "?pageSize=100"
                    ]
                ]
            ]
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param array $sortFields
     * @return array
     */
    protected function getAllowedSortFields($collection, $sortFields = []): array
    {
        return count($sortFields) > 0 ?
            $sortFields : (($collection->count() > 0 && isset($collection->first()->allowed_sorts))?
                $collection->first()->allowed_sorts : []);
    }

    protected function getAllowedFilterFields($collection, $sortFields = []): array
    {
        return count($sortFields) > 0 ?
            $sortFields : (($collection->count() > 0 && isset($collection->first()->allowed_filters))?
                $collection->first()->allowed_filters : []);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator $resource
     * @param string $property
     * @param bool $key
     * @return array
     */
    protected function getProperty($resource, $property = '', bool $key = false): array
    {
        if ($resource instanceof \Illuminate\Database\Eloquent\Collection ||
            $resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return $resource->count() > 0 ?
                $this->getProperty($resource->first(), $property, $key) : [];
        }

        return
            ($resource instanceof \App\Core\Models\BaseEntity ||
            $resource instanceof \Illuminate\Http\Resources\Json\JsonResource) &&
            (property_exists($resource, $property) || (property_exists($resource, 'resource')
                && property_exists($resource->resource, $property))) ?
                $this->arrPluck($resource->$property, $key) : [];
    }

    /**
     * @param array $props
     * @param bool $key
     * @return array
     */
    protected function arrPluck($props, bool $key = false)
    {
        if ($key) {
            return array_values(collect($props)->map(function ($key, $value) {
                return is_string($value) ? $value : $key;
            })->all());
        }
        return $props ?? [];
    }
}