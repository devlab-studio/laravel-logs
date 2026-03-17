<?php

namespace Devlab\LaravelLogs\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Facades\Auth;

class Model extends LaravelModel
{

    /**
	 * Overwrite model save.
	 */
    public function save (array $options = array(), $do_log = true) {
        $is_dirty = $this->isDirty();
        $user_id = Auth::user()->id ?? config('constants.users.system');
        if (empty($this->id)) {
            if (array_key_exists('created_user', $this->attributes)) {
                if (empty($this->created_user)) {
                    $this->created_user = $user_id;
                } else {
                    $user_id = $this->created_user;
                }
            }
        } else {
            if (array_key_exists('updated_user', $this->attributes)) {
                if (empty($this->updated_user)) {
                    $this->updated_user = $user_id;
                } else {
                    $user_id = $this->updated_user;
                }
            }
        }
        if ($do_log && $is_dirty) {
            $procedure_id = $this->checkProcedure(get_class($this).'::save');
            $log = new ModelsLog();
            $log->procedure_id = $procedure_id;
            $log->procedure = get_class($this).'::save';
            $log->data = [
                'original' => $this->getOriginal(),
                'changes' => $this->getDirty(),
            ];
            $log->save();
        }
        parent::save($options); // Calls Default Save
    }
    /**
	 * Overwrite model delete.
	 */
    public function delete ($do_log = true)
    {
        $result = static::checkDelete($this->getTable(), [$this->id]);

        if ($result) {
            return $result;
        } else {
            if ($do_log) {
                $procedure_id = $this->checkProcedure(get_class($this).'::delete');
                $log = new ModelsLog();
                $log->procedure_id = $procedure_id;
                $log->procedure = get_class($this).'::delete';
                $log->data = [
                    'id' => $this->id
                ];
                $log->save();
            }

            if (array_key_exists('updated_user', $this->attributes) && empty($this->updated_user)) {
                $this->updated_user = Auth::user()->id ?? $this->updated_user;
            }

            parent::delete(); // Calls Default Save
            return false;
        }
    }

    private function checkProcedure($procedure)
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
