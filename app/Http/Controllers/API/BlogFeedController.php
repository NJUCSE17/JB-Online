<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Resources\BlogFeedResource;
use App\Http\Resources\BlogFeedResourceCollection;
use App\Models\BlogFeed;
use Illuminate\Support\Facades\Request;

class BlogFeedController extends APIController
{
    /**
     * List blog feeds.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $blogFeeds = BlogFeed::query()->get();
        return $this->data(new BlogFeedResourceCollection($blogFeeds));
    }

    /**
     * Get one blog feed.
     *
     * @param  Request   $request
     * @param  BlogFeed  $blogFeed
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, BlogFeed $blogFeed) {
        return $this->data(new BlogFeedResource($blogFeed));
    }

    /**
     * Get the XML-format feed.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function xml()
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"
            ."<feed xmlns=\"http://www.w3.org/2005/Atom\">\n"
            ."  <title>".env('APP_NAME')."</title>\n"
            ."  <author><name>".env('APP_AUTHOR')."</name></author>\n"
            ."  <updated>".date("c")."</updated>\n";
        $feeds = BlogFeed::all();
        foreach ($feeds as $feed) {
            $xml .= $feed->feedItem();
        }
        $xml = $xml."</feed>";

        return response($xml)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
