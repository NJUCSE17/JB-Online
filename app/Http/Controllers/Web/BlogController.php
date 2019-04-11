<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogFeed;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.index')
            ->with('feeds', BlogFeed::query()->paginate(15));
    }

    /**
     * Display the specified resource.
     *
     * @param  BlogFeed  $feed
     *
     * @return \Illuminate\Http\Response
     */
    public function show(BlogFeed $feed)
    {
        return view('blog.feed')
            ->with('feed', $feed);
    }
}
