@extends('layouts.blank')


@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->

    <!-- NProgress -->
    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('css/green.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/buttons.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/fixedHeader.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/responsive.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet">
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
    
@endpush

@push('scripts')
    <script src="{{asset('js/datatables/jquery.dataTables.min.js') }}"></script>  
             <!-- FastClick -->
    <script src="{{asset('js/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{asset('js/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{asset('js/icheck.js') }}"></script>
    <!-- Datatables -->

    <script src="{{asset('js/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('js/datatables/buttons.bootstrap.min.js') }}"></script>
    <script src="{{asset('js/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{asset('js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{asset('js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{asset('js/datatables/dataTables.fixedHeader.min.js') }}"></script>
	<script type="text/javascript">

		$(document).ready(function() {

    		//$('#datatable-checkbox').DataTable();

    		$('#datatable-checkbox').dataTable( {
			  "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ]
			} );
		} );
		
	</script>
@endpush

@section('main_container')

    <!-- page content -->

                  
       
<div class="right_col" role="main">
          
            <div class="page-title col-md-12">
              <div class="title_left">
                <h3>Sales Register</h3>
              </div>
            </div>


<type="" class="js-switch">
            
                            
    <div class="clearfix"></div>
	   <div class="col-md-6">
			<div class="x_content">
	                    
	                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
	                      <thead>
	                        <tr>
	                          
	                          <th>id</th>
	                          <th>name</th>
	                          <th>combo</th>
	                          <th>price</th>
	                          <th>quantity</th>
							  <th>Action</th>
	                          
	                        </tr>
	                      </thead>


	                      <tbody>
	                      	@foreach ($products as $product)
	                        <tr>
	                         
	                          <td>{{ $product->id }}</td>
	                          <td>{{ $product->product->name }}</td>
	                          <td>{{ $product->combo }}</td>
	                          <td>{{ $product->price }}</td>
	                          <td>{{ $product->quantity }}</td>
							  <td> <button class="Add-modal btn btn-danger" 
							  				data-id="{{ $product->id }}" 
											  data-product-name="{{$product->product->name }}"
							   					data-combo="{{ $product->combo }}" 
												   data-price="{{ $product->price }}"
												   data-quantity="{{ $product->quantity }}">
                                                                                <span class="glyphicon glyphicon-shopping-cart"></span> Add</button></td>
	                        </tr>
	                       @endforeach
	                      </tbody>
	                    </table>
	        </div>
	        

	</div> 
	<div class="col-md-4 cart">
		
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
		                                <a class="pull-left" href="{{ url('/pos', ['productId' => $item->variance->product->id]) }}">{{$item->variance['id']}}</a>
		                                <div class="media-body">
		                                    <h4 class="media-heading"><a href="{{ url('/pos', ['productId' => $item->variance->product->id]) }}"><br>&nbsp;&nbsp;&nbsp;{{$item->variance->product['name']}}</a></h4>
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

	</div>

</div>
<!-- data-id="{{ $product->id }}" 
					data-product-name="{{$product->product->name }}"
					data-combo="{{ $product->combo }}" 
					data-price="{{ $product->price }}"
					data-quantity="{{ $product->quantity }}"> -->
 <!-- Modal form to Insert Again a form -->
 <div id="add" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Are you sure you want to Add the following product?</h3>
                        <br />
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="id">Product_ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="id_ProductAdd" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="title">Product Name:</label>
                                <div class="col-sm-10">
                                    <input type="name" class="form-control" id="product_name_add" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                   <label class="control-label col-sm-2" for="title">Product Combo:</label>
                                       <div class="col-sm-10">
                                            <input type="name" class="form-control" id="product_combo_add" autofocus>
                                       </div>
                            </div>
							<div class="form-group">
                                   <label class="control-label col-sm-2" for="title">Product Price:</label>
                                       <div class="col-sm-10">
                                            <input type="name" class="form-control" id="product_price_add" autofocus>
                                       </div>
                            </div>
							<div class="form-group">
                                   <label class="control-label col-sm-2" for="title">Product Quantity:</label>
                                       <div class="col-sm-10">
                                            <input type="name" class="form-control" id="product_quantity_add" autofocus>
                                       </div>
                            </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger Insertagain" data-dismiss="modal">
                                <span id="" class='glyphicon glyphicon-trash'></span> Add
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Close
                            </button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
              




            
    

//Inserting new data

<script>
                $(document).on('click', '.Add-modal', function() {
					alert($('#id_ProductAdd').val($(this).data('id')));
                    $('.modal-title').text('Add');
                    $('#id_ProductAdd').val($(this).data('id_ProductAdd'));
                    $('#product_name_add').val($(this).data('product-name'));
                    $('#product_combo_add').val($(this).data('product_combo'));
					$('#product_price_add').val($(this).data('product_price'));
					$('#product_quantity_add').val($(this).data('product_quantity'));
                    $('#AddModal').modal('show');
                    id = $('#id_ProductAdd').val();
                });
                $('.modal-footer').on('click', '.Add', function() {
                    $.ajax({
                        type: 'POST',
                        url: 'newInsert/ajax',
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'id': $("#id_ProductAdd").val(),
                            'title': $('#title_insert_again').val(),
                            'content': $('#content_insert_again').val()
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
      
            <!-- /page content -->

<script type="text/javascript">

addedProduct = [];
result = [];
	
	function addToCart(x) {
		$.post('/addProduct/' + x.value + '/1/', function(response) {
		    // handle your response here
		    //console.log(response);
		    //setTimeout(function() {
				$.get('test', function(data){ 
					//addedProduct = data;
			        console.log(data);
			        

			        // check if an element exists in array using a comparer function
					// comparer : function(currentElement)
					/*Array.prototype.inArray = function(comparer) { 
					    for(var i=0; i < this.length; i++) { 
					        if(comparer(this[i])) return true; 
					    }
					    return false; 
					}; 

					// adds an element to the array if it does not already exist using a comparer 
					// function
					Array.prototype.pushIfNotExist = function(element, comparer) { 
					    if (!this.inArray(comparer)) {
					        this.push(element);
					    }
					}; 

					//var array = [{ name: "tom", text: "tasty" }];
					//var element = { name: "tom", text: "tasty" };
					addedProduct.pushIfNotExist(data, function(e) { 
					    return e.id === data.id && e.status === data.status; 
					});

					console.log(addedProduct);*/




					/*var props = ['id', 'status'];

					result = data.filter(function(o1){
					    // filter out (!) items in result2
					    return !result.some(function(o2){
					        return o1.id === o2.id;          // assumes unique id
					    });
					}).map(function(o){
					    // use reduce to make objects with only the required properties
					    // and map to apply this to the filtered array as a whole
					    return props.reduce(function(newo, name){
					        newo[name] = o[name];
					        return newo;
					    }, {});
					});
					console.log(result);*/


			    });
		    //}, 1000); //5 seconds
		});
		//window.location.reload(true);
		
	}

</script>
	
@endsection


   