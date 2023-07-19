@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="col-8">{{$product->name}}</h4>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-4">
                    <img src="{{Storage::url('public/products/'.$product->img);}}" width="100%" height="100%">
                </div>
                <div class="col-8">
                    <h5>{{$product->name}}</h5>
                    <h5>Price {{$product->price}}</h5>
                    <h5>{{$product->category->name}}</h5>
                    <h5>{{$product->desc}}</h5>
                    <br>
                    @if (Auth::check() && Auth::user()->hasPermission('cart-create'))
                    <h5>Add to chart</h5>
                    <form action="{{ route('cart_add',$product) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <label for="formamount" class="form-label">Amount :</label>
                            </div>
                            <div class="col-4">
                                <input name="amount" type="int" class="form-control" id="formamount"
                                    placeholder="Ammount">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    @else
                    <h5>Go Login Member to add chart</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection