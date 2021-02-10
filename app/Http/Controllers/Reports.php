<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
// use Mail;
use App\PasswordSecurity;

class Reports extends Controller
{
    public function __construct()
    {

        //  $fa=PasswordSecurity::where('user_id',Auth::user()->id)->first();
        // if($fa && $fa->google2fa_enable==0){
        //   return  redirect('/2fa');
        // }

      //$this->middleware(['auth','2fa']);
   
    }

	public function response_reports_external_users ($category_id)
	{	

		 


        
   

            // 

     //        $articles = DB::table('articles')
     //        ->select('articles.id as articles_id')
     //        ->join('categories', 'articles.categories_id', '=', 'categories.id')

     //        ->join('users', 'articles.user_id', '=', 'user.id')
  			// ->where('user_id',$user_id)
     //        ->get();
            // 
    

        $client_id = Auth::user()->client_id;
        // dd($client_id);

        
	  	  $option_questions = array();
          // $filled_questions = DB::table('external_users_filled_response')->pluck('question_key');
          
          $filled_questions = DB::table('external_users_forms')->select('*' )
          ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->pluck('question_key');





          // $filled_questions = DB::table('external_users_filled_response')->pluck('question_key');



          // dd($filled_questions);

          // $filled_questions_internal = DB::table('internal_users_filled_response')->pluck('question_key');
          $piaDpiaRop_ids = [2,9,12];
           
           $filled_questions_internal = DB::table('user_forms')->select('*' )
          ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->pluck('question_key');



          $filled_questions = $filled_questions->merge($filled_questions_internal);
          // dd($filled_questions);
          // dd($filled_questions);
          

	  	  $question  = DB::table('questions')->where('type','mc')->wherein('form_id' , $piaDpiaRop_ids )->wherein('form_key' , $filled_questions )->get();
	  	  // dd($question);
	  	  $question = $question->unique('question');
	  	   $opt=null;



	  	    foreach ($question as $value) {

	  	    	 $option = $value->question;
	  	    	 $temporary_question  = DB::table('questions')->where('question' , $option )->pluck('form_key');
                 // $question_response = DB::table('external_users_filled_response')->wherein('question_key' , $temporary_question )->get();
                 
                 $question_response = DB::table('external_users_forms')->select('*' )->wherein('external_users_filled_response.question_key' , $temporary_question )
                       ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->get();


                  // $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $temporary_question )->get();

                   $question_response2 = DB::table('user_forms')->select('*' )->wherein('internal_users_filled_response.question_key' , $temporary_question )
                         ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->get();


                  // dd($question_response);
                  if(count($question_response2) > 5){
                  	foreach($question_response2 as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	}
                  }
                  $question_response = $question_response->merge($question_response2);
                 // dd($question_response2);
                        $final_options_array= array();
                        $count = 0;
                        foreach ($question_response as $resp) {
                       
                            $remove_duplicate_options = array();
                        	$user_responses = explode(',',$resp->question_response);
                        	foreach ($user_responses as $pickoption) {
	  	       					  if(!in_array(trim($pickoption), $final_options_array))
	  	       					  { 
	  	       					  	// dd(str_contains($pickoption, "UTF-8"));
	  	       					  	// if(mb_substr($pickoption, 0, 1, "UTF-8") != "{" )
	  	       					  	// {
	  	       					  		if(strlen($pickoption) >1){
	  	       					  	        $final_options_array[]=trim($pickoption);
											}

                  	  	       					                                    // }
	  	       					  }
                                   
                                                     }
                        }
                        	$count =count($final_options_array);

                        foreach ($final_options_array as $tt ) {
	  	    		        $opt[] = explode(',',$tt);
	  	    	                                              }
                        // print_r($final_options_array);

	  	    	 // $temp = DB::table('questions')->where('id',$value->id)->pluck('options')->first();
                 
                 $op_count = $count;
                 array_push($option_questions, array(
	  	    	  "question_string" => $option,
	  	    	  "op_count" => $op_count
	  	               ));	 
	  	    }

	  	    $final=null;
	  	    if($opt != null){
			  	    foreach ($opt as $jugar) {
			  	    
			  	        $final[]=$jugar[0];
			  	    	# code...
			  	    }
	         	}
	         	// dd($final);
	  	  $mc_ids  = DB::table('questions')->where('type', 'mc' )->wherein('form_id' , $piaDpiaRop_ids )->pluck('form_key');


	         	$emails = DB::table('external_users_forms')->select('*' )
                ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->wherein('question_key' , $mc_ids)->get();
                // dd($emails);

	  	       // $emails = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->select('user_email','external_user_form_id')->get();
   
                 $emails_internal = DB::table('user_forms')->select('*' )
                  ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->wherein('question_key' , $mc_ids)->get();
                  // dd($emails_internal);
   
	  	  // $emails_internal = DB::table('internal_users_filled_response')->wherein('question_key' , $mc_ids)->select('user_id as user_email'  ,'user_form_id as external_user_form_id' )->get();
         if(count($emails_internal) > 5){
	  	  	foreach($emails_internal as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	}
                  }

                  	$emails=$emails -> merge($emails_internal);


	  	  $emails = $emails->unique('external_user_form_id');
	  	  // dd($emails);

	  	  
          $data = array();
          $flag = false;
          $count = 0;
          // dd($emails);
          if(count($emails) >0){
          foreach($emails as $users){
                    // print_r($users->external_user_form_id);
                  $ex_user_res  = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->where('external_user_form_id' , $users->external_user_form_id )->get();

                  $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $mc_ids )->where('user_form_id' , $users->external_user_form_id )->get();
                  if(count($question_response2) > 0){
                  	foreach($question_response2 as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	                         }
                  	                     }
                  	                      $ex_user_res = $ex_user_res ->merge($question_response2);

                        $rr=array();

                   // dd($users);
                  foreach ($ex_user_res as $ex_u_res) {
                  	if($ex_u_res->user_email == $users->user_email){
                        $flag = true;
                        $tempo =  $ex_u_res->question_response;
                        $exusres = explode(',',$tempo);
                        foreach ($exusres as $tt ) 
                        {
	  	    		    $rr[] = explode(',',$tt);
	  	                }
	  	               
                  	}

                 if($flag == true){
                 	  $finalar = array();
	  	        foreach ($rr as $jugar) {
	  	        	$finalar[]=$jugar[0];
	  	    	}
	  	    	$flag = false;
                 }


                  }
	  	   
              $exuserfrmid = DB::table('external_users_forms')->where('id' ,$users->external_user_form_id)->pluck('sub_form_id')->first();
              $form_name = DB::table('sub_forms')->where('id' ,$exuserfrmid)->pluck('title')->first();
              if($form_name == null) {
              	 $exuserfrmid = DB::table('user_forms')->where('id' ,$users->external_user_form_id)->pluck('sub_form_id')->first();
                 $form_name = DB::table('sub_forms')->where('id' ,$exuserfrmid)->pluck('title')->first();
              }
	  	     array_push($data, array(
	  	    	"email" => $users->user_email,
	  	    	"response" => $finalar,
	  	    	"sub_form_title" => $form_name
	  	    ));

              // $finalar = ',';

          }
      }
		/*
			// get external user form response
			SELECT *, forms.title as form_title 
			FROM  questions
            JOIN  external_users_filled_response ON questions.id            = external_users_filled_response.question_id
            JOIN  external_users_forms           ON external_users_forms.id =   external_users_filled_response.external_user_form_id      
			JOIN  users                          ON users.id                = external_users_forms.client_id    
            JOIN  forms                          ON forms.id                = external_users_filled_response.form_id     
            WHERE questions.question_category = 1		
		*/			
		
