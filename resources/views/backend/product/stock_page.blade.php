@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        {{-- Variant --}}
        {{-- <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Variant
                </button>
            </ol>
        </nav> --}}

        <!-- Add Variant-->
        {{-- <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Variant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addStockForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreStock();">
                            @csrf
                            <input type="hidden" name="product_id" value={{ $product_id->id }}>
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Attribute Set</label>
                                <select name="attribute_set" class="form-control" id="attribute_set"
                                    onChange="attributeChange()">
                                    <option value="">Select Attribute Set</option>
                                    <!-- Options will be dynamically populated here -->
                                    @foreach ($attributeSets as $attributeSet)
                                        <option value="{{ $attributeSet->id }}">{{ $attributeSet->title }}</option>
                                    @endforeach
                                </select>
                                <span id="attribute_set_error" class="text-danger"></span>
                                <!-- Error message placeholder -->
                            </div>

                            <button type="submit" class="btn btn-primary">Add Variant</button>
                        </form>

                    </div>
                </div>
            </div>
        </div> --}}

        {{-- ALL Variant --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            {{ $product_id->name }}
                        </h6>
                        <div class="">
                            <form id="myForm" method="POST" action="{{ route('stock.store') }}" class="forms-sample"
                                onsubmit="return validateForm()">
                                @csrf
                                <input type="hidden" name="product_id" value={{ $product_id->id }}>

                                <div class="row">
                                    @forelse ($attributeSets as $attributeSet)
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <div class="card shadow-sm border-0">
                                                <div
                                                    class="card-header bg-primary text-white d-flex align-items-center justify-content-center">
                                                    <h5 class="mb-0 text-center w-100">{{ $attributeSet->title }}</h5>
                                                </div>
                                                <div class="card-body" style="border: 1px solid #6571FF;">
                                                    <div class="d-flex flex-wrap">

                                                        @forelse($attributeSet->attributes as $attribute)
                                                            <div class="col-4 text-capitalize form-check mb-2"
                                                                style="">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="attribute[]" id="checkDefault{{ $attribute->id }}"
                                                                    value="{{ $attribute->id }}">
                                                                <label class="form-check-label"
                                                                    for="checkDefault{{ $attribute->id }}">
                                                                    {{ $attribute->title }}
                                                                </label>
                                                            </div>
                                                        @empty
                                                            <h3>No data</h3>
                                                        @endforelse

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <h3>No Data</h3>
                                    @endforelse
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Add Attribute</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Variant Wise Stock --}}
        {{-- <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Variant
                </button>
            </ol>
        </nav> --}}

        {{-- ALL Variant Wise Stock --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            Add variant wise stock of - {{ $product_id->name }}</h6>
                        <button type="button" class="btn btn-danger delete-btns" data-id="{{ $product_id->id ?? '' }}">
                            Delete All Variant
                        </button>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Attribute</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Step 1: Retrieve the Product_with_attribute record
                                        $ids = App\Models\Product_with_attribute::where(
                                            'product_id',
                                            $product_id->id,
                                        )->first();
                                        $attribute_ids = $ids ? explode(',', $ids->attribute_ids) : [];

                                        // Step 2: Retrieve all the relevant attributes from Product_attribute
                                        $attributes = App\Models\Product_attribute::whereIn(
                                            'id',
                                            $attribute_ids,
                                        )->get();

                                        // Step 3: Group the attributes by attribute_set_id
                                        $attribute_sets = $attributes->groupBy('attribute_set_id');

                                        // Step 4: Calculate the Cartesian Product of the attribute sets
                                        $cartesian_combinations = [[]];

                                        foreach ($attribute_sets as $set_id => $set_attributes) {
                                            $new_combinations = [];
                                            foreach ($cartesian_combinations as $combination) {
                                                foreach ($set_attributes as $attribute) {
                                                    $new_combinations[] = array_merge($combination, [$attribute]);
                                                }
                                            }
                                            $cartesian_combinations = $new_combinations;
                                        }
                                    @endphp

                                    {{-- {{ count($cartesian_combinations) }} --}}

                                    @foreach ($cartesian_combinations as $key => $combination)
                                        @if (!empty(array_filter($combination)))
                                            <tr>
                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    @foreach ($combination as $index => $attribute)
                                                        {{ $attribute->title }}{{ $loop->last ? '' : ' - ' }}
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @php
                                                        // Map the attribute IDs to strings
                                                        $attributeIds = array_map(
                                                            fn($attribute) => (string) $attribute->id, // Cast to string explicitly
                                                            $combination,
                                                        );

                                                        $attributeIdString = implode(',', $attributeIds);
                                                        $stock = App\Models\Product_attribute_wise_stock::where(
                                                            'product_id',
                                                            $product_id->id,
                                                        )
                                                            ->where('attribute_id', $attributeIdString)
                                                            ->first();
                                                        $quantity = $stock ? $stock->stock : 0;

                                                    @endphp

                                                    <!-- Display the stock quantity -->
                                                    {{ $quantity }}
                                                </td>


                                                <td>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addStock"
                                                        data-attribute-ids="{{ implode(',', array_map(fn($attribute) => $attribute->id, $combination)) }}"
                                                        onclick="setAttributeData(this)">
                                                        Add
                                                    </button>

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Variant Wise Stock-->
        <div class="modal fade" id="addStock" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAttributeStockForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreAttributeWiseStock();">
                            @csrf
                            <input type="hidden" name="attribute_ids" id="attribute_ids">
                            <input type="hidden" name="product_id" value={{ $product_id->id }}>
                            <div class="form-group mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                {{-- <select name="attribute_set" class="form-control" id="attribute_set"
                                    onChange="attributeChange()">
                                    <option value="">Select Attribute Set</option>
                                    <!-- Options will be dynamically populated here -->
                                    @foreach ($attributeSets as $attributeSet)
                                        <option value="{{ $attributeSet->id }}">{{ $attributeSet->title }}</option>
                                    @endforeach
                                </select> --}}
                                <input type="text" name="quantity" class="form-control" id="quantity">
                                <span id="quantity_error" class="text-danger"></span>
                                <!-- Error message placeholder -->
                            </div>

                            <button type="submit" class="btn btn-primary">Add Stock</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Store Stock --}}
    <script type="text/javascript">
        function StoreStock() {
            var formData = new FormData(document.getElementById('addStockForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('stock.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        toastr.success(data.message);
                        $('#addStockForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 1500);
                    } else {
                        for (let field in data.errors) {
                            $('#' + field + '_error').text(data.errors[field][0]); // Show error
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr); // Log the error for debugging
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); // Show error
                    }
                }
            });
        }


        function setAttributeData(button) {
            const attributeIds = button.getAttribute('data-attribute-ids');
            console.log('Attribute IDs:', attributeIds); // Get attributes from button



            // Set the hidden input value
            $('#attribute_ids').val(JSON.stringify(attributeIds));
        }


        function StoreAttributeWiseStock() {
            var formData = new FormData(document.getElementById('addAttributeStockForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('attributeWise.stock.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addStock').modal('hide'); // Close modal
                        toastr.success(data.message);
                        $('#addAttributeStockForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 1500);
                    } else {
                        for (let field in data.errors) {
                            $('#' + field + '_error').text(data.errors[field][0]); // Show error
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr); // Log the error for debugging
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); // Show error
                    }
                }
            });
        }
    </script>

    {{-- Delete Stock  --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btns', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('stock.destroy', ':id') }}';
            url = url.replace(':id', id); // Ensure id is correctly replaced

            // SweetAlert confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request if the user confirms
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}" // Include CSRF token for security
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                toastr.success('Deleted Successfully.');
                                setTimeout(function() {
                                    window.location
                                        .reload(); // Reload the page to see the changes
                                }, 1500);
                            } else {
                                toastr.error('Failed to delete the Stock.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while deleting the item.');
                            console.log(xhr); // Log the error for debugging
                        }
                    });
                }
            });
        });
    </script>


    <script>
        function validateForm() {
            var checkboxes = document.querySelectorAll('input[name="attribute[]"]:checked');
            if (checkboxes.length === 0) {
                // Using Toastr to show the validation message
                toastr.error('Please select at least one attribute.', {});
                return false;
            }
            return true;
        }
    </script>
@endsection
