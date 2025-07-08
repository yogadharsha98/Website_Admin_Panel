<div>
    @include('livewire.admin.sub-category.modal-form')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Sub-Category List
                        <a href="#" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                            data-bs-target="#AddsubcategoryModal">Add Sub-Category</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="sub_category_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sub_categories as $sub_category)
                                <tr>
                                    <td>{{ $sub_category->id }}</td>
                                    <td>{{ $sub_category->category->title }}</td>
                                    <td>{{ $sub_category->title }}</td>
                                    <td>{{ $sub_category->slug }}</td>
                                    <td>{{ $sub_category->is_active ? 'Active' : 'Not Active' }}</td>
                                    <td>
                                        <!-- Edit Icon -->
                                        <a href="#" wire:click="editSubCategory({{ $sub_category->id }})" data-bs-toggle="modal" data-bs-target="#UpdatesubcategoryModal">
                                            <i class="fas fa-edit text-success"></i>
                                        </a>

                                        <!-- Delete Icon -->
                                        <a href="#" wire:click="deleteSubCategory({{ $sub_category->id }})" data-bs-toggle="modal" data-bs-target="#deletesubcategoryModal">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>{{$sub_categories->links()}}</div>
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
</script>
@endpush