		//echo $category_id;exit;
// 			$client_id = Auth::user()->client_id;


// 		$response_ques = DB::table('questions')->where('external_users_forms.client_id', '=', $client_id)
//                           ->join('external_users_filled_response', 'questions.id',    '=', 'external_users_filled_response.question_id')
// 					      ->join('external_users_forms', 'external_users_forms.id',   '=', 'external_users_filled_response.external_user_form_id')
// 					      ->join('users',      'users.id',                            '=', 'external_users_forms.client_id')
//                           ->join('forms',      'forms.id',                            '=', 'external_users_filled_response.form_id')
// 					      ->where('questions.question_category', '=', $category_id)  
//                           ->select('*', 
// 					              'forms.title as form_title', 
// 								  'external_users_filled_response.created as time')->get();



//          $response_ques2 = DB::table('questions')->where('user_forms.client_id', '=', $client_id)
//                           ->join('internal_users_filled_response', 'questions.id',    '=', 'internal_users_filled_response.question_id')
// 					      ->join('user_forms', 'user_forms.id',   '=', 'internal_users_filled_response.user_form_id')
// 					      ->join('users',      'users.id',                            '=', 'user_forms.client_id')
//                           ->join('forms',      'forms.id',                            '=', 'internal_users_filled_response.form_id')
// 					      ->where('questions.question_category', '=', $category_id)  
//                           ->select('*', 
// 					              'forms.title as form_title', 
// 								  'internal_users_filled_response.created as time')->get(); 
//                           // dd($response_ques2);


//                           // foreach($response_ques2 as $datum){
//                           // 	dd($datum);
//                           // 	    $datum->user_email = DB::table('users')->where('id' , $datum->user_id)->pluck('name')->first();
//                           // }
// 								  // dd($response_ques2);                


// 								  $response_ques = $response_ques->merge($response_ques2);

				
	
// 		//$form_info = DB::table('forms');
		
// 		if (Auth::user()->role == 1)
// 		{
// 			$user_type = 'admin';
// 			$response_ques = $response_ques->get();
// 		}
// 		else
// 		{
// 			$user_type = 'client';
// 			$client_id = Auth::user()->client_id;

// 			//$client_id = Auth::id();
// // 			if (Auth::user()->user_type == 1) 
// // 			{
// // 			    $client_id = Auth::user()->client_id;
// // 			}
			
			
// 			// $response_ques = $response_ques->where('external_users_forms.client_id', '=', $client_id)->get();
// 		}
		
// 		if ($category_id == 1)
// 		{
// 			$heading = 'Asset Reports (External Users)';
// 		}
// 		else
// 		{
// 			$heading = 'Data Inventory Reports (External Users)';
// 		}
		
// 		// echo "<pre>";
// 		// print_r($response_ques);
// 		// echo "</pre>";
// 		// exit;
// 		// dd($user_type);

            $user_type = 'client';
            $heading = 'Headumg';

