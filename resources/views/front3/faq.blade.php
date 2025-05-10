@extends('front3.layouts.master')
@section('title', 'FAQs')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-12 mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body" id="dc-body">
                    <div class="dash-sss">
                        @foreach ($faqs as $item)
                        <div class="sss-tab">
                            <div class="sss-htab">
                                <div class="row">
                                    <div class="col">
                                    {{$item->question}}
                                    </div>
                                    <div class="col-auto align-self-center right-p">
                                        <i class="fa fa-chevron-up"></i>
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="ss-tab-content">
                                {{$item->answer}}
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


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
                    If you cannot find what you are looking for, please open a <a href="{{route('user.tickets')}}">Support Ticket. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$('.sss-tab').click(function() {
    if ($(this).hasClass('active')) {
        $(this).find('.ss-tab-content').slideToggle(200);
        $(this).toggleClass('active');
    } else {
        $('.sss-tab').removeClass('active');
        $('.sss-tab > .ss-tab-content').slideUp(200);
        $(this).find('.ss-tab-content').slideToggle(200);
        $(this).toggleClass('active');
    }
});
</script>
@endpush
