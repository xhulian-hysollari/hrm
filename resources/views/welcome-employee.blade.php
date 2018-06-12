@extends ('layouts.main_employee')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @foreach($posts as $post)
                @include('includes.posts', ['post' => $post])
            @endforeach
        </div>
    </div>
@endsection