<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogFeedResource extends JsonResource
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
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'user_name'    => $this->user_name,
            'user_avatar'  => $this->user_avatar,
            'title'        => $this->title,
            'permalink'    => $this->permalink,
            'content_html' => $this->content_html,
            'published_at' => $this->published_at->setTimezone(\Auth::user()->timezone),
        ];
    }
}
