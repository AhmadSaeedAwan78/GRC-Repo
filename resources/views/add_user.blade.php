@extends('admin.client.client_app')

@section('content')

@if (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

#size{
    font-size: 17px;
    width: 174px;
    padding-top: 9px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>


<!-- Breadcrumb-->

<!-- Forms Section-->
<section class="forms">
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12">

				<div class="card">

					<div class="card-header d-flex align-items-center">
						<h3 class="h4">Add Organization New User</h3>
					</div>
					<div class="card-body">
						<form class="form-horizontal" method="POST" action="{{ url('store_user') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Name</label>
								<div class="col-sm-10">
									<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> 
								</div>
							</div>
							<div class="line"></div>

							<div class="line"></div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Email</label>
								<div class="col-sm-10">
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
								</div>
							</div>
							<div class="line"></div>
							
							
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Password</label>
								<div class="col-sm-10">
									<input id="password" type="password" class="form-control" name="password" required>
								</div>
							</div>
							<div class="line"></div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Repeat Password</label>
								<div class="col-sm-10">
									<input id="rpassword" type="password" class="form-control" name="rpassword" required>
								</div>
							</div>
							<div class="line"></div>
                            
                           
							<div class="form-group row">
							<label class="col-sm-2 form-control-label">2FA</label>
								<label class="switch">
								    @if(old('slider') == "on")
									  <input name="slider" type="checkbox" checked>
									  @else
									  <input name="slider" type="checkbox" >
									 @endif
									  <span class="slider round"></span>
								</label>
							</div>
							<div class="line"></div>							

							

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Profile image</label>
								<div class="img_dlt">
									<a class="btn btn-primary" id="add_images" href="#">Browse image</a>
									<div id="size" style="font-size:14px;">Max Resolution 800 x 600</div>
									<div id="size" style="font-size:14px;">Max Size 1 MB</div>
										<label style="display: none;">
										<input id="images" type="file"  name="images">
									</label><br>
									<img id="blah" src="<?php echo url("dummy.jpg");?>" style=" width: 325px; height: 270px; padding: 9px;" />
								</div>		
							</div>
							

							<div class="form-group row">
								<div class="col-sm-12 text-right">
									<a href="{{url('users')}}" class="btn btn-sm btn-secondary">@lang('general.cancel')</a>
									<button type="submit" class="btn btn-sm btn-primary">@lang('general.save') </button>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	
	$('#add_images').click(function(){
	$('#images').click();
	});

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#images").change(function() {
  readURL(this);
});


</script>




@endsection