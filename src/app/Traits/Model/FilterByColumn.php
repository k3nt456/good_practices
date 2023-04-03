<?php

namespace App\Traits\Model;

use Illuminate\Database\Eloquent\Builder;

trait FilterByColumn
{
    abstract public function searchableColumns(): array;

    public function scopeFilterByColumns($query, $values = [])
    {

        $columns = $this->searchableColumns();
        //dd($columns['search']);
        foreach ($values as $key => $value) {
            if (array_key_exists($key, $columns)) {
                $query->filterByColumn($key, $value, $columns[$key]);
            } elseif (in_array($key, $columns)) {
                $query->filterByColumn($key, $value);
            }
        }
        return $query;
    }

    public function scopeFilterByColumn($query, $key, $value, $column = null)
    {
        if (is_null($column)) {

            $query->where($key, 'like', "%$value%");

        } elseif (is_callable($column)) {

            $column($query, $value, $key);

        } elseif (is_array($column)) {

            $columnName = array_key_exists('column', $column) ? $column['column'] : $key;
            $value = array_key_exists('value', $column) ? $column['value'] : $value;
            $condition = array_key_exists('condition', $column) ? $column['condition'] : 'like';

            if ($condition == "like") {
                $value = "%" . $value . "%";
            }

            $relation = array_key_exists('relation', $column) ? $column['relation'] : null;

            if (!$relation) {
                if (strpos($value, ',') !== false && $condition == "=") {
                    $arrayValues = explode(",", $value);
                    $query->whereIn($columnName, $arrayValues);
                } else {
                    $query->where($columnName, $condition, $value);
                }
            } elseif ($condition == 'whereMonth') {
                $query->whereHas($relation, function (Builder $queryA) use ($relation, $value, $columnName) {
                    $queryA->whereMonth($relation . "." . $columnName, '=', $value);
                });
            } elseif ($condition == 'whereYear') {
                $query->whereHas($relation, function (Builder $queryA) use ($relation, $value, $columnName) {
                    $queryA->whereYear($relation . "." . $columnName, '=', $value);
                });
            } elseif (strpos($value, ',') !== false) {
                $arrayValues = explode(",", $value);
                $query->whereHas($relation,
                    function (Builder $queryA) use ($condition, $value, $columnName, $arrayValues) {
                        $queryA->whereIn($columnName, $arrayValues);
                    });
            } else {
                $query->whereHas($relation, function (Builder $queryA) use ($condition, $value, $columnName) {
                    $queryA->where($columnName, $condition, $value);
                });
            }
        }

        return $query;
    }
}
