<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SaveFile
{
    /**
     * Save images
     */
    public function saveFile($image, string $name)
    {
        $full=$image->store($name , 'public');
        return $full;
    }

    public function FileRemove($file){
        if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

}
