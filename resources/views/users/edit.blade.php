<x-templates.default>
    @section('title')
        Edit User
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Edit Users</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('users.update', [$users->id]) }}" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" disabled id="email"
                                        placeholder="Enter Email" value="{{ $users->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password"
                                        class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}"
                                        name="password" id="password" placeholder="Enter Password">
                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text"
                                        class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" name="name"
                                        id="name" placeholder="Enter Name" value="{{ $users->name }}">
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select name="level" id="level"
                                        class="form-control {{ $errors->first('level') ? 'is-invalid' : '' }}">
                                        <option value="admin" @if ($users->level=="admin") selected @endif>Admin</option>
                                        <option value="mentor" @if ($users->level=="mentor") selected @endif>Mentor</option>
                                    </select>
                                    <span class="error invalid-feedback">{{ $errors->first('level') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender"
                                        class="form-control {{ $errors->first('gender') ? 'is-invalid' : '' }}">
                                        <option value="pria" @if ($users->gender=="pria") selected @endif>Pria</option>
                                        <option value="wanita" @if ($users->gender=="wanita") selected @endif>Wanita</option>
                                    </select>
                                    <span class="error invalid-feedback">{{ $errors->first('gender') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text"
                                        class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}"
                                        name="phone" id="phone" placeholder="Enter Phone"
                                        value="{{ $users->phone }}">
                                    <span class="error invalid-feedback">{{ $errors->first('phone') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="addres">Address</label>
                                    <textarea name="address" id="address" class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}">{{$users->address}}</textarea>
                                    <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <div class="input-group">
                                     <img src="{{asset('uploads/'.$users->avatar)}}" width=150px>
        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="avatar"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input {{ $errors->first('avatar') ? 'is-invalid' : '' }}"
                                                name="avatar" id="avatar">
                                            <label class="custom-file-label" for="avatar">Choose file</label>
                                        </div>
                                        <span class="error invalid-feedback">{{ $errors->first('avatar') }}</span>
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
