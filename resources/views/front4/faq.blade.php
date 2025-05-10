@extends('front4.layouts.master')
@section('title', 'FAQs')

@section('content')

<section class="accordion__section py-130" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center wow fadeInUp" data-wow-delay=".2s">
                    <h2 class="title">Here Are Some FAQs That Might Give A Better Understanding Of {{get_setting('title')}}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion__wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $key => $item)
                        <div class="accordion__item">
                            <div class="accordion__header" id="heading_{{$key}}">
                                <button class="accordion-button @if($loop->iteration != 1) collapsed @endif" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{$key}}" aria-expanded="true" aria-controls="collapse_{{$key}}">
                                    {{$item->question}}
                                </button>
                            </div>
                            <div id="collapse_{{$key}}" class="accordion-collapse collapse @if($loop->iteration == 1) show  @endif " aria-labelledby="heading_{{$key}}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="accordion__content">
                                        <p>
                                            <p> {{$item->answer}}.<br></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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
