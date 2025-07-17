@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4>
                            Update Product
                            <a href="{{ route('admin.product.index') }}"
                                class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/product/' . $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control" id="categorySelect">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Sub Category</label>
                                    <select name="sub_category_id" class="form-control" id="subCategorySelect">
                                        @foreach ($subCategories as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="customFieldsContainer"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Product Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $product->name }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Product Slug</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ $product->slug }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Small Description</label>
                                    <textarea name="small_description" class="form-control">{{ $product->small_description }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="{{ $product->meta_title }}" />
                                </div>
                                <div class="col-md-4">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control">{{ $product->meta_description }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label>Meta Keyword</label>
                                    <textarea name="meta_keyword" class="form-control">{{ $product->meta_keyword }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Original Price</label>
                                    <input type="text" name="original_price" class="form-control"
                                        value="{{ $product->original_price }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Starting Price</label>
                                    <input type="text" name="starting_price" class="form-control"
                                        value="{{ $product->starting_price }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Ending Price</label>
                                    <input type="text" name="ending_price" class="form-control"
                                        value="{{ $product->ending_price }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Quantity</label>
                                    <input type="number" name="total_quantity" class="form-control"
                                        value="{{ $product->total_quantity }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="is_active" style="width: 25px; height: 25px;"
                                        {{ $product->is_active ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Trending</label><br>
                                    <input type="checkbox" name="trending" style="width: 25px; height: 25px;"
                                        {{ $product->trending ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-3">
                                    <label>Featured</label><br>
                                    <input type="checkbox" name="featured" style="width: 25px; height: 25px;"
                                        {{ $product->featured ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-3">
                                    <label>New Arrivals</label><br>
                                    <input type="checkbox" name="new_arrivals" style="width: 25px; height: 25px;"
                                        {{ $product->new_arrivals ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-3">
                                    <label>On Sale</label><br>
                                    <input type="checkbox" name="on_sale" style="width: 25px; height: 25px;"
                                        {{ $product->on_sale ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Upload Product Main Image</label>
                                    <input type="file" name="main_image" class="form-control" />
                                    @if ($product->main_image)
                                        <img src="{{ asset($product->main_image) }}" alt="Main Image" width="60"
                                            class="mt-2">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label>Upload Product Images</label>
                                    <input type="file" multiple name="product_image[]" class="form-control" />
                                    <div class="mt-2" id="productImagesContainer">
                                        @foreach ($product->images as $img)
                                            <div class="d-inline-block me-2" id="img-{{ $img->id }}">
                                                <img src="{{ asset($img->image_path) }}" width="60" />
                                                <label>
                                                    <input type="checkbox" class="delete-image-checkbox"
                                                        data-id="{{ $img->id }}">
                                                    Remove
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-success float-end">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('categorySelect').addEventListener('change', function() {
            var categoryId = this.value;

            fetch(`/admin/get-subcategories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    const subCategorySelect = document.getElementById('subCategorySelect');
                    subCategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
                    data.forEach(function(subcategory) {
                        subCategorySelect.innerHTML +=
                            `<option value="${subcategory.id}">${subcategory.title}</option>`;
                    });

                    // Clear fields until subcategory is selected
                    document.getElementById('customFieldsContainer').innerHTML = '';
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                });
        });

        function renderFields(fields) {
            const container = document.getElementById('customFieldsContainer');
            container.innerHTML = '';

            fields.forEach(({
                field
            }) => {
                let inputHtml = '';
                const name = `custom_fields[${field.id}]`;

                switch (field.type) {
                    case 'text':
                        inputHtml = `<input type="text" name="${name}" class="form-control" />`;
                        break;
                    case 'textarea':
                        inputHtml = `<textarea name="${name}" class="form-control"></textarea>`;
                        break;
                    case 'select':
                        inputHtml = `<select name="${name}" class="form-control">`;
                        field.options.forEach(opt => {
                            inputHtml += `<option value="${opt.value}">${opt.value}</option>`;
                        });
                        inputHtml += `</select>`;
                        break;
                    case 'checkbox_multiple':
                        inputHtml = field.options.map(opt =>
                            `<div><label><input type="checkbox" name="${name}[]" value="${opt.value}"> ${opt.value}</label></div>`
                        ).join('');
                        break;
                        // add other types similarly...
                }

                container.innerHTML += `
            <div class="mb-3">
                <label>${field.name}</label>
                ${inputHtml}
            </div>
        `;
            });
        }

        document.getElementById('categorySelect').addEventListener('change', fetchAndRenderFields);
        document.getElementById('subCategorySelect').addEventListener('change', fetchAndRenderFields);

        function fetchAndRenderFields() {
            const categoryId = document.getElementById('categorySelect').value;
            const subCategoryId = document.getElementById('subCategorySelect').value;

            if (categoryId && subCategoryId) {
                fetch(`/admin/get-fields/${categoryId}/${subCategoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        renderFields(data);
                    })
                    .catch(err => {
                        console.error('Failed to load custom fields:', err);
                    });
            } else {
                document.getElementById('customFieldsContainer').innerHTML = '';
            }
        }
        document.querySelector('input[name="name"]').addEventListener('input', function() {
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-') // replace spaces and invalid chars with dashes
                .replace(/^-+|-+$/g, ''); // trim dashes from start and end
            document.querySelector('input[name="slug"]').value = slug;
        });
        // Existing code...

        document.getElementById('categorySelect').addEventListener('change', fetchAndRenderFields);
        document.getElementById('subCategorySelect').addEventListener('change', fetchAndRenderFields);

        function fetchAndRenderFields() {
            const categoryId = document.getElementById('categorySelect').value;
            const subCategoryId = document.getElementById('subCategorySelect').value;

            if (categoryId && subCategoryId) {
                fetch(`/admin/get-fields/${categoryId}/${subCategoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        renderFields(data);
                    })
                    .catch(err => {
                        console.error('Failed to load custom fields:', err);
                    });
            } else {
                document.getElementById('customFieldsContainer').innerHTML = '';
            }
        }

        // Call on page load too:
        document.addEventListener('DOMContentLoaded', () => {
            fetchAndRenderFields();
        });
    </script>
    <script>
        document.querySelectorAll('.delete-image-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    const imageId = this.dataset.id;

                    if (confirm('Are you sure you want to delete this image?')) {
                        fetch(`/admin/product-image/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove the image container div
                                    document.getElementById(`img-${imageId}`).remove();
                                } else {
                                    alert('Failed to delete image');
                                    this.checked = false; // uncheck on failure
                                }
                            })
                            .catch(() => {
                                alert('Error deleting image');
                                this.checked = false;
                            });
                    } else {
                        // If cancel on confirm, uncheck checkbox
                        this.checked = false;
                    }
                }
            });
        });
    </script>
@endsection
