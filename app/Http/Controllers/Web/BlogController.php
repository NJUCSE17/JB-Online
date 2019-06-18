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
        $feeds = BlogFeed::query()
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return view('blog.index')
            ->with('feeds', $feeds);
    }

    /**
     * Display the specified resource.
     *
     * @param  $feedID
     *
     * @return \Illuminate\Http\Response
     */
    public function show($feedID)
    {
        /* Blog is not a model, hence we need to find the model manually */
        return view('blog.feed')
            ->with('feed', BlogFeed::query()->findOrFail($feedID));
    }
}
