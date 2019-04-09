<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRecourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'student_id'    => $this->student_id,
            'name'          => $this->name,
            'email'         => $this->email,
            'blog_feed_url' => $this->blog_feed_url,
            'verified'      => $this->isVerified(),
            'active'        => $this->isActive(),
        ];
    }
}
