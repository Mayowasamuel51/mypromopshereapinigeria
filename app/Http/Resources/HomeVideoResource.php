<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id ,
            'titlevideourl'=>$this->titlevideourl,
            'user_image'=>$this->user_image,
            'categories'=>$this->categories,
            'user_phone'=>$this->user_phone,
            'user_website'=>$this->user_website
            // 'titlevideourl'=>$this->titlevideourl
        ];
    }
}
