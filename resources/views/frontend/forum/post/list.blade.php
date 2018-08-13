@foreach($group as $post)
    @include('frontend.forum.post.post', ['post'=>$post])
@endforeach