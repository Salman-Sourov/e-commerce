@extends('admin.admin_dashboard')
@section('admin')


    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Attribute
                </button>
            </ol>
        </nav>

        <!-- Add Attribute Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Attribute</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAttributeForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreAttribute();">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Attribute Set *</label>
                                <select name="attribute_set_id" class="form-control" id="attribute_set_id">
                                    <option value="">Select a Attribute</option>
                                    <!-- Options will be dynamically populated here -->
                                    @foreach ($attribute_sets as $attribute_set)
                                        <option value="{{ $attribute_set->id }}">{{ $attribute_set->title }}</option>
                                    @endforeach
                                </select>
                                <span id="attribute_set_id_error" class="text-danger"></span>
                                <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Title *</label>
                                <input type="text" name="title" class="form-control" id="title">
                                <span id="title_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>

                            {{-- <div class="form-group mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="color" name="color" class="form-control" id="color"> <!-- Default hex color value -->
                                <span id="color_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div> --}}


                            {{-- <div class="col-9-row d-flex justify-content-start align-items-center mb-3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="status" class="form-check-input" id="status">
                                    <label class="form-check-label" for="enableSubcat">
                                        Enable Status
                                    </label>
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Add Attribute Set</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        {{-- ALL Attribute Set --}}
        <div class="row">
            <!-- Loop through each Attribute Set -->
            @foreach ($attribute_sets as $attribute_set)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-folder-outline me-2"></i>{{ $attribute_set->title }}
                            </h5>
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $attribute_set->id }}">
                                View Attributes
                            </button>
                        </div>
                        <div id="collapse-{{ $attribute_set->id }}" class="collapse">
                            <div class="card-body">
                                @if ($attribute_set->attributes->isNotEmpty())
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attribute_set->attributes as $key => $attribute)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $attribute->title }}</td>
                                                    <td>
                                                        @if ($attribute->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning" onclick="AttributeEdit({{ $attribute->id }})">Edit</button>
                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $attribute->id }}">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No attributes available for this set.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Edit Attribute Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Attribute Set</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAttributeForm" method="POST" enctype="multipart/form-data" class="forms-sample"
                        onsubmit="event.preventDefault(); UpdateAttribute();">
                        @csrf
                        <!-- Simulate PATCH method -->
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="id" id="id">


                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Attribute Set</label>
                            <select name="edit_attribute_set_id" class="form-control" id="edit_attribute_set_id">
                                <option value="">Select a Category</option>
                                <!-- Options will be dynamically populated here -->
                                @foreach ($attribute_sets as $attribute_set)
                                    <option value="{{ $attribute_set->id }}">{{ $attribute_set->title }}</option>
                                @endforeach
                            </select>
                            <span id="edit_attribute_set_id_error" class="text-danger"></span>
                            <!-- Error message placeholder -->
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" name="edit_title" class="form-control" id="edit_title">
                            <span id="edit_title_error" class="text-danger"></span>
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="color" name="edit_color" class="form-control" id="edit_color"> <!-- Default hex color value -->
                            <span id="color_error" class="text-danger"></span> <!-- Error message placeholder -->
                        </div> --}}

                        {{-- <div class="col-9-row d-flex justify-content-start align-items-center mb-3">
                            <div class="form-check mb-2">
                                <input type="checkbox" name="status" class="form-check-input"
                                    id="edit_status">
                                <label class="form-check-label" for="edit_status">
                                  Enable Status
                                </label>
                            </div>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Store Attribute Set --}}
    <script type="text/javascript">
        function StoreAttribute() {
            var formData = new FormData(document.getElementById('addAttributeForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('attribute.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        toastr.success(data.message);
                        $('#addAttributeForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 150);
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

    {{-- Edit Attribute Set --}}
    <script type="text/javascript">
        function AttributeEdit(id) {
            $.ajax({
                type: 'GET',
                url: '/attribute/' + id + '/edit', // Ensure this is the correct route
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        $('#id').val(data.id);
                        $('#set_id').val(data.set_id);
                        $('#edit_title').val(data.title);
                        $('#edit_status').prop('checked', data.status ==
                            'active'); // Check if 'enableSubcat' is true
                        // $('#edit_color').val( data.color);
                        $('#edit_attribute_set_id').val(data.set_id);
                        $('#edit_attribute_set_id').trigger("change");
                        $('#editModal').modal('show'); // Open modal with data loaded

                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>

    {{-- Update Attribute Set --}}
    <script type="text/javascript">
        function UpdateAttribute() {
            var formData = new FormData(document.getElementById('editAttributeForm'));
            var Id = $('#id').val(); // Get the brand ID
            console.log(Id);

            $.ajax({
                type: 'POST', // POST method to support _method PATCH
                url: '/attribute/' + Id,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token header
                },
                success: function(data) {
                    if (data.success) {
                        $('#editModal').modal('hide'); // Close the modal
                        toastr.success(data.message); // Show success notification
                        // Optionally refresh the brand list or table here
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 150);
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

    {{-- Delete Attribute Set --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('attribute.destroy', ':id') }}';
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
                                toastr.error('Failed to delete the brand.');
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
