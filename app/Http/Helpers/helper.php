<?php

use Illuminate\Database\Eloquent\Model;

if (!function_exists('getImage')) {
    /**
     * Get the image if exists.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    function getImage($model)
    {
        if (optional($model->images)->url && file_exists("storage/{$model->images->url}")) {
            return asset("storage/{$model->images->url}");
        }

        return asset('storage/uploads/default/default.jpg');
    }
}

if (!function_exists('validatorFailed')) {
    function validatorFailed($param)
    {
        if (is_array($param)) {
            foreach ($param as $value) {
                notify($value, null, 'error');
            }
        }
    }
}
