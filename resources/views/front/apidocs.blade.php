@extends('front.layouts.master')
@section('title', 'API Docs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="d-card">

            <div class="d-card-body" id="dc-body">

                 <div class="table-responsive">
                    <div class="center-big-content-block">
                       <div class="center-big-content-block">
                          <table class="table api table-bordered">
                             <tbody>
                                <tr>
                                   <td class="width-40">HTTP Method</td>
                                   <td>POST</td>
                                </tr>
                                <tr>
                                   <td>API URL</td>
                                   <td>{{route('index')}}/api/v1</td>
                                </tr>
                                <tr>
                                   <td>API Key</td>
                                   <td>{{Auth::user()->api_token ?? "3db4e9d642e994e65261e31d7c04951z31"}}</td>
                                </tr>
                                <tr>
                                   <td>Response format</td>
                                   <td>JSON</td>
                                </tr>
                             </tbody>
                          </table>
                          <h4 class="m-t-md"><strong>Service list</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>services</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
[
{
"service": 1,
"name": "Followers",
"type": "Default",
"category": "First Category",
"rate": "0.90",
"min": "50",
"max": "10000",
"refill": true
},
{
"service": 2,
"name": "Comments",
"type": "Custom Comments",
"category": "Second Category",
"rate": "8",
"min": "10",
"max": "1500",
"refill": false
}
]
</pre>
                          <h4 class="m-t-md"><strong>Add order</strong></h4>
                          <p>
                          <form class="form-inline">
                             <div class="form-group">
                                <select class="form-control input-sm" id="service_type">
                                   <option value="0">Default</option>
                                   <option value="10">Package</option>
                                   <option value="2">Custom Comments</option>
                                   <option value="17">Poll</option>
                                   <option value="100">Subscriptions</option>
                                </select>
                             </div>
                          </form>
                          </p>
                          <div id="type_0" style="display:none;">
                             <table class="table api table-bordered">
                                <thead class="white">
                                   <tr>
                                      <th class="width-40">Parameters</th>
                                      <th>Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td>key</td>
                                      <td>Your API key</td>
                                   </tr>
                                   <tr>
                                      <td>action</td>
                                      <td>add</td>
                                   </tr>
                                   <tr>
                                      <td>service</td>
                                      <td>Service ID</td>
                                   </tr>
                                   <tr>
                                      <td>link</td>
                                      <td>Link to page</td>
                                   </tr>
                                   <tr>
                                      <td>quantity</td>
                                      <td>Needed quantity</td>
                                   </tr>
                                   <tr>
                                      <td>runs (optional)</td>
                                      <td>Runs to deliver</td>
                                   </tr>
                                   <tr>
                                      <td>interval (optional)</td>
                                      <td>Interval in minutes</td>
                                   </tr>
                                </tbody>
                             </table>
                          </div>
                          <div id="type_10" style="display:none;">
                             <table class="table api table-bordered">
                                <thead class="white">
                                   <tr>
                                      <th class="width-40">Parameters</th>
                                      <th>Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td>key</td>
                                      <td>Your API key</td>
                                   </tr>
                                   <tr>
                                      <td>action</td>
                                      <td>add</td>
                                   </tr>
                                   <tr>
                                      <td>service</td>
                                      <td>Service ID</td>
                                   </tr>
                                   <tr>
                                      <td>link</td>
                                      <td>Link to page</td>
                                   </tr>
                                </tbody>
                             </table>
                          </div>
                          <div id="type_2" style="display:none;">
                             <table class="table api table-bordered">
                                <thead class="white">
                                   <tr>
                                      <th class="width-40">Parameters</th>
                                      <th>Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td>key</td>
                                      <td>Your API key</td>
                                   </tr>
                                   <tr>
                                      <td>action</td>
                                      <td>add</td>
                                   </tr>
                                   <tr>
                                      <td>service</td>
                                      <td>Service ID</td>
                                   </tr>
                                   <tr>
                                      <td>link</td>
                                      <td>Link to page</td>
                                   </tr>
                                   <tr>
                                      <td>comments</td>
                                      <td>Comments list separated by \r\n or \n</td>
                                   </tr>
                                </tbody>
                             </table>
                          </div>
                          <div id="type_100" style="display:none;">
                             <table class="table api table-bordered">
                                <thead class="white">
                                   <tr>
                                      <th class="width-40">Parameters</th>
                                      <th>Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td>key</td>
                                      <td>Your API key</td>
                                   </tr>
                                   <tr>
                                      <td>action</td>
                                      <td>add</td>
                                   </tr>
                                   <tr>
                                      <td>service</td>
                                      <td>Service ID</td>
                                   </tr>
                                   <tr>
                                      <td>username</td>
                                      <td>Username</td>
                                   </tr>
                                   <tr>
                                      <td>min</td>
                                      <td>Quantity min</td>
                                   </tr>
                                   <tr>
                                      <td>max</td>
                                      <td>Quantity max</td>
                                   </tr>
                                   <tr>
                                      <td>posts</td>
                                      <td>New posts count</td>
                                   </tr>
                                   <tr>
                                      <td>delay</td>
                                      <td>Delay in minutes. Possible values: 0, 5, 10, 15, 30, 60, 90</td>
                                   </tr>
                                   <tr>
                                      <td>expiry (optional)</td>
                                      <td>Expiry date. Format d/m/Y</td>
                                   </tr>
                                </tbody>
                             </table>
                          </div>
                          <div id="type_17" style="display:none;">
                             <table class="table api table-bordered">
                                <thead class="white">
                                   <tr>
                                      <th class="width-40">Parameters</th>
                                      <th>Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td>key</td>
                                      <td>Your API key</td>
                                   </tr>
                                   <tr>
                                      <td>action</td>
                                      <td>add</td>
                                   </tr>
                                   <tr>
                                      <td>service</td>
                                      <td>Service ID</td>
                                   </tr>
                                   <tr>
                                      <td>link</td>
                                      <td>Link to page</td>
                                   </tr>
                                   <tr>
                                      <td>quantity</td>
                                      <td>Needed quantity</td>
                                   </tr>
                                   <tr>
                                      <td>answer_number</td>
                                      <td>Answer number of the poll</td>
                                   </tr>
                                </tbody>
                             </table>
                          </div>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
"order": 23501
}
</pre>
                          <h4 class="m-t-md"><strong>Order status</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>status</td>
                                </tr>
                                <tr>
                                   <td>order</td>
                                   <td>Order ID</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
