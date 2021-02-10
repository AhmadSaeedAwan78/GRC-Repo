@extends ((($user_type == 'admin')?('admin.layouts.admin_app'):('admin.client.client_app')), ['load_admin_css' => true])

@section('content')
  	<link rel="stylesheet" type="text/css" href="{{ url('public/custom_form/css/style.css') }}">
<style>
.section-heading-edit {
    display:none;
}
.change-heading-btn {
	display:none;
}
/***************************/
.main-panel{
	background-color: #fff;
	-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
    -webkit-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.margin{
	background-color: #fff;
	padding: 20px;
	margin: 0 !important; 
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
}
.head{
	background-color:#4267b2;
}
input[type="text"] {
	color:#4267b2;
}
.head h3,.fork i,.btn:hover{
	color:#FCFCFC;
}
.head ul{
	background-color:#f26924;
}
#easySelectable li.es-selected, #easySelectable li:hover {
    background: #f26924 !important;
	color:#fff;
}
textarea{
	border-radius:6px;
}
.change-heading-btn{
	background-color:#f26924;
	color:#fff;
}
li.es-selectable {
    font-size:12px;
}
h6.question-comment {
    font-size:16px;
}
.form-note {
    color: #fff;
    background: #c52c14;
    
}
.main-panel {
    padding-bottom:25px;
}
.container-fluid h3 {
    float: left;
}
.container-fluid a {
        display: flex;
    justify-content: flex-end;
}

</style>
<body style="background-color: #E5E5E5;">
<?php if ($user_type == 'admin'): ?>
<div class="app-title">
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{route('admin_forms_list')}}">Manage Assessment Forms</a>
		</li>
		<li class="breadcrumb-item"><a href="{{ url('Forms/ViewForm/'.$form_id) }}">View Forms</a>
		</li>
	</ul>
