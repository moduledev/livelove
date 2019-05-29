<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 029 29.05.19
 * Time: 14:43
 */

namespace App\Traits;



use Illuminate\Http\Request;

trait StoreImageTrait
{
    public function storeImage(Request $request, $fileName)
    {
        if($request->hasFile($fileName)){
            $path = $request->file('image')->store('program', 'public');
            return $path;
        }
    }
}