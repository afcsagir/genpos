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
    <!-- Custom Theme Style -->
    
@endpush

@push('scripts')
      
    <!-- FastClick -->
    <script src="{{asset('js/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{asset('js/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{asset('js/icheck.js') }}"></script>
    <!-- Datatables -->
    <script src="{{asset('js/datatables/jquery.dataTables.min.js') }}"></script>
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

            $('#datatable').dataTable( {
              "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            } );
        } );
        
    </script>
@endpush

@section('main_container')



<div class="right_col" role="main">


    

        
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="page-header">
            <h3>Search DB</h3>
        </div>
            <div class="x_content">
                        
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      
                      <th>id</th>
                      <th>name</th>
                      <th>email</th>
                      <th>address</th>
                      <th>city</th>
                      <th>phone</th>
                      <th>zip</th>
                    </tr>
                  </thead>


                  <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                     
                      <td>{{ $customer->id }}</td>
                      <td>{{ $customer->name }}</td>
                      <td><a href="{{ url('edit-customer', ['customerId' => $customer->id]) }}">{{ $customer->email }}</a></td>
                      <td>{{ $customer->address }}</td>
                      <td>{{ $customer->city }}</td>
                      <td>{{ $customer->phone }}</td>
                      <td>{{ $customer->zip }}</td>
                    </tr>
                   @endforeach
                  </tbody>
                </table>
            </div>

    </div> 
    
    <div class="col-md-6">

                   <!-- load bootstrap -->
                
            <div class="page-header">
                <h3>Add New</h3>
            </div>

            @if(isset($cusExists))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="danger" aria-label="close">&times;</a>
                         {{ $cusExists }}
                         
                </div>
            @endif


            <!-- FORM STARTS HERE -->
            <form method="POST" action="{{url('/customer-data-add')}}" name=""  novalidate>
                      {{ csrf_field() }}


                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="..." value="" >
                    <input type="hidden" name="id" value="">
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" id="email" class="form-control" name="email" placeholder="..." value="">
                </div>
                <div class="form-group">
                    <label for="name">Address</label>
                    <input type="text" id="address" class="form-control" name="address" placeholder="..." value="">
                </div>
                <div class="form-group">
                                <label for="name">City</label>
                                <input type="text" id="city" class="form-control" name="city" placeholder="..." value="">
                </div>
                <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="text" id="phone" class="form-control" name="phone" placeholder="..." value="">
                </div>
                <div class="form-group">
                                <label for="name">Zip</label>
                                <input type="text" id="zip" class="form-control" name="zip" placeholder="..." value="">
                </div>

                <button type="submit" class="btn btn-success">Add</button>

            </form>

        </div>
</div>




@endsection