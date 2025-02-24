@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name: *</label>
                            <input type="text" id="first_name" name="first_name" class="form-control"
                            value="{{ old('first_name', $user->first_name) }}">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name: *</label>
                            <input type="text" id="last_name" name="last_name" class="form-control"
                            value="{{ old('last_name', $user->last_name) }}">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role: *</label>
                            <select name="role_id" id="role_id" class="form-control">
                                <option value="">--Select Role--</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email: *</label>
                            <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $user->email) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username: *</label>
                            <input type="text" id="username" name="username" class="form-control"
                            value="{{ old('username', $user->username) }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div>
                                <label for="avatar">Avatar:</label>
                                <input type="file" id="avatar" name="avatar" class="form-control-file" onchange="previewAvatar()">
                            </div>
                            <div class="ml-3">
                                <img id="avatar-preview"
                                src="{{ $user->avatar ? asset('images/' . $user->avatar) : '#' }}" alt="Avatar Preview"
                                class="img-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                            </div>
                            @error('avatar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#confirmCancelModal">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCancelModalLabel">Confirm Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        Are you sure you want to cancel the user editing process?
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('user.index') }}" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewAvatar() {
            var file = document.getElementById('avatar').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                var preview = document.getElementById('avatar-preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                var preview = document.getElementById('avatar-preview');
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@stop