              if($category_id == 1){
                   return view('global_report_export',compact('final','data','option_questions' , 'heading' , 'user_type'));
                                   }
               return view('response_reports',compact('final','data','option_questions' , 'heading' , 'user_type'));

		
		// return view('response_reports', ['response_reports' => $response_ques, 'heading' => $heading, 'user_type' => $user_type]);

	}
	
	public function response_reports_registered_users ($category_id)
	{			
		/*
			// get internal user form response
			SELECT *, forms.title as form_title, u.email as user_email, c.email as client_email  
			FROM  questions
            JOIN  internal_users_filled_response ON questions.id  = internal_users_filled_response.question_id
            JOIN  user_forms                     ON user_forms.id = internal_users_filled_response.user_form_id      
			JOIN  users as u                     ON u.id          = user_forms.user_id
            JOIN  users as c                     ON c.id          = user_forms.client_id
            JOIN  forms                          ON forms.id      = internal_users_filled_response.form_id     
            WHERE questions.question_category = 2	
		*/

		$response_ques = DB::table('questions')
                          ->join('internal_users_filled_response', 'questions.id',   '=', 'internal_users_filled_response.question_id')
		                  ->join('user_forms', 'user_forms.id',                      '=', 'internal_users_filled_response.user_form_id')
		                  ->join('users as u', 'u.id',                               '=', 'user_forms.user_id')
		                  ->join('users as c', 'c.id',                               '=', 'user_forms.client_id')
                          ->join('forms',      'forms.id',                           '=', 'internal_users_filled_response.form_id')
		                  ->where('questions.question_category',                     '=', $category_id)  
                          ->select('*', 
		                          'forms.title as form_title',
								  'u.email as user_email',
								  'c.email as client_email',
				                  'internal_users_filled_response.created as time');	
	
		//$form_info = DB::table('forms');
		
		if (Auth::user()->role == 1)
		{
			$user_type = 'admin';
			$response_ques = $response_ques->get();
		}
		else
		{
			$user_type = 'client';
// 			$client_id = Auth::id();
			
// 			if (Auth::user()->user_type == 1) 
// 			{
// 			    $client_id = Auth::user()->client_id;
// 			}
			
			$client_id = Auth::user()->client_id;

			$response_ques = $response_ques->where('user_forms.client_id', '=', $client_id)->get();
			
		}
		
		if ($category_id == 1)
		{
			$heading = 'Asset Reports (Organization Users)';
		}
		else
		{
			$heading = 'Data Inventory Reports (Organization Users)';
		}
		
		/* echo "<pre>";
		print_r($response_ques);
		echo "</pre>";
		exit; */
		
		return view('response_reports', ['response_reports' => $response_ques, 'heading' => $heading, 'user_type' => $user_type]);

	}

	public function internal_user_form_report ()
	{
		//$client_id = Auth::id();
		$client_id = Auth::user()->client_id;

		$form_id = 2;
		
// 		if (Auth::user()->role == 3 && Auth::user()->user_type == 1)
// 		{
// 			$client_id = Auth::user()->client_id;
// 		}
		
		$client_id = Auth::user()->client_id;

		
		// get subforms list
		$subform_list = DB::table('sub_forms')
						  ->where('client_id',        $client_id)
						  ->where('parent_form_id',   $form_id)
						  ->select(
								   'id', 
								   'title')
						  ->get()
						  ->toArray();						  
			  
		// get user list			  
		$user_list    = DB::table('users')
						  ->where('client_id', $client_id)
						  ->select(
								  'id',
								  'name')
						  ->get()
						  ->toArray();
						  		  
		// get form data questions
		/*
		SELECT questions.id,questions.question,questions.form_key,questions.type,questions.options,questions.assoc_type
		FROM   questions 
		JOIN   form_questions ON questions.id = form_questions.question_id
		JOIN   forms          ON forms.id     = form_questions.form_id
		WHERE  questions.question_category = 2
		*/	
		
		$data_category = 2;
		$questions = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type')
					   ->orderBy('sort_order')
					   ->get()
					   ->toArray();
		

		$user_responses = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type')//->toSql();
					        ->get()
					        ->toArray();
							
		/* echo "<h1> questions </h1>";
		echo "<pre>";
		//print_r($questions);
		echo "</pre>"; */
		/* 
			echo "<h1> user resp</h1>";
		echo "<pre>";
		print_r($user_responses);
		echo "</pre>"; */
		//exit;
		
		$curr_index = 0;
		
		foreach ($questions as $key => $question)
		{
			while (isset($user_responses[$curr_index]) && $user_responses[$curr_index]->question_id == $question->id)
			{
				//echo "match with response : ".$user_responses[$curr_index]->question_response."<br>";
				if (!empty($user_responses[$curr_index]->question_response))
				{
					$questions[$key]->user_responses[$user_responses[$curr_index]->subform_id]
													[$user_responses[$curr_index]->user_id] = ['response'   => $user_responses[$curr_index]->question_response,
					                                                                           'user_name'  => $user_responses[$curr_index]->name];				
				}
				$curr_index++;
			}
		}
		
		/* echo "curr_index : ".$curr_index."<br>";
		echo "<h1> questions </h1>";
		echo "<pre>";
		//print_r($questions);
		print_r($subform_list);
		echo "</pre>"; */
		//	exit;
	
					   
	/* 	array_map(function ($sub_form) use($questions) {
		   return $sub_form->questions = $questions;
		}, $subform_list); */			   
					   
		/* echo "<h1>Questions</h1>";								
		echo "<pre>";
		print_r($subform_list);
		echo "</pre>"; */

		//exit;
		return view('reports.report', [
			'subform_list'  => $subform_list,
			'questions' 	=> $questions,
			'user_list' 	=> $user_list,
		]);

						
						  								   
		/* return view('reports.internal_user_form_report', [
					'subform_list' => $subform_list, 
					'user_type'    => 'client',
					'user_list'   => $user_list,
					'questions' => $form_info,
		]); */


	}
	
	public function summary_reports ()
	{
// 		$client_id = Auth::id();
		$client_id = Auth::user()->client_id;

		$form_id = 2;
		
		if (Auth::user()->role == 3)
		{
			if (Auth::user()->user_type == 1)
			{
				$client_id = Auth::user()->client_id;
			}
			else
			{
				return abort('404');
			}
			
		}
		
		// get subforms list
		$subform_list = DB::table('sub_forms')
						  ->where('client_id',        $client_id)
						  ->where('parent_form_id',   $form_id)
						  ->select(
								   'id', 
								   'title')
						  ->get()
						  ->toArray();						  
			  
		// get user list			  
		$user_list    = DB::table('users')
						  ->where('client_id', $client_id)
						  ->select(
								  'id',
								  'name')
						  ->get()
						  ->toArray();
						  		  
		// get form data questions
		
		$data_category = 2;
		/*
		SELECT questions.id,questions.question,questions.form_key,questions.type,questions.options,questions.assoc_type
		FROM   questions 
		JOIN   form_questions ON questions.id = form_questions.question_id
		JOIN   forms          ON forms.id     = form_questions.form_id
		WHERE  questions.question_category = 2
		*/	
		
		$questions = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type')
					   ->orderBy('sort_order')
					   ->get()
					   ->toArray();
					   
		
		$user_responses = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type')//->toSql();
					        ->get()
					        ->toArray();
		
		$curr_index = 0;
		
		foreach ($questions as $key => $question)
		{
			while (isset($user_responses[$curr_index]) && $user_responses[$curr_index]->question_id == $question->id)
			{
				//echo "match with response : ".$user_responses[$curr_index]->question_response."<br>";
				if (!empty($user_responses[$curr_index]->question_response))
				{
					$questions[$key]->user_responses[$user_responses[$curr_index]->subform_id]
													[$user_responses[$curr_index]->user_id] = ['response'   => $user_responses[$curr_index]->question_response,
					                                                                           'user_name'  => $user_responses[$curr_index]->name];				
				}
				$curr_index++;
			}
		}
		
		return view('reports.summary_reports', [
			'subform_list'  => $subform_list,
			'questions' 	=> $questions,
			'user_list' 	=> $user_list,			
		]);
	}
	
	// subform wise summary reports
	public function summary_reports_sfw ()
	{
		$client_id = Auth::user()->client_id;
		
		$form_id = 2;
		
		if (Auth::user()->role == 3)
		{
			if (Auth::user()->user_type != 1)
			{
				return abort('404');
			}
		}
		
		// get subforms list and assigned users
		/*
		$subform_list = DB::table('sub_forms')
						  ->where('client_id',        $client_id)
						  ->where('parent_form_id',   $form_id)
						  ->select(
								   'id', 
								   'title')
						  ->get()
						  ->toArray();	
		*/
	
		$subform_list = [];
	
		/*
		SELECT * 
		FROM  `sub_forms`
		LEFT 
		JOIN   user_forms ON sub_forms.id = user_forms.sub_form_id
		JOIN   users      ON users.id     = user_forms.user_id
		WHERE  user_forms.client_id       = 76		
		*/
				
		$subform_in_query = DB::table('sub_forms')
						  ->leftJoin('user_forms', 'sub_forms.id', '=', 'user_forms.sub_form_id')
						  ->join('users',          'users.id',     '=', 'user_forms.user_id')
						  ->where('user_forms.client_id',               $client_id)
						  ->select( '*',
									'sub_forms.id    as subform_id',						  
									'sub_forms.title as title',
									'users.id       as user_id',
									'users.name     as user_name'
								  )
						  ->get()
						  ->toArray();				  
		/*
		SELECT * 
		FROM  `sub_forms`
		LEFT 
		JOIN   external_users_forms ON sub_forms.id = external_users_forms.sub_form_id
		WHERE  external_users_forms.client_id       = 76
		*/				  
						  
	    $subform_ex_query = DB::table('sub_forms')
						  ->leftJoin('external_users_forms', 'sub_forms.id', '=', 'external_users_forms.sub_form_id')
						  ->where('external_users_forms.client_id',               $client_id)
						  ->select( '*',
									'sub_forms.id    as subform_id',						  
									'sub_forms.title as title',
									'external_users_forms.user_email as user_email'
								  )						  
						  ->get()
						  ->toArray();						  
						  
		foreach ($subform_in_query as $subform)
		{
			if (!isset($subform_list[$subform->sub_form_id]['user_list']))
			{
				$subform_list[$subform->sub_form_id] = [
					'id'            => $subform->subform_id,
					'subform_title' => $subform->title,
					'user_list'     => [
											[
												'user_id'   => $subform->user_id,
												'user_name' => $subform->name
											]
					]
				];
			}
			else
			{
				$subform_list[$subform->sub_form_id]['user_list'][] = [
					'user_id'   => $subform->user_id,
					'user_name' => $subform->name
				];
			}
		}
		
		foreach ($subform_ex_query as $subform)
		{
			if (!isset($subform_list[$subform->sub_form_id]['user_list']))
			{
				$subform_list[$subform->sub_form_id] = [
					'id'            => $subform->subform_id,				
					'subform_title' => $subform->title,
					'user_list'     => [
											[
												'user_email' => $subform->user_email
											]
					]
				];
			}
			else
			{
				$subform_list[$subform->sub_form_id]['user_list'][] = [
					'user_email' => $subform->user_email
				];
			}			
		}
		
	/* 	echo "<pre>";
		print_r($subform_list);
		echo "</pre>";
		exit; */ 
		
		/*	  
		// get user list			  
		$user_list    = DB::table('users')
						  ->where('client_id', $client_id)
						  ->select(
								  'id',
								  'name')
						  ->get()
						  ->toArray();
		*/
						  		  
		// get form data questions
		
		$data_category = 2;
		/*
		SELECT questions.id,questions.question,questions.form_key,questions.type,questions.options,questions.assoc_type
		FROM   questions 
		JOIN   form_questions ON questions.id = form_questions.question_id
		JOIN   forms          ON forms.id     = form_questions.form_id
		WHERE  questions.question_category = 2
		*/	
		
		$questions = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type')
					   ->orderBy('sort_order')
					   ->get()
					   ->toArray();
					   
		
		$in_user_responses = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type')//->toSql();
					        ->get()
					        ->toArray();
							
		/*
		SELECT external_users_forms.id, sub_forms.id as subform_id, sub_forms.title, external_users_forms.user_email, sort_order, questions.question_num, questions.question, eufrq.question_response, external_users_forms.form_link
		FROM   external_users_forms
		JOIN   sub_forms                               ON sub_forms.id         = external_users_forms.sub_form_id AND external_users_forms.client_id = 76
		JOIN   forms                                   ON forms.id             = sub_forms.parent_form_id
		JOIN   form_questions                          ON forms.id             = form_questions.form_id
		JOIN   questions                               ON questions.id         = form_questions.question_id
		LEFT
		JOIN   external_users_filled_response AS eufrq ON questions.id         = eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id
		WHERE  questions.question_category = 2
		GROUP BY sub_forms.title, external_users_forms.user_email, questions.question
		ORDER BY form_questions.sort_order
		*/
		
		$ex_user_responses = DB::table('external_users_forms')
							->join('sub_forms', 'sub_forms.id',        									'=', 'external_users_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('external_users_filled_response AS eufrq'), 'questions.id',       '=', DB::raw('eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id'))			
					        ->where('questions.question_category',     '=', $data_category)
							->groupBy('sub_forms.title', 'external_users_forms.user_email', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title',
								'external_users_forms.user_email as user_email',								
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'eufrq.question_response',
								'questions.question_assoc_type')//->toSql();
					        ->get()
					        ->toArray();
							
/* 		echo "<h1>In </h1>";					
		echo "<pre>";
		print_r($in_user_responses);
		echo "</pre>";							
							
		echo "<h1>Ex </h1>";					
		echo "<pre>";
		print_r($ex_user_responses);
		echo "</pre>";
		exit;  */

				
		$in_curr_index = 0;
		$ex_curr_index = 0;
		
		foreach ($questions as $key => $question)
		{
			while (isset($in_user_responses[$in_curr_index]) && $in_user_responses[$in_curr_index]->question_id == $question->id)
			{
				if (!empty($in_user_responses[$in_curr_index]->question_response))
				{
					$questions[$key]->user_responses['in'][$in_user_responses[$in_curr_index]->subform_id]
													      [$in_user_responses[$in_curr_index]->user_id] = ['response'   => $in_user_responses[$in_curr_index]->question_response,
					                                                                                       'user_name'  => $in_user_responses[$in_curr_index]->name];				
				}
				
				$in_curr_index++;				
			}
			
			while (isset($ex_user_responses[$ex_curr_index]) && $ex_user_responses[$ex_curr_index]->question_id == $question->id)
			{
				if (!empty($ex_user_responses[$ex_curr_index]->question_response))
				{
					$questions[$key]->user_responses['ex'][$ex_user_responses[$ex_curr_index]->subform_id]
													      [$ex_user_responses[$ex_curr_index]->user_email] = ['response'   => $ex_user_responses[$ex_curr_index]->question_response,
					                                                                                          'user_email' => $ex_user_responses[$ex_curr_index]->user_email];	
				}
				
				$ex_curr_index++;
			}
						
		}
		

//  		echo "<pre>";
// 		print_r($subform_list);
// 		echo "</pre>";
		
// 		echo "<pre>";
// 		print_r($questions);
// 		echo "</pre>";		
		
// 		exit;				
		return view('reports.summary_reports2', [
			'subform_list'  => $subform_list,
			'questions' 	=> $questions,
		]);
	}



    // detail data inventory new
	  public function summary_reports_all_2(){
        // dd('walla');

	  	
        $user = Auth::user()->id;

            $assigned_permissions =array();
            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if($data != null){
                 foreach ($data as $value) {
                $assigned_permissions = explode(',',$value);
                 
            }
            }
            // if(Auth::user()->role != 3 ){
            if(!in_array('Detailed Data Inventory', $assigned_permissions)){
                return redirect('dashboard');
            }
          // }



            // 

     //        $articles = DB::table('articles')
     //        ->select('articles.id as articles_id')
     //        ->join('categories', 'articles.categories_id', '=', 'categories.id')

     //        ->join('users', 'articles.user_id', '=', 'user.id')
  			// ->where('user_id',$user_id)
     //        ->get();
            // 
    

        $client_id = Auth::user()->client_id;
        // dd($client_id);


	  	  $option_questions = array();
        $piaDpiaRop_ids = [2,9,12];
          // $filled_questi,ons = DB::table('external_users_filled_response')->pluck('question_key');

        // ->join('sub_forms'  ,'external_users_forms.sub_form_id' , '=' ,'sub_forms.id' )->wherein('sub_forms.parent_form_id' , $piaDpiaRop_ids )
          
          $filled_questions = DB::table('external_users_forms')->select('*' )
          ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->pluck('question_key');





          // $filled_questions = DB::table('external_users_filled_response')->pluck('question_key');



          // dd($filled_questions);

          // $filled_questions_internal = DB::table('internal_users_filled_response')->pluck('question_key');


          // ->join('sub_forms'  ,'user_forms.sub_form_id' , '=' ,'sub_forms.id' )->wherein('sub_forms.parent_form_id' , $piaDpiaRop_ids )
           
           $filled_questions_internal = DB::table('user_forms')->select('*' )
          ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->pluck('question_key');
          // dd($filled_questions_internal);
  



          $filled_questions = $filled_questions->merge($filled_questions_internal);
          // dd($filled_questions);
          // dd($filled_questions);
          

	  	  $question  = DB::table('questions')->where('type','mc')->wherein('form_id' , $piaDpiaRop_ids )->wherein('form_key' , $filled_questions )->get();
	  	  // dd($question);
	  	  $question = $question->unique('question');
	  	  // echo "<pre>";
	  	  // print_r($question);
	     //   exit();
	  	   $opt=null;



	  	    foreach ($question as $value) {

	  	    	 $option = $value->question;
	  	    	 $temporary_question  = DB::table('questions')->where('question' , $option )->pluck('form_key');
                 // $question_response = DB::table('external_users_filled_response')->wherein('question_key' , $temporary_question )->get();
                 
                 $question_response = DB::table('external_users_forms')->select('*' )->wherein('external_users_filled_response.question_key' , $temporary_question )
                       ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->get();


                  // $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $temporary_question )->get();

                   $question_response2 = DB::table('user_forms')->select('*' )->wherein('internal_users_filled_response.question_key' , $temporary_question )
                         ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->get();


                  // dd($question_response);
                  if(count($question_response2) > 5){
                  	foreach($question_response2 as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	}
                  }
                  $question_response = $question_response->merge($question_response2);
                 // dd($question_response2);
                        $final_options_array= array();
                        $count = 0;
                        foreach ($question_response as $resp) {
                       
                            $remove_duplicate_options = array();
                        	$user_responses = explode(',',$resp->question_response);
                        	foreach ($user_responses as $pickoption) {
	  	       					  if(!in_array(trim($pickoption), $final_options_array))
	  	       					  { 
	  	       					  	// dd(str_contains($pickoption, "UTF-8"));
	  	       					  	if(mb_substr($pickoption, 0, 1, "UTF-8") != "{" )
	  	       					  	{
	  	       					  		if(strlen($pickoption) >1){
	  	       					  	        $final_options_array[]=trim($pickoption);
											}

                  	  	       					                                    }
	  	       					  }
                                   
                                                     }
                        }
                        	$count =count($final_options_array);

                        foreach ($final_options_array as $tt ) {
	  	    		        $opt[] = explode(',',$tt);
	  	    	                                              }
                        // print_r($final_options_array);

	  	    	 // $temp = DB::table('questions')->where('id',$value->id)->pluck('options')->first();
                 
                 $op_count = $count;
                 array_push($option_questions, array(
	  	    	  "question_string" => $option,
	  	    	  "op_count" => $op_count
	  	               ));	 
	  	    }

	  	    $final=null;
	  	    if($opt != null){
			  	    foreach ($opt as $jugar) {
			  	    
			  	        $final[]=$jugar[0];
			  	    	# code...
			  	    }
	         	}
	         	// dd($final);
	  	  $mc_ids  = DB::table('questions')->where('type', 'mc' )->wherein('form_id' , $piaDpiaRop_ids )->pluck('form_key');


	         	$emails = DB::table('external_users_forms')->select('*' )
                ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->wherein('question_key' , $mc_ids)->get();
                // dd($emails);

	  	       // $emails = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->select('user_email','external_user_form_id')->get();
   
                 $emails_internal = DB::table('user_forms')->select('*' )
                  ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->wherein('question_key' , $mc_ids)->get();
                  // dd($emails_internal);
   
	  	  // $emails_internal = DB::table('internal_users_filled_response')->wherein('question_key' , $mc_ids)->select('user_id as user_email'  ,'user_form_id as external_user_form_id' )->get();
         if(count($emails_internal) > 5){
	  	  	foreach($emails_internal as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	}
                  }

                  	$emails=$emails -> merge($emails_internal);


	  	  $emails = $emails->unique('external_user_form_id');
	  	  // dd($emails);

	  	  
          $data = array();
          $flag = false;
          $count = 0;
          // dd($emails);
          if(count($emails) >0){
          foreach($emails as $users){
                    // print_r($users->external_user_form_id);
                  $ex_user_res  = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->where('external_user_form_id' , $users->external_user_form_id )->get();

                  $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $mc_ids )->where('user_form_id' , $users->external_user_form_id )->get();
                  if(count($question_response2) > 0){
                  	foreach($question_response2 as $internal_question){
                  		$internal_question->external_user_form_id = $internal_question->user_form_id;
                  		$internal_question->user_email = DB::table('users')->where('id' , $internal_question->user_id)->pluck('name')->first();
                  	                         }
                  	                     }
                  	                      $ex_user_res = $ex_user_res ->merge($question_response2);

                        $rr=array();

                   // dd($users);
                  foreach ($ex_user_res as $ex_u_res) {
                  	     // echo "<pre>";
                  	     // print_r($ex_u_res->user_email.$users->user_email );
                  	     // // continue;
                  	if($ex_u_res->user_email == $users->user_email){
                        $flag = true;
                        $tempo =  $ex_u_res->question_response;
                        $exusres = explode(',',$tempo);
                        foreach ($exusres as $tt ) 
                        {
	  	    		    $rr[] = explode(',',$tt);
	  	                }
	  	               
                  	}

                 if($flag == true){
                 	  $finalar = array();
	  	        foreach ($rr as $jugar) {
	  	        	$finalar[]=$jugar[0];
	  	    	}
	  	    	$flag = false;
                 }


                  }
	  	   
              $exuserfrmid = DB::table('external_users_forms')->where('id' ,$users->external_user_form_id)->pluck('sub_form_id')->first();
              $form_name = DB::table('sub_forms')->where('id' ,$exuserfrmid)->pluck('title')->first();
              if($form_name == null) {
              	 $exuserfrmid = DB::table('user_forms')->where('id' ,$users->external_user_form_id)->pluck('sub_form_id')->first();
                 $form_name = DB::table('sub_forms')->where('id' ,$exuserfrmid)->pluck('title')->first();
              }
	  	     array_push($data, array(
	  	    	"email" => $users->user_email,
	  	    	"response" => $finalar,
	  	    	"sub_form_title" => $form_name
	  	    ));

              // $finalar = ',';

          }
      }
    // dd($data);
               return view('reports.detail_data_inventory',compact('final','data','option_questions'));
	  }


      // Global Data Inventory NEW
	  public function summary_reports_all(){

         $user = Auth::user()->id;
            $assigned_permissions =array();
            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if($data != null){
                 foreach ($data as $value) {
                $assigned_permissions = explode(',',$value);
                 
            }
            }
            if(Auth::user()->role != 3 ){
            if(!in_array('Global Data Inventory', $assigned_permissions)){
                return redirect('dashboard');
            }}
	  	  $option_questions = array();
	  	  $client_id = Auth::user()->client_id;
        $piaDpiaRop_ids = [2,9,12];


            $filled_questions = DB::table('external_users_forms')->select('*' )
               ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->pluck('question_key');
           
           $filled_questions_internal = DB::table('user_forms')->select('*' )
               ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->pluck('question_key');

          // $filled_questions = DB::table('external_users_filled_response')->pluck('question_key');
          // $filled_questions_internal = DB::table('internal_users_filled_response')->pluck('question_key');
          $filled_questions = $filled_questions->merge($filled_questions_internal);

          // dd($filled_questions);

	  	   $question  = DB::table('questions')->where('type','mc')->wherein('form_id' , $piaDpiaRop_ids )->wherein('form_key' , $filled_questions )->get();
         // dd($question);
	  	   $question = $question->unique('question');



	  	    foreach ($question as $value) {
	        $opt = array();

	  	    	 $option = $value->question;
	  	    	 $temporary_question  = DB::table('questions')->where('question' , $option )->pluck('form_key');

                 // $question_response = DB::table('external_users_filled_response')->wherein('question_key' , $temporary_question )->get();
                 // $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $temporary_question )->get();


                   $question_response = DB::table('external_users_forms')->select('*' )->wherein('external_users_filled_response.question_key' , $temporary_question )
                       ->join('external_users_filled_response' , 'external_users_forms.id' , '=' ,'external_users_filled_response.external_user_form_id')->where('external_users_forms.client_id' , $client_id)->get();


                  // $question_response2 = DB::table('internal_users_filled_response')->wherein('question_key' , $temporary_question )->get();

                   $question_response2 = DB::table('user_forms')->select('*' )->wherein('internal_users_filled_response.question_key' , $temporary_question )
                         ->join('internal_users_filled_response' , 'user_forms.id' , '=' ,'internal_users_filled_response.user_form_id')->where('user_forms.client_id' , $client_id)->get();



			     $question_response  = $question_response->merge($question_response2);    


                        $final_options_array= array();
                        $count = 0;
                        foreach ($question_response as $resp) {
                       
                            $remove_duplicate_options = array();
                        	$user_responses = explode(',',$resp->question_response);
                        	foreach ($user_responses as $pickoption) {
	  	       					  if(!in_array(trim($pickoption), $final_options_array))
	  	       					  { 
	  	       					  	// dd(str_contains($pickoption, "UTF-8"));
	  	       					  	if(mb_substr($pickoption, 0, 1, "UTF-8") != "{" )
	  	       					  	{
	  	       					  		if(strlen($pickoption) >1){
	  	       					  	        $final_options_array[]=trim($pickoption);
											}

                  	  	       					                                    }
	  	       					  }
                                   
                                                     }
                        }
                        	$count =count($final_options_array);

                        foreach ($final_options_array as $tt ) {
	  	    		        $opt[] = explode(',',$tt);
	  	    	                                              }
                        // print_r($final_options_array);

	  	    	 // $temp = DB::table('questions')->where('id',$value->id)->pluck('options')->first();
	  	    	                                              $final  =array();
	  	    foreach ($opt as $jugar) {
	  	        $final[]=$jugar[0];
	  	    	# code...
	  	    }
                 
                 $op_count = $count;
                 array_push($option_questions, array(
	  	    	  "question_string" => $option,
	  	    	  "op_count" => $op_count,
	  	    	   "options" => $final
	  	               ));	 
	  	    }

	  	    
	  	    // dd($final);

	  	  $mc_ids  = DB::table('questions')->where('type', 'mc' )->wherein('form_id' , $piaDpiaRop_ids )->pluck('form_key');
	  	  // dd('walla');
	  	  // $emails = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->select('user_email','external_user_form_id')->get();

	  	  // $emails = $emails->unique('external_user_form_id');
	  	  
          $data = array();
          $flag = false;
          $count = 0;
          // foreach($emails as $users){
                    // print_r($users->external_user_form_id);
                  $ex_user_res  = DB::table('external_users_filled_response')->wherein('question_key' , $mc_ids)->get();
                  $ex_user_res2  = DB::table('internal_users_filled_response')->wherein('question_key' , $mc_ids)->get();
              $ex_user_res  =$ex_user_res->merge($ex_user_res2);
                        $rr=array();

                  foreach ($ex_user_res as $ex_u_res) {
                  
                        $tempo =  $ex_u_res->question_response;
                        $exusres = explode(',',$tempo);
                        foreach ($exusres as $tt ) 
                        {
	  	    		    $rr[] = explode(',',$tt);
	  	                }
	  	               
                  	


                  }
                  // dd($rr);
                  $data = array();
	  	        foreach ($rr as $jugar) {
	  	        	$data[]=trim($jugar[0]);
	  	    	}
	  	    	// dd($option_questions);

	  	   
             
               return view('reports.global_data_inventory',compact('final','data','option_questions'));
	  
	  }
 
	//Detailed data inventory removed
	public function summary_reports_all_2removed(){

		// dd('sdjkhfsdjkhf');
		$client_id = Auth::user()->client_id;
		// dd($client_id);
		$form_id = [12,2];
		
		if (Auth::user()->role == 3 && Auth::user()->user_type != 1)
		{
			return abort('404');	
		}
		
		// get all unique internal and external users of organization
/* 		$users_list  = DB::select('SELECT DISTINCT external_users_forms.id, user_email as user, "ex" as type 
								   FROM   external_users_forms 
								   WHERE  external_users_forms.client_id = ?
								   UNION
								   SELECT users.id, name as user, "in" as type 
								   FROM   users 
								   JOIN   user_forms 
								   ON     users.id        = user_forms.user_id 
								   WHERE  users.client_id = ?', [$client_id, $client_id]); */

		// get all users with respective subforms
		
		$subject_form_name = DB::table('forms')->wherein('id', $form_id)->pluck('title')->first();

		$user_form_list = DB::select('SELECT external_users_forms.id, user_email as user, "ex" as type, sub_forms.id as sub_form_id, sub_forms.title as sub_form_title 
										FROM  external_users_forms
										JOIN   sub_forms 
										ON     sub_forms.id = external_users_forms.sub_form_id
										WHERE   external_users_forms.client_id = ? AND sub_forms.parent_form_id IN (2,12)
										UNION
										SELECT users.id, name as user, "in" as type, sub_forms.id as sub_form_id, sub_forms.title as sub_form_title 
										FROM   users 
										JOIN   user_forms 
										ON     users.id = user_forms.user_id 
										JOIN   sub_forms 
										ON     sub_forms.id = user_forms.sub_form_id AND sub_forms.parent_form_id IN (2,12)
										WHERE  users.client_id = ?', [$client_id, $client_id]);

		$user_count_list = array_count_values(array_column($user_form_list, 'user'));
		array_walk($user_form_list, function (&$user, $index) use($user_count_list) {
			if (isset($user_count_list[$user->user]) && $user_count_list[$user->user] > 1)
			{
				$user->user = $user->user.' '.'(<span class="dept-name">'.$user->sub_form_title.'</span>)';	
			}					
		});
		
//  	    echo "<pre>";
// 		print_r(($user_form_list));
// 		echo "</pre>";
// 		exit;
									  
		
		$data_category = 2;
		/*
		SELECT questions.id,questions.question,questions.form_key,questions.type,questions.options,questions.assoc_type
		FROM   questions 
		JOIN   form_questions ON questions.id = form_questions.question_id
		JOIN   forms          ON forms.id     = form_questions.form_id
		WHERE  questions.question_category = 2
		*/	
		
		$questions = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->where('form_questions.form_id',          12)
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type',
								'sort_order')
					   ->orderBy('sort_order')
					   ->get();
					   
					   $questions2 = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->where('form_questions.form_id',          2)
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type',
								'sort_order')
					   ->orderBy('sort_order')
					   ->get();
					   					   $questions = $questions->merge($questions2);

					   					   // $questions = $questions->unique('question');
					   					   // echo "<pre>";
					   					   //  print_r($questions);
					   					   //  exit();


					   
