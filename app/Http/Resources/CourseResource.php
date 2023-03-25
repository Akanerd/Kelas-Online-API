<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'category'=>$this->category->name,
            'mentor'=>$this->user->name,
            'title'=>$this->title,
            'description'=>$this->description,
            'group'=>$this->group,
            'thumbnail'=>env('UPLOAD_PATH')."/uploads/".$this->thumbnail
        ];
    }
}
