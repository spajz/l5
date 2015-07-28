<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\BaseController;
use Image;
use File;
use Illuminate\Support\Str;

class LocalController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function prepareImages()
    {
        $sourcePath = 'd:/fotke';

        $dirs = File::directories($sourcePath);

        foreach ($dirs as $dir) {
            $files = File::files($dir);
            $dirName = basename($dir);
            $this->createImage($files, $dirName);
        }
    }

    protected function createImage($files, $dirName)
    {
        $destpath = 'd:/fotke_obradjene/';

        if (count($files)) {

            $image = Image::canvas(4500, 500, "#000000");
            echo $dirName . '<br>';
            $i = 0;
            foreach ($files as $file) {
                echo $file . '<br>';
                $parts = pathinfo($file);

                if (strtolower($parts['extension']) != 'jpg') continue;

                $baseName = Str::slug($dirName);

                $image->insert($file, 'top-left', $i * 500);

                $i++;
            }
            $image->save($destpath . $baseName . '.jpg', 100);
        }
    }

}