<?php

namespace App\Traits;

trait ApiFilterTrait
{

    /**
     * Check Query
     * @param  Object  $obj
     * @param  Array  $filter
     * @return object
     */
    public function checkQuery($obj, $filter = [])
    {
        switch ($filter['query'] ?? 'default') {
            case 'like':
                $obj = $obj->where($filter['field'], 'like', '%'.$filter['value'].'%');
                break;
            case 'null':
                $obj = $obj->whereNull($filter['field']);
                break;
            case 'not-null':
                $obj = $obj->whereNotNull($filter['field']);
                break;
            case 'strtotime':
                $obj = $obj->where($filter['field'], strtotime($filter['value']));
                break;
            case 'where-has':
                $obj = $obj->whereHas($filter['relation']);
                break;
            case 'doesnt-have':
                $obj = $obj->doesntHave($filter['relation']);
                break;
            case 'relation':
                $obj = $obj->whereHas($filter['relation'], function ($q) use ($filter) {
                    $q->where($filter['field'], $filter['value']);
                });
                break;
            case 'relation-like':
                $obj = $obj->whereHas($filter['relation'], function ($q) use ($filter) {
                    $q->where($filter['field'], 'like', '%'.$filter['value'].'%');
                });
                break;
            default:
                $obj = $obj->where($filter['field'], $filter['value']);
                break;
        }
        return $obj;
    }

    /**
     * Filter Fields
     * @param  Object  $obj
     * @param  Array  $data
     * @return object
     */
    public function filterFields($obj, $filters = [])
    {
        foreach ($filters as $filter) {
            if (isset($filter['field']) && strlen($filter['value'])) {
                $obj = $this->checkQuery($obj, $filter);
            }
        }
        return $obj;
    }

    /**
     * Set Order
     * @param  Object  $obj
     * @param  Array  $sort[By, Order]
     * @return object
     */
    public function setOrder($obj, $sort = [])
    {
        if (!empty($sort[0]) && !empty($sort[1])) {
            $order = $sort[1] == -1 ? 'DESC' : 'ASC';
            $obj = $obj->orderBy($sort[0], $order);
        }
        return $obj;
    }
}
