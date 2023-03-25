<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->document == null)
        {
            $document = null;
        }
        else
        {
            $document = env('UPLOAD_PATH')."/uploads/".$this->document;
        }
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'module_type'=>$this->module_type,
            'file_type'=>$this->file_type,
            'youtube'=>$this->youtube,
            'document'=>$document,
            'order'=>$this->order,
            'view'=>$this->view,
        ];
    }
}
