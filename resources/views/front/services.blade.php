@extends('front.layouts.master')
@section('title', 'Services')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-5 mb-lg-0">
            <div class="d-card">
                <div class="d-card-body table-responsive" id="dc-body">

                    <form class="app-search" method="get">
                        <label for="" class="form-label">Search Services</label>
                        <input type="text" id="serv-inp" class="form-control app-input" value="{{ $search }}" name="name" placeholder="Enter the service you are looking for..">
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
                                <th class="nowrap">Rate per 1000 ({{get_setting('currency')}})</th>
                                <th class="nowrap">Min / Max</th>
                                <th class="service-description__th">Description</th>
                            </tr>
                        </thead>

                        <tbody class="w-100">
                            @foreach ($category->service()->whereStatus(1)->get() as $item)
                            <tr class="app-block">
                                <td class="app-col" data-title="ID">{{$item->id}}</td>
                                <td class="app-col mk-icons" data-title="Name"> {{$item->name}}</td>
                                <td class="app-col" data-title=""> <strong>{{format_amount($item->price)}}</strong></td>
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
    </div
</div>

@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
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





@section('styles')
<style>

body.dark {
    background: #ffffff;
}

.header .header-menu ul li a {
    color: #000;

}

.login-card {
    background: #fff;
    border-radius: 15px;
    margin-top: 50px;
}

.app-search input {

    font-size: 12px;
    font-weight: 300;

}

.header .header-menu ul li a:hover {
    color: #6642be;
}

.head-text p {
    font-size: 14px;
    line-height: 18px;
    color: #000;
    margin-top: 20px;
    font-weight: 300;
}

.head-text h1 span {
    line-height: 50px !important;
    font-weight: 700;
    font-size: 46px !important;
}

