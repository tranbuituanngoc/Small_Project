<!-- filepath: /d:/Work/SmallProject/small-project/resources/views/profile/index.blade.php -->
<!-- filepath: /d:/Work/SmallProject/small-project/resources/views/profile/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1 class="text-center">User Profile</h1>
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

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-header text-black bold">
            <h3 class="card-title">Profile Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('PATCH')
                <div class="form-group text-center">
                    <label for="avatar" class="font-weight-bold">Avatar</label>
                    <div class="d-flex justify-content-center">
                        <img id="avatar-preview" src="{{ $user->getAvatarUrl() }}"
                            alt="Avatar" class="img-thumbnail rounded-circle shadow-lg"
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer; transition: 0.3s;"
                            onclick="showAvatarOptions()">
                    </div>
                    <input type="file" id="avatar" name="avatar" class="d-none" onchange="previewAvatar()">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Update Profile</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for avatar options -->
    <div class="modal fade" id="avatarOptionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Change Avatar</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <img id="avatar-modal-preview" src="{{ $user->getAvatarUrl() }}"
                        alt="Avatar" class="img-thumbnail rounded-circle shadow-lg mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('avatar').click()">
                        <i class="fas fa-upload"></i> Upload New Avatar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAvatarOptions() {
            $('#avatarOptionsModal').modal('show');
        }

        function previewAvatar() {
            var file = document.getElementById('avatar').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                document.getElementById('avatar-preview').src = reader.result;
                document.getElementById('avatar-modal-preview').src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop
