@extends('user4.layouts.master')
@section('title', 'Services')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-body table-responsive" id="dc-body">

                <form class="app-search" method="get">
                    <label for="" class="form-label">Search Services</label>
                    <input type="text" id="serv-inp" class="form-control app-input" value="{{ $request->has('name') ? $request->input('name') : '' }}" name="name" placeholder="Enter the service you are looking for..">
                    <button type="search" class="app-ord-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                @forelse ($categories as $category)
                <table class="table app-mtable my-3" width="100%">
                    <thead>
                        <tr class="catetitle">
                            <td colspan="8"><strong>{{$category->name}}</strong></td>
                        </tr>
                        <tr class="thead-tr">
                            <th class="nowrap">ID</th>
                            <th class="nowrap width-service-name">Service Name</th>
                            <th class="nowrap">Rate per 1000 </th>
                            <th class="nowrap">Min / Max</th>
                            <th class="service-description__th">Description</th>
                        </tr>
                    </thead>

                    <tbody class="w-100">
                        @foreach ($category->service()->whereStatus(1)->get() as $item)
                        <tr class="app-block">
                            <td class="app-col" data-title="ID">{{$item->id}}</td>
                            <td class="app-col mk-icons" data-title="Name">{{$item->name}}</td>
                            <td class="app-col" data-title="Price per 1000">{{format_amount($item->price)}}</td>
                            <td class="app-col" data-title="Min-Max"><span class="text-danger">{{$item->min}}</span> - <span class="text-success">{{$item->max}}</span></td>
                            <td class="app-col" data-title="Action">
                                <a type="button" class="desc-btn" data-toggle="modal" data-target="#exampleModal{{$item->id}}"><i class="far fa-eye"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$item->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{$item->name}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{!! nl2br($item->description) !!}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @empty
                <p>Services Not found</p>
                @endforelse


            </div>
            <div class="mt-3 text-right">
                {{$categories->links()}}
            </div>
        </div>

    </div>
</div>

@endsection
@section('styles')
<style>
    @media (max-width: 992px) {
    .thead-tr {
        display: none !important;
    }

}
.app-block{
    width: 100% !important;
}
</style>
@endsection
@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Our prices are calculated based on 1000 units.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
