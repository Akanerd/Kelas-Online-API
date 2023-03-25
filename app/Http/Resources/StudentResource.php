<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'email'=>$this->email,
            'password'=>$this->password,
            'name'=>$this->name,
            'gender'=>$this->name,
            'phone'=>$this->phone,
            'avatar'=>env('UPLOAD_PATH')."/uploads/".$this->avatar
        ];
    }
}
