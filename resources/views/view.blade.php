@extends('layouts.app')

<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>


@section('content')


    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th></th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="{{ route('product', ['productId' => $item->variance->product->id]) }}"> <img class="media-object" src="/uploads/products/{{ $item->variance->product->pic }}" style="width: 100px; height: auto; padding-left: 3px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="{{ route('product', ['productId' => $item->variance->product->id]) }}"><br>&nbsp;&nbsp;&nbsp;{{$item->variance->product['name']}}</a></h4>
                                    <br><p>&nbsp;&nbsp;&nbsp;{{$item->variance['combo']}}</p>
                                </div>
                            </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center">{{$item->quantity}}</td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>৳{{$item->variance['price']*$item->quantity}}</strong></td>
                        <td class="col-sm-1 col-md-1">
                            <a href="{{url('/removeItem/'.$item->id)}}"> <button type="button" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Remove
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h3>Total</h3></td>
                    <td class="text-right"><h3><strong>৳{{$total}}</strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <a href="{{ url('/') }}" button class="btn btn-default">Continue Shopping</a>
                    </td>
                    <td>
                        <a href="{{ url('/checkout/').'/'.$userId }}" button class="btn btn-success">Proceed to Checkout</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
