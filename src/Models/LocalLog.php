<?php

namespace Devlab\LaravelLogs\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LocalLog extends Model
{
    use HasFactory;

    // public $timestamps = false;

    protected $table = 'logs';
    protected $fillable = ['procedure', 'created_user'];

    public static function doLog($procedure, $data)
    {
        $user_id = Auth::user()->id ?? config('constants.users.system');
        $procedure_id = self::checkProcedure($procedure);
        $log = new self();
        $log->procedure_id = $procedure_id;
        $log->procedure = $procedure;
        $log->data = $data;
        $log->created_user = $user_id;
        $log->save();
    }

    private static function checkProcedure($procedure)
    {
        $bd_procedure = ModelsProcedure::where('procedure', $procedure)->get()->first();
        if (empty($bd_procedure)) {
            $bd_procedure = new ModelsProcedure();
            $bd_procedure->procedure = $procedure;
            $bd_procedure->save();
        }
        return $bd_procedure->id;
    }
}
