<x-templates.default>
    @section('title')
        Module Page - {{ $course->title }}
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Course Module - {{ $course->title }}</h3>
                    </div>
                    <div class="card-body table-responsive">
                        @include('alert.success')
                        <a href="{{ route('module.create', [$course_id]) }}" class="btn btn-primary">Create</a>
                        <br><hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>File Type</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($module as $row)
                                    <tr>
                                        <td>{{ $loop->iteration + ($module->perPage() * ($module->currentPage() - 1)) }}
                                        </td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{$row->module_type}}
                                        @if ($row->module_type == "file")
                                            {{$row->filetype}}
                                        @endif
                                        </td>
                                        <td>
                                            @if ($row->module_type == "file")
                                            <a class="btn btn-info btn-sm" href="{{ route('module.download', [$row->id]) }}">Download</a>
                                            @else
                                            <iframe width="200" height="100" src="https://www.youtube.com/embed/{{$row->youtube}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('module.edit', [$row->id]) }}" class="btn btn-info btn-sm">Edit</a>
                                            <a href="{{ route('module.show', [$row->id]) }}" class="btn btn-warning btn-sm">Show</a>
                                            <form action="{{ route('module.destroy', [$row->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete This Item ?')">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$module->links()}}
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
</x-templates.default>
