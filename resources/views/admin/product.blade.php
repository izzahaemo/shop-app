@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class='row'>
                <h5 class="col-8">Product Data</h5>
                <button type="button" class="col-4 btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalCreate">
                    Add New Product
                </button>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Total Products : {{$products->total()}}</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td> <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{$product->id}}">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{$product->id}}">
                                <i class="bi bi-trash3-fill me-2"></i>
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container">
    {!! $products->links() !!}
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCreateLabel">New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('product_create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formName" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="formName" placeholder="Input Name">
                    </div>
                    <div class="mb-3">
                        <label for="formPrice" class="form-label">Price</label>
                        <input name="price" type="int" class="form-control" id="formPrice" placeholder="Input Price">
                    </div>
                    <div class="mb-3">
                        <label for="formPrice" class="form-label">Category</label>
                        <select name="category_id" id="formPrice" class="form-select" aria-label="Category">
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formDesc" class="form-label">Desc</label>
                        <textarea name="desc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input name="file" class="form-control" type="file" id="formFile">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach ($products as $product)
<div class="modal fade" id="modalEdit{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product {{$product->name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('product_update',$product) }}" method="post" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formName" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="formName" placeholder="Input Name"
                            value="{{$product->name}}">
                    </div>
                    <div class="mb-3">
                        <label for="formPrice" class="form-label">Price</label>
                        <input name="price" type="int" class="form-control" id="formPrice" placeholder="Input Price"
                            value="{{$product->price}}">
                    </div>
                    <div class="mb-3">
                        <label for="formPrice" class="form-label">Category</label>
                        <select name="category_id" id="formPrice" class="form-select" aria-label="Category">
                            <option value="{{$product->category_id}}">{{$product->category->name}}</option>
                            @foreach ($categories as $category)
                            @if($category->id != $product->category_id)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formDesc" class="form-label">Desc</label>
                        <textarea name="desc" class="form-control" id="exampleFormControlTextarea1"
                            rows="3">{{$product->desc}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input name="file" class="form-control" type="file" id="formFile">
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
@foreach ($products as $product)
<div class="modal fade" id="modalDelete{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product {{$product->name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('product_delete',$product) }}" method="post">
                @method('delete')
                @csrf
                <div class="modal-body">
                    <h3>Are you sure want to delete this? {{$product->name}}</h3>
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