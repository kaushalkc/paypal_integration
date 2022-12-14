<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}"></script>

</head>
<body>
    <h2>Please make a payment using paypal</h2> <br>
    <form action="{{route('processPaypal')}}" method="POST">
        @csrf
         <input type="number" name="card_num" placeholder="card number"/><br><br>
         <input type="date" name="exp_date" placeholder="expiration date"/><br><br>
         <input type="number" name="cvv" placeholder="CVV"/><br><br>
         <input type="number" name="amount" placeholder="amount"/><br><br>
         <input type="submit" name="submit" value="Place order"/>
    </form> 

	@if(\Session::has('error'))
        <div class="alert alert-danger">{{ \Session::get('error') }}</div>
        {{ \Session::forget('error') }}
    @endif

    
    @if(\Session::has('success'))
        <div class="alert alert-success">{{ \Session::get('success') }}</div>
        {{ \Session::forget('success') }}
    @endif

</body>
</html>