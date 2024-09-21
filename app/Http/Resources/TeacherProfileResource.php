<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TeacherProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'country'=>$this->country,
            'description'=>$this->description,
            'subject'=>$this->subject,
            'image'=>asset(Storage::url($this->image)),
            'video'=>asset(Storage::url($this->video)),
            'CostHour'=>$this->CostHour,
            'phone'=>'+'.$this->phone,
        ];
    }
}
