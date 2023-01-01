<?php

namespace App\Traits;

use Exception;
use Intervention\Image\Facades\Image;

trait HandleImageUpLoad
{
    private string $path = 'uploads';
    private array $requestNames = ['avatar', 'image'];

    /**
     * Store an user image.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string folder
     * @return string
     */
    function storeImage($request, string $folder)
    {
        if ($avatar = $this->checkValidRequest($request)) {
            $path = "$this->path/$folder/$this->id_" . time() . "{$avatar->getClientOriginalName()}";
            Image::make($avatar)->fit(300)->save("storage/$path");
            $this->savePath($path);
            return $path;
        }
    }

    /**
     * Update an image.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $folder
     * @return string
     */
    public function updateImage($request, string $folder)
    {
        if ($this->checkValidRequest($request)) {
            $this->deleteImage();

            $path = $this->storeImage($request, $folder);
            return $path;
        }
    }

    /**
     * Delete an image
     * 
     * @return void
     * 
     */
    public function deleteImage()
    {
        if (isset($this->images->url)) {
            $name = $this->images->url;
            if (\file_exists(\public_path('storage/' . $name))) {
                \unlink('storage/' . $name);
            }

            $this->images()->delete();
        }
    }

    /**
     * Save path to database
     * 
     * @param string $path
     */
    private function savePath(string $path)
    {
        try {
            $this->images()->create(['url' => $path]);
        } catch (\Exception) {
            throw new Exception('You must call this method from valid model!!');
        }
    }

    /**
     * Check if request is valid.
     * 
     * @param \Illuminate\Http\Request $request
     * @return Request|bool
     */
    private function checkValidRequest($request)
    {
        foreach ($request->allFiles() as $key => $file) {
            if (\collect($this->requestNames)->contains($key)) {
                if (!is_null($this->id)) {
                    return $request->file($key);
                }

                throw new \Exception('You must call this method from valid model!!');
            }
        }

        return false;
    }
}