.main-stats .home-stat i {
   font-size: 25px;
    background: #6642be;
    width: 50px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    color: #fff;
    border-radius: 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.main-stats .hstat-text {
   font-size: 20px;
    font-weight: 800;
    color: #000;
}

.main-stats {
    padding: 35px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 12px;
    font-weight: 400;
    color: #ABBCC5;
}

.header .head-menu .btn.btn-primary {
    -webkit-box-shadow: none;
    box-shadow: none;
}

.header .head-menu .btn {
    font-size: 14px;
    border-radius: 20px;
    padding: 10px 25px;
    font-weight: 400;
}

.main-top {
    width: 100%;
    overflow: hidden;
    position: relative;
    padding: 120px 0 20px 0;
}

    body.dark .app-mtable .app-block .app-col:before {
        margin-bottom: 3px;
        content: attr(data-title);
        min-width: 98px;
        font-size: 10px;
        line-height: 10px;
        font-weight: 700;
        text-transform: uppercase;
        color: #000;
        display: block;
    }

.container, .container-lg, .container-md, .container-sm {
   width: 100%;
    max-width: 100%;
    padding: 0 45px;
    overflow: hidden;
}

.btn.btn-primary {
    background: #6642be;
    color: #fff;
    border: 0;
    border-radius: 20px;
    padding: 9px 20px;
    font-size: 16px;
}


body.dark .btn.btn-outline {
    border: 1px solid #151428;
    color: #151428;
    border-radius: 20px;
    padding: 9px 20px;
    font-size: 16px;
}



.header .site-name img {
    height: 32px !important;
}

.home-menu-btn {
    color:#000;
}



.fcheck label {
    font-size: 12px;
    line-height: 20px;
    font-weight: 400;
    color: #000;
}

.fcheck label::before {

    font-size: 12px;
    font-weight: 900;
    height: 15px;
    width: 15px;
    border: 2px solid #6642be;

}

.frgpass {
    font-size: 12px;
    line-height: 20px;
    font-weight: 400;
    color: #000;
}




body.dark .d-card {
    background: #ffffff;
    color: #000;
}


body.dark .form-group label {
    color: #000;
    font-weight: 600;
    margin: 0;
}

body.dark .form-group .form-control, body.dark pre.code {
    background: #ffffff;
    color: #000;
}

.home-box-2 .detail-box .dt-title {
    font-weight: bold;
    font-size: 22px;
    line-height: 24px;
    color: #000;
    margin-bottom: 4px;
}
.home-box-2 .detail-box .dt-icon {
    height: 50px;
    width: 50px;
    border: 2px solid #6642be;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 50px;
    color: #6642be;
    font-size: 20px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.home-box-2 .detail-box .dt-title {
    font-weight: 600;
    font-size: 18px;
    line-height: 18px;
    color: #000;
    margin-bottom: 4px;
}
.home-box-2 .detail-box .dt-text {
    font-size: 12px;
    line-height: 12px;
    color: #000;
    margin-bottom: 0px;
    font-weight: 300;
}

.home-box-2 .detail-box {
    margin: 20px 0;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    cursor: pointer;
    transition: 500ms all;

}

.home-box-2 .detail-box:hover {
    transform: none;
    transition: none;
}

.home-bottom, .home-box-2 {
    padding: 50px 0 105px 0;
}

.home-box-2 .home-phone .iphone {
    position: absolute;
    margin-left: 0;
    margin-right: auto;
    left: 0;
    right: 0;
    background: #6642be94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone2 .iphone {
    position: absolute;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #6642be94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone {
    position: relative;
    padding-top: 20px;
}

.soclog {
    height: 60px;
}

.text-container {
    font-size: 13px;
    font-weight: 300;
    margin-top: 15px;
}

.footer {
    background: black;
    padding: 20px;
}

.footer .footer-links {
    font-size: 14px;
}


body.dark .table td {
    color: #000;
    border-color: #e5e5e5 !important;
}

.catetitle td strong {
    background-color: #6642be;
    border-radius: 10px;
    display: block;
    padding: 12px 15px;
    margin: -8px -10px;
    text-align: center;
    font-size: 15px;
    color: #fff;
    font-weight: 500;
}

body.dark .app-mtable .app-block:nth-child(odd) {
    background: #fff;
    color: #000;
}

body.dark .thead-tr, body.dark .thead-tr th {
    background-color: transparent;
    color: #000;
}

.table td {
    border-color: #fff !important;
    color: #000;
    font-size: 11px;
}

.table td, .table th {
    padding: .5rem .50rem;
    vertical-align: middle;
}

body.dark ul.app-news li .group, body.dark .app-search input {
    background: #ffffff;
    border: 1px solid #e5e5e5;
}















@media (max-width: 600px) {
.container, .container-lg, .container-md, .container-sm {
    max-width: 100%;
    padding: 0 15px;
    overflow: hidden;
}

.mh {

    display:none;
}

.btn.btn-primary {
    background: #6642be;
    color: #fff;
    border: 0;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 14px;
}


body.dark .btn.btn-outline {
    border: 1px solid #151428;
    color: #151428;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 14px;
}

.head-text p {
    font-size: 14px;
    line-height: 18px;
    color: #000;
    margin-top: 10px;
    font-weight: 300;
    text-align:left;
}

.header .header-menu ul li a {
    color: #000;
    text-align: center;
    padding-bottom: 35px;
}


.head-menu {
    line-height:1;
    background-color: #fff;
    -webkit-box-shadow: none;
    box-shadow: none;
    padding: 0 30px;
    z-index: 1003;
    overflow-y: auto;
    border-radius:0;
}

.head-text h1  span {
    line-height: 35px !important;
    font-weight: 600 !important;
    font-size: 30px !important;
    text-align:left;
}

.head-text h1  {

    text-align:left;
}

.login-card {
    background: #fff;
    border-radius: 15px;
    margin-top: 40px;
}

    .main-stats {
        display: block;
    }


.main-stats .home-stat i {
   font-size: 20px;
    background: #6642be;
    width: 40px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    color: #fff;
    border-radius: 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.main-stats .hstat-text {
   font-size: 16px;
    font-weight: 800;
    color: #000;
}

.main-stats {
    padding: 10px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 10px;
    font-weight: 400;
    color: #ABBCC5;
}

.home-bottom, .home-box-2 {
    padding: 30px 0 30px 0 !important;
}

body.dark .table td {
    color: #000;
    border-color: #e5e5e5 !important;
}

.catetitle td strong {
    background-color: #6642be;
    border-radius: 10px;
    display: block;
    padding: 12px 15px;
    margin: -8px -10px;
    text-align: center;
    font-size: 15px;
    color: #fff;
    font-weight: 500;
}

body.dark .app-mtable .app-block:nth-child(odd) {
    background: #fff;
    color: #000;
}

body.dark .thead-tr, body.dark .thead-tr th {
    background-color: transparent;
    color: #000;
}

.table td {
    border-color: #fff !important;
    color: #000;
    font-size: 11px;
}

.table td, .table th {
    padding: .5rem .50rem;
    vertical-align: middle;
}

body.dark ul.app-news li .group, body.dark .app-search input {
    background: #ffffff;
    border: 1px solid #e5e5e5;
}
    body.dark .app-mtable .app-block {
        background: #ffffff;
    }


}


















</style>
@endsection




