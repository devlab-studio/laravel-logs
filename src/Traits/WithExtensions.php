<?php

namespace Devlab\LaravelLogs\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithExtensions
{
    public function scopeWhereInto(Builder $query, $field, $value)
    {
        if (is_array($value)) {
            return $query->whereIn($field, $value);
        } else {
            $value = explode(",", $value);
            return $query->whereIn($field, $value);
        }
    }
    public function scopeOrWhereInto(Builder $query, $field, $value)
    {
        if (is_array($value)) {
            return $query->orWhereIn($field, $value);
        } else {
            $value = explode(",", $value);
            return $query->orWhereIn($field, $value);
        }
    }
    public function scopeWhereNotInto(Builder $query, $field, $value)
    {
        if (is_array($value)) {
            return $query->whereNotIn($field, $value);
        } else {
            $value = explode(",", $value);
            return $query->whereNotIn($field, $value);
        }
    }
    public function scopeOrWhereNotInto(Builder $query, $field, $value)
    {
        if (is_array($value)) {
            return $query->orWhereNotIn($field, $value);
        } else {
            $value = explode(",", $value);
            return $query->orWhereNotIn($field, $value);
        }
    }
    public static function getModelData($query, $model_id, $records_in_page = 0, $with = [], $key_by = 'id') {
        if (!empty($with)) {
            $query->with($with);
        }
        if ($model_id == 0) {
            $records_in_page = ($records_in_page == 0 ) ? config('constants.pagination.DEFAULT_PAGE_RECORDS', 150) : $records_in_page;
            if ($records_in_page > 0) {
                $oRecords = $query->paginate($records_in_page);
                if (!empty($key_by)) {
                    $oRecordsC = $oRecords->getCollection()->keyBy($key_by);
                    $oRecords->setCollection($oRecordsC);
                }
            } else {
                if (!empty($key_by)) {
                    $oRecords = $query->get()->keyBy($key_by);
                }
            }
        } else {
            $oRecords = $query->get()->first();
        }
        return $oRecords;
    }
}
