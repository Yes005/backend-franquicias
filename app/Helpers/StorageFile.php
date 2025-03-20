<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;


class StorageFile
{

    private string $pathTo;

    private  $relationship;

    private $createCallback;

    public function __construct(
        string $pathTo,
        $createCallback,
        $relationship = null,
    ) {
        $this->pathTo = $pathTo;
        $this->relationship = $relationship;
        $this->createCallback = $createCallback;
    }

    private function getModel($model)
    {
        if ($this->relationship) {
            return $model->{$this->relationship}();
        }

        return $model;
    }

    public  function saveFile(mixed $fileName, $file, Model $model): void
    {
        if (!method_exists($file, 'storeAs')) {
            throw new BadRequestException('El archivo no es valido para guardar');
        }
        try {

            $name = is_callable($fileName) ? $fileName() : $fileName;

            $image = Image::load($file);

            $temp = tempnam(sys_get_temp_dir(), 'image');
            $path = $this->pathTo . '/' . $name . '.' . $file->getClientOriginalExtension();

            $image->optimize([Jpegoptim::class => [
                '--all-progressive',
                '--strip-all',
            ]
            ])->save($temp);

            Storage::put($path, file_get_contents($temp));

            $this->getModel($model)->create(
                call_user_func($this->createCallback, $path, $file, $model)
            );
        } catch (\Exception $e) {
            Storage::delete($path);

            throw $e;
        }
    }


    public function deleteFile(Model $model, $deleteCallback): void
    {
        $model = $this->getModel($model);

        if (is_callable($deleteCallback)) {
            $model?->each(function ($file) use ($deleteCallback) {
                $path =  call_user_func($deleteCallback, $file);

                Storage::delete($path);
            });
        }
        $model->forceDelete();
    }
}
