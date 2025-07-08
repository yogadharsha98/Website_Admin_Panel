<div>
    @include('livewire.admin.category.modal-form')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Category List
                        <a href="#" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#AddcategoryModal">Add Category</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="category_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}" width="50" height="50">
                                    </td>
                                    <td>{{ $category->is_active ? 'Active' : 'Not Active' }}</td>
                                    <td>
                                        <!-- Edit Icon -->
                                        <a href="#" wire:click="editCategory({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#UpdatecategoryModal">
                                            <i class="fas fa-edit text-success"></i>
                                        </a>

                                        <!-- Delete Icon -->
                                        <button type="button" class="btn btn-link text-danger"
                                            onclick="confirmDeletion({{ $category->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle alertify events
        window.addEventListener('alertify', event => {
            const alertifyDetail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            const { type, message } = alertifyDetail;

            if (!type || !message) {
                console.error('Type or message is missing:', alertifyDetail);
                return;
            }

            if (type === 'success') {
                alertify.success(message);
            } else if (type === 'error') {
                alertify.error(message);
            } else {
                console.error('Invalid alertify type:', type);
            }
        });
    });

    function confirmDeletion(categoryId) {
        alertify.confirm("Delete Confirmation", "Are you sure you want to delete this category?",
            function(){
                // Call Livewire delete method
                @this.deleteCategory(categoryId);
            },
            function(){
                alertify.error('Cancel');
            });
    }
</script>
@endpush
