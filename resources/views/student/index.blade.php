<x-templates.default>
    @section('title')
        Student Page
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Student Data</h3>
                    </div>
                    <div class="card-body table-responsive">
                        @include('alert.success')
                        @if (Request::get('keyword'))
                        <a href="{{ route('student.index') }}" class="btn btn-success">Back</a>                                
                        @else
                        <a href="{{ route('student.create') }}" class="btn btn-primary">Create</a>
                        @endif
                        <hr>
                        <form action="{{ route('student.index') }}" method="get">
                            <div class="row">
                                <div class="col-2">
                                    <b>Search Name</b>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" value="{{Request::get('keyword')}}" name="keyword" id="keyword">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Avatar</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student as $row)
                                <tr>
                                    <td>{{ $loop->iteration + ($student->perPage() * ($student->currentPage() - 1)  )  }}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->gender}}</td>
                                    <td>{{$row->phone}}</td>
                                    <td><img src="{{ asset('uploads/'.$row->avatar) }}" width="150px" class="img-thumbnail"></td>
                                    <td>{{$row->status}}</td>
                                    <td>
                                        <a href="{{ route('student.edit', [$row->id]) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('student.resetpassword', [$row->id]) }}" class="d-inline" method="post" onsubmit="return confirm('Reset Password This Student?')">
                                        @csrf
                                        <input type="submit" value="Reset Password" class="btn btn-success btn-sm">
                                        </form>
                                        <form action="{{ route('student.destroy', [$row->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete This Item ?')">
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
                        {{$student->appends(Request::all())->links()}}
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
</x-templates.default>
