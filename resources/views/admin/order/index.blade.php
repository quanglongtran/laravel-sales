@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Status</th>
                <th>Total</th>
                <th>Ship</th>
                <th>Customer name</th>
                <th>Customer email</th>
                <th>Customer address</th>
                <th>Note</th>
                <th>Payment</th>
            </tr>

            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        <select class="change-status" data-url="{{ route('admin.order.update-status') }}"
                            data-order-id="{{ $order->id }}">
                            @foreach (config('order.status') as $status)
                                <option value="{{ $status }}" {{ $status == $order->status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ $order->ship }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_email }}</td>
                    <td>{{ $order->customer_adress }}</td>
                    <td>{{ $order->note }}</td>
                    <td>Cash</td>
                </tr>
            @endforeach
        </table>

        {{ $orders->links() }}
    </div>
@endsection

@section('scripts')
    @vite('resources/js/admin/order/index.js')
@endsection
