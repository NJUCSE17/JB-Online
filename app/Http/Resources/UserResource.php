<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'              => $this->id,
            'student_id'      => $this->student_id,
            'name'            => $this->name,
            'email'           => $this->email,
            'want_email'      => $this->want_email,
            'blog_feed_url'   => $this->blog_feed_url,
            'is_verified'     => $this->isVerified(),
            'is_active'       => $this->isActive(),
            'privilege_level' => $this->privilege_level,
            'timezone'        => $this->timezone,
        ];
    }
}
