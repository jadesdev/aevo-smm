@extends('admin.layouts.master')
@section('title') @lang('Edit Newsletter') @stop
@section('content')
<div class="d-card">
    <h5 class="card-header fw-bold">@lang('Edit Newsletter') </h5>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-card-body">
            <div class="form-group">
                <label class="form-label">@lang('Send Email to ')</label>
                <div class="btn-group mt-2" data-toggle="select">
                    <label class="btn btn-primary n-butn">
                        <input type="checkbox" name="user_emails" value="1" class="btn btn-check" @if($nl->user_emails)checked @endif>
                        <span>@lang('Users')</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="name">@lang('Other Emails') (comma separated)</label>
                <textarea class="form-control" name="other_emails" id="" rows="3" placeholder="Other Emails">{{$nl->other_emails}}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="date">@lang('Send Date')</label>
                <input type="text" class="form-control" name="date" id="dtpicker" value="{{$nl->date}}" placeholder="Date" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="subject">@lang('Newsletter Subject')</label>
                <input type="text" class="form-control" name="subject" id="subject" value="{{$nl->subject}}" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('Newsletter Content')</label>
                <textarea class="form-control text-editor" name="content" id="tiny1" rows="4" placeholder="Mail Body" >{{$nl->content}}</textarea>
            </div>
            <div class="form-group mb-0 text-end">
                <button class="btn btn-primary w-100 btn-md" type="submit">@lang('Update')</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('styles')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@6659d24c7d2a9c782dc2058dcf4267603934c863/css/bootstrap-material-datetimepicker-bs4.min.css">
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/moment/moment@develop/min/moment-with-locales.min.js"></script>
<!--Wysiwig js-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@83a10c38ee94dd27fd946ea137af6667c65a738f/js/bootstrap-material-datetimepicker-bs4.min.js"></script>
<script>
$(document).ready(function() {
    $('.text-editor').summernote({
        tabsize: 2,
        height: 300
    });
});
</script>
<script>
    $(function() {
        var $now = moment();
        var $dateMin = $now.subtract(1, 'days');

        $('#dtpicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm',
            shortTime: false,
            minDate: $dateMin,
            currentDate: $now,
            date: true,
            time: true,
            monthPicker: false,
            year: true,
            clearButton: false,
            nowButton: true,
            switchOnClick: true,
            cancelText: 'Cancel',
            //okText: 'VALIDER',
            //clearText: 'EFFACER',
            //nowText: 'MAINTENANT',
            //triggerEvent: 'focus',
            //lang: 'en',
            //weekStart: 1,
        });
    });
</script>
@endpush
