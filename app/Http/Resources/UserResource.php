<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'job_name'=>$this->job_name,
            'phone_number'=>$this->phone_number,
            'email'=>$this->email,
            'created_at'=>$this->created_at->toDateString(),
        ];
    }
}
