<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

HELL IN THE MAIL    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.jpg') }}">

    <!-- CSFR token for ajax call http://anytch.com/populate-table-jquery-ajax-laravel-5-x-4-steps/5/-->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <title>Manage Posts</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    {{-- <link rel="styleeheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}

    <!-- icheck checkboxes -->
    <link rel="stylesheet" href="{{ asset('icheck/square/yellow.css') }}">
    {{-- <link rel="stylesheet" href="https://raw.githubusercontent.com/fronteed/icheck/1.x/skins/square/yellow.css"> --}}

    <!-- toastr notifications -->
    {{-- <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .panel-heading {
            padding: 0;
        }
        .panel-heading ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .panel-heading li {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .panel-heading li:last-child:hover {
            background-color: #ccc;
        }
        .panel-heading li:last-child {
            border-right: none;
        }
        .panel-heading li a:hover {
            text-decoration: none;
        }

        .table.table-bordered tbody td {
            vertical-align: baseline;
        }
    </style>

</head>

<body>
  
    <div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">Manage Posts</h2>
        <br />
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul>
                    <li><i class="fa fa-file-text-o"></i> All the current Posts</li>

                </ul>
            </div>

            <div class="panel-body">
            <div class="form-group">
                <label for="users">Select user</label>
                <select name="user_id" id="users" class="form-control">
                @foreach($users as $key => $user)
                <option value="{{ $key }}">{{ $user }}</option>
                @endforeach
                </select>
            </div>
                    <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Combo</th>
                                <th>Price</th>
                                <th>Quantity</th>
								<th>Action</th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>

						@foreach ($products as $product)
						<tr>

						  <td>{{ $product->id }}</td>
						  <td>{{ $product->product->name }}</td>
						  <td>{{ $product->combo }}</td>
						  <td>{{ $product->price }}</td>
						  <td>{{ $product->quantity }}</td>
						  <td> <button class="InserAgain-modal btn btn-danger"
										  data-id="{{ $product->id }}"
										  data-product-name="{{$product->product->name }}"
										  data-combo="{{ $product->combo }}"
										  data-price="{{ $product->price }}"
										  data-quantity="{{ $product->quantity }}">
																			<span class="glyphicon glyphicon-shopping-cart"></span> InserAgain</button></td>
						</tr>
					   @endforeach
                        </tbody>
                    </table>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-default -->
    </div><!-- /.col-md-8 -->
     <!---Here is another View -->
	 <div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">Added Products</h2>
        <br />

     <div class="col-md-4 col-md-offset-2">
            <h2 class="text-center">New Inserted</h2>
            <br />
         <div id="displaydata"><!-- for displaying data-->
                <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="" >
                                    <thead>
                                        <tr>
                                            <th>Cart ID</th>
                                            <th>Varriance</th>
											<th>Quantity</th>
											<th>Customer</th>


                                        </tr>
                                        {{ csrf_field() }}
                                    </thead>
                                    <tbody>

                                       <tr>
                                                <td></td>
                                                <td></td>
												<td></td>
												<td></td>


                                       </tr>

                                    </tbody>
                                </table>
                </div><!-- /.panel-body -->
         </div>
    </div>
    

    <div id="show">
    <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                          
                                        </tr>
                                        {{ csrf_field() }}
                                    </thead>
                                    <tbody>
                                             @foreach($cartAd as $cart)
                                       <tr>
                                                <td>{{$cart->id}}
                                                
                                       </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                </div><!-- /.panel-body -->
    
    
    </div>

	




    <!-- Modal form to Insert Again a form -->
        <div id="insertAgainModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Are you sure you want to InsertAgain the following post?</h3>
                        <br />
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="id">ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="id_Insertagain" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Name:</label>
                                <div class="col-sm-10">
                                    <input type="name" class="form-control" id="name_insert_again" autofocus>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-sm-2" for="name">Combo:</label>
                                <div class="col-sm-10">
                                    <input type="combo" class="form-control" id="combo_insert_again" autofocus>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-sm-2" for="name">Price:</label>
                                <div class="col-sm-10">
                                    <input type="price" class="form-control" id="price_insert_again" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                   <label class="control-label col-sm-2" for="title">Quantity:</label>
                                       <div class="col-sm-10">
                                            <input type="name" class="form-control" id="quantity_insert_again" autofocus>
                                       </div>
                            </div>
                            <div class="form-group">
                                   <label class="control-label col-sm-2" for="title">Customer:</label>
                                       <div class="col-sm-10">
                                            <input type="name" class="form-control" id="user_id" autofocus>
                                       </div>
                            </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger Insertagain" data-dismiss="modal">
                                <span id="" class='glyphicon glyphicon-trash'></span> Insertagain
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Close
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- jQuery -->
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <!-- Bootstrap JavaScript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

    <!-- toastr notifications -->
    {{-- <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script> --}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- icheck checkboxes -->
    <script type="text/javascript" src="{{ asset('icheck/icheck.min.js') }}"></script>

    <!-- Delay table load until everything else is loaded -->
    <script>
        $(window).load(function(){
            $('#postTable').removeAttr('style');
        })
    </script>


   
   <!-- <script language="javascript">
   setTimeout(function(){
     window.location.reload(1);
}, 10000);
</script> -->



    <!-- AJAX CRUD operations -->
    <script type="text/javascript">

        //Inserting new data
                $(document).on('click', '.InserAgain-modal', function() {
                     // e.preventDefault();
					//alert($('#name_insert_again').val($(this).data('name')));
                    $('.modal-title').text('InsertAgain');
                    $('#id_Insertagain').val($(this).data('id'));
                    $('#name_insert_again').val($(this).data('name'));
                    $('#combo_insert_again').val($(this).data('combo'));
					$('#price_insert_again').val($(this).data('price'));
					$('#quantity_insert_again').val($(this).data('quantity'));
                    $('#users').val($(this).data('users'));
                   // alert($('#users').val());


                    $('#insertAgainModal').modal('show');
                    id = $('#id_Insertagain').val();
                });
                $('.modal-footer').on('click', '.Insertagain', function() {
                    $.ajax({
                        type: 'POST',
                        url: 'addCart/ajax',
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'id': $("#id_Insertagain").val(),
                            'name': $('#name_insert_again').val(),
                            'combo': $('#combo_insert_again').val(),
							'price': $('#price_insert_again').val(),
							'quantity': $('#quantity_insert_again').val(),
                            'users': $('#user_id').val(),



                        },
                        dataType: "JSON",
                        success: function(data) {

                                  console.log(response);

                            toastr.success('Successfully Inserted Again Post!', 'Success Alert', {timeOut: 5000});

                            //$('.item' + data['id']).remove();
                            $('.col1').each(function (index) {
                                $(this).html(index+1);
                            });
                        }
                    });
                });
    </script>
    
      <script src="js/app.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script>
        $(document).ready(function(){
            $('#users').select2({
                placeholder : 'Please select Customer',
                tags: true
            });
        });
    </script>
    <script>
    $('#users').change(function() {
    alert('The option with value ' + $(this).val()  + ' was selected.');
    $("#user_id").val($(this).val());

    });
</script>
	<!--Display added to cart Data -->
<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function () {
				$('#show').load('getData')
			}, 3000);
		});
	</script>

</body>
</html>
