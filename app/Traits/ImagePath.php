<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 030 30.05.19
 * Time: 9:31
 */

namespace App\Traits;


trait ImagePath
{
    public function imagePath($imagesFolder, $destinationFolder)
    {
       return storage_path($imagesFolder . $destinationFolder);
    }
}