<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HandleImageUpLoad
{
    protected string $path = 'upload/users';

    /**
     * Store an user image.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    function storeImage($request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = "$this->path/$this->id_" . time() . "{$avatar->getClientOriginalName()}";
            Image::make($avatar)->fit(300)->save("storage/$path");
            return $path;
        }

        throw new \Exception('An error occurred while uploading the image at: ' . __FILE__);
    }

    /**
     * Update an user image.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function updateImage($request)
    {
        $path = $this->storeImage($request);
        $image = $this->images;

        if (isset($image->url)) {
            $this->deleteImage($image->url);
        }

        $this->images()->create(['url' => $path]);

        return ($path);
    }

    /**
     * Delete an user image
     * 
     * @param string $name
     */
    public function deleteImage(string $name)
    {
        if (\file_exists(\public_path('storage/' . $name))) {
            \unlink('storage/' . $name);
        }

        if (isset($this->images->url)) {
            $this->images()->delete();
        }

        return $this;
    }
}