</div>
<?php endif; ?>    
    
	<div class="container-fluid">
	    <h3 class="tile-title">Assessment Form</h3>
	    <?php 
	        $btn_url = '/Forms/FormsList';
	        if (Auth::user()->role == 1)
	        {
	            $btn_url = '/Forms/AdminFormsList';
	        }
	        if (Auth::user()->role == 3 && Auth::user()->user_type != 1)
	        {
	            $btn_url = '/Forms/ClientUserFormsList';
	        }
	    ?>
	    <a href="{{url($btn_url)}}"><button class="btn btn-primary pull-right">Back</button></a>
		<!---------------main-panel----------->
		<div class="main-panel" >
		
		<?php if (!empty($questions)):
				if (isset($questions[0])):
		?>
			<form style="display:none">
				<input type="hidden" name="form-id"      id="form-id"      value="{{ $form_id }}"> 
			</form>
		<?php
				endif;
			endif;
		?>
			<div id="heading">
				<div class="head" id="form-heading">
				    
					<ul>
						<li><strong>&starf;</strong></li>
						<li><i class="fa fa-chevron-up"></i></li>
					</ul>
					<?php if (isset($questions[0]) && !empty($questions[0])): ?>
					<h3>
						<?php echo $questions[0]->title; ?>	
					</h3>
					<?php endif; ?>
				</div>
			</div>

			<div class="collapseZero " id="form-body">
			<?php if (isset($questions[0]) && !empty($questions[0]->comments)): ?>
                <div class="form-note"><h5> <?php //echo $questions[0]->comments; ?></h5></div>	
            <?php endif; ?>
			<?php
			$heading_recs = [];
			$section      = 0;
			$display_body_sec_div = 0;
			$close_body_sec_div   = 0;	
			foreach ($questions as $key => $question): 
				$sec_id          = $question->afs_sec_id;
				$heading         = $question->admin_sec_title;

				if ((isset($question->client_sec_title) && !empty($question->client_sec_title))) 
				{
					//$sec_id          = $question->cfs_sec_id;
					$sec_id          = $question->afs_sec_id;		// admin form section id
					$heading         = $question->client_sec_title; // 
				}

			    if ($heading != null && !in_array($heading, $heading_recs)):
					$heading_recs[] = $heading;
					$section++;
					$display_body_sec_div = 1;	
					
			?>
			<?php if ($close_body_sec_div): // close 
					$close_body_sec_div = 0;
			?>
				</div>
			<?php endif; ?>
				<div class="head sec-heading" id="{{ "section-title-".$sec_id }}" num="{{ $section }}">
					<ul>
						<li><span>Section {{ $section }}</span></li>
						<li><i class="fa fa-chevron-up"></i></li>
					</ul>
					<div class="section-heading" id="{{ "section-heading-".$sec_id }}" num="{{ $section }}">
						<h3>{{ $heading }}</h3>
					</div>
					<div id="{{"section-heading-edit-".$sec_id}}" class="section-heading-edit container" style="width:20%">
						<div class="">
							<div class="">
								<input id="{{"new-section-heading-".$sec_id}}" type="text" class="form form-control" value="{{ $heading }}" old-value="{{ $heading }}" />
							</div>
						</div>
					</div>					
					
                    <?php if (Auth::user()->role == 1): ?>
					    <select name="section-{{ $question->question_section }}"
							sec="{{ $question->question_section }}"
							form-id="{{ $form_id }}"
							class="form form-control sec-ctgry"
							style="margin-left:10px; width:200px">
    						<option value="">Select Category</option>
    						<option value="1" <?php if ($question->question_category == 1) echo 'selected'; ?>>Asset Inventory</option>
    						<option value="2" <?php if ($question->question_category == 2) echo 'selected'; ?>>Data Inventory</option>
					    </select>
				    <?php endif; ?>						
							

					<?php if (Auth::user()->role == 1 || Auth::user()->role == 2): ?>
						<div class="fork" >
							<a href="#" class="change-heading-icon" id={{ "heading-edit-".$sec_id }} sec-id="{{ $sec_id }}"><i class="fa fa-pencil-alt"></i></a>
							<button class="btn btn-default change-heading-btn" id="save-sec-heading-{{$sec_id}}" sec-id="{{ $sec_id }}">Save</button>
						</div>
					<?php endif; ?>	
	
				</div>
			<?php 
				endif; 
			?>
			<?php if ($display_body_sec_div): 
				$display_body_sec_div = 0;
				$close_body_sec_div = 1;
			?>
				<div class="margin" id="section-{{ $section }}-body" num="{{ $section }}" class="sec-heading-detail" style="margin: 20px 30px; display: block;">
			<?php
			endif;
			?>
					<div class="content">
						<p></p>
						<h6>{{ $question->question_num.' '.$question->question }}</h6>
						<?php if ($question->question_comment != null && $question->question_comment != ''): ?>
							<small>{{-- $question->question_comment --}}</small>
						<?php endif; ?>						
						
					</div>
									
					<div id="wrap" class="wrap-content">						
						<?php if ($question->question_comment != null && $question->question_comment != ''): ?>
							<h6 class="question-comment"><?php echo $question->question_comment; ?></h6>				
						<?php endif; ?>						
						
						<?php
							$type = $question->type;	
							switch ($type): 
							    case('cc'):
							        echo $question->custom_fields;
							        break;
								case('sc'):
								case('mc'):
									$options = explode(', ', $question->options); 
									// if($question->question  = 'What assets are used to process the data for this activity?' && $question->question_num == '6.1'){echo "<pre>"; print_r($question->options);}

									if (!empty($options)):
						?>
									<section class="options">
										<ul id="easySelectable" class="easySelectable">

						<?php
						              $pia_form_check = false;
                                 	if( ($question->question  == 'What assets are used to process the data for this activity?' || $question->question  ==  'What assets are used to collect store and process the data'  || $question->question  ==  'What assets are used to process the data for this activity?' ||    $question->question  == 'What is the name of the asset you are assessing?') && ($question->question_num == '6.1' || $question->question_num == '4.1' || $question->question_num == '2.1' || $question->question_num == '1.1'))
										{    
                       			     	  	$client_id = Auth::user()->client_id;
											$options =  DB::table('assets')->where('client_id' , $client_id)->get();
											$pia_form_check = true;
											$selected_class = 'es-selected';
										}
										foreach ($options as $option):
											$selected_class = '';
											if (isset($filled[$question->form_key]))
											{
												if ($type == 'sc' && trim($filled[$question->form_key]['question_response']) == trim($option))
												{
													$selected_class = 'es-selected';
												}
												if ($type == 'mc' && in_array(trim($option), $filled[$question->form_key]['question_response']))
												{
													$selected_class = 'es-selected';			
												}
											}
															
						           
						            ?>
										@if($pia_form_check == 'true')
											<li class="es-selectable {{ $selected_class }}" name="" value="{{ $option->name }}" type="{{ $type }}">{{ $option->name }}</li>

										@elseif($pia_form_check == 'false' || isset($pia_form_check) == 'false')	
											<li class="es-selectable {{ $selected_class }}" name="" value="{{ $option }}" type="{{ $type }}">{{ $option }}</li>
										@endif	

						<?php
										endforeach;
						?>
										</ul>
									</section>
						<?php
									endif;	
								break;
								case ('bl'):
								case ('qa'):
						?>
								<div>
									<form>
										<label></label>
										<textarea  name=""  rows="4" cols="50" disabled></textarea>
									</form>
								</div>	
						<?php	
								break;									
							endswitch; 
						?>
					</div>					
				<!--</div>-->
			<?php endforeach; ?>
			</div>
		</div>
	</div>
