@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        {{-- ALL Order --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Order</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Order ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Method</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($orders && count($orders) > 0)
                                        @foreach ($orders as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>#order{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->address }}</td>
                                                <td>৳ {{ $item->total_cost }}</td>
                                                <td>
                                                    @if ($item->payment_option == 'full-amount')
                                                        {{ $item->bkash ?? 'Empty' }}
                                                    @else
                                                        {{ 'Cash On Delivery' }}
                                                    @endif
                                                </td>
                                                <td>{{ $item->created_at->timezone('Asia/Dhaka')->format('g:i A | j M Y') }}</td>
                                                <td>
                                                    @if ($item->status == 'Processing')
                                                        <span class="badge rounded-pill bg-success">Processing</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Confirm</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.details', $item->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    @if ($item->status == 'Processing')
                                                    <a href="{{ route('order.confirm', $item->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i data-feather="check-circle"></i>
                                                    </a>
                                                    @else
                                                    {{-- Confirmed --}}
                                                    @endif
                                                    
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
