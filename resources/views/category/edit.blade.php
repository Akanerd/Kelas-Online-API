<x-templates.default>
    @section('title')
        Edit Category
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Edit Categories</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('category.update',[$category->id])}}" enctype="multipart/form-data">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text"
                                        class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                                        name="name" id="name" placeholder="Enter Category Name" value="{{$category->name}}">
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <div class="input-group">
                                        <img src="{{asset('uploads/'.$category->thumbnail)}}" class="img-thumbnail" width="150px">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {{ $errors->first('thumbnail') ? 'is-invalid' : '' }}" name="thumbnail" id="thumbnail">
                                            <label class="custom-file-label" for="thumbnail">Choose file</label>
                                        </div>
                                    <span class="error invalid-feedback">{{ $errors->first('thumbnail') }}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-templates.default>
