@extends('admin.client.client_app')

@section('content')

        <!-- Begin Page Content -->
<!--  -->
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
    #size{
    margin-left: 8px;
    font-size: 18px;
    width: 174px;
    padding: 3px;
}
.img_dlt{
        display: flex;
    flex-direction: column;
    align-items: flex-end;
       align-items: center;
    text-align: center;
}
.h1_sample{
        position: fixed;
            top: 20%;
}
@media screen and (max-width: 576px){
   .h1_sample{
        position: initial;
} 
}
#add_images {
    margin-top: 11px;
}
</style>


      <div class="container">
        <section class="user_profile">
             <div class="col-6 p-0">
          <h1>Profile</h1>
           </div>
          <div class="left-side-bar">
            
            <form method="post" action="{{url('profile/edit')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="row">
            <div class="col-md-8 right-side">
            <form>
                
            <input type="hidden" name="id" value="{{$client->id}}">
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{$client->name}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="{{$client->email}}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Company Name</label>
                  <div class="col-sm-8">
                        <input type="text" class="form-control" id="company" name="company" value="{{$company_name->company}}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Password</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" id="password" >
                  </div>
                </div>
                 <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Repeat Password</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" name="rpassword" id="rpassword" >
                    <a href="{{url('dashboard')}}" class="btn btn-default" style="color: #4e73df; border: solid 1px;">@lang('general.cancel')</a>
                    <button class="btn btn-primary" type="submit" style="margin: 20px 0;">Update</button>
                    <span id='message'></span>
                  </div>
                </div>
                
              </form>
              </div>
              <div class="profile_info">
             
          

      <div class="row col-sm-4">

        <div class="form-group">  
          
            <div class="img_dlt">
                 <label class="form-control-label">Profile image</label>              
              <label style="display: none;">
              <input id="images" type="file"  name="images">
              <input name="profile_image" value="{{ $client->image_name }}">
          </label>
          @if($client->image_name=="")
          <img id="blah" class="img-fluid" src="<?php echo url("dummy.jpg");?>" name="profile_image" style="padding: 5px; height: 150px; width: 186px; border-radius: 20px;">
          @else
            <img id="blah" class="img-fluid" src="<?php echo url("img/$client->image_name");?>" name="profile_image" style="padding: 5px; height: 150px; width: 186px; border-radius: 20px;"><br>
            @endif
            <div id="size" style="font-size:14px;">Max Resolution 800 x 600</div>
            <div id="size" style="font-size:14px;">Max Image Size 1 MB</div>
            <a class="btn btn-primary" id="add_images" href="#">Browse Image</a>
 
            	
            </div>
        </div>
      </div>
      </div>
            </div>
            </div>
          </section>
        </div>

      <!-- End of Main Content -->

      

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


$('#password, #rpassword').on('keyup', function () {
  if ($('#password').val() == $('#rpassword').val()) {
    $('#message').html('<h5>Password is Matched</h5>').css('color', 'green');
  } else 
    $('#message').html('<h5>Password is Not Matching</h5>').css('color', 'red');
});

  </script>
  <!-- Page level plugins -->
  <!-- <script src="{{url('frontend/js/Chart.min.js')}}"></script> -->

  <!-- Page level custom scripts -->
  <!-- <script src="{{url('frontend/js/chart-area-demo.js')}}"></script> -->
  <!-- <script src="{{url('frontend/js/chart-pie-demo.js')}}"></script> -->

@endsection
