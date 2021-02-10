
@extends('admin.client.client_app')



@section('content')

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

  <style>
    .set_heading {
      min-width: 10% !important;
    max-width: 152px;
    width: 65%; 
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
      font-size: 14px !important;
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
      table {
        white-space: initial !important;
      }
      .table-sm {
        font-size: 16px;
      }
      .check {
        text-align: right;
    width: 50%;
      }
      .check i {
        font-size: 21px !important;
      }
  </style>   
  <div style="float: right;"> <a href="{{url('/Reports/AssetsReportsEx/1')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Export</a></div>

      <div class="container-fluid">
        <h3>Global data inventory</h3>
        <!-- <a href="{{url('/Reports/AssetsReportsEx/1')}}" > <button type="button" class="Export btn btn-primary">Export</button></a> -->
    
                                    
          <div class="table-responsive" >
      <table    class="table table table-responsive-sm " id="report_table">
        

        <head>
      @foreach($option_questions as $row)
          <tr>
          <th class=" set_heading table-sm" >{{$row['question_string']}}</th>
          </tr>
       @foreach($row['options'] as $opt)
          <tr> 
             <td class="styling table-sm">{{$opt}} </td>
             <td>
              <div class="check">
                <i class="fa fa-check-circle styling"></i>
              </div>
             </td>      
             </tr>

             @endforeach
          
          @endforeach

                 </head>
       

      </table>
</div>


      </div>



       
@endsection