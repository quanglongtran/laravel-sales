<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('getImage')) {
    /**
     * Get the image if exists.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    function getImage($model, $defaultFolder = '')
    {
        if (optional($model->images)->url && file_exists("storage/{$model->images->url}")) {
            return asset("storage/{$model->images->url}");
        }

        if ($defaultFolder) {
            return asset("storage/uploads/$defaultFolder/default.jpg");
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
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}

if (!function_exists('redirectPrevRoute')) {
    function redirectPrevRoute($default = RouteServiceProvider::HOME)
    {
        $currentRoute = request()->route()->getName();
        $prevRoute = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if ($currentRoute == $prevRoute) {
            return redirect($default);
        }

        return back();
    }
}
