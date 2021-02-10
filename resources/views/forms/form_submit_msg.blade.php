@extends($template)

@section('content')


</style>	
<body>
	<div class="container-fluid">
		<div class="alert alert-success" id="submit-msg" style="margin-top:20px;margin-bottom:10px">	 
			<h4>Success!</h4>
					Your response was successfully recorded.
					@if ($user_type == 'in') 
					    @if ($user_role == 2 || $is_super == 1)
						Click <a href="{{url('Forms/FormsList')}}">here</a> to go back to Forms List
					    @else
						Click <a href="{{url('Forms/ClientUserFormsList')}}">here</a> to go back to Forms List
						@endif
					@endif
		</div>
	</div>
@endsection