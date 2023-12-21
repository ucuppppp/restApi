<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'isiKomen' => $this->commentContents,
            'user_id' => $this->user_id,
            'username' => $this->whenLoaded('comentator'),
            'waktuDibuat' => date_format($this->created_at, "Y-m-d H:i:s")
        ];
    }
}
