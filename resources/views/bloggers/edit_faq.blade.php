@extends('lms::bloggers.blogger_main')
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endsection

@section('content')
    <h1> Edit Post </h1>
    <div class="d-flex justify-content-end">
        <a href="{{ route('blogger_v_faq') }}" class="btn btn-lg btn-info"> View FAQs </a>
    </div>

    @include('lms::session_msg')

    <form method="POST" action="{{ route('blogger_update_faq', compact('faq')) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="title"> Title </label>
            <input type="text" class="form-control mb-1 @error('title') is-invalid @enderror" id="title"
                name="title" placeholder="Title" value="{{ $faq->title ?? '' }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea type="password" class="form-control mb-2" rows="15" id="message" name="message" placeholder="Message">{{ $faq->message ?? '' }}</textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <img src="{{ asset('vendor/lms/storage/' . $faq->upload_img) }}" alt="lms" width="100" height="50"
            class="img-fluid mb-1" />
        <div class="form-group">
            <input type="file" class="d-none" id="upload_img" name="upload_img">
            <label class="btn btn-info" for="upload_img"> <i class="fa fa-upload" aria-hidden="true"></i> Upload Image
            </label>
            @error('upload_img')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-lg btn-info">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Update FAQ
        </button>
    </form>
@endsection

@section('page-js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/8u3ztd4lh4p738dj3wqjofivswytdrssy8lgrqzc5jb4vcce/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        $(function() {
            tinymce.init({
                selector: 'textarea#message',
                menubar: false,
                plugins: 'lists, link, image, media',
                toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            });

            setTimeout(() => {
                $('.alert').fadeOut();
                $('#title,#message').removeClass('is-invalid');
            }, 5000);

        });
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
