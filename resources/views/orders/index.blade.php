@extends('layouts.admin')
@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-success">Open POS</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- <div class="col-md-3"></div> -->
            <div class="col-md-12">
                <form action="{{route('orders.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th>Remain.</th>
                    <th>Created At</th>
                    <th>Pay</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">Not Paid</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">Partial</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">Paid</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">Change</span>
                        @endif
                    </td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>
                    <td>{{$order->created_at}}</td>
{{--                    <td>--}}
{{--                        <div id="pay">--}}
{{--                            <button id="pay-button-{{ $order->id }}" class="btn btn-primary" onclick="payOrder({{ $order->id }})"> Pay </button>--}}
{{--                            <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--                            <script>--}}
{{--                                function payOrder(orderId) {--}}
{{--                                    // Get the CSRF token from the meta tag in the head section--}}
{{--                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');--}}

{{--                                    // Send an AJAX request to pay the order--}}
{{--                                    var xhr = new XMLHttpRequest();--}}
{{--                                    xhr.open('POST', '/orders/' + orderId + '/pay');--}}
{{--                                    xhr.setRequestHeader('Content-Type', 'application/json');--}}
{{--                                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);--}}
{{--                                    xhr.onload = function() {--}}
{{--                                        if (xhr.status === 200) {--}}
{{--                                            // The payment was successful, reload the page to show the updated order status--}}
{{--                                            location.reload();--}}
{{--                                        } else {--}}
{{--                                            // There was an error with the payment, show an error message--}}
{{--                                            alert('There was an error processing the payment. Please try again later.');--}}
{{--                                        }--}}
{{--                                    };--}}
{{--                                    xhr.send(JSON.stringify({--}}
{{--                                        _token: csrfToken,--}}
{{--                                        amount: parseFloat(prompt('Enter the amount to pay:', 0)),--}}
{{--                                    }));--}}
{{--                                }--}}
{{--                            </script>--}}

{{--                        </div>--}}
{{--                    </td>--}}

                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{ $orders->render() }}
    </div>
</div>
@endsection

