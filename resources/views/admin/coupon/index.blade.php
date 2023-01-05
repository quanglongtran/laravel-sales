@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
    <div class="card">
        <h1>Coupon list</h1>
    </div>

    <div>
        <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary">Create</a>
    </div>

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Expired</th>
                <th>Action</th>
            </tr>

            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->type }}</td>
                    <td>{{ $coupon->value }}</td>
                    <td>{{ $coupon->expired }}</td>
                    <td>
                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('admin.coupon.destroy', $coupon->id) }}" style="display: inline" method="POST"
                            id="coupon-form-delete-{{ $coupon->id }}">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn bg-gradient-danger mb-3 btn-submit-delete-modal"
                                data-bs-toggle="modal" data-bs-target="#modal-default" data-coupon-id="{{ $coupon->id }}"
                                data-coupon-name="{{ $coupon->name }}">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $coupons->links() }}
    </div>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-default">Type your modal title</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger text-white" id="modal-delete-text">Delete</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-primary" id="save">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var categoryId;

            // Array.from(document.getElementsByClassName('btn-submit-delete-modal')).forEach((item) => {
            //     item.onclick = () => {
            //         getCategory(
            //             item.getAttribute('data-coupon-id'),
            //             item.getAttribute('data-coupon-name')
            //         )
            //     }
            // });

            // document.getElementById('save').onclick = () => {
            //     deleteCategory()
            // };

            // function getCategory(id, name) {
            //     document.getElementById('modal-delete-text').innerText = `Delete ${name}`
            //     categoryId = id;
            // }

            // function deleteCategory() {
            //     document.getElementById(`coupon-form-delete-${categoryId}`).submit()
            // }


        })();
    </script>
@endsection

@section('scripts')
    @vite('resources/js/coupon/index.js')
@endsection
