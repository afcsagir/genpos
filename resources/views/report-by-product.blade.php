@extends('layouts.blank')

@section('main_container')

<div class="right_col" role="main">
	<div class="page-title">
      <div class="title_left">
        <h3>Reports</h3>
      </div>
    </div>




                            
    <div class="clearfix"></div>
	<div class="col-md-6">
		<a href="#"></a>
		@foreach ($products as $product)
			{{$product->tquantity}}, {{ $product->variance_id }}, {{ $product->variance->product['name'] }}, {{ $product->variance->product['price'] }} <br>

		@endforeach
	</div>
	<div class="col-md-6">

	</div>

</div>

@endsection