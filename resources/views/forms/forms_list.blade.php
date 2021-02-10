@extends (($user_type == 'admin')?('admin.layouts.admin_app'):('admin.client.client_app'))

@section('content')
<?php if ($user_type == 'admin'): ?>
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

       <!-- ahmad -->
       <!-- <a href="{{ route('all_generated_forms') }}"> <i class="fas fa-plus-circle"></i> genmerated forms</a> -->
       <!-- end -->

      <div class="table-responsive cust-table-width">
                <h3 class="tile-title">Assessment Forms
      </h3>
        <table class="table" id="forms-table">
          <thead class="back_blue">
    <tr>

      <th scope="col">Form Name</th>

	<?php if (Auth::user()->role == 1): ?>
	  <th scope="col">Assign to Organization(s)</th>
	<?php endif; ?>

      <th scope="col">Show Form</th>
    <?php if (Auth::user()->role != 1): ?>
      <th scope="col">Sub Forms List</th>
	<?php endif; ?>
    <?php if (Auth::user()->role == 2 || Auth::user()->user_type == 1): ?>
      <th scope="col">Number of Subforms</th>
	<?php endif; ?>	
    <?php if (Auth::user()->role == 1): ?>
      <th scope="col">Actions</th>
	<?php endif; ?>	
    </tr>

  </thead>

  <tbody>

  	<?php foreach ($forms_list as $form_info): ?>

    <tr>

      <td>{{ $form_info->title }}</td>
	<?php if (Auth::user()->role == 1): ?>
	  <td><a href="{{ url('Forms/FormAssignees/'.$form_info->form_id) }}"> <i class="fas fa-tasks"></i> Form Assignees</a></td></td>  	  
	<?php endif; ?>

      <td><a href={{ url('Forms/ViewForm/'.$form_info->form_id) }}> <i class="far fa-eye"></i> View Form</a></td></td>	  

    <?php if (Auth::user()->role != 1): ?>
      <td><a href="{{ route('subforms_list', ['id' => $form_info->form_id]) }}"> <i class="fas fa-plus-circle"></i> Add / <i class="fas fa-list"></i> Show Sub Forms</a></td>
	<?php endif; ?>
    <?php if (Auth::user()->role == 2 || Auth::user()->user_type == 1): ?>
      <td>{{ $form_info->subforms_count }}</td>
	<?php endif; ?>
    <?php if (Auth::user()->role == 1): ?>
      <td><a href="{{ url('edit_form/'.$form_info->form_id) }}"> <i class="fas fa-pencil-alt"></i> Edit Name</a></td>
	<?php endif; ?>

      
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
        $('#forms-table').DataTable({
                "order": [[ 0, "desc" ]]
        });
    })
</script>

@endsection