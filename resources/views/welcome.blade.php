@extends ('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{route('post')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-12">
                        <label for="status">Status</label>
                        <textarea name="status" id="status" class="form-control" style="width:100%"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="structure_id">Structure</label>
                        <select name="structure_id" class="form-control" id="structure_id">
                            <option value="0">All Structures</option>
                            @foreach($structures as $structure)
                                <option value="{{$structure->id}}">{{$structure->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="images">Images</label>
                        <input type="file" class="form-control" name="images[]" id="images" multiple>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @foreach($posts as $post)
                @include('includes.posts', ['post' => $post])
            @endforeach
        </div>
    </div>
@endsection