<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Email Template</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery & Summernote CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>
<body class="bg-light">
    <div class="container my-4">
        <h1 class="h2 fw-bold mb-4">Edit Email Template</h1>

        <form action="{{ route('email_templates.update', $emailTemplate) }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')

            <!-- Template Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Template Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $emailTemplate->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Subject -->
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror"
                    value="{{ old('subject', $emailTemplate->subject) }}">
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content with Placeholder Instructions -->
            <div class="mb-3">
                <label for="content" class="form-label">
                    Content
                    <small class="text-muted">(Use {!! '{{name}}' !!}, {!! '{{email}}' !!} as placeholders)</small>
                </label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror">{{ old('content', $emailTemplate->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Template</button>
        </form>
    </div>

    <!-- Summernote Initialization -->
<script>
    $(document).ready(function () {
        $('#content').summernote({
            height: 300,
            placeholder: {!! "'Write your email content here using {{name}}, {{email}}, etc.'" !!},
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'table']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
