<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SaveFile
{
    /**
     * Save files
     */
    public function saveFile($file, string $name)
    {
        $full=$file->store($name , 'public');
        return $full;
    }

    public function FileRemove($file){
        if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

}
