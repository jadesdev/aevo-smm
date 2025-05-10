@extends('front4.layouts.master')
@section('title', 'Services')

@section('content')
<div class="banner__section container">
    <div class="card">
        <div class="card-header border-0 py-3">
            <div class="row justify-content-end">
                <div class="col-md-5 col-sm-6">
                    <div class="form-group mb-2">
                        <select class="form-control form-select select2" data-toggle="select2"  onchange="window.location.href = this.options[this.selectedIndex].getAttribute('data-link')" >
                            <option value="" data-link="?category=" selected="">@lang('Select Category')</option>
                            @foreach($categoriz as $category)
                                <option value="{{$category->id}}" data-link="?category={{$category->id}}" {{($category->id == request()->input('category')) ? 'selected' : ''}}>@lang($category->name)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group mb-2">
                        <input type="text" name="name" id="searchName" value="{{@request()->service}}" class="form-control" placeholder="@lang('Search for Service ID or Name')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <button type="submit" id="searchBtn" class="btn w-100 btn-primary">
                            <i class="fas fa-search"></i> @lang('Search')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" width="100%">
                    <thead>
                        <tr class="table-dark">
                            <th class="nowrap">@lang('ID')</th>
                            <th class="nowrap">@lang('Service Name')</th>
                            <th class="nowrap">@lang('Rate per 1000')</th>
                            <th class="nowrap">@lang('Min') </th>
                            <th class="nowrap">@lang('Max')</th>
                            <th class="nowrap">@lang('Description')</th>
                        </tr>
                    </thead>
                    <tbody id="service-body">
                    @foreach ($categories as $category)
                        @if( 0 < count($category->services))
                        <tr class="services-list-category-title" data-filter-table-category-id="{{$category->id}}">
                            <td colspan="6" class="fw-bold services-category ">
                                <h6> {{$category->name}}</h6>
                            </td>
                        </tr>
                        @foreach($category->services as $service)
                        <tr  data-filter-table-category-id="{{$category->id}}">
                            <td data-service-id="{{$service->id}}">{{$service->id}}</td>
                            <td class="table-service" data-filter-table-service-name="true">{{$service->name}}</td>
                            <td >{{format_amount($service->price)}} </td>
                            <td >{{$service->min}}</td>
                            <td >{{$service->max}}</td>
                            <td data-label="" class="">
                                <button type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#serviceDesc" id="details"
                                    data-id="{{$service->id}}"
                                    data-servicetitle="{{$service->name}}"
                                    data-description="{!! nl2br($service->description) !!}">
                                    @lang('View')
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Description Modal --}}
<div class="modal fade" id="serviceDesc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title" id="title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="servicedescription">
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>

</style>
@endpush
@push('scripts')
<script>
    "use strict";
    $(document).on('click', '#details', function () {
        var title = $(this).data('servicetitle');
        var id = $(this).data('id');

        var description = $(this).data('description');
        $('#title').text(title);
        $('#servicedescription').html(description);
    });
</script>

<script>
    $(document).ready(function () {
        $('#searchName').on('keyup', function (e) {

            e.preventDefault();

            // Get the search query
            var searchQuery = $('#searchName').val().toLowerCase();

            // Hide all category titles initially
            $('tr.services-list-category-title').hide();

            // Hide all rows initially
            $('tbody tr').hide();

            // Loop through each row and show only those that match the search query
            $('tbody tr').each(function () {
                var serviceName = $(this).find('.table-service').text().toLowerCase();
                if (serviceName.includes(searchQuery)) {
                    // Show the category title for the matching service
                    var categoryId = $(this).data('filter-table-category-id');
                    $('tr.services-list-category-title[data-filter-table-category-id="'+ categoryId +'"]').show();

                    // Show the matching service row
                    $(this).show();
                }
            });
        });
    });
</script>
@endpush

