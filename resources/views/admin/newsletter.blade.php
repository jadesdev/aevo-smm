@extends('admin.layouts.master')
@section('title') @lang('Newsletter') @stop
@section('content')
<div class="d-card">
    <h5 class="card-header fw-bold">@lang('Newsletter') </h5>
    <form action="{{ route('admin.newsletter') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-card-body">
            <div class="form-group">
                <label class="form-label">@lang('Send Email to ')</label>
                <div class="btn-group mt-2" data-toggle="select">
                    <label class="btn btn-primary n-butn">
                        <input type="checkbox" name="user_emails" value="1" class="btn btn-check" checked>
                        <span>@lang('Users')</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="name">@lang('Other Emails') (comma separated)</label>
                <textarea class="form-control" name="other_emails" id="" rows="3" placeholder="Other Emails"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="subject">@lang('Newsletter Subject')</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('Newsletter Content')</label>
                <textarea class="form-control text-editor" name="content" id="tiny1" rows="4" placeholder="Mail Body" > </textarea>
            </div>
            <div class="form-group mb-0 text-end">
                <button class="btn btn-primary w-100 btn-md" type="submit">@lang('Send')</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('styles')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@push('scripts')
<!--Wysiwig js-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}
<script>
$(document).ready(function() {
    $('.text-editor').summernote({
        tabsize: 2,
        height: 300
    });
});
</script>
@endpush
