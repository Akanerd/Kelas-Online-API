<x-templates.default>
    @section('title')
        Course Page
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Course Data</h3>
                    </div>
                    @include('alert.success')
                    <div class="card-body table-responsive">
                        @if (Request::get('keyword'))
                            <a href="{{ route('course.index') }}" class="btn btn-success">Back</a>
                        @else
                        <a href="{{ route('course.create') }}" class="btn btn-primary btn-sm">Create</a>
                        @endif
                        <hr>
                        <form action="{{ route('course.index') }}" method="get">
                            <div class="row">
                                <div class="col-2">
                                    <b>Search Title</b>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" value="{{ Request::get('keyword') }}"
                                        id="keyword" name="keyword">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <a class="btn bg-gradient-primary" href="{{ route('course.index') }}">Published</a>
                                    <a class="btn btn-outline-primary" href="{{ route('course.trash') }}">Trash</a>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Mentor</th>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($course as $row)
                                    <tr>
                                        <td>{{ $loop->iteration + $course->perpage() * ($course->currentPage() - 1) }}</td>
                                        <td>{{ $row->category->name }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td><img class="img-thumbnail" src="{{ asset('uploads/' . $row->thumbnail) }}"
                                                width="150px"></td>
                                        <td>
                                            <a href="{{ route('course.edit', [$row->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form class="d-inline" action="{{ route('course.destroy', [$row->id]) }}"
                                                method="post" onsubmit="return confirm('Move This Data To Trash ?')">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                            </form>
                                            <a href="{{ route('course.show', [$row->id]) }}" class="btn btn-warning btn-sm">Show</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $course->appends(Request::all())->links() }}
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
</x-templates.default>
