@extends(($user_type=='admin')?('admin.layouts.admin_app'):('admin.client.client_app'))
@section('content')
@if (Auth::user()->role == 1)
<div class="app-title">
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
    </li>
    <li class="breadcrumb-item"><a href="{{URL::current()}}"></a>
    </li>
  </ul>
</div>
@endif
@if (session('alert'))
    <div class="alert alert-primary">
        {{ session('alert') }}
    </div>
@endif

<div class="row" style="padding-left:20px; padding-right:12px;">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title"></h3>
      
      <div class="table-responsive">
        


          <table class="table" id="report_table">
        <thead>
          
         <tr>
             @if(count($option_questions))
                 <th class="set_heading">  Question:: </th> 
             @endif
          
          @foreach($option_questions as $quest_heading)
          <td class="set_heading"  >{{$quest_heading['question_string']}}</td>

          <?php  $opcount = (int)$quest_heading['op_count'];  ?>

            
         
          
            @if($opcount > 1)
               @for ($i = $opcount-1 ; $i > 0 ; $i--)
                   <td> ... </td>
                @endfor
            @endif

            <?php $opcount = 0;  ?>

           @endforeach

          </tr>
   
           </tr> 
<tr>
  <!-- <td></td>              -->
                <th class="coloring"> Options::  </th>
                @if($final != null)
               @foreach($final as $options)   
               <td  id="{{$options}}" class="table-sm">{{$options}}   </td>        
              @endforeach
              @endif


          </tr>


        </thead>
        <tbody>
        
          <tr>
            <th>User Responses::</th>
            @if($final != 0)
               @foreach($final as $options)
               
                         <td> {{$options}} </td>
                      
                    @endforeach   

              @endif        
                         
                            
                 




          


        </tbody>


      </table>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  
    // Setup - add a text input to each footer cell
    // $('#report_table thead tr').clone(true).appendTo('#report_table thead'); 
    $('#report_table thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
        // $(this).html('<input type="text" placeholder="Search '+title+'" />');
 
        $('input', this ).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        });
    
    });
  
//  var table = $('#report_table').DataTable({
//         orderCellsTop: true,
//         //fixedHeader: true
//     });  
 
  var table = $('#report_table').DataTable({
          orderCellsTop: true,
            dom: 'Bfrtip',
            "pageLength": 15,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                // 'pdfHtml5'
            ]
        });


});
</script>
@endsection