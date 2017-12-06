@extends('layouts.blank')


@section('main_container')







            <div class="right_col" role="main">

                      <form class="form-horizontal" action="" method="post" id="payment-form">

                                            {{csrf_field()}}
                    <br style="clear:both">

                				<div class="form-group">
                                       <input type="text" class="form-control" id="cardnum" name="cardnum" placeholder="Card Number" required>
                                 </div>
            					<div class="form-group">
            					    <input type="text" class="form-control" id="Month" name="Month" placeholder="Expiration Month" required >
            					</div>
            					<div class="form-group">
                                     <input type="text" class="form-control" id="Year" name="Year" placeholder="Expiration Year" required >
                                 </div>
                                 <div class="form-group">
                                      <input type="text" class="form-control" id="CVC" name="CVC" placeholder="CVC" required >
                                </div>



                    <button type="button" id="submit" name="submit" class="btn btn-primary pull-middle">Submit Form</button>
                    </form><br><hr>
                
            
        
        </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <script>
    	$(document).ready(function(){
    		var date_input=$('input[name="date"]'); //our date input has the name "date"
    		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    		date_input.datepicker({
    			format: 'mm/dd/yyyy',
    			container: container,
    			todayHighlight: true,
    			autoclose: true,
    		})
    	})
    </script>
@endsection
