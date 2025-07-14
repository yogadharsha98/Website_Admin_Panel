<!-- Slider Add Modal -->
<div wire:ignore.self class="modal fade" id="AddsliderModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Slider</h1>
                <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="storeSlider">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Slider Title</label>
                        <input type="text" wire:model.defer="title" class="form-control">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Slug</label>
                        <input type="text" wire:model.defer="slug" class="form-control">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Content Title</label>
                        <input type="text" wire:model.defer="content_title" class="form-control">
                        @error('content_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Main Title</label>
                        <input type="text" wire:model.defer="content_title_main" class="form-control">
                        @error('content_title_main')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Content Description</label>
                        <input type="text" wire:model.defer="content_description" class="form-control">
                        @error('content_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" wire:model.defer="image" class="form-control" accept="image/*">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="checkbox" wire:model.defer="is_active" />
                        @error('is_active')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Slider Update Modal -->
<div wire:ignore.self class="modal fade" id="UpdatesliderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Slider</h1>
                <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="p-2">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent="updateSlider">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Slider Title</label>
                            <input type="text" wire:model.defer="title" class="form-control">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label> Slug</label>
                            <input type="text" wire:model="slug" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Content Title</label>
                            <input type="text" wire:model.defer="content_title" class="form-control">
                            @error('content_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Main Title</label>
                            <input type="text" wire:model.defer="content_title_main" class="form-control">
                            @error('content_title_main')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Content Description</label>
                            <input type="text" wire:model.defer="content_description" class="form-control">
                            @error('content_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            @if ($image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Slider Image" width="100" height="100" class="mb-2">
                            @endif
                            <input type="file" wire:model.defer="image" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <input type="checkbox" wire:model.defer="is_active" />
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- Delete Slider Modal -->
 <div wire:ignore.self class="modal fade" id="deletesliderModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Slider</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="destroySlider">
                <div class="modal-body">
                    <h6>Are you you want to delete this slider?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#AddsliderModal').modal('hide');
        $('#UpdatesliderModal').modal('hide');
        $('#deletesliderModal').modal('hide');
    });
</script>
@endpush
