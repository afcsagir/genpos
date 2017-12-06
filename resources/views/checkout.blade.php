@extends('layouts.blank')

@section('main_container')
    <div class="right_col" role="main">

        <div class="page-header">
            <h1><span class="glyphicon glyphicon-flash"></span> Checkout: Please Fill or Update Your Information</h1>
        </div>



        <!-- FORM STARTS HERE -->
        <form method="POST" action="{{url('/post-checkout')}}" name=""  novalidate>
                  {{ csrf_field() }}


            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" placeholder="..." value="{{ (isset($getuserData->name)) ? $getuserData->name : '' }}" >
                <input type="hidden" name="id" value="{{ $getuserData->id }}">
            </div>

            <div class="form-group">
                <label for="name">Email</label>
                <input type="text" id="email" class="form-control" name="email" placeholder="..." value="{{ (isset($getuserData->email)) ? $getuserData->email : '' }}">
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address1" class="form-control" name="address1" placeholder="..." value="{{ (isset($getuserData->address1)) ? $getuserData->address1 : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">Delivery address</label>
                            <input type="text" id="deliveryaddress" class="form-control" name="deliveryaddress" placeholder="..." value="{{ (isset($getuserData->deliveryaddress)) ? $getuserData->deliveryaddress : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">City</label>
                            <input type="text" id="city" class="form-control" name="city" placeholder="..." value="{{ (isset($getuserData->city)) ? $getuserData->city : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="text" id="phone" class="form-control" name="phone" placeholder="..." value="{{ (isset($getuserData->phone)) ? $getuserData->phone : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">Zip</label>
                            <input type="text" id="zip" class="form-control" name="zip" placeholder="..." value="{{ (isset($getuserData->zip)) ? $getuserData->zip : '' }}">
            </div>
            <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" class="form-control" name="country" placeholder="..." value="{{ (isset($getuserData->country)) ? $getuserData->country : '' }}">
             </div><br><hr>

            <div>
                <h3><label for="checkOutMethod">Checkout Method&nbsp;&nbsp;</label>
                <input type="radio" name="checkOutMethod" value="cod" checked> Cash On Delivery
                <input type="radio" name="checkOutMethod" value="cc"> Pay With Credit Card</h3>
            </div><hr><br>







            <button type="submit" class="btn btn-success">Confirmed</button><br><br>

        </form>

    </div>




@endsection