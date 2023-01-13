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

            @foreach ($orders as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->ship }}</td>
                    <td>{{ $user->customer_name }}</td>
                    <td>{{ $user->customer_email }}</td>
                    <td>{{ $user->customer_adress }}</td>
                    <td>{{ $user->note }}</td>
                    <td>Cash</td>
                </tr>
            @endforeach
        </table>

        {{ $orders->links() }}
    </div>
@endsection
