<x-templates.default>
    @section('title')
        Create Course
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Create Course</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('course.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error invalid-feedback">{{ $errors->first('category_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="user_id">Mentor</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        @foreach ($users as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error invalid-feedback">{{ $errors->first('user_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text"
                                        class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}" value="{{old('title')}}" name="title"
                                        id="title">
                                    <span class="error invalid-feedback">{{ $errors->first('title') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control {{$errors->first('description') ? 'is-invalid' : '' }}" name="description" id="description">{{old('description')}}</textarea>
                                    <span class="error invalid-feedback">{{ $errors->first('description') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="group">Group</label>
                                    <input type="text"
                                        class="form-control {{ $errors->first('group') ? 'is-invalid' : '' }}" name="group"
                                        id="group" value="{{old('group')}}">
                                    <span class="error invalid-feedback">{{ $errors->first('group') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input {{ $errors->first('thumbnail') ? 'is-invalid' : '' }}"
                                                name="thumbnail" id="thumbnail">
                                            <label class="custom-file-label" for="thumbnail">Choose file</label>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback">{{ $errors->first('thumbnail') }}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-templates.default>
