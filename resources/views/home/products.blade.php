@extends('layouts.app')

@section('content')

<div class="album py-5 bg-body-tertiary">
    <div class="container">
        @if (!$category)
        <div class="p-2 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">All Products</h1>
        </div>
        @else
        <div class="p-2 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">Product {{$category->name}}</h1>
        </div>
        @endif

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach ($products as $product)
            <div class="col">
                <div class="card shadow-sm">
                    <img src="{{Storage::url('public/products/'.$product->img);}}" width="100%" height="225">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <div class="row">
                            <div class="col">
                                <p class="card-text">Price {{$product->price}} </p>
                            </div>
                            <div class="col">
                                <p class="card-text">{{$product->category->name}} </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('product',$product) }}" type="button"
                                class="btn btn-sm btn-outline-secondary">Check</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            {!! $products->links() !!}
        </div>
    </div>
</div>

@endsection