"charge": "0.27819",
"start_count": "3572",
"status": "Partial",
"remains": "157",
"currency": "USD"
}
</pre>
                          <h4 class="m-t-md"><strong>Multiple orders status</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>status</td>
                                </tr>
                                <tr>
                                   <td>orders</td>
                                   <td>Order IDs separated by comma</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
    "1": {
        "charge": "0.27819",
        "start_count": "3572",
        "status": "Partial",
        "remains": "157",
        "currency": "USD"
    },
    "10": {
        "error": "Incorrect order ID"
    },
    "100": {
        "charge": "1.44219",
        "start_count": "234",
        "status": "In progress",
        "remains": "10",
        "currency": "USD"
    }
}
</pre>
                          <h4 class="m-t-md"><strong>Create refill</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>refill</td>
                                </tr>
                                <tr>
                                   <td>order</td>
                                   <td>Order ID</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
"refill": "1"
}
</pre>
                          <h4 class="m-t-md"><strong>Get refill status</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>refill_status</td>
                                </tr>
                                <tr>
                                   <td>refill</td>
                                   <td>Refill ID</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
"status": "Completed"
}
</pre>
                          <h4 class="m-t-md"><strong>User balance</strong></h4>
                          <table class="table api table-bordered">
                             <thead class="white">
                                <tr>
                                   <th class="width-40">Parameters</th>
                                   <th>Description</th>
                                </tr>
                             </thead>
                             <tbody>
                                <tr>
                                   <td>key</td>
                                   <td>Your API key</td>
                                </tr>
                                <tr>
                                   <td>action</td>
                                   <td>balance</td>
                                </tr>
                             </tbody>
                          </table>
                          <p><strong>Example response</strong></p>
                          <pre class="code">
{
"balance": "100.84292",
"currency": "USD"
}
</pre>
                          <a href="example.txt" class="btn btn-secondary m-t" target="_blank">Example of PHP code</a>
                       </div>
                    </div>
                 </div>


            </div>
        </div>
    </div>
</div>
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
                    View API Documentation and use our endpoint with the following information
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

.header .header-menu ul li a:hover {
    color: #ff401a;
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
    background: #ff401a;
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


.container, .container-lg, .container-md, .container-sm {
   width: 100%;
    max-width: 100%;
    padding: 0 45px;
    overflow: hidden;
}

.btn.btn-primary {
    background: #ff401a;
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
    border: 2px solid #ff401a;

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
    border: 2px solid #ff401a;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 50px;
    color: #ff401a;
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
    background: #ff401a94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone2 .iphone {
    position: absolute;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #ff401a94;
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
    border-color: #313131 !important;
}

body.dark .table-bordered td, body.dark .table-bordered th {
    border: 0;
    color: #000;
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
    background: #ff401a;
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
    background: #ff401a;
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




}


















</style>
@endsection



