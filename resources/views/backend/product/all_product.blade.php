@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('product.create') }}" class="btn btn-inverse-info"> Add Product</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Product</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Brand</th>
                                        {{-- <th>Old Price</th> --}}
                                        <th>Sale Price</th>
                                        <th>Stock</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><img src="{{ asset($item->thumbnail) }}" style="width:70px; height:40px;">
                                            </td>
                                            @php
                                                $brand = App\Models\Brand::find($item->brand_id); // Corrected namespace and query
                                            @endphp
                                            <td>{{ $brand ? $brand->name : 'N/A' }}</td>
                                            <!-- Check if brand exists and display its name, otherwise 'N/A' -->

                                            {{-- <td>৳ {{ $item->price }}</td> --}}
                                            <td>৳ {{ $item->sale_price }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            {{-- <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge rounded-pill bg-success">Active</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">InActive</span>
                                                @endif
                                            </td> --}}

                                            <td>
                                                <a href="{{ route('product.details', $item->id) }}"
                                                    class="btn btn-outline-info btn-sm" title="View" target="_blank">
                                                    <i data-feather="eye"></i>
                                                </a>

                                                <a href="{{ route('product.edit', $item->id) }}"
                                                    class="btn btn-outline-warning btn-sm mx-2" title="Edit">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                <a href="javascript:void(0);" class="delete-btn btn btn-outline-danger btn-sm"
                                                    data-id="{{ $item->id }}" title="Delete">
                                                    <i data-feather="power"></i>
                                                </a>
                                
                                                <a href="{{ route('get.stock', $item->id) }}"
                                                    class="btn btn-outline-primary btn-sm mx-2" title="Variant & Stock">Variant & Stock
                                                </a>

                                                @if ($item->stock_status == 'stock_out')
                                                    <a href="{{ route('stock.in', $item->id) }}"
                                                        class="btn btn-outline-success btn-sm" title="Stock In">
                                                        <i data-feather="arrow-up" class="me-1"></i>Stock In
                                                    </a>
                                                @else
                                                    <a href="{{ route('stock.out', $item->id) }}"
                                                        class="btn btn-outline-danger btn-sm" title="Stock Out">
                                                        <i data-feather="arrow-down" class="me-1"></i>Stock Out
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Product --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('product.destroy', ':id') }}';
            url = url.replace(":id", id); // Replace placeholder with actual ID

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
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                                toastr.success('Deleted Successfully.');
                                setTimeout(function() {
                                    window.location
                                        .reload(); // Reload the page to see the new brand
                                }, 1500);
                            } else {
                                toastr.error('Failed to delete Product.');
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
@endsection
