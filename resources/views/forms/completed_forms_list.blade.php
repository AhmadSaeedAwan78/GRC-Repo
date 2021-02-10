@extends ((isset($user_type) && $user_type == 'admin')?('admin.layouts.admin_app'):('admin.client.client_app'))

@section('content')
<style>
    .fs-12 {
        font-size:10px;
    }
    #forms-table_wrapper {
        white-space: nowrap;
        /*padding-top: 15px;*/ 
    }
    .back_blue th {
        
    font-size: 16px !important;
    }
</style>
<?php if (isset($user_type) && $user_type == 'admin'): ?>
<div class="app-title">
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{route('admin_forms_list')}}">Manage Assessment Forms</a>
		</li>
	</ul>
</div>
<?php endif; ?>
<div class="row" style="margin-left:10px;">
  <div class="col-md-12">
    <div class="tile">

      <div class="table-responsive cust-table-width">
                <h3 class="tile-title">Completed Forms
      </h3>
        <table class="table" id="forms-table">
          <thead class="back_blue">
    <tr>
	  <th scope="col">User Email</th>
	  <th scope="col">User Type</th>
	  <th scope="col">Form Link</th>
      <th scope="col">Subform Name</th>
      <th scope="col">Form Name</th>
      <th scope="col" class="fs-12">Total Organization Users of this subform</th>
      <th scope="col" class="fs-12">Completed Forms (By Organization Users)</th>
      <th scope="col" class="fs-12">Total External Users of this subform</th>
      <th scope="col" class="fs-12">Completed Forms (By External Users)</th>
      <th scope="col">Completed</th>
      <th scope="col">Completed On</th>
    </tr>

  </thead>

  <tbody>

  	<?php foreach ($completed_forms as $form_info): ?>
    <tr>
        <td><?php echo $form_info->email; ?></td>
        <td><?php echo $form_info->user_type; ?></td>
        <td>
            <?php
                $form_link = ''; 
                if ($form_info->user_type == 'Internal')
                    $form_link = url('Forms/CompanyUserForm/'.$form_info->form_link);
                if ($form_info->user_type == 'External')
                    $form_link = url('Forms/ExtUserForm/'.$form_info->form_link);
                    
            ?>
            <a href="<?php echo $form_link; ?>" target="_blank">Open</a>
        </td>
        <td><?php echo $form_info->subform_title; ?></td>
        <td><?php echo $form_info->form_title; ?></td>
        <td>
            <?php 
                if (isset($form_info->total_internal_users_count))
                {
                    echo $form_info->total_internal_users_count;
                }
                else
                    echo '-';            
            ?>
        </td>
        <td>
            <?php
                if (isset($form_info->in_completed_forms))
                {
                    echo $form_info->in_completed_forms;
                }
                else
                    echo '-';            
            ?>            
        </td>
        <td>
            <?php
                if (isset($form_info->total_external_users_count))
                {
                    echo $form_info->total_external_users_count;
                }
                else
                    echo '-';            
            ?>
        </td>
        <td>
            <?php
                if (isset($form_info->ex_completed_forms))
                {
                    echo $form_info->ex_completed_forms;
                }
                else
                    echo '-';            
            ?>  
        </td>
        <td>
            <?php
                echo $form_info->is_locked;
            ?>
        </td>
        <td>
            <?php
                echo date('Y-m-d', strtotime($form_info->updated));
            ?>
        </td>        
    </tr>
	<?php endforeach; ?>

  </tbody>

</table>

</div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
        var check_col_index = 9;
        var table = $('#forms-table').DataTable({
            "order": [[ 10, "desc" ]],
            "rowCallback": function(row, data) {
                if (data[check_col_index] == "0") {
                    $(row).hide();
                }
            }
        });
        
        table.column(check_col_index).visible(false);
    })
</script>

@endsection