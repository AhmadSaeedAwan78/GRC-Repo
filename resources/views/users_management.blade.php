@extends('admin.client.client_app')

@section('content')


<!-- @if (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
@endif -->

<style>
    .row {
        margin-left:10px;
        margin-right:10px;
    }
</style>



<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<h3 class="tile-title" style="margin-left: 10px">Organization Users (Excluding Admins)
				<a href="{{url('add_user')}}" class="btn btn-sm btn-primary pull-right cust_color" style="float: right; margin-right: 10px "><i class="fa fa-plus" ></i> Add Organization User</a>
			</h3>
             @if(Session::has('success'))
                    <p class="alert alert-info">{{ Session::get('success') }}</p>
                @endif
			<div class="table-responsive">
				<table class="table" id="users">
					<thead class="back_blue">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Image</th>
							<th>User Type</th>
							<th>Added By</th>
							<th>Super User status</th>
                            <th>Permissions</th>                          

							<th width="130" class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($user as $row)
						<tr>							
							<td> {{$row->name}} </td>							
							<td>{{$row->email}}</td>
							@if($row->image_name=="")
							<td><img  src="{{url('dummy.jpg')}}" style=" height: 50px; width: 75px;" /> </td>
							@else
							<td><img src="<?php echo url("img/$row->image_name");?>" style="height: 50px; width: 75px;"> </td>
							@endif
							@if($row->user_type == 0)
							<td> User </td>
							@else($row->user_type == 1)
							<td> Super User </td>							
							@endif
							<td>{{ $row->added_by }}</td>
							
							<td>
								@if($row->user_type==1)
								<!-- <div class="badge badge-rounded bg-green">Active</div>  -->
								<a href="javascript:void(0)" data-id="{{$row->id}}" data-status="{{$row->user_type}}" id="change_status" class="btn btn-sm btn-success"> @lang('users.active')</a>
								@else
								<a href="javascript:void(0)" data-id="{{$row->id}}" data-status="{{$row->user_type}}" id="change_status" class="btn btn-sm btn-danger"> @lang('users.inactive')</a>
								<!-- <div class="badge badge-rounded bg-red">Inactive</div>  -->
								@endif
							</td>

                               <td class="text-center">
                                     
                                     <a href="{{ url('/Orgusers/permissions/'.$row->id)}}" class="btn btn-sm btn-dark"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Permissions</a>


                               </td>
							<td class="text-center">
								<div class="actions-btns dule-btns">
									<!-- <a href="javascript:void(0)" data-id="{{$row->id}}" data-status="{{$row->status}}" id="change_status" class="btn btn-sm btn-primary"> <i class="fa fa-eye"> </i></a>  -->
									<a href="{{url('edit_user/' . $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger removePartner"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#users').DataTable();

    	$( "body" ).on( "click", ".removePartner", function () {
    		var task_id = $( this ).attr( "data-id" );
    		var form_data = {
    			id: task_id
    		};
    		swal( {
    				title: "@lang('users.delete_user')",
    				text: "@lang('users.delete_user_msg')",
    				type: 'info',
    				showCancelButton: true,
    				confirmButtonColor: '#F79426',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Yes',
    				showLoaderOnConfirm: true
    			},
    			function () {
    				$.ajax( {
    					type: 'POST',
    					headers: {
    						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    					},
    					url: '<?php echo url("delete_user"); ?>',
    					data: form_data,
    					success: function ( msg ) {
    						swal( "@lang('users.success_delete')", '', 'success' )
    						setTimeout( function () {
    							location.reload();
    						}, 2000 );
    					}
    				} );
    			} );
    
    	} );
    	$( "body" ).on( "click", "#change_status", function () {
    		var id = parseInt( $( this ).attr( "data-id" ) );
    		var status = parseInt( $( this ).attr( "data-status" ) );
    		if ( status == 0 ) {
    			var s = 1
    		} else if ( status == 1 ) {
    			s = 0
    		}
    		var form_data = {
    			id: id,
    			status: s
    		};
    		swal( {
    				title: "@lang('users.change_status')",
    				text: "@lang('users.change_status_msg')",
    				type: 'info',
    				showCancelButton: true,
    				confirmButtonColor: '#F79426',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Yes',
    				showLoaderOnConfirm: true
    			},
    			function () {
    				$.ajax( {
    					type: 'POST',
    					headers: {
    						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    					},
    					url: '<?php echo url("users/change_status"); ?>',
    					data: form_data,
    					success: function ( msg ) {
    						swal( "@lang('users.success_change')", '', 'success' )
    						setTimeout( function () {
    							location.reload();
    						}, 2000 );
    					}
    				} );
    			} );
    
    
    	} );        
        
        
    });



</script>

<style>
	.sweet-alert h2 {
		font-size: 1.3rem !important;
	}
	
	.sweet-alert .sa-icon {
		margin: 30px auto 35px !important;
	}
</style>


@endsection