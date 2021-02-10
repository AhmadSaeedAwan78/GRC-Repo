@extends (($user_type == 'admin')?('admin.layouts.admin_app'):('admin.client.client_app'))

@section('content')

<?php if ($user_type == 'admin'): ?>
<div class="app-title">

  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
    </li>
    <li class="breadcrumb-item"><a href="{{route('admin_forms_list')}}">Manage Assessment Forms </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('Forms/FormAssignees/'.$form_id) }}">Form Assignees </a>
    </li>   
  </ul>
</div>
<?php endif; ?>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Form Assignees
      </h3>
      <div class="table-responsive">
	  	  <button class="btn btn-primary"  onclick="getall_checkbox()" id="assign">Assign / Unassign</button>
        <table class="table" id="assignees-table">
          <thead class="back_blue">
    <tr>
<!--<th><input type="checkbox" id="checkAll"/></th>-->
      <!--<th scope="col">Select</th>-->
      <th>Select</th>

      <th>Organization</th>

    </tr>

  </thead>

  <tbody>
	
  	<?php foreach ($client_list as $client): ?>

    <tr>
	  <!--<td></td>-->
	   <td><input type="checkbox" class="cbox" name="row{{$client->id}}" value="{{$client->id}}" <?php if (in_array($client->id, $assigned_client_ids)) echo 'checked'; ?> ></td>
		<!--<input type="checkbox" value="{{ $client->id}}" class="assign-clients" id="client-{{ $client->id}}" <?php // if (in_array($client->id, $assigned_client_ids)) echo 'checked'; ?> >-->
	  <!--</td>-->
      <td>{{ $client->company }}</td>

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
	    
	   $('#assignees-table').DataTable({
	       "pageLength": 10
	   });
		
// 		var ids              = [];
		
// 		<?php //foreach ($assigned_client_ids as $client_id): ?>
// 					if (ids.indexOf(<?php // echo $client_id; ?>) == -1) {
// 						ids.push(Number(<?php //echo $client_id; ?>));
// 					}		
// 		<?php //endforeach; ?>
		
// 		console.log(ids);
		
// 		$('.assign-clients').change(function(){
// 			var id = Number($(this).val());
// 			if ($(this).prop('checked')){
// 				if (ids.indexOf(id) == -1) {
// 					ids.push(id);
// 				}
// 				else {}
// 			}
// 			else {
// 				var ind = ids.indexOf(id);
// 				if (ind > -1) {
// 					ids.splice(ind, 1);
// 				}	
// 			}
// 			console.log(ids);
// 		});
			
		
// 		$('#assign').click(function(){
			
// 			var post_data        = {};
// 			post_data['ids']     = ids;
// 			post_data['_token']  = '{{csrf_token()}}';
// 			post_data['form_id'] = {{$form_id}};
			
// 			$.ajax({
// 				url:'{{route('assign_form_to_client')}}',
// 				method:'POST',
// 				/*
// 				headers: {
// 					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
// 				},
// 				*/
// 				data: post_data,
// 				success: function(response) {
// 					//console.log(response);
// 					swal('Information Updated', 'Forms assigned/un-assigned to company', 'success');
// 				}
// 			});
// 		});

		
	});
	
	 function getall_checkbox(){
        checkbox = [];
        $("input:checkbox[class=cbox]:checked").each(function () {
            checkbox.push(Number($(this).val()));
        });
        
        	
		<?php foreach ($assigned_client_ids as $client_id): ?>
			if (checkbox.indexOf(<?php  echo $client_id; ?>) == -1) {
				checkbox.push(Number(<?php echo $client_id; ?>));
			}		
		<?php endforeach; ?>
		
		
        console.log(checkbox);  
        
        var post_data        = {};
		post_data['ids']     = checkbox;
		post_data['_token']  = '{{csrf_token()}}';
		post_data['form_id'] = {{$form_id}};
		
		$.ajax({
			url:'{{route('assign_form_to_client')}}',
			method:'POST',
			/*
			headers: {
				'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			},
			*/
			data: post_data,
			success: function(response) {
				//console.log(response);
				swal('Information Updated', 'Forms assigned/un-assigned to company', 'success');
			}
		});
    }
</script>

@endsection