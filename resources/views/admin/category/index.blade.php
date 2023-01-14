@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="card">
        <h1>Category list</h1>
    </div>

    @can('create-category')
        <div>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Create</a>
        </div>
    @endcan

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parent name</th>
                <th>Action</th>
            </tr>

            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_name }}</td>
                    <td>
                        @can('update-category')
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        @endcan

                        @can('delete-category')
                            <form action="{{ route('admin.category.destroy', $category->id) }}" style="display: inline"
                                method="POST" id="category-form-delete-{{ $category->id }}">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn bg-gradient-danger mb-3 btn-submit-delete-modal"
                                    data-bs-toggle="modal" data-bs-target="#modal-default"
                                    data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $categories->links() }}
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

            Array.from(document.getElementsByClassName('btn-submit-delete-modal')).forEach((item) => {
                item.onclick = () => {
                    getCategory(
                        item.getAttribute('data-category-id'),
                        item.getAttribute('data-category-name')
                    )
                }
            });

            document.getElementById('save').onclick = () => {
                deleteCategory()
            };

            function getCategory(id, name) {
                document.getElementById('modal-delete-text').innerText = `Delete ${name}`
                categoryId = id;
            }

            function deleteCategory() {
                document.getElementById(`category-form-delete-${categoryId}`).submit()
            }
        })()
    </script>
@endsection
