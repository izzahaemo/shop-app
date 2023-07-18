@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class='row'>
                <h5 class="col-8">Your Cart</h5>
            </div>
        </div>
        <div class="card-body">
            @if ($total != 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                    <tr>
                        <th scope="row"></th>
                        <td>{{ $cart->product->name }}</td>
                        <td>{{ $cart->product->price }}</td>
                        <td>{{ $cart->amount }}</td>
                        <td>
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{$cart->id}}">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{$cart->id}}">
                                <i class="bi bi-trash3-fill me-2"></i>
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="card-title">Total = {{$total}}</h5>
            @else
            <h5 class="card-title">You don't have any cart, go shop</h5>
            @endif
        </div>
    </div>
</div>


<!-- Modal Update -->
@foreach ($carts as $cart)
<div class="modal fade" id="modalEdit{{$cart->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Cart Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cart_update',$cart) }}" method="post">
                @method('patch')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2">
                            <label for="formamount" class="form-label">Amount :</label>
                        </div>
                        <div class="col-4">
                            <input name="amount" type="int" class="form-control" id="formamount" placeholder="Amount"
                                value="{{$cart->amount}}">
                        </div>
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
@endforeach

<!-- Modal Delete -->
@foreach ($carts as $cart)
<div class="modal fade" id="modalDelete{{$cart->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Cart Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cart_delete',$cart) }}" method="post">
                @method('delete')
                @csrf
                <div class="modal-body">
                    <h5>Are you sure want to delete this from your chart? {{$cart->product->name}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection