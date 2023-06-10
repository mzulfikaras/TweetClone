<?php

namespace App\Traits;

use File;

trait ImageTrait
{
    public function uploadImage($image, $filename)
    {
        $folder = "public";
        $path = 'assets/images/'.$filename;
        $name = time().'.'.$image->getClientOriginalName();

        $uploadImage = $image->move($path, $name.'.'.$image->getClientOriginalExtension(), $folder);

        return $uploadImage;
    }

    public function deleteImage($image)
    {
        if(File::exists(public_path($image))){
            File::delete(public_path($image));
            $message = "File success deleted";
        }else{
            $message = 'File does not exists';
        }

        return $message;
    }
}