// 		echo "<pre>";
// 		print_r($questions);
// 		echo "</pre>";
// 		exit;
					   
		
		$in_user_responses = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id',12)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get();

$in_user_responses2 = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id',2)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get();
 
					        $in_user_responses = $in_user_responses->merge($in_user_responses2);
					        // dd($in_user_responses);
					        // $in_user_responses = $in_user_responses->unique('question_num');
	             				        // dd($in_user_responses);
							
		/*
		SELECT external_users_forms.id, sub_forms.id as subform_id, sub_forms.title, external_users_forms.user_email, sort_order, questions.question_num, questions.question, eufrq.question_response, external_users_forms.form_link
		FROM   external_users_forms
		JOIN   sub_forms                               ON sub_forms.id         = external_users_forms.sub_form_id AND external_users_forms.client_id = 76
		JOIN   forms                                   ON forms.id             = sub_forms.parent_form_id
		JOIN   form_questions                          ON forms.id             = form_questions.form_id
		JOIN   questions                               ON questions.id         = form_questions.question_id
		LEFT
		JOIN   external_users_filled_response AS eufrq ON questions.id         = eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id
		WHERE  questions.question_category = 2
		GROUP BY sub_forms.title, external_users_forms.user_email, questions.question
		ORDER BY form_questions.sort_order
		*/
		
		$ex_user_responses = DB::table('external_users_forms')
							->join('sub_forms', 'sub_forms.id',        									'=', 'external_users_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('external_users_filled_response AS eufrq'), 'questions.id',       '=', DB::raw('eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id', 12)
							->groupBy('sub_forms.title', 'external_users_forms.user_email', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title',
								'external_users_forms.user_email as user_email',								
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'eufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get();

					        $ex_user_responses2 = DB::table('external_users_forms')
							->join('sub_forms', 'sub_forms.id',        									'=', 'external_users_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('external_users_filled_response AS eufrq'), 'questions.id',       '=', DB::raw('eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id', 2)
							->groupBy('sub_forms.title', 'external_users_forms.user_email', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title',
								'external_users_forms.user_email as user_email',								
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'eufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get();

					        $ex_user_responses = $ex_user_responses->merge($ex_user_responses2);
					        // dd($ex_user_responses);

					        // $ex_user_responses = $ex_user_responses->unique('question_response');
							
//  		echo "<h1>In </h1>";					
// 		echo "<pre>";
// 		print_r($in_user_responses);
// 		echo "</pre>";							
							
// 		echo "<h1>Ex </h1>";					
// 		echo "<pre>";
// 		print_r($ex_user_responses);
// 		echo "</pre>";
// 		exit;  

				
		$in_curr_index = 0;
		$ex_curr_index = 0;
		
		foreach ($questions as $key => $question)
		{
			if (trim(strtolower($question->question)) == 'who is the data controller?')
			{
				$questions[$key]->question = 'Data Controller';
			}
			
			if (trim(strtolower($question->question)) == 'who is the data processor?')
			{
				$questions[$key]->question = 'Data Processor';				
			}
			
			while (isset($in_user_responses[$in_curr_index]) && $in_user_responses[$in_curr_index]->question_id == $question->id)
			{
				if (!empty($in_user_responses[$in_curr_index]->question_response))
				{
					$questions[$key]->user_responses['in'][$in_user_responses[$in_curr_index]->subform_id]
													      [$in_user_responses[$in_curr_index]->user_id] = ['response'   => $in_user_responses[$in_curr_index]->question_response,
					                                                                                       'user_name'  => $in_user_responses[$in_curr_index]->name];				
				}
				
				$in_curr_index++;				
			}
			
			while (isset($ex_user_responses[$ex_curr_index]) && $ex_user_responses[$ex_curr_index]->question_id == $question->id)
			{
				if (!empty($ex_user_responses[$ex_curr_index]->question_response))
				{
					$questions[$key]->user_responses['ex'][$ex_user_responses[$ex_curr_index]->subform_id]
													      [$ex_user_responses[$ex_curr_index]->user_email] = ['response'   => $ex_user_responses[$ex_curr_index]->question_response,
					                                                                                          'user_email' => $ex_user_responses[$ex_curr_index]->user_email];	
				}
				
				$ex_curr_index++;
			}
						
		}
		
//  		echo "<pre>";
// 		print_r($user_form_list);
// 		echo "</pre>";
//         echo "<h1>Questions</h1>";		
// 		echo "<pre>";
// 		print_r($questions);
// 		echo "</pre>";		
		
//   		exit;	


// $arra;
// foreach ($questions as $value) {
// 	if(isset($value->user_responses)){
// 		$arra[]=$value;
// 	}
// 	# code...
// }

		echo "<pre>";
					           print_r($questions);
					           exit();
    // dd($array);
    // $art = $arra->unique('options');
    // dd($art);
		// echo "<pre>";
		// print_r($questions);
  //  exit();
		return view('reports.detailed_reports', [
			'user_form_list'  => $user_form_list,
			'questions' 	  => $questions,
			'form_name'       => $subject_form_name
			//'user_list' 	=> $user_list,			
		]);
	}

	//Global Data inventory REMOVED}}
	//remove   '_removed'  to re enable
	public function summary_reports_all_REMOVED ()
	{
		$client_id = Auth::user()->client_id;
		$form_id = [2];
		
		if (Auth::user()->role == 3 && Auth::user()->user_type != 1)
		{
			return abort('404');	
		}
		
		$sfn = [2];
		// dd('asldjaskldlkjasd');
		
		$subject_form_name = DB::table('forms')->wherein('id', $sfn)->pluck('title');
		// dd($subject_form_name);
		$user_form_list = DB::select('SELECT external_users_forms.id, user_email as user, "ex" as type, sub_forms.id as sub_form_id, sub_forms.title as sub_form_title 
										FROM  external_users_forms
										JOIN   sub_forms 
										ON     sub_forms.id = external_users_forms.sub_form_id
										WHERE   (external_users_forms.client_id = ?) AND (sub_forms.parent_form_id In (2) )
										UNION
										SELECT users.id, name as user, "in" as type, sub_forms.id as sub_form_id, sub_forms.title as sub_form_title 
										FROM   users 
										JOIN   user_forms 
										ON     users.id = user_forms.user_id 
										JOIN   sub_forms 
										ON     sub_forms.id = user_forms.sub_form_id AND (sub_forms.parent_form_id in (2))
										WHERE  users.client_id = ?', [$client_id, $client_id]);
		

		$user_count_list = array_count_values(array_column($user_form_list, 'user'));
		array_walk($user_form_list, function (&$user, $index) use($user_count_list) {
			if (isset($user_count_list[$user->user]) && $user_count_list[$user->user] > 1)
			{
				$user->user = $user->user.' '.'(<span class="dept-name">'.$user->sub_form_title.'</span>)';	
			}					
		});
			// dd($user_count_list);						  
		
		$data_category = 2;
			
		
		$questions = DB::table('questions')
		               ->join('form_questions', 'questions.id',   '=', 'form_questions.question_id')
					   ->join('forms', 'forms.id',                '=', 'form_questions.form_id')
					   ->wherein('form_questions.form_id',  $form_id)
					   ->where('questions.question_category',     '=', $data_category)
					   ->select('questions.id', 
					            'questions.question',
								'questions.form_key',
								'questions.type',
								'questions.options',
								'questions.question_assoc_type',
								'sort_order')
					   ->orderBy('sort_order')
					   ->get()
					   ->toArray();

					   // dd($questions)

					   
		
		$in_user_responses = DB::table('users')
		                    ->leftjoin('user_forms', 'users.id',       									'=', DB::raw('user_forms.user_id AND user_forms.client_id = '.$client_id))
							->join('sub_forms', 'sub_forms.id',        									'=', 'user_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('internal_users_filled_response AS iufrq'), 'questions.id',       '=', DB::raw('iufrq.question_id AND sub_forms.id = iufrq.sub_form_id AND users.id = iufrq.user_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id',         '=',  $form_id)
							->groupBy('sub_forms.title', 'users.name', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title', 
					            'users.id        as user_id',
								'users.name',
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'iufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get()
					        ->toArray();
							
		
		
		$ex_user_responses = DB::table('external_users_forms')
							->join('sub_forms', 'sub_forms.id',        									'=', 'external_users_forms.sub_form_id')
					        ->join('forms', 'forms.id',                									'=', 'sub_forms.parent_form_id')
							->join('form_questions', 'forms.id',       									'=', 'form_questions.form_id')
							->join('questions', 'questions.id',       									'=', 'form_questions.question_id')
		                    ->leftjoin(DB::raw('external_users_filled_response AS eufrq'), 'questions.id',       '=', DB::raw('eufrq.question_id AND external_users_forms.id = eufrq.external_user_form_id'))			
					        ->where('questions.question_category',     '=', $data_category)
					        ->where('form_questions.form_id',         '=',  $form_id)
							->groupBy('sub_forms.title', 'external_users_forms.user_email', 'questions.question')
							->orderBy('form_questions.sort_order')							
					        ->select(
								'sub_forms.id    as subform_id',
								'sub_forms.title as subform_title',
								'external_users_forms.user_email as user_email',								
								'sort_order',
								'questions.id as question_id',
								'questions.question_num',
								'questions.form_key',
								'questions.question', 
								'eufrq.question_response',
								'questions.question_assoc_type',
								'sort_order')//->toSql();
					        ->get()
					        ->toArray();

				
		$in_curr_index = 0;
		$ex_curr_index = 0;
		
		foreach ($questions as $key => $question)
		{
			if (trim(strtolower($question->question)) == 'who is the data controller?')
			{
				$questions[$key]->question = 'Data Controller';
			}
			
			if (trim(strtolower($question->question)) == 'who is the data processor?')
			{
				$questions[$key]->question = 'Data Processor';				
			}
			
			while (isset($in_user_responses[$in_curr_index]) && $in_user_responses[$in_curr_index]->question_id == $question->id)
			{
				if (!empty($in_user_responses[$in_curr_index]->question_response))
				{
					$questions[$key]->user_responses['in'][$in_user_responses[$in_curr_index]->subform_id]
													      [$in_user_responses[$in_curr_index]->user_id] = ['response'   => $in_user_responses[$in_curr_index]->question_response,
					                                                                                       'user_name'  => $in_user_responses[$in_curr_index]->name];				
				}
				
				$in_curr_index++;				
			}
			
			while (isset($ex_user_responses[$ex_curr_index]) && $ex_user_responses[$ex_curr_index]->question_id == $question->id)
			{
				if (!empty($ex_user_responses[$ex_curr_index]->question_response))
				{
					$questions[$key]->user_responses['ex'][$ex_user_responses[$ex_curr_index]->subform_id]
													      [$ex_user_responses[$ex_curr_index]->user_email] = ['response'   => $ex_user_responses[$ex_curr_index]->question_response,
					                                                                                          'user_email' => $ex_user_responses[$ex_curr_index]->user_email];	
				}
				
				$ex_curr_index++;
			}
						
		}
	
	    // dd($subject_form_name);
		
		return view('reports.summary_reports_all', [
			'user_form_list'  => $user_form_list,
			'questions' 	  => $questions,
			'form_name'       => $subject_form_name
			//'user_list' 	=> $user_list,			
		]);
	}	
		
}
