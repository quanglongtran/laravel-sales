@extends('client.layouts.app')

@section('title', 'Order')

@section('styles')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row px-lg-5">
            <div class="col-12">
                <table class="table table-hover">
                    <tr>
                        <th>Number</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Ship</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th>Payment</th>
                    </tr>

                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->ship }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>{{ $order->customer_address }}</td>
                            <td>{{ $order->note }}</td>
                            <td>Cash</td>
                            @if ($order->status == 'pending')
                                <td>
                                    <div class="btn btn-danger rounded btn-submin-cancel" data-order-id="{{ $order->id }}"
                                        data-url="{{ route('order.delete', $order->id) }}">
                                        Cancel</div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>

                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/client/order/index.js')
@endsection
