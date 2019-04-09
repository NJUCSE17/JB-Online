<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Models\BlogFeed;

class BlogFeedController extends APIController
{
    public function feed()
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"
            ."<feed xmlns=\"http://www.w3.org/2005/Atom\">\n"
            ."  <title>".env('APP_NAME')."</title>\n"
            ."  <author><name>".env('APP_AUTHOR')."</name></author>\n"
            ."  <updated>".date("c")."</updated>\n";
        $feeds = BlogFeed::all();
        foreach ($feeds as $feed) {
            $xml .= $feed->xmlItem();
        }
        $feed = $feed."</feed>";

        return response($feed)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
