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

/**
 * Create a new JSON response instance.
 *
 * @param  bool $success
 * @param  string $message
 * @param  array $data
 * @return \Illuminate\Http\JsonResponse
 */
function jsonResponse(bool $success, string $message, array $data = [])
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
}
