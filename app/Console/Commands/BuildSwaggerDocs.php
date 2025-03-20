<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\CssSelector\Exception\ParseException;

class BuildSWaggerDocs extends Command
{
    protected $signature = 'swagger';

    protected $description = 'Generate Swagger documentation';


    function getContents($files, $path, $fileContent)
    {
        $folder = [];

        foreach ($files as $file) {

            if (is_dir($path . '/' . $file)) {

                // guardar en un array los archivos de las subcarpetas
                $files2 = scandir($path . '/' . $file);

                $files2 = array_diff($files2, ['.', '..']);

                $folder[] = [
                    'path' => $path . '/' . $file,
                    'files' => $files2
                ];
            } else {

                $fileContent[] = file_get_contents($path . '/' . $file);
            }
        }

        // si hay subcarpetas
        if (count($folder) > 0) {
            foreach ($folder as $key => $value) {

                $fileContent = $this->getContents($value['files'], $value['path'], $fileContent);
            }
        }


        return $fileContent;
    }

    public function handle()
    {

        $path_swagger = env('PATH_SWAGGER') ?? 'resources/api-docs';


        $info = file_get_contents($path_swagger . '/index.yml');


        $path = $path_swagger . '/docs';

        $files = scandir($path);

        $files = array_diff($files, ['.', '..']);



        $fileContent = [];

        $fileContent = $this->getContents($files, $path, $fileContent);



        $main = Yaml::parse($info);

        $main['paths'] = [];

        foreach ($fileContent as $key => $content) {


            try {

                $values = Yaml::parse($content);
            } catch (ParseException $e) {

                $this->error('Failed to generate Swagger documentation.');

                $this->error($e->getMessage());
            }


            foreach (array_keys($values) as $key) {

                $main['paths'][$key] = $values[$key];
            }
        }

        $fileUpdate = file_put_contents($path_swagger . '/output/swagger.json', json_encode($main, JSON_UNESCAPED_SLASHES));


        if ($fileUpdate) {
            $this->info("Swagger documentation generated successfully: swagger.json");
            $this->info('path: ' . base_path($path_swagger . '/output/swagger.json'));
        } else {
            $this->error('Failed to generate Swagger documentation.');
        }
    }
}
