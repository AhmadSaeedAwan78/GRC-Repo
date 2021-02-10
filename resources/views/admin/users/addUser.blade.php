@extends( 'admin.layouts.admin_app' )
@section( 'content' )

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

#size{
    margin-left: 58px;
    width: 168px;
    padding: 3px;
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
.max-spec {
    font-size:14px;
}
</style>

<div class="app-title">
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{url('/admin')}}">Organization Admins </a>
		</li>
		<li class="breadcrumb-item"><a href="{{url('/users/add')}}">Add Organization Administrator</a>
		</li>		
	</ul>
</div>

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

<!-- Breadcrumb-->
<!--<div class="breadcrumb-holder container-fluid">-->
<!--	<ul class="breadcrumb">-->
<!--		<li class="breadcrumb-item">-->
<!--			<a href="{{url('dashboard')}}">Home</a>-->
<!--		</li>-->
<!--		<li class="breadcrumb-item active">Add Organization Administrator</li>-->
<!--	</ul>-->
<!--</div>-->
<!-- Forms Section-->
<section class="forms">
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12">

				<div class="card">
				    

					<div class="card-header d-flex align-items-center">
						<h3 class="h4">Add Organization Administrator</h3>
					</div>
					<div class="card-body" id="org-form">
						<div class="card-body-form">
						<form class="form-horizontal" method="POST" action="{{ url('users/store') }}" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Name</label>
								<div class="col-sm-8">
									<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> 
								</div>
							</div>
							<div class="line"></div>

							<!--<div class="form-group row">-->
							<!--	<label class="col-sm-4 form-control-label">Company Name</label>-->
							<!--	<div class="col-sm-8">-->
							<!--		<input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required autofocus> -->
							<!--	</div>-->
							<!--</div>-->
							<!--<div class="line"></div>-->

							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Email</label>
								<div class="col-sm-8">
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
								</div>
							</div>
							<div class="line"></div>
							
							
							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Password</label>
								<div class="col-sm-8">
									<input id="password" type="password" class="form-control" name="password" required>
								</div>
							</div>
							<div class="line"></div>

							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Repeat Password</label>
								<div class="col-sm-8">
									<input id="rpassword" type="password" class="form-control" name="rpassword" required>
								</div>
							</div>
							<div class="line"></div>

							<div class="form-group row">
							<label class="col-sm-4 form-control-label">2FA</label>
								<label class="switch">
									  <input name="slider" type="checkbox">
									  <span class="slider round"></span>
								</label>
							</div>


							





							<div class="line"></div>
                            @if ($fixed_company)
							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Organization</label>
								<div class="col-sm-8">
								    <input type="hidden" name="team" id="team" class="form-control" value="{{ $client->id }}"></input>
								    <input type="text"  class="form-control" value="{{$client->company }}" disabled></input>
								</div>
                            </div>                            
                            @else
							<div class="form-group row">
								<label class="col-sm-4 form-control-label">Select Organization</label>
								<div class="col-sm-8">
									<select name="team" id="team" class="form-control" style="width: 50%">

							@foreach($client as $data)
							@if($data->company =="")
							@else
							<option value="{{ $data->id }}">{{$data->company }}</option>
							@endif
                                       
							 @endforeach
							</select>
								</div>
							</div>
							@endif
							<div class="line"></div>	
						
						</div>					
							

							
							<div class="OrganizationUser">
								<div class="form-group row">
									<label class="col-sm-6 form-control-label">Profile image</label>
									<div class="img_dlt">
										
											<label style="display: none;">
											<input id="images" type="file"  name="images">
										</label><br>
										<div class="dummi-img">
										<img id="blah" src="<?php echo url("dummy.jpg");?>" style=" width: 100%; height: 100%;" />
										</div>
							<a style="margin-top: 20px; margin-left: 52px;" class="btn btn-primary" id="add_images" href="#">Browse image</a><br>
									<div id="size" class="max-spec">Max Resolution 800 x 600</div>
									<div id="size" class="max-spec">Max Size 1 MB</div>
									</div>
								</div>
								<div class="form-group row form-btn" style="margin-left: 52px;">
										<div class="col-sm-12 text-left">
											<a href="{{url('admin')}}" class="btn btn-sm btn-secondary">@lang('general.cancel')</a>
											<button type="submit" class="btn btn-sm btn-primary">@lang('general.save') </button>
										</div>
									</div>	
							</div>
							
							</form>

							

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


  $(document).ready(function() {
    const company = '{{ old('team') }}';
    
    if(company !== '') {
      $('#team').val(company);
    }
  });



</script>

@endsection