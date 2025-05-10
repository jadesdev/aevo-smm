@extends('admin.layouts.master')
@section('title', 'Withdrawal Requests')

@section('content')
    

    <div class="d-card">
        <div class="card-header">
            <h5 class="fw-bold">Withdrawal Requests</h5>
        </div>
        <div class="d-card-body table-responsive">
            <table class="table app-mtable">
                <thead class="white">
                    <tr class="thead-tr">
                        <th>#</th>
                        <th>TRX ID</th>
                        <th>User</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Charges</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="w-100">
                    @foreach ($withdraws as $key => $item)
                        <tr class="app-block w-100">
                            <td class="app-col" data-title="#">{{ $key + 1 }}</td>
                            <td class="app-col" data-title="Code">{{ $item->code }}</td>
                            <td class="app-col" data-title="User">{{ $item->user->username }} <br>{{ $item->user->email }}
                            </td>
                            <td class="app-col" data-title="Service">{{ __($item->service) }}</td>
                            <td class="app-col" data-title="Amount">{{ format_price($item->amount) }}</td>
                            <td class="app-col" data-title="Fee">{{ format_price($item->charge) }}</td>
                            <td class="app-col" data-title="Date">{{ show_datetime($item->created_at) }}</td>
                            <td class="app-col" data-title="Status">
                                @if ($item->status == 1)
                                    <span class="badge bg-success">@lang('Completed')</span>
                                @elseif ($item->status == 2)
                                    <span class="badge bg-warning">@lang('processing')</span>
                                @elseif ($item->status == 3)
                                    <span class="badge bg-danger">@lang('rejected')</span>
                                @endif
                            </td>
                            <td class="app-col" data-title="Action">
                                @if ($item->status == 2)
                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.withdraw.pay', $item->id) }}"
                                        title="Approve Withdrawal"><i class="fa fa-check"></i></a>
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.withdraw.reject', $item->id) }}"
                                        title="Delete Withdrawal"><i class="fa fa-times"></i></a>
                                @endif
                                <a class="btn btn-sm btn-outline-success" href="#" data-toggle="modal"
                                    data-target="#manualReceipt{{ $item->id }}" title="View"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="manualReceipt{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel"> User Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <p class="col-6"> <b>New Bal:</b> {{ format_price($item->new_balance) }} </p>
                                            <p class="col-6"> <b>Old Bal :</b> {{ format_price($item->old_balance) }}
                                            </p>
                                            <p class="col-6"> Amount : {{ format_price($item->amount) }} </p>

                                            <p class="col-6"> User : {{ __($item->user->username) }} </p>
                                            <p class="col-6"> Bank Name : {{ get_bank_name($item->user->bank_name) }}
                                            </p>
                                            <p class="col-6"> Account Name : {{ __($item->user->acc_name) }} </p>
                                            <p class="col-6"> Account Number : {{ __($item->user->acc_number) }} </p>



                                        </div>
                                        @if ($item->status == 2)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('admin.withdraw.pay', $item->id) }}" title="pay">Approve
                                                Withdrawal</a>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                class="fa fa-times"></i> @lang('Close')</button>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $withdraws->links() }}
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <style>
        .man-img {
            width: 100%;
            height: auto;
        }
    </style>
@stop

@push('scripts')
    <script>
        function updateSystem(el, name) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('admin.setting.sys_settings') }}', {
                _token: '{{ csrf_token() }}',
                name: name,
                value: value
            }, function(data) {
                if (data == '1') {
                    Snackbar.show({
                        text: '{{ __('Settings Updated Successfully') }}',
                        pos: 'top-right',
                        backgroundColor: '#38c172'
                    });
                } else {
                    Snackbar.show({
                        text: '{{ __('Something went wrong') }}',
                        pos: 'top-right',
                        backgroundColor: '#e3342f'
                    });
                }
            });
        }
    </script>
@endpush
