<x-templates.default>
    @section('title')
        Module Page
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Course Data - {{ Auth::user()->name }}</h3>
                    </div>
                    <div class="card-body table-responsive">
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
                                        <td>{{ $loop->iteration + $course->perPage() * ($course->currentPage() - 1) }}
                                        </td>
                                        <td>{{ $row->category->name}}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td><img class="img-thumbnail" src="{{ asset('uploads/'.$row->thumbnail) }}" width="150px"></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('module.detail', [$row->id]) }}">Detail Module</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $course->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-templates.default>