<script type="text/javascript" src="{{ url('public/custom_form/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/custom_form/js/popper.min.js') }}"></script>
	{{-- <script type="text/javascript" src="{{ url('public/custom_form/js/bootstrap.min.js') }}"></script> --}}
<script src="{{ url('public/custom_form/js/easySelectable.js') }}"></script>
	{{-- <script src="public/js/index.js"></script> --}}

<script type="text/javascript" src="{{ url('public/custom_form/js/cust_js.js') }}"></script>

<script>

	$(document).ready(function(){
		//$('#form-body').slideToggle("slow");
		
		$('.change-heading-icon').click(function(event){

			event.preventDefault();

			var heading_sec_id = $(this).attr('sec-id');

			$('div#section-heading-'+heading_sec_id).hide();
			
			$('#save-sec-heading-'+heading_sec_id).show();
			$('#heading-edit-'+heading_sec_id).hide();

			$('div#section-heading-edit-'+heading_sec_id).show();

		});

		$('.change-heading-btn').click(function(event){

			event.preventDefault();

			var heading_sec_id = $(this).attr('sec-id');
			
			// 
			$('#save-sec-heading-'+heading_sec_id).hide();
			$('#heading-edit-'+heading_sec_id).show();


			$('div#section-heading-edit-'+heading_sec_id).hide();

			var old_heading = $('#new-section-heading-'+heading_sec_id).attr('old-value');
			var new_heading = $('#new-section-heading-'+heading_sec_id).val();

			$('div#section-heading-'+heading_sec_id+' > h3').text(new_heading);
			$('div#section-heading-'+heading_sec_id).show();

			var form_id = $('#form-id').val();

			var post_data = {};

			post_data['_token']          = '{{csrf_token()}}';
			post_data['form_id']         =    form_id;
			post_data['title']           =    new_heading;
			post_data['old_title']       =    old_heading;

			post_data['user_id']         =  {{ Auth::user()->client_id }};
			//post_data['user_id']         =  23;
			post_data['updated_by']      =  {{ Auth::id() }};
			post_data['form_section_id'] =    heading_sec_id;

			<?php if (Auth::user()->role==1): ?>
			post_data['is_admin']    = 1;
			<?php endif; ?>

			$.ajax({
				url:'{{route('update_form_section_heading')}}',
				method:'POST',
				data: post_data,
				success: function(response) {
					console.log(response);
					//alert('Forms assigned to client');
				}

			});

		});


		<?php if (Auth::user()->role == 1): ?>

			$('.sec-ctgry').change(function(){
				var section_name = $(this).attr('sec');
				var form_id      = $(this).attr('form-id');
				var category_id  = $(this).val();

				if (category_id != '') {

					var post_data = {};

					post_data['_token']    = '{{csrf_token()}}';
					post_data['form_id']   = form_id;
					post_data['sec_name']  = section_name;
					post_data['ctg_id']    = category_id;

					$.ajax({
						url:'{{route('asgn_sec_ctgry')}}',
						method:'POST',
						/*
						headers: {
							'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
						},
						*/
						data: post_data,
						success: function(response) {
							console.log(response);
							//alert('Forms assigned to client');
						}
					});
				}

			});

		<?php endif; ?>
				
		$('.sec-heading').click(function(e){

			var tag = e.target.tagName.toLowerCase();	
			console.log(tag);			
			var num = $(this).attr('num');
			
			var up   = $(this).find($('i.fa-chevron-up')).length;
			var down = $(this).find($('i.fa-chevron-down')).length;

			if (tag == 'div' || tag == 'span' || tag == 'h3') {
				$("#section-"+num+"-body").slideToggle("slow");	
				if (up) {
					$("i.fa-chevron-up", this).toggleClass("fa-chevron-up fa-chevron-down");
				}
				if (down) {
					$("i.fa-chevron-down", this).toggleClass("fa-chevron-down fa-chevron-up");
				}
			}
		});
	
	});
	
</script>
@endsection