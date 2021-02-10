@extends('admin.client.client_app')
@section('content')
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Export-Table-Data-To-CSV-File-table2csv/src/table2csv.js"></script>


  <style>
        .set_heading {
      text-align: center;
      font-size: 15px;
      color: gray;
    }
    .table-responsive {
      background: #fff;
    }
    .set_heading {
        border-right: 9px solid #fff !important;
    }
    .table td, .table th {
    /*border-left: 9px solid #fff !important;*/
    /*border: none !important;*/
    border-bottom: 0 !important;
    /*border-bottom-color: rgba(110, 111, 115, 0.51);
    border-bottom-style: solid;
    border-bottom-width: 3px;*/
    }
    .table td, .table th {
      border-top:  0 !important;
    }
    .set_heading , .set_bg {
        background: #dfdfdfb3;
        /*color: #fff;*/
    }
    .styling {
      font-size: 18px !important;
      color: #1cc88a !important;
    }
    .table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
    border-radius: 14px;
    filter: drop-shadow;
    font-size: 15px;
    }
    .table thead th {
        vertical-align: bottom;
        font-size: 16px;
    }
    .table-responsive {
        min-height: 200px;
      }
      .add_color {
        color: #1cc88a;
      }
      .coloring span {
         color: #1cc88a;
         font-weight: 600;
      }
      .table-sm {
        font-size: 14px;
      }
      .print_exp {
        margin-bottom: .5rem;
      }
  </style>

      <div class="container-fluid">
        <h3>Data inventory</h3>
        <!-- <button id="dl" class="btn btn-primary">Download</button> -->
          
   <div style="float: right;"> <a href="{{url('/Reports/AssetsReportsEx/2')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Export</a></div>
          <div class="table-responsive">
      <table class="table table table-responsive-sm text-center" id="tab">
        <thead>
          
          <tr>
             @if(count($option_questions))
                 <th class="set_heading">  Question </th> 
             @endif
          
          @foreach($option_questions as $quest_heading)
          <th class="set_heading" colspan="{{$quest_heading['op_count']}}" >{{$quest_heading['question_string']}}</th>
          @endforeach
          </tr>
          <tr>
          

          

            
                <td class="coloring"> <!-- <span> User </span> |  Option --> </td>
                @if($final != null)
               @foreach($final as $options)   
               <td  id="{{$options}}" class="table-sm">{{$options}}</td>        
              @endforeach
              @endif


          </tr>
        </thead>
        <tbody>
          @foreach($data as $responses)
          <!-- user -->
          <tr>
              <td class="add_color table-sm">{{$responses['email']}} ( {{$responses['sub_form_title']}}) </td>
            
               @foreach($final as $options)
               <!-- options -->
                  <?php
                       $flag = false;
                           ?>
                   @foreach($responses['response'] as $res )

                   @if(  trim($res) == trim($options)  ) 
                               
                         <!-- {{trim($res)}} -->
                         <td> <i class="fa fa-check-circle styling"></i> </td>
                         <?php

                                $flag = true;
                                break;
                           ?>
                         @endif
                    @endforeach     
                          <?php
                                if($flag == false){
                                  ?>
                                 <td class="blank">-</td>
                                  <?php
                                }
                           ?>
                           @endforeach
                           </tr>
                           @endforeach
                 




          


        </tbody>


      </table>
</div>
      </div>
<script>
  /* global $ */
  $("#dl").click(function(){
    $("#tab").table2csv('output', {appendTo: '#out'});
    $("#tab").table2csv();
  })
</script>
@endsection