@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class='row'>
                <h5 class="col-8">Confirmation Order</h5>
            </div>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <td>Name</td>
                    <td> : {{$order->name}}</td>
                </tr>
                <tr>
                    <td>No Phone</td>
                    <td> : {{$order->phone}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td> : {{$order->address}}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td> : {{$order->gross_amount}}</td>
                </tr>
            </table>
            <br>
            <h5>Product</h5>
            <table>
                @foreach($products as $product)
                <tr>
                    <td>Name</td>
                    <td> : {{$product->name}}</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td> : {{$product->price}}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td> : {{$product->amount}}</td>
                </tr>
                @endforeach
            </table>
            <button class="btn btn-primary mt-3" id="pay-button">Pay Now</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{$snapToken}}', {
            onSuccess: function (result) {
                /* You may add your own implementation here */
                // alert("payment success!");
                window.location.href = '/order'
                console.log(result);
            },
            onPending: function (result) {
                /* You may add your own implementation here */
                alert("wating your payment!");
                console.log(result);
            },
            onError: function (result) {
                /* You may add your own implementation here */
                alert("payment failed!");
                console.log(result);
            },
            onClose: function () {
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        })
    });

</script>
@endsection