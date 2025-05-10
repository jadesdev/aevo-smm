@extends('admin.layouts.master')
@section('title', 'FAQs')

@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Frequestly Asked Questions</h5>
            <a href="#" data-toggle="modal" data-target="#CreateFaq" class="btn btn-primary btn-sm">Add Question</a>
        </div>
    </div>
    <div class="d-card-body">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="white">
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faqs as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->question}}</td>
                        <td>{{text_trim($item->answer, 100)}}</td>
                        <td>{!! get_status($item->status) !!}</td>
                        <td>
                            <div>
                                <a href="#" data-toggle="modal" data-target="#TrackEdit{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="TrackEdit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h6 class="modal-title" id="myModalLabel"> Edit {{$item->name}}</h6>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('admin.faqs.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}" >
                                    <div class="form-group">
                                        <label class="form-label">Question</label>
                                        <input type="text" class="form-control" value="{{$item->question}}" required placeholder="Question" name="question">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Answer</label>
                                        <textarea class="form-control" required rows="5" placeholder="Answer" name="answer">{{$item->answer}} </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" @if($item->status == 1) selected @endif>Enabled</option>
                                            <option value="2" @if($item->status == 2) selected @endif>Disabled</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success mt-2 w-100" type="submit">Edit FAQ</button>
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

<div class="modal fade" id="CreateFaq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="myModalLabel"> Add FAQ</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
          </div>
          <div class="modal-body">
            <form action="{{route('admin.faqs.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">Question</label>
                    <input type="text" class="form-control" required placeholder="Question" name="question">
                </div>
                <div class="form-group">
                    <label class="form-label">Answer</label>
                    <textarea class="form-control" required rows="5" placeholder="Answer" name="answer"></textarea>
                </div>
                <button class="btn btn-success mt-2 w-100" type="submit">Create FAQ</button>
            </form>
          </div>
      </div>
    </div>
</div>
@endsection

@section('breadcrumb')

@endsection
