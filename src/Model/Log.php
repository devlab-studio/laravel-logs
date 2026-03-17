<?php

namespace Devlab\LaravelLogs\Models;

use Devlab\LaravelCore\Traits\WithExtensions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'url', 'topic'];

    /**
     * Get logs.
     *
     * @param int $iUsers_id
     * @param int $iRecordsInPage
     * @param array $aSort (attribute => 'asc'/'desc')
     * @param array $aFilters
     * @return mixed Collection
     *
     */
    public static function dlGet(
        ?int $iModels_id = 0,
        int $iRecordsInPage = 0,
        array $aSort = [],
        ?array $aFilters = [],
        array $aWith = []
    ) {

        $iModels_id = ($iModels_id) ? $iModels_id : 0;

        $oQuery = static::select('logs.*');
        $oQuery->when($iModels_id > 0, function ($query)  use ($iModels_id) {
            return $query->where('logs.id', $iModels_id);
        });

        $oQuery = static::dlApplyFilters($oQuery, $aFilters);

        foreach ($aSort as $key => $value) {
            $oQuery->orderBy($key, $value);
        }
        //$oQuery->dd();
        return static::getModelData($oQuery, $iModels_id, $iRecordsInPage, $aWith);
    }
    /**
     * Apply filters.
     *
     * @param $oQuery
     * @param array $aFilters
     * @return mixed Query
     *
     */
    private static function dlApplyFilters(
        $oQuery,
        ?array $aFilters = []
    ) {
        $oQuery->when(isset($aFilters['logs_ids']) && !empty($aFilters['logs_ids']), function ($query) use ($aFilters) {
            return $query->whereIn('logs.id', $aFilters['logs_ids']);
        })
        ->when(isset($aFilters['type']) && !empty($aFilters['type']), function ($query) use ($aFilters) {
            return $query->where('logs.type', $aFilters['type']);
        })
        ->when(isset($aFilters['topic']) && !empty($aFilters['topic']), function ($query) use ($aFilters) {
            return $query->where('logs.topic', $aFilters['topic']);
        })
        ->when(isset($aFilters['data']) && !empty($aFilters['data']), function ($query) use ($aFilters) {
            return $query->where('logs.data', 'like', '%' . $aFilters['data'] . '%');
        })
        ->when(isset($aFilters['date']) && !empty($aFilters['date']), function ($query) use ($aFilters) {
            return $query->whereBetween('logs.' . $aFilters['date'][0], [$aFilters['date'][1], $aFilters['date'][2]]);
        });
        return $oQuery;
    }
}
