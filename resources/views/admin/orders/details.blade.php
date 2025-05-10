@extends('admin.layouts.master')
@section('title', 'Order Details')

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Edit and Update Order.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-card my-4 m-md-0">
            <div class="d-card-body">
                <form method="post" action="{{route('admin.orders.update', $order->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="category_id">@lang('Category')</label>
                                        <input type="text" class="form-control" value="{{ optional(optional($order->service)->category)->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="service_id">@lang('Service')</label>
                                        <input type="text" class="form-control" value="{{ optional($order->service)->name }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>@lang('Quantity')</label>
                                        <input type="number" name="quantity" id="quantity" value="{{ $order->quantity }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Start Counter')</label>
                                        <input type="number" name="start_counter" value="{{ old('start_counter',$order->start_counter) }}" placeholder="{{ __('start counter') }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>@lang('Interval')</label>
                                        <input type="number" name="interval" value="{{ $order->interval }}" placeholder="{{ __('interval') }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Runs')</label>
                                        <input class="form-control" type="text" placeholder="{{ __('runs') }}" value="{{ $order->runs }}" disabled>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('API Provider')</label>
                                        <input class="form-control" type="text" placeholder="{{ __('API Provider') }}" value="{{ optional(optional($order->service)->provider)->name }}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('API Order ID')</label>
                                        <input class="form-control" type="text" placeholder="{{ __('API Order ID') }}" value="{{ $order->api_order_id }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label>@lang('API Response')</label>
                                <textarea class="form-control" rows="5" placeholder="{{ __('API Response') }}" disabled>{{ $order->response }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>@lang('User')</label>
                                        <a class="form-control" href="{{ route('admin.users.detail', $order->user_id) }}"> {{ __($order->user->username) }} </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('ORDER ID')</label>
                                        <input class="form-control" type="text" value="{{ $order->id }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label>@lang('Link')</label>
                                <input type="text" name="link" value="{{ old('link',$order->link) }}"
                                       placeholder="www.example.com/your_profile_identity" class="form-control">
                                @error('link')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>@lang('Remains')</label>
                                        <input type="number" name="remain" value="{{ old('remains',$order->remain) }}"
                                               placeholder="remains" class="form-control">
                                        @error('remains')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Start counter')</label>
                                        <input class="form-control" type="number" name="start_counter" id="start_counter"
                                               value="{{ old('start_counter',$order->start_counter) }}">
                                        @error('start_counter')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('Change Status')</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>@lang('Processing')</option>
                                            <option value="inprogress" {{ $order->status == 'inprogress' ? 'selected' : '' }}>@lang('In progress')</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                            <option value="partial" {{ $order->status == 'partial' ? 'selected' : '' }}>@lang('Partial')</option>
                                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>@lang('Canceled')</option>
                                        </select>
                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="submit-btn-wrapper mt-md-5 text-center text-md-left">
                        <button type="submit" class=" btn  btn-primary btn-block mt-3">
                            <span>@lang('Submit')</span></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
