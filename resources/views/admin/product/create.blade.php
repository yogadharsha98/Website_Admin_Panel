@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    @section('alertify-script')
                        <script>
                            alertify.success("{{ session('success') }}");
                        </script>
                    @show
                @elseif (session('failure'))
                    @section('alertify-script')
                        <script>
                            alertify.danger("{{ session('failure') }}");
                        </script>
                    @show
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Add Products
                            <a href="" class="btn btn-primary btn-sm text-white float-end">Back</a>
                            <a href="{{ url()->current() }}" class="btn btn-info btn-sm text-white float-end mx-2">
                                Refresh
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <!-- Category and Subcategory in one row -->
                                <div class="col-md-6">
                                    <label for="categorySelect">Category</label>
                                    <select name="category_id" class="form-control" id="categorySelect">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="subCategorySelect">Sub Category</label>
                                    <select name="sub_category_id" class="form-control" id="subCategorySelect">
                                        <option value="">-- Select Subcategory --</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Custom Fields full width -->
                            <div class="row mb-3" id="customFieldsContainer">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="">Product Name</label>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <label for="">Product Slug</label>
                                    <input type="text" name="slug" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <label for="">Small Description(400 Words)</label>
                                    <textarea name="small_description" id="" class="form-control" rows="4"></textarea>
                                </div>
                            </div>



                            <div class="mb-3">
                                <label for="">Description</label>
                                <textarea name="description" id="" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <label for="">Meta Description</label>
                                    <textarea name="meta_description" id="" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Meta Keyword</label>
                                    <textarea name="meta_keyword" id="" class="form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Original Price</label>
                                        <input type="text" name="original_price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Selling Price</label>
                                        <input type="text" name="selling_price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Quantity</label>
                                        <input type="number" name="total_quantity" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Status</label>
                                        <input type="checkbox" name="is_active" style="width: 25px; height: 25px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Trending</label>
                                        <input type="checkbox" name="trending" style="width: 25px; height: 25px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">Featured</label>
                                        <input type="checkbox" name="featured" style="width: 25px; height: 25px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">New Arrivals</label>
                                        <input type="checkbox" name="new_arrivals" style="width: 25px; height: 25px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">On Sale</label>
                                        <input type="checkbox" name="on_sale" style="width: 25px; height: 25px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="">Upload Product Main Image</label>
                                    <input type="file" name="main_image" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label for="">Upload Product Images</label>
                                    <input type="file" multiple name="product_image[]" class="form-control" />
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-success float-end">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    form input.form-control,
    form select.form-control,
    form textarea.form-control,
    form input[type="file"].form-control {
        background-color: #ffffff !important;
        color: #0f0f0f !important;
        border-color: #0e0e0e !important;
    }

    form input.form-control::placeholder,
    form textarea.form-control::placeholder {
        color: #faf6f6 !important;
    }
</style>
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
    </script>

@endsection
