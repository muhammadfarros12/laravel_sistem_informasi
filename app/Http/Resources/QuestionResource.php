<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'status_code' => $this->status_code,
            'title' => $this->title,
            'description' => $this->description,
            // 'created_at' => $this->created_at,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
        ];
    }
}
