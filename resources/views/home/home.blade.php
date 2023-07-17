@extends('layouts.app')

@section('content')

<div class="px-4 py-5 my-5 text-center">
    {{-- <img class="d-block mx-auto mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72"
        height="57"> --}}
    <h1 class="display-5 fw-bold text-body-emphasis">Wellcome in Shop App</h1>
    <div class="col-lg-6 mx-auto">
        @if (!Auth::check())
        <p class="lead mb-4">This is Shop App. Go Login or Register to shop!</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ route('login') }} type=" button" class="btn btn-primary btn-lg px-4 gap-3">Login</a>
            <a href="{{ route('register') }} type=" button" class="btn btn-outline-secondary btn-lg px-4">Register</a>
        </div>
        @else
        <p class="lead mb-4">Hi {{ Auth::user()->name }}</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ route('products') }}" type="button" class="btn btn-primary btn-lg px-4 gap-3">Go Shop</a>
        </div>
        @endif
    </div>
</div>

<div class="album py-5 bg-body-tertiary">
    <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach ($products as $product)
            <div class="col">
                <div class="card shadow-sm">
                    <img src="{{Storage::url('public/products/'.$product->img);}}" width="100%" height="225">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->price}} </p>
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
            <h1 class="text-body-emphasis">Check more product</h1>
            <a href="{{ route('products') }}" type="button" class="btn btn-primary btn-lg px-4 gap-3">Go</a>
        </div>
    </div>
</div>

@endsection