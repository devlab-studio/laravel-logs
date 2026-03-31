<?php

namespace Devlab\LaravelLogs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithExtensions;
use Carbon\Carbon;

class ModelsLog extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data' => 'json',
    ];
    /**
     * Get records
     *
     * @param int $model_id
     * @param int $records_in_page
     * @param array $sort (attribute => 'asc'/'desc')
     * @param array $filters
     * @return mixed Collection
     *
     */
    public static function dlGet(
        int $model_id = 0,
        int $records_in_page = 0,
        array $sort = [],
        array $filters = [],
        array $with = []
    ) {

        $oQuery = static::select('models_logs.*')
        ->when($model_id > 0, function ($query) use ($model_id) {
            return $query->where('models_logs.id', $model_id);
        });

        $oQuery = static::dlApplyFilters($oQuery, $filters);

        foreach ($sort as $key => $value) {
            $oQuery->orderBy($key, $value);
        }
        // $oQuery->dd();
        return static::getModelData($oQuery, $model_id, $records_in_page, $with);
    }
    public static function dlApplyFilters(
        $oQuery,
        ?array $filters = []
    ) {

        $oQuery->when(isset($filters['models_logs_ids']) && !empty($filters['models_logs_ids']), function ($query) use ($filters) {
            return $query->whereInto('models_logs.id', $filters['models_logs_ids']);
        })
        ->when(isset($filters['procedure_id']) && !empty($filters['procedure_id']), function ($query) use ($filters) {
            return $query->whereInto('models_logs.procedure_id', $filters['procedure_id']);
        })
        ->when(isset($filters['data']) && !empty($filters['data']), function($query) use ($filters) {
            return $query->whereFullText('data', $filters['data']);
        })
        ->when(isset($filters['date']) && ! empty($filters['date']) && isset($filters['date'][0]), function ($query) use ($filters) {
            $from = (new Carbon($filters['date'][1]))->startOfDay();
            $to = (new Carbon($filters['date'][2]))->endOfDay();

            return $query->whereBetween('models_logs.'.$filters['date'][0], [$from, $to]);
        });

        return $oQuery;
    }

    public function models_procedure()
    {
        return $this->hasOne(ModelsProcedure::class, 'id', 'procedure_id');
    }

    public function createduser()
    {
        return $this->hasOne(User::class, 'id', 'created_user');
    }

    public function updateduser()
    {
        return $this->hasOne(User::class, 'id', 'updated_user');
    }
}
