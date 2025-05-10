@extends('admin.layouts.master')
@section('title', 'News Section')

@section('content')
<div class="col-12">
    <div class="d-card">
        <div class="card-header d-flex justify-content-between">
            <h4> All News Updates</h4>
            <a href="#" data-toggle="modal" data-target="#createPlan"class="btn btn-primary btn-sm">Add News</a>
        </div>
        <div class="d-card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{text_trim($item->message, 200)}}</td>
                        <td>
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPlan-{{$item->id}}"  href="#" ><i class="fa fa-edit"></i></a>
                            <a class="delete-btn btn btn-danger btn-sm" href="{{route('admin.setting.news.delete' ,[$item->id])}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="editPlan-{{$item->id}}" tabindex="-1"  aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Edit News Update</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.setting.news.update', $item->id)}}" enctype="multipart/form-data" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" required value="{{$item->title}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" name="message" placeholder="Update Information" rows="6" required>{{$item->message}}</textarea>
                                    </div>
                                    <div class="form-group text-end">
                                        <button class="btn-success w-100 btn" type="submit">Update News Update</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createPlan" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold">Create News Update</h5>
        </div>
        <div class="modal-body">
            <form action="{{route('admin.setting.news.create')}}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required value="">
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" name="message" placeholder="Update Information" rows="6" required> </textarea>
                </div>
                <div class="form-group text-end">
                    <button class="btn-success w-100 btn" type="submit">Create News Update</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection


@section('styles')
<style>
    .primage {
        max-height: 150px !important;
        max-width: 150px !important;
        margin: 0;
    }
</style>
@endsection
