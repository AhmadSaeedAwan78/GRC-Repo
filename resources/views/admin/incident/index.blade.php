@extends(($user_type=='1')?('admin.layouts.admin_app'):('admin.client.client_app'))
@section( 'content' )
@if($user_type !='1')
<style>
    .tile{
        margin-left: 15px;
    }
</style>
@endif
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
@if($user_type=='1')
<div class="app-title">

	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{url('/incident')}}">Incident Register </a>
		</li>
	</ul>
</div>
@endif

<div class="session" style="margin-bottom: 20px">
@if(Session::has('error'))
      <div class="alert alert-danger">
      <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ Session::get('error') }}
    </div>
    @endif
    @if(Session::has('success'))
      <div class="alert alert-success">
      <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ Session::get('success') }}
  </div>
    @endif
     @if(Session::has('alert'))
      <div class="alert alert-danger">
      <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ Session::get('alert') }}
    </div>
    @endif 
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<h3 class="tile-title">Incident Register
                @if($user_type=='1') 			
				<!-- <a href="{{url('add_inccident')}}" class="btn btn-sm btn-success pull-right cust_color pull-right" style="margin-right: 10px;"><i class="fa fa-plus" ></i> Add Incident</a> -->
                @else
                <a href="{{url('add_inccident')}}" class="btn btn-sm btn-success pull-right cust_color pull-right" style="float: right; background: #4E73DF;"><i class="fa fa-plus" ></i> Add Incident</a>
                @endif
			</h3>
			<div class="table-responsive">
				<table class="table" id="orgs">
					<thead class="back_blue">
						<tr>
							<th>Incident Name</th>
                            <th>Type</th>
						    <th>Organization</th>
						    <th>Assignee</th>
                            <th>Root Cause</th>
                            <th>Date Discovered</th>
                            <th>Deadline Date</th>
                            <th>Status</th>
                            <th>Severity</th>
                            <th>Date</th>
							<th width="130" class="text-center">Actions</th>
						</tr>
					</thead>
                    @if($user_type=='1')
					<tbody>
						@foreach($incident_register as $row)
						<tr>
                            <td>{{$row->name}}</td>
						    <td><?php $incident  = DB::table('incident_type')->where('id',$row->incident_type)->first();?> {{ $incident->name}}</td>
						    <td><?php $org  = DB::table('users')->where('id',$row->organization_id)->first();?> {{ $org->company}}</td>
                            <td>{{$row->assignee}}</td>
                            <!-- <td>{{$row->root_cause}}</td> -->
                            <td><>
                            <td><a href="" class="btn btn-primary btn-sm nowrap_btn"  data-toggle="modal" data-val="{{$row->root_cause}}"  data-target='#practice_modal' ><i class="fa fa-eye mr-2"></i>See Detail</a></td>
                                <!-- {{$row->date_discovered}} -->

                            {{date('d', strtotime($row->date_discovered))}} {{date(' F', strtotime($row->date_discovered))}} {{date('Y  ', strtotime($row->date_discovered))}}
                            </td>
                            <td>
                                 {{date('d', strtotime($row->deadline_date))}} {{date(' F', strtotime($row->deadline_date))}} {{date('Y  ', strtotime($row->deadline_date))}}
                            </td>
                            <td>{{$row->incident_status}}</td>
                            <td>{{$row->incident_severity}}</td>
                            <td>
                                <!-- {{$row->created_at}} -->
                                 {{date('d', strtotime($row->created_at))}} {{date(' F', strtotime($row->created_at))}} {{date('Y  h:i ', strtotime($row->created_at))}}
                            </td>
							<td class="text-center">
								<div class="actions-btns dule-btns">
									<a href="{{url('edit_incident/' . $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger removePartner"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
                    @else
                    <tbody>

                        @foreach($incident_front as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td><?php $incident  = DB::table('incident_type')->where('id',$row->incident_type)->first();?> {{ $incident->name}}</td>
                            <td><?php $org  = DB::table('users')->where('id',$row->organization_id)->first();?> {{ $org->company}}</td>
                            <td>{{$row->assignee}}</td>
                            <!-- <td>{{$row->root_cause}}</td> -->
                            <td><a href="" class="btn btn-primary btn-sm nowrap_btn"  data-toggle="modal" data-val="{{$row->root_cause}}"  data-target='#practice_modal' ><i class="fa fa-eye mr-2"></i>See Detail</a></td>
                            <td>
                                <!-- {{$row->date_discovered}} -->

                            {{date('d', strtotime($row->date_discovered))}} {{date(' F', strtotime($row->date_discovered))}} {{date('Y  ', strtotime($row->date_discovered))}}
                            </td>
                            <td>
                                 {{date('d', strtotime($row->deadline_date))}} {{date(' F', strtotime($row->deadline_date))}} {{date('Y  ', strtotime($row->deadline_date))}}
                            </td>
                            <td>{{$row->incident_status}}</td>
                             <td>{{$row->incident_severity}}</td>
                            <td>{{date('d', strtotime($row->created_at))}} {{date(' F', strtotime($row->created_at))}} {{date('Y  h:i ', strtotime($row->created_at))}}</td>
                            <td class="text-center">
                                <div class="actions-btns dule-btns">
                                    <a href="{{url('edit_incident/' . $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger removePartner"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
				</table>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="practice_modal" tabindex="-1" role="dialog" aria-labelledby="my-modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Root Cause</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    $('#practice_modal').on('show.bs.modal', function (event) {
  var myVal = $(event.relatedTarget).data('val');
  $(this).find(".modal-body").html(myVal);
});
</script>


<script type="text/javascript">



    $(document).ready(function(){
        
        

        $(document).ready(function() {

            $('#orgs').DataTable( {

                "order": [[ 10, "desc" ]]

            } );

        } );
        
    	$( "body" ).on( "click", ".removePartner", function () {
    		var task_id = $( this ).attr( "data-id" );
    		var form_data = {
    			id: task_id
    		};
    		swal( {
    				title: "Delete Incident",
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
    					url: '<?php echo url("incident/delete"); ?>',
    					data: form_data,
    					success: function ( msg ) {
    						swal( "@lang('Incidet.successfully delete')", '', 'success' )
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