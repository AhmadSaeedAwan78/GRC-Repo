@extends('admin.client.client_app')

@section('content')


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

#size{
    font-size: 18px;
    width: 174px;
    /*padding: 3px;*/
        padding: 5px 4px;
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
/*#size {*/
/*    padding: 10px 0;*/
/*}*/

#add_images {
    margin-top: 5px;
}

</style>



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



	

<div class="left-side-bar">

	

		<form class="form-horizontal" method="POST" action="{{ url('store_edit/'. $user->id) }}" enctype="multipart/form-data" style="padding: 0 30px;">

			{{ csrf_field() }}

			<div class="tile">

				<h3 class="tile-title">edit</h3>

					<div class="row">
                                <div class="col-md-8 right-side">


							<div class="form-group row">

								<label class="col-sm-3 col-form-label form-control-label">Name</label>
                                <div class="col-md-8">
								<input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                                        </div>
							</div>

				

		

							<div class="form-group row">

								<label class="col-sm-3 col-form-label form-control-label">Email</label>
                                <div class="col-md-8">
								<input id="email" type="email" class="form-control is-valid" name="email" value="{{ $user->email }}" readonly>
                                </div>
							</div>


					

							<div class="form-group row">

								<label class="col-sm-3 col-form-label form-control-label">Company Name</label>
                                <div class="col-md-8">
								<input id="phone" type="text" class="form-control is-valid" name="phone" value="{{ $company_name->company }}" readonly>
                                </div>
							</div>

					




							<div class="form-group row">

								<label class="col-sm-3 col-form-labe form-control-label">Password</label>
                                <div class="col-md-8">
								<input id="password" type="password" class="form-control" name="password">
                                        </div>
							</div>

						

						


							<div class="form-group row">

								<label class="col-sm-3 col-form-labe form-control-label">Repeat Password</label>
                                 <div class="col-md-8">
								<input id="rpassword" type="password" class="form-control" name="rpassword">

								<span id='message'></span>
                                    </div>
							</div>



							<div class="form-group row">
								<label class="col-sm-3 col-form-labe form-control-label">2FA</label><br>
								 <div class="col-md-8">
							<label class="switch">
								@if($user->tfa==1)
							  <input name="slider" type="checkbox" checked>
							  @else
							  <input name="slider" type="checkbox">
							  @endif
							  <span class="slider round"></span>
							</label>
							<span id='message'></span>
							<div class="tile-footer">

						<a href="{{url('users_management')}}" class="btn btn-default" style="color: #4e73df; border: solid 1px;">@lang('general.cancel')</a>

						<button type="submit" class="btn btn-primary">@lang('general.save')</button>

					</div>
							</div>
							</div>


						

		</div>


                        

					

				</form>

		
                            <div class="profile_info">
						<div class="row col-sm-4">

							<div class="form-group">	

								<label class="form-control-label" style="display: flex;justify-content: center;" >Profile image</label>

								<div class="img_dlt text-center">
                                    <img id="blah" class="img-fluid" src="<?php echo url("img/$user->image_name");?>" name="profile_image" style="padding: 5px;height: 150px;width: 186px;border-radius: 20px;">
									<br>
								
									<div id="size" style="font-size:14px;">Max Resolution 800 x 600</div>
									<div id="size" style="font-size:14px;">Max Size 1 MB</div>
                                    	<a class="btn btn-primary" id="add_images" href="#">Browse image</a>
										<label style="display: none;">

										<input id="images" type="file"  name="images">

										<input name="profile_image" value="{{ $user->image_name }}">

									</label>

								@if($user->image_name=="")
								<img id="blah" src="{{url('dummy.jpg')}}" style=" width: 220px; height: 220px; padding: 9px;" />
								@else
								
								@endif
								</div>

							</div>
                            <input id="file" type="hidden" class="form-control" name="id" value="{{$user->id}}">

					
						</div>

                        </div>
		</form>
	</div>
	</div>

</div>





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







// $( "#rpassword" )

//   .focusout(function() {

//   	var pasword,rpasword;

//  pasword = $("#password").val();

//  rpasword = $("#rpassword").val();

//    if(pasword!=rpasword){

//    	alert('password did not match')

//    }

//   })



$('#password, #rpassword').on('keyup', function () {

  if ($('#password').val() == $('#rpassword').val()) {

    $('#message').html('<h5>Password is Matched</h5>').css('color', 'green');

  } else 

    $('#message').html('<h5>Password is Not Matching</h5>').css('color', 'red');

});



</script>


@endsection
