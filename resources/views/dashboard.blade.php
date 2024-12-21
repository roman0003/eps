@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Statistics Section -->
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Photos</h5>
                    <p class="card-text display-4">{{ $folders->sum(fn($folder) => $folder->images->count()) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Folders</h5>
                    <p class="card-text display-4">{{ $folders->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Folders Section -->
    <div class="card">
        <div class="card-header">
            <h5>Recent Folders</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($folders as $folder)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $folder->name }}</strong>
                        <span class="badge bg-primary ms-2">{{ $folder->images->count() }} photos</span>
                    </div>
                    <form method="POST" action="/folders/{{ $folder->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Create Folder Form -->
    <div class="card">
        <div class="card-header">
            <h5>Create New Folder</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/folders">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Enter folder name" required>
                </div>
                <button class="btn btn-primary w-100">Create Folder</button>
            </form>
        </div>
    </div>

    <!-- Upload Image Form -->
    <div class="card">
        <div class="card-header">
            <h5>Upload Image</h5>
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <select name="folder_id" class="form-select" required>
                        @foreach ($folders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button class="btn btn-success w-100">Upload Image</button>
            </form>
        </div>
    </div>

    <!-- Folder and Images Section -->
    @foreach ($folders as $folder)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $folder->name }}</h5>
            <form method="POST" action="/folders/{{ $folder->id }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete Folder</button>
            </form>
        </div>
        <div class="card-body">
            <h6>Photos:</h6>
            <div class="row">
                @foreach ($folder->images as $image)
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <!-- Display the Image -->
                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" alt="Photo">

                    <!-- Add the Download Button -->
                    <a href="{{ route('images.download', $image->id) }}" class="btn btn-primary btn-sm mt-2 w-100">Download</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection