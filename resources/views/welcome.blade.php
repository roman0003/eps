<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8eaf7, #e0c3fc);
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 380px;
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container h1 {
            font-size: 22px;
            font-weight: bold;
            color: #6e3b6e;
            text-align: center;
            margin-bottom: 20px;
        }

        .custom-file-upload {
            display: block;
            width: 100%;
            padding: 50px 15px;
            text-align: center;
            border: 2px dashed #ddd;
            border-radius: 12px;
            background-color: #fafafa;
            color: #888;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-file-upload:hover {
            border-color: #8b458b;
            background-color: #f7ecf9;
            color: #6e3b6e;
        }

        .submit-btn {
            background: linear-gradient(45deg, #6e3b6e, #8b458b);
            color: #fff;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: bold;
            color: #6e3b6e;
        }

        /* Modal Styling */
        .modal-header {
            background: linear-gradient(135deg, #f8eaf7, #e0c3fc);
            color: #6e3b6e;
            border-bottom: none;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-body {
            color: #6e3b6e;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: #6e3b6e;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #8b458b;
        }

        .container {
            padding: 20px;
            width: 100%;
            max-width: 1200px;
        }

        .card-body {
            padding: 15px;
        }

        .card-header {
            background-color: #6e3b6e;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .img-fluid {
            border-radius: 5px;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #343a40;
            color: #fff;
        }

        /* Responsive design tweaks */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }
            .submit-btn {
                font-size: 14px;
                padding: 10px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Let's create lasting memories together!</h1>
            <form id="photoForm">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="photos" class="form-label">Upload Photos <small>(Exactly 10 photos required)</small></label>
                    <label for="photos" class="custom-file-upload">
                        <img src="https://via.placeholder.com/50" alt="Upload Icon" style="margin-bottom: 10px;">
                        <br>Click to upload your <br>10 best shots! 😍
                    </label>
                    <input type="file" id="photos" name="photos[]" multiple class="form-control d-none" accept="image/*">
                    <p id="filePreview" class="file-preview"></p>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>

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
        <div class="card mt-4">
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

        <footer>
            &copy; {{ date('Y') }} Admin Dashboard. All rights reserved.
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('photoForm');
        const emailInput = document.getElementById('email');
        const photosInput = document.getElementById('photos');
        const filePreview = document.getElementById('filePreview');
        const modalMessage = document.getElementById('modalMessage');
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

        photosInput.addEventListener('change', () => {
            const fileCount = photosInput.files.length;
            if (fileCount > 0) {
                filePreview.textContent = `${fileCount} file(s) selected`;
            } else {
                filePreview.textContent = '';
            }
        });

        form.addEventListener('submit', (event) => {
            const fileCount = photosInput.files.length;

            // Validate email
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                event.preventDefault();
                showModal('Please enter a valid email address.');
                return;
            }

            // Validate photo upload
            if (fileCount !== 10) {
                event.preventDefault();
                showModal('You must upload exactly 10 photos.');
                return;
            }
        });

        function showModal(message) {
            modalMessage.textContent = message;
            errorModal.show();
        }
    </script>
</body>
</html>
