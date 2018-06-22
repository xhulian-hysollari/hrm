<div class="row" style="margin: 0 -21px; border-top:20px solid #f6f6f6; padding-top: 15px">
    @if(count($post->images) > 0)
        <div class="col-6">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($post->images as $index => $image)
                        <div class="carousel-item active">
                            <img class="d-block w-100"
                                 data-src="holder.js/800x400?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide"
                                 alt="First slide [800x400]"
                                 {{--src="{{$image->path}}"--}}
                                 src="https://images.unsplash.com/photo-1515163988842-60ece4c9a5bb?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=7e6b67128f0c03c7bd1ecfbe6f890b1f&w=1000&q=80"
                                 data-holder-rendered="true">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    @endif
    <div class="col-6">
        <h3>{{$post->title}}</h3>
        <hr>
        {{$post->body}}
    </div>
</div>
<div class="row">
    <div class="col-12" style="padding: 20px">
        @foreach($post->comments as $comment)
            <div>
                    {{$comment->body}}
                </div>
            @endforeach

        <form action="{{route('comment', ['post_id' => $post->id])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="text" class="form-control" name="comment" id="comment-{{$post->id}}">
            <button class="btn btn-primary">Comment</button>
        </form>
    </div>
</div>