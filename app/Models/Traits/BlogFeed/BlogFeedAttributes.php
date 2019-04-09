<?php

namespace App\Models\Traits\BlogFeed;


use Carbon\Carbon;

trait BlogFeedAttributes
{
    public function feedItem()
    {
        return "  <entry>\n"
            ."    <title>".$this->title."</title>"
            ."    <link href='".$this->permalink."'></link>\n"
            ."    <id>".route('blog.view', ['slug' => $this->slug])."</id>\n"
            ."    <published>".Carbon::parse($this->published_at)->format('c')
            ."</published>\n"
            ."    <updated>".Carbon::parse($this->published_at)->format('c')
            ."</updated>\n"
            ."    <summary type='html'>".$this->title."</summary>\n"
            ."    <content type='html'>\n"
            ."      <![CDATA[".$this->content_html."]]>\n"
            ."    </content>\n"
            ."  </entry>\n";
    }
}