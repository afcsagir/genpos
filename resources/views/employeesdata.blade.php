@extends('layouts.blank')

@section('main_container')

<div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
                <h3>Sales Register</h3>
              </div>
            </div>


            <div>
            	<form method="post" enctype="multipart/form-data" action="{{ url('/up-employees-post') }}">
            		<input type="file" name="file">
            		<input type="submit" name="submit">
            		<input type="hidden" value="{{ Session::token() }}" name="_token" />
            	</form>
            </div>

            <div>
            	@foreach ($fileDatas as $count => $fileData)
            		{{ $count + 1 }}, {{ $fileData[0] }}, {{ $fileData[1] }}, {{ $fileData[2] }}, {{ $fileData[3] }}, {{ $fileData[4] }}, {{ $fileData[5] }}, {{ $fileData[6] }}, {{ $fileData[7] }}, {{ $fileData[8] }}, {{ $fileData[9] }}, {{ $fileData[10] }}, {{ $fileData[11] }} <br>

            		

            	@endforeach
            </div>

            

</div>

@endsection