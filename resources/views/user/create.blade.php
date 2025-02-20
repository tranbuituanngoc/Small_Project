<!-- filepath: /d:/Work/SmallProject/small-project/resources/views/user/create.blade.php -->
@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create User</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create User</h3>
    </div>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name: *</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"
                        value="{{ old('first_name') }}" >
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name: *</label>
                        <input type="text" id="last_name" name="last_name" class="form-control"
                        value="{{ old('last_name') }}" >
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password: *</label>
                        <input type="password" id="password" name="password" class="form-control" >
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password: *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control" >
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email: *</label>
                        <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email') }}" >
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username: *</label>
                        <input type="text" id="username" name="username" class="form-control"
                        value="{{ old('username') }}" >
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role: *</label>
                        <select name="role_id" id="role_id" class="form-control" >
                            <option value="">--Select Role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group  d-flex align-items-center">
                        <div>
                            <label for="avatar">Avatar:</label>
                            <input type="file" id="avatar" name="avatar" class="form-control-file" onchange="previewAvatar()">
                        </div>
                        <div class="ml-3">
                            <img id="avatar-preview" src="#" alt="Avatar Preview" class="img-thumbnail"
                            style="display: none; max-width: 100px; max-height: 100px; object-fit: contain;">
                        </div>
                        @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
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
