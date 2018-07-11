<div class="row" style="margin: 0 -25px; border-top:20px solid #f6f6f6; padding: 15px 15px 0 15px">
    @if(count($post->images) > 0)
        <div class="col-6">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($post->images as $index => $image)
                        <div class="carousel-item @if($index === 0) active @endif">
                            <img class="d-block w-100"
                                 {{--src="{{asset($image->path)}}"--}}
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
        <div class="col-6">
            <h3>{{$post->title}} <span class="pull-right"
                                       style="font-size: 15px; font-weight: initial;"><i>Posted by:</i> <b>{{$post->author}}</b> @ {{\Carbon\Carbon::parse($post->created_at)->format('d M Y')}}</span>
            </h3>
            <hr>
            {{$post->body}}
        </div>
    @else

        <div class="col-12">
            <h3>{{$post->title}} <span class="pull-right"
                                       style="font-size: 15px; font-weight: initial;"><i>Posted by:</i> <b>{{$post->author}}</b> @ {{\Carbon\Carbon::parse($post->created_at)->format('d M Y')}}</span>
            </h3>
            <hr>
            {{$post->body}}
        </div>
    @endif
</div>
<div class="row">
    <div class="col-12" style="padding: 20px">
        @foreach($post->comments as $comment)
            <div>
                <h4>{{$comment->author}} <span style="font-size: small; font-weight: 500;">{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span></h4>
                {{$comment->body}}
                <br>
            </div>
            <hr>
        @endforeach
        <form action="{{route('comment', ['post_id' => $post->id])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="text" class="form-control" name="comment" id="comment-{{$post->id}}">
            <button class="btn btn-primary">Comment</button>
        </form>
    </div>
</div>
