<?php

namespace App\Traits;

use Exception;
use Intervention\Image\Facades\Image;

trait HandleImageUpLoad
{
    private string $path = 'uploads';
    private array $requestNames = ['avatar', 'image', 'photo'];

    /**
     * Store an user image.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    function storeImage($request)
    {
        if ($avatar = $this->checkValidRequest($request)) {
            $path = "$this->path/{$this->modelName}/{$this->model->id}_" . time() . "{$avatar->getClientOriginalName()}";
            Image::make($avatar)->fit(300)->save("storage/$path");
            $this->savePath($path);
            return $path;
        }
    }

    /**
     * Update an image.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function updateImage($request)
    {
        if ($this->checkValidRequest($request)) {
            $this->deleteImage();

            $path = $this->storeImage($request);
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
        if (isset($this->model->images->url) && $this->model->images->url) {
            $name = $this->model->images->url;
            if (\file_exists(\public_path('storage/' . $name))) {
                \unlink('storage/' . $name);
            }

            $this->model->images()->delete();
        }
    }

    /**
     * Save path to database
     * 
     * @param string $path
     */
    private function savePath(string $path)
    {
        $this->model->images()->create(['url' => $path]);
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
                if (!is_null($this->model->id)) {
                    return $request->file($key);
                }

                throw new \Exception('You must call this method from valid model!!');
            }
        }

        return false;
    }
}
