<div>
    @include('livewire.admin.slider.modal-form')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Slider List
                        <a href="#" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#AddsliderModal">Add Slider</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="slider_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Content Title</th>
                                <th>Content Title Main</th>
                                <th>Content Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->slug }}</td>
                                    <td>{{ $slider->content_title }}</td>
                                    <td>{{ $slider->content_title_main }}</td>
                                    <td>{{ $slider->content_description }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" width="50" height="50">
                                    </td>
                                    <td>{{ $slider->is_active ? 'Active' : 'Not Active' }}</td>
                                    <td>
                                        <!-- Edit Icon -->
                                        <a href="#" wire:click="editSlider({{ $slider->id }})" data-bs-toggle="modal" data-bs-target="#UpdatesliderModal">
                                            <i class="fas fa-edit text-success"></i>
                                        </a>

                                        <!-- Delete Icon -->
                                        <button type="button" class="btn btn-link text-danger"
                                            onclick="confirmDeletion({{ $slider->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $sliders->links() }}
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

    function confirmDeletion(sliderId) {
        alertify.confirm("Delete Confirmation", "Are you sure you want to delete this slider?",
            function(){
                // Call Livewire delete method
                @this.deleteSlider(sliderId);
            },
            function(){
                alertify.error('Cancel');
            });
    }
</script>
@endpush
