@extends('admin.layouts.master')
@section('title') @lang('Newsletter') @stop
@section('content')
<div class="d-card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="fw-bold">@lang('Newsletter') </h5>
        <a class="btn btn-sm btn-primary" href="{{route('admin.newsletter.add')}}">Send Emails</a>
    </div>

    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nls as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->subject}}</td>
                    <td>{{$item->date}}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">sent</span>
                        @else
                            <span class="badge bg-warning">scheduled</span>
                        @endif
                    <td>
                        <a class="btn btn-light btn-sm" type="button" href="{{route('admin.newsletter.edit', $item->id)}}" >
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" type="button" href="{{route('admin.newsletter.delete', $item->id)}}" >
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
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
