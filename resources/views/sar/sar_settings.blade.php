@extends((isset($user_type) && $user_type=='admin')?('admin.layouts.admin_app'):('admin.client.client_app'))

@section('content')

<style>
  #sub-form-area {
      width:100%;
  }
  .sub-form {
    margin-top:20px;
  }
  .row.sub-form{
    margin-left: 0;
  }
  #sub-form-area .sub-form{
    display: flex;
    flex-direction: row;
        align-items: baseline;
  }
  #sub-form-area .sub-form input,#sub-form-area .sub-form select{
    max-width: 80%;
    min-width:30%;
    margin-right: 2%;
  }
  #sub-form-area .sub-form button{
    width: 15%;
  }
  .form-control:focus{
    outline: 0;
    box-shadow: none;
  }
  .btn-primary.focus, .btn-primary:focus,.btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus{
    box-shadow: none;
    outline: 0;
  }
  @media screen and (max-width: 998px){
    #sub-form-area {
      width:100%;
    }
    #sub-form-area .sub-form button{
    width: auto;
    }
  }
  #act-msg {
	display:none; 
  }
  .fs-14 {
      font-size:14px;
  }
  .fs-12 {
      font-size:12px;
  }
  .zdd {
     width: 100% !important; 
  }
</style>
<div class="modal" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Subform</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <label for="usr">Name :</label>
            <input type="text" name="sb-name" id="sb-name" sb-id="" class="form-control zdd">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <div style="text-align:center;">
          <button id="edit-form" type="button" class="btn btn-primary">Edit</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
<h3 class="tile-title" style="margin-left: 25px;">SAR Settings </h3>
<div class="" style="margin-left:30px; ">

    <?php
        $days   = $sar_settings->duration;
        $period = $sar_settings->period;
    ?>

    <div id="sar-settings">
        <div class="col col-md-6">
            <div class="form-group">
              <label for="duration">Duration</label>
              <input type="number" class="form-control" value="{{$days}}" id="duration">
            </div>
            <div class="form-group">
                <label for="duration">Period</label>
                <select name="period"  class="form-control" id="period">
                    <option value="days"  <?php echo ($sar_settings->period == 'days')?('selected'):(''); ?>>Days</option>
                    <option value="months"<?php echo ($sar_settings->period == 'months')?('selected'):(''); ?>>Months</option>
                </select>
            </div>
            <button class="btn btn-primary" id="update-settings">Update Settings</button>
        </div>
    </div>


</div>
<script>

$(document).ready(function() {
    var settings_info = {};

    settings_info['_token'] = '{{csrf_token()}}';

    $('#update-settings').click(function (){
        console.log('sler');

        settings_info['duration']         = $('#duration').val();
        settings_info['period']           = $('#period').val();
        settings_info['client_id']        = {{Auth::user()->client_id}};
		
        $.ajax({
          url: '{{url('FormSettings/SARExpirySettings')}}',
          method: 'POST',
          data: settings_info,
          success: function (response) {
            if (response.status == 'success') {
              swal('Updated','SAR Form expiration settings updated. These settings will be applied from the next request', 'success');
            }
            else {
              swal('Something went wrong','The settings could not be updated due to some error', 'failure');                
            }
          }
        });
    });
});
</script>
@endsection
