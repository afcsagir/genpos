@extends('layouts.blank')

@section('main_container')
<div class="right_col" role="main">
    
        <div class="col-md-8">

               <!-- load bootstrap -->
            


                <div class="page-header">
            <h1><span class="glyphicon glyphicon-flash"></span> Edit Customer</h1>
        </div>



        <!-- FORM STARTS HERE -->
        <form method="POST" action="{{url('/customer-data-update')}}" name=""  novalidate>
                  {{ csrf_field() }}


            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" placeholder="..." value="{{ (isset($getCustomerData->name)) ? $getCustomerData->name : '' }}" >
                <input type="hidden" name="id" value="{{ $getCustomerData->id }}">
            </div>

            <div class="form-group">
                <label for="name">Email (this email is used for login)</label>
                <input type="text" id="email" class="form-control" name="email" placeholder="..." value="{{ (isset($getCustomerData->email)) ? $getCustomerData->email : '' }}">
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address" class="form-control" name="address" placeholder="..." value="{{ (isset($getCustomerData->address)) ? $getCustomerData->address : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">City</label>
                            <input type="text" id="city" class="form-control" name="city" placeholder="..." value="{{ (isset($getCustomerData->city)) ? $getCustomerData->city : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="text" id="phone" class="form-control" name="phone" placeholder="..." value="{{ (isset($getCustomerData->phone)) ? $getCustomerData->phone : '' }}">
            </div>
            <div class="form-group">
                            <label for="name">Zip</label>
                            <input type="text" id="zip" class="form-control" name="zip" placeholder="..." value="{{ (isset($getCustomerData->zip)) ? $getCustomerData->zip : '' }}">
            </div>
            <input type="hidden" name="customerId" value="{{ $getCustomerData->id }}">
            









            <button type="submit" class="btn btn-success">Confirmed</button>

        </form>

    </div>
</div>



@endsection