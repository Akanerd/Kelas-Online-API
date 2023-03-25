<x-templates.default>
    @section('title')
        Users Data
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Users Data</h3>
                    </div>
                    @include('alert.success')
                    <br>
                    <div class="card-body table-responsive">
                        @if (Request::get('keyword'))
                        <a href="{{route('users.index')}}" class="btn btn-success">Back</a>
                        @else
                        <a href="{{route('users.create')}}" class="btn btn-primary">Create</a>
                        @endif
                        <hr>
                        <form action="{{route('users.index')}}" method="get">
                        <div class="row">
                            <div class="col-2">
                                <b>Search Name</b>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{Request::get('keyword')}}" id="keyword" name="keyword">
                            </div>
                            <div class="col-3">
                                <select name="level" id="level" class="form-control">
                                    <option value="admin" @if(Request::get('level')=="admin") selected @endif>Admin</option>
                                    <option value="mentor" @if(Request::get('level')=="mentor") selected @endif>Mentor</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
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
                                    <th>Level</th>
                                    <th>Gender</th>
                                    <th>Avatar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $row)
                                    <tr>
                                        <td>{{$loop->iteration + ($users->perPage() * ($users->currentPage() - 1))}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->level}}</td>
                                        <td>{{$row->gender}}</td>
                                        <td><img class="img-thumbnail" src="{{asset('uploads/'.$row->avatar)}}" width="150px"></td>
                                        <td>
                                            <a href="{{route('users.edit',[$row->id])}}" class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{route('users.destroy', [$row->id])}}" method="post" class="d-inline" onsubmit="return confirm('Delete This Item ?')">
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <input type="submit" class="btn btn-danger btn-sm" value="delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$users->appends(Request::all())->links()}}
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
</x-templates.default>
