@extends (($user_type == 'admin')?('admin.layouts.admin_app'):('admin.client.client_app'))

@section('content')
<?php if ($user_type == 'admin'): ?>
<div class="app-title">
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{route('asset_list')}}">Assets</a>
		</li>
	</ul>
</div>
<?php endif; ?>
<div class="row" style="margin-left:10px;">
  <div class="col-md-12">
    <div class="tile">
        <div class="table-responsive cust-table-width">
            <h3 class="tile-title">Activities List</h3>
               
           

            <table class="table" id="activity-table" >
                <thead class="back_blue">
                    <tr>
                          <th> Activity Response</th>
                           <th> User Email <strong>/</strong> Name </th>
                           <th> Form Completion Date </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($filled_questions as $fq)
                    <tr>
                           <th>{{$fq->question_response}}</th>
                           <th> {{$fq->user_email}}</th>  
                           <th> {{date('d', strtotime($fq->created))}} {{date(' F', strtotime($fq->created))}} {{date('Y  H:i', strtotime($fq->created))}} </th>
                       
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>

    



       </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(() => {
        $('#activity-table').DataTable({dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
        ]});
    })
</script>

@endsection