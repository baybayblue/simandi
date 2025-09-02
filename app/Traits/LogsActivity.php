<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait.
     * Automatically log created, updated, and deleted events.
     */
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            static::logActivity($model, 'created');
        });

        static::updated(function (Model $model) {
            static::logActivity($model, 'updated');
        });

        static::deleted(function (Model $model) {
            static::logActivity($model, 'deleted');
        });
    }

    /**
     * Log an activity for the given model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $action
     */
    protected static function logActivity(Model $model, string $action)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => static::getActivityDescription($model, $action),
            'loggable_id' => $model->id,
            'loggable_type' => get_class($model),
        ]);
    }

    /**
     * Get the description for the activity.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $action
     * @return string
     */
    protected static function getActivityDescription(Model $model, string $action): string
    {
        $modelName = class_basename($model);
        $identifier = $model->name ?? $model->invoice_code ?? $model->id;

        return "{$modelName} '{$identifier}' was {$action}.";
    }
}

