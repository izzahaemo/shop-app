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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection