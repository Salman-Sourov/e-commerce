@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-start mb-3">
            <!-- All Products Button -->
            <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm d-flex align-items-center me-3"
                title="View All Products">
                <i data-feather="box" class="me-2" style="width: 18px; height: 18px;"></i> All Products
            </a>

            <!-- View Product Button -->
            <a href="{{ route('product.details', $product->id) }}" class="btn btn-success btn-sm d-flex align-items-center"
                title="View Product on Website" target="_blank">
                <i data-feather="eye" class="me-2" style="width: 18px; height: 18px;"></i> View Product on Website
            </a>
        </div>


        <div class="row profile-body">
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Product</h6>

                            <form method="POST" action="{{ route('product.update', $product->id) }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch') <!-- This tells Laravel to treat the request as a PUT request -->
                                {{-- <input type="hidden" value="{{ $product->id }}" name="update_prduct_id"> --}}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3 text-danger">
                                            <label class="form-label">Product Name *</label>
                                            <input type="text" name="product_name" class="form-control"
                                                value="{{ $product->name }}">
                                            @error('product_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3 text-danger">
                                            <label for="banglaInputText" class="form-label">Name in Bangla *</label>
                                            <input type="text" name="product_name_bangla" class="form-control"
                                                id="banglaInputText"
                                                value="{{ $product->translations ? $product->translations->name : 'N/A' }}">
                                            @error('product_name_bangla')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3 text-danger">
                                            <label class="form-label">Product Quantity *</label>
                                            <input type="text" name="quantity" class="form-control" placeholder="N/A"
                                                value="{{ old('quantity', $product->quantity) }}">
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3 text-danger">
                                            <label for="brand" class="form-label">Brand *</label>
                                            <select name="brand_id" class="form-control" id="brand">
                                                <option selected="" disabled="">Select a Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3 text-danger">
                                            <label for="category" class="form-label">Category *</label>
                                            <input type="hidden" id="sub_category_id"
                                                value="{{ $product->categories->category_id }}">
                                            <select name="category_id" class="form-control" id="category_id"
                                                onChange="categoryChanged()">
                                                <option value="">Select a Category</option>

                                                @if ($product->categories->category_detail->parent_id)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->categories->category_detail->parent_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->categories->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3">
                                            <label for="sub_category" class="form-label">Sub Category</label>
                                            <select name="sub_category_id" class="form-control" id="sub_category">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 text-danger">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Sale Price (Sell/New Price) *</label>
                                            <input type="text" name="sale_price" class="form-control" placeholder="N/A"
                                                value="{{ old('sale_price', $product->sale_price) }}">
                                            @error('sale_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Price (Old Price)</label>
                                            <input type="text" name="price" class="form-control" placeholder="N/A"
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">Start Date</label>
                                        <input class="form-control mb-4 mb-md-0" data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd" inputmode="numeric" value="{{ old('start_date', $product->start_date) }}">
                                    </div> --}}

                                    {{-- <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date', $product->start_date) }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date', $product->end_date) }}">
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Length</label>
                                            <input type="text" name="length" class="form-control" placeholder="N/A"
                                                value="{{ old('length', $product->length) }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Wide</label>
                                            <input type="text" name="wide" class="form-control" placeholder="N/A"
                                                value="{{ old('wide', $product->wide) }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Height</label>
                                            <input type="text" name="height" class="form-control" placeholder="N/A"
                                                value="{{ old('height', $product->height) }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Weight</label>
                                            <input type="text" name="weight" class="form-control" placeholder="N/A"
                                                value="{{ old('weight', $product->weight) }}">
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="col-sm-6 text-danger">
                                            <div class="mb-3">
                                                <label class="form-label">Short Content*</label>
                                                <textarea name="short_content" class="form-control" id="exampleFormControlTextarea1" rows="10"
                                                    placeholder="N/A">{{ old('short_content', $product->content) }}</textarea>
                                                @error('short_content')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Long Description</label>
                                                <textarea name="description" class="form-control" rows="10">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group text-danger">
                                            <label class="form-label">Main Thumbnail*</label>
                                            <!-- File input to upload a new thumbnail -->
                                            <input type="file" name="thumbnail" class="form-control" id="image">
                                            {{-- @error('thumbnail')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror --}}
                                            <br>
                                        </div>
                                        <div class="mb-10">
                                            <div>
                                                <img id="showImage" class="wd-100"
                                                    src="{{ !empty($product->thumbnail) ? url($product->thumbnail) : url('upload/no_image.jpg') }}"
                                                    alt="profile">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">Video Type</label>
                                        <select name="video_type" class="form-control">
                                            <option value="" disabled selected>Select Video Type</option>
                                            <option value="youtube"
                                                {{ optional($product->videos->first()->video_detail ?? null)->video_type == 'youtube' ? 'selected' : '' }}>
                                                Youtube
                                            </option>
                                            <option value="vimeo"
                                                {{ optional($product->videos->first()->video_detail ?? null)->video_type == 'vimeo' ? 'selected' : '' }}>
                                                Vimeo
                                            </option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Video Link</label>
                                            <input type="text" name="video_link" class="form-control"
                                                value="{{ $product->videos->first()->video_detail->video_link ?? '' }}"
                                                placeholder="Submit Video Link Here: ">
                                        </div>
                                    </div><!-- Col --> --}}

                                </div>
                                <hr>

                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <div class="form-check form-check-inline me-3">
                                                <input type="checkbox" name="status" value="1"
                                                    class="form-check-input" id="status"
                                                    {{ $product->status == 'active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Enable Status</label>
                                            </div>
                                            <div class="form-check form-check-inline me-3">
                                                <input type="checkbox" name="is_variation" value="1"
                                                    class="form-check-input" id="is_variation"
                                                    {{ $product->is_variation == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_variation">Have Variation</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="is_featured" value="1"
                                                    class="form-check-input" id="is_featured"
                                                    {{ $product->is_featured == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">Enable Featured</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 d-flex justify-content-center align-items-center">
                    <div class="page-content" style="margin-top: 10px;">
                        <div class="row profile-body">
                            <div class="col-md-12 col-xl-12 middle-wrapper">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Edit Multi Image</h6>

                                            <form method="post" action="" id="myForm"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="row">
                                                    @foreach ($product->multi_images as $multi_image => $img)
                                                        <!-- Each image is in a column and occupies 4 columns out of 12 -->
                                                        <div class="col-sm-1 mb-3">
                                                            <div class="card">
                                                                <img src="{{ asset($img->image_detail->image) }}"
                                                                    alt="image" class="card-img-top"
                                                                    style="height: 190px; object-fit: cover;">
                                                                <div class="card-body text-center">
                                                                    <a href="{{ route('deleteMultiImg.delete', $img->image_detail->id) }}"
                                                                        class="btn btn-danger btn-sm"
                                                                        id="delete">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>


                                            </form>

                                            <!-- Upload New Images -->
                                            <form method="post" action="{{ route('uploadMultiImg.add') }}"
                                                id="myForm" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="imageid" value="">
                                                <input type="hidden" value="{{ $product->id }}"
                                                    name="upload_product_id">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="file" class="form-control"
                                                                    name="multi_img">
                                                                @error('multi_img')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </td>

                                                            <td>
                                                                <input type="submit" class="btn btn-info px-4"
                                                                    value="Add Image">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        var categoryId = $('#category_id').val();
        var subCategoryId = $('#sub_category_id').val(); // ID of the sub-category to be selected
        // console.log(subCategoryId);
        // console.log(categoryId);

        if (categoryId) {
            $.ajax({
                url: '/selected-subcategories/' + categoryId, // URL to fetch subcategories
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sub_category').empty(); // Clear existing options
                    $('#sub_category').append(
                        '<option value="">Select a Sub Category</option>'); // Add default option

                    $.each(data, function(key, value) {
                        $('#sub_category').append('<option value="' + value.id + '">' + value.name +
                            '</option>');

                    });

                    // After all options have been appended, set the value of the sub-category dropdown
                    if (subCategoryId) {
                        // console.log(subCategoryId);
                        // Use setTimeout to ensure the UI has updated
                        setTimeout(function() {
                            $('#sub_category').val(subCategoryId).trigger(
                                'change'); // Select the found sub-category
                        }, 100); // Delay in milliseconds (adjust if necessary)
                    }
                },
                error: function() {
                    console.log('Error fetching subcategories');
                }
            });


        }



        function categoryChanged() {
            console.log('hello');
            var categoryId = $('#category_id').val();
            // Get selected category ID


            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId, // URL to fetch subcategories
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sub_category').empty(); // Clear existing options
                        $('#sub_category').append(
                            '<option value="">Select a Sub Category</option>'); // Add default option

                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name +
                                '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error fetching subcategories');
                    }
                });
            } else {

            }
            console.log('Selected Category ID:', categoryId);

            // You can add more logic here to load subcategories based on the selected category
        }



        $(document).ready(function() {
            let imageCounter = 1; // Start from 1 for the first cloned input

            // Handle adding a new input field
            $('#imageFieldsContainer').on('click', '.addMoreButton', function() {
                // Clone the first image field
                var imageField = $('.image-field').first().clone();

                // Remove any file from the cloned input and hide/reset the preview
                $(imageField).find('input[type="file"]').val('');
                $(imageField).find('.image-preview').attr('src', '').hide(); // Reset image preview

                // Update the IDs for the new input and preview
                $(imageField).find('input[type="file"]').attr('id', 'imageInput_' + imageCounter);
                $(imageField).find('.image-preview').attr('id', 'imagePreview_' + imageCounter);

                // Create a remove button
                var removeButton = $('<button/>', {
                    type: 'button',
                    class: 'btn btn-danger ms-2 removeButton',
                    text: '-'
                });

                // Append the remove button next to the cloned "+" button
                $(imageField).find('.addMoreButton').after(removeButton);

                // Append the new image field to the container
                $('#imageFieldsContainer').append(imageField);

                imageCounter++; // Increment the counter for the next input
            });

            // Handle removing an input field
            $('#imageFieldsContainer').on('click', '.removeButton', function() {
                $(this).closest('.image-field').remove(); // Remove the closest image field
            });

            // Handle image preview
            $('#imageFieldsContainer').on('change', 'input[type="file"]', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Find the corresponding preview image for the input
                        $(this).closest('.image-field').find('.image-preview').attr('src', e.target
                            .result).show();
                    }.bind(this); // Bind 'this' to access the input element within the FileReader
                    reader.readAsDataURL(file);
                }
            });
        });

        function mainThamUrl(input) {
            // Check if a file has been selected
            if (input.files && input.files[0]) {
                var reader = new FileReader(); // Create a FileReader object

                reader.onload = function(e) {
                    // Set the src of the img element to the file's data URL
                    var img = document.getElementById('mainThmb');
                    img.src = e.target.result;
                    // Update the src to the loaded file
                    img.style.width = '50px'; // Set width
                    img.style.height = '50px'; // Set height
                    img.style.display = 'block'; // Show the image
                }

                reader.readAsDataURL(input.files[0]); // Read the selected file as a data URL
            }
        }
    </script>

    <!-- JavaScript function to display the uploaded image -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    {{-- Bangla Language --}}
    <script src="{{ asset('backend/assets/js/bangla.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Bangla input plugin once
            $('#banglaInputText').bangla({
                enable: true
            });
            $('#banglaInputText').bangla('on');
        });
    </script>

@endsection
