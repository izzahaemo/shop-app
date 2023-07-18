@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class='row'>
                <h5 class="col-8">Your Order</h5>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row"></th>
                        <td>{{$order->created_at}}</td>
                        <td>{{ $order->gross_amount}}</td>
                        <td>{{ $order->status}}</td>
                        <td>
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#modalCheck{{$order->id}}">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Check
                            </button>
                            @if (Auth::check() && Auth::user()->hasPermission('order-delete') && $order->status ==
                            'Unpaid')
                            <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{$order->id}}">
                                <i class="bi bi-x-circle-fill"></i>
                                Cancel
                            </button>
                            @endif
                            @if (Auth::check() && Auth::user()->hasPermission('order-create') && $order->status ==
                            'Unpaid')
                            <a href="{{ route('checkout',$order) }}" class="btn btn-primary me-2" id="pay-button">
                                <i class="bi bi-credit-card-2-back-fill"></i>
                                Pay Now
                            </a>
                            @endif
                            @if (Auth::check() && Auth::user()->hasPermission('order-update') && $order->status ==
                            'Paid')
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#modalUpdate{{$order->id}}">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Update
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Checkout -->
@foreach ($orders as $order)
<div class="modal fade" id="modalCheck{{$order->id}}" tabindex="-1" aria-labelledby="modalCheckLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCheckLabel">Your Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="formName" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="formName" disabled
                        placeholder="{{$order->name}}">
                </div>
                <div class="mb-3">
                    <label for="formphone" class="form-label">Phone Number</label>
                    <input name="phone" type="text" class="form-control" id="formphone" disabled
                        placeholder="{{$order->phone}}">
                </div>
                <div class="mb-3">
                    <label for="formAddress" class="form-label">Address</label>
                    <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3"
                        disabled>{{$order->address}}</textarea>
                </div>
                <div class="mb-3">
                    <label for="formphone" class="form-label">Track Number</label>
                    <input name="phone" type="text" class="form-control" id="formphone" disabled
                        placeholder="{{$order->track}}">
                </div>
                <div class="mb-3">
                    <h5>Total = {{$order->gross_amount}}</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Update -->
@foreach ($orders as $order)
<div class="modal fade" id="modalUpdate{{$order->id}}" tabindex="-1" aria-labelledby="modalUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUpdateLabel">Update Status Order to Shipped</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order_update',$order) }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formName" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="formName" disabled
                                placeholder="{{$order->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="formphone" class="form-label">Phone Number</label>
                            <input name="phone" type="text" class="form-control" id="formphone" disabled
                                placeholder="{{$order->phone}}">
                        </div>
                        <div class="mb-3">
                            <label for="formAddress" class="form-label">Address</label>
                            <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                disabled>{{$order->address}}</textarea>
                        </div>
                        <div class="mb-3">
                            <h5>Total = {{$order->gross_amount}}</h5>
                        </div>
                        <div class="mb-3">
                            <label for="formTrack" class="form-label">Track</label>
                            <input name="track" type="text" class="form-control" id="formTrack">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Delete -->
@foreach ($orders as $order)
<div class="modal fade" id="modalDelete{{$order->id}}" tabindex="-1" aria-labelledby="modalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDeleteLabel">Cancel Your Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order_delete',$order) }}" method="post">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <h5>Are you sure want to cancel this order? {{$order->created_at}}</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection