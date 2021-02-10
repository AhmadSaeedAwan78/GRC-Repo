@extends('parent', ['page_title' => $title, 'page_heading' => $heading, 'load_admin_css'])



@section('user_form')

<div class="container" style="background-color:white;padding-bottom:20px;">

	<div class="form_pia">

<?php

    // echo "<pre>";

    // print_r($filled);

    // echo "</pre>";

    // exit;

?>



<h1>@if (!empty($questions)) {{ $questions[0]->title }} @endif</h1>

<p>@if (!empty($questions) && !empty($questions[0]->description)) {{ $questions[0]->description }} @endif</p>



<form method="POST" action="{{ route('submit_form') }}">

    {{ csrf_field() }}



  @if (!empty($questions))

  <input type="hidden" name="form-id"      value="{{ $questions[0]->uf_id }}">

  <input type="hidden" name="form-link-id" value="{{ $questions[0]->form_link_id }}">

  <input type="hidden" name="user-id"      value="{{ $questions[0]->u_id }}">

  <input type="hidden" name="email"        value="{{ $user_info->email }}">

  



  

  @foreach ($questions as $key => $question)

  

	<div class="form-group">

		<label><h5>{{ $question->question }}</h5></label>

		@if ($question->question_comment != null && $question->question_comment != '')

		<p>

			{{ $question->question_comment }}

		</p>  

		@endif



      @switch($question->type)

		  

		@case('sc')

			<?php $radio_options = explode(', ', $question->options); ?>

			@if (!empty($radio_options))

				@foreach ($radio_options as $option)

					<div class="form-group form-check">

						<label class="form-check-label">

							<input type="radio" name="{{ $question->form_key.'_'.$question->q_id }}"  value="{{ $option }}" <?php if (isset($filled[$question->form_key]) && $filled[$question->form_key]['question_response'] == $option) echo 'checked'; ?>> {{ $option}}<br><br>

						</label>

						</div>

				@endforeach

			@endif

		@break		  

		  

		  

          @case('mc')

          <?php $chkbox_options = explode(', ', $question->options); ?>

          @if (!empty($chkbox_options))

            @foreach ($chkbox_options as $option)

              <input type="checkbox" name="{{ $question->form_key.'_'.$question->q_id }}[]" value="{{ $option }}" <?php if (isset($filled[$question->form_key]) && in_array($option, $filled[$question->form_key]['question_response'])) echo 'checked'; ?>> {{ $option}}<br><br>

            @endforeach

          @endif

          @break

          @case('bl')

            <br>

            <input type="text" name="{{ $question->form_key.'_'.$question->q_id }}"  value="<?php (isset($filled[$question->form_key]))?($filled[$question->form_key]):('') ?>"><br><br>

          @break

          @case('qa')

            <br>

            <textarea name="{{ $question->form_key.'_'.$question->q_id }}"  rows="4" cols="50"><?php (isset($filled[$question->form_key]))?($filled[$question->form_key]):('') ?></textarea><br><br>

          @break



          @case('blanks')

          @break

        Default case...

@endswitch

@if ($question->additional_comments)

        <div>Additional Comments</div>

        <input type="text" name="c-{{ $question->q_id }}" value="<?php echo (isset($filled[$question->form_key]))?($filled[$question->form_key]['question_comment']):('') ?>"><br><br>

@endif

  </div>



  @endforeach

  @endif

  <br>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>

	</div>

</div>







@endsection

