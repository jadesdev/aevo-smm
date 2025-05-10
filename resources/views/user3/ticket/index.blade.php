@extends('user3.layouts.master')
@section('title', 'Support Tickets')
@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Contact Support for all Enquires and Questions
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-7 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <div class="dch-body">
                    <i class="icon fa fa-comment me-3"></i>
                    <span class="ml-3">Create Support Ticket</span>
                </div>
            </div>

            <div class="card-body" id="dc-body">
                <form method="post" action="{{route('user.ticket.create')}}" id="ticketsend" class="sub-form">
                    @csrf
                    <div class="form-group">
                        <label for="subject" class="control-label">Subject</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-bars"></i>
                                </div>
                                <select class="form-control form-select" id="subject" name="subject" onchange="handleOrderType(this)">
                                    <option value="Order Inquiry">Order</option>
                                    <option value="Payment Notification">Payment Notification</option>
                                    {{-- <option value="Rent Panel">Rent Panel</option> --}}
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="order-group">
                        <label>Your Order Number</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-hashtag"></i>
                                </div>
                                <input type="text" class="form-control" id="orderid" />
                            </div>
                        </div>
                        <label style="margin-top: 15px;">Specify Your Request</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-book-reader"></i>
                                </div>
                                <select class="form-control form-select" id="want">
                                    <option value="" selected="">Please Select</option>
                                    <option value="I think there is an error in my order, can you check it?">I think there is an error in my order, can you check it?</option>
                                    <option value="My order has not started yet, can I get information?">My order has not started yet, can I get information?</option>
                                    <option value="Why was my order canceled?">Why was my order canceled?</option>
                                    <option value="It was marked as completed but the task is not done.">It was marked as completed but the task is not done.</option>
                                    <option value="If possible, can you cancel it?">If possible, can you cancel it?</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="payment-group">
                        <label>Payment</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-university"></i>
                                </div>
                                <select class="form-control form-select" id="payment">
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Card Payment">Card Payment</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <label style="margin-top: 15px;">Sender Name</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-user-alt"></i>
                                </div>
                                <input type="text" class="form-control" name="Transaction[ID]" id="PaymentID" />
                            </div>
                        </div>
                        <label style="margin-top: 15px;">Sent Amount</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-icon bg-primary">
                                    <i class="fa fa-database"></i>
                                </div>
                                <input type="number" class="form-control" name="addamount[ID]" id="addamount" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group message">
                        <label for="message" class="control-label">Message <span id="optional"> (optional) </span></label>
                        <textarea class="form-control" rows="7" id="message" name="message" style="height: 150px !important;"></textarea>
                    </div>
                    <input id="hmessage" name="message" type="hidden" />
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Send Support Request</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <div class="dch-body">
                    <i class="icon fa fa-ticket-alt me-3"></i>
                    <span class="ml-3">My Past Requests</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="white">
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $item)
                            <tr>
                                <td>{{$item->ticket}}</td>
                                <td><a href="{{route('user.ticket.detail', $item->ticket)}}">{{$item->subject}}</a></td>
                                <td>
                                    {!! get_ticket_status($item->status)!!}
                                </td>
                                <td><span class="nowrap">{{show_datetime($item->updated_at)}}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    var element2 = (document.getElementById("payment-group").style = "display:none");
    function handleOrderType(selectObject) {
        var element = document.getElementById("order-group");
        var element2 = document.getElementById("payment-group");
        var optional = document.getElementById("optional");
        if (selectObject.value == "Order Inquiry" || selectObject.value == "VIP-Order") {
            element.style.display = "block";
            element2.style.display = "none";
            optional.style.display = "inline";
        } else if (selectObject.value == "Payment Notification" || selectObject.value == "VIP-Payment") {
            element.style.display = "none";
            element2.style.display = "block";
            optional.style.display = "none";
        } else if (selectObject.value == "Rent Panel" || selectObject.value == "VIP-Panel") {
            element.style.display = "none";
            element2.style.display = "none";
            optional.style.display = "none";
        } else if (selectObject.value == "Other" || selectObject.value == "VIP-Other") {
            element.style.display = "none";
            element2.style.display = "none";
            optional.style.display = "none";
        }
    }

    function createTicket(e) {
        if (e.preventDefault) e.preventDefault();

        var subject = document.getElementById("subject").value;
        var message = "";
        if (subject == "Order Inquiry" || subject == "VIP-Order") {
            message = "Order number: " + document.getElementById("orderid").value + "\n" + "Request: " + document.getElementById("want").value + "\n" + document.getElementById("message").value;
        } else if (subject == "Payment Notification" || subject == "VIP-Payment") {
            message =
                "Payment Method: " +
                document.getElementById("payment").value +
                "\n Sender Name: " +
                document.getElementById("PaymentID").value +
                "\n Amount: " +
                document.getElementById("addamount").value +
                "\n" +
                document.getElementById("message").value;
        } else {
            message = document.getElementById("message").value;
        }

        document.getElementById("hmessage").value = message;

        // return true;
        form.submit();

    }

    var form = document.getElementById("ticketsend");

    if (form.attachEvent) {
        form.attachEvent("submit", createTicket);
    } else {
        form.addEventListener("submit", createTicket);

    }

</script>
@endpush
