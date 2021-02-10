@extends('admin.client.client_app')

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"/>

<style>
        <!-- table style -->
    table.stats-table,
    .stats-table th,
    .stats-table td {
		border: 1px solid black;
		border-collapse: collapse;
		padding: 6px;
		text-align: center;
    }
    .table-bordered td, .table-bordered th {
        /*border: 1px solid #00000047;*/
        background: #fff;
    border: none;
    border-bottom: 1px solid #efefef;
    }
    .stats-table {
      border: none;
    }
    .stats-table tr {
      border: 1px dotted dashed #bbbbbbbb;
    }
    .stats-table table { 
		border-collapse: collapse !important ;
	}
	.stats-table tr { 
	border: none  !important ;  
	}
	.stats-table td {
		/*border-right: dotted 1.5px #000 !important;
		border-left: dotted 1px #000 !important;*/
		text-align: center;
	}
	.table p {
       margin-bottom: 0;
        margin-left: 2px;
         font-size: 12px;
         margin-top: 14px;    
	}
	.not_cmplt {
	    color: #f26925;
	}
	.cmplt {
	    color: #1cc88a;
	}
  #map_wrapper {
    height: 400px;
    margin-bottom: 2rem;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
.set_bg {
  background: #fff;
}
.top_table h4 {
  margin: 0;
  padding: 15px;
  font-size: 20px;
  font-weight: 700;
}
.set_bg .table thead th {
  border-top: 0;
}
.mapouter {
  margin-bottom: 2rem;
}
.mapouter , .gmap_canvas {
  width: auto !important;
  height: auto !important;
}
.mapouter iframe {
  width: 100% !important;
  
}
.mapouter{
  position:relative;text-align:right;height:500px;
  }
.gmap_canvas {
    overflow:hidden;background:none!important;height:500px;width:600px;
    /*-webkit-filter: grayscale(100%) !important;*/
       /* -moz-filter: grayscale(100%)!important;
        -ms-filter: grayscale(100%) !important;
        -o-filter: grayscale(100%) !important;*/
         /*filter: grayscale(100%) !important;*/
  }
  .gm-style-iw {
        text-align: center;
  }
</style>


    <!-- table style -->
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="tile-title">Dashboard</h3>
            
            <!--<a href="{{url('/send_email/'.Auth::user()->id)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin-left: 660px;"><i class="fas fa-envelope fa-sm text-white-50"></i> Send Email</a>-->
            <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
          </div>

            @if (isset($sar_pending_request_info) && $sar_pending_request_info['request_count'] > 0)
            <div class="row">
                <div class="col col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="row">
                            <span><b>SAR Request(s) Action Pending: </b><span style="font-size:14px"><b>{{$sar_pending_request_info['request_count']}}</b> Pending request(s) due within 10 days. 
                               Visit <a href="{{url('SAR/SARCompletedFormsList')}}" class="alert-link">SAR Requests Page</a> to complete remaining requests</span>
                           </span>                           
                        </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            
                    </div>
                </div>

            </div>
            @endif
            
          <!-- Page Heading -->

        

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="{{url('Forms/FormsList')}}">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Assessment Forms</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$forms_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </a>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Sub Forms</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$subforms_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clone fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Users</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$total_users}}</div>
                        </div>
                        <div class="col">
                          <!-- <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>            

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Organization Users</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$org_users_count}}</div>
                        </div>
                        <div class="col">
                          <!-- <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total External Users</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$ext_users_count}}</div>
                        </div>
                        <div class="col">
                          <!-- <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="far fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Forms Shared</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_shared_forms}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-share fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          

          <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Completed Form</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_completed_forms}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Incomplete Forms</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_incomplete_forms}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-times fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
   
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <a href="{{url('activities')}}">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Activities</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_activities}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-assistive-listening-systems fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                </a>
              </div>
            </div>

	    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <a href="{{url('SAR/SARCompletedFormsList')}}">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Completed SAR Forms</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_sar_completed_forms}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                </a>
              </div>
            </div>  


	    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <?php if (isset($sar_subform_id) && !empty($sar_subform_id)): $search_filter = urlencode('Not Submitted'); ?>
                <a href="{{url('SAR/OrgSubFormsList/'.$sar_subform_id.'/?search_filter='.$search_filter)}}">
                <?php endif; ?>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Incomplete SAR Forms</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_sar_incomplete_forms}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                <?php if (isset($sar_subform_id) && !empty($sar_subform_id)): ?>
                </a>
                <?php endif; ?>
              </div>
            </div>  
            
	    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <a href="{{url('incident')}}">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Incident Register Forms</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_incident_register_forms}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>                    
                </a>
              </div>
            </div>   

	    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <a href="{{url('SAR/SARCompletedFormsList?search_filter=Completed')}}">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed SAR Requests</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sar_completed_requests}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                </a>
              </div>
            </div>           
 
	    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                    <a href="{{url('SAR/SARCompletedFormsList?search_filter=Pending')}}">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Incomplete SAR Requests</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sar_incomplete_requests}}</div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-times fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                    </a>
              </div>
            </div>          
          
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <!--<div class="col-xl-8 col-lg-7">-->
            

            <!-- Pie Chart -->
            <!--<div class="col-xl-4 col-lg-5">-->
            <!--  <div class="card shadow mb-4">-->
                <!-- Card Header - Dropdown -->
            <!--    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">-->
            <!--      <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>-->
            <!--      <div class="dropdown no-arrow">-->
            <!--        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>-->
            <!--        </a>-->
            <!--        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">-->
            <!--          <div class="dropdown-header">Dropdown Header:</div>-->
            <!--          <a class="dropdown-item" href="#">Action</a>-->
            <!--          <a class="dropdown-item" href="#">Another action</a>-->
            <!--          <div class="dropdown-divider"></div>-->
            <!--          <a class="dropdown-item" href="#">Something else here</a>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
                <!-- Card Body -->
            <!--    <div class="card-body">-->
            <!--      <div class="chart-pie pt-4 pb-2">-->
            <!--        <canvas id="myPieChart"></canvas>-->
            <!--      </div>-->
            <!--      <div class="mt-4 text-center small">-->
            <!--        <span class="mr-2">-->
            <!--          <i class="fas fa-circle text-primary"></i> Direct-->
            <!--        </span>-->
            <!--        <span class="mr-2">-->
            <!--          <i class="fas fa-circle text-success"></i> Social-->
            <!--        </span>-->
            <!--        <span class="mr-2">-->
            <!--          <i class="fas fa-circle text-info"></i> Referral-->
            <!--        </span>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->
          </div>


 <!-- ahmd strt -->



<!-- ahmad ed -->



         <div class="mapouter">
          <div class="gmap_canvas"><!-- <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe> -->
          <div id='map_canvas' style="position:relative; width:auto; height:400px;">

            
          </div> 
        </div>
      </div>

<hr>
        

           <?php 
        $client_id = Auth::user()->client_id;
        $assets = DB::table('assets')->where('client_id' , $client_id )->get(); ?> 
         <?php if (!empty($assets)): ?>
          <div class="row">
             <div class="col-lg-12">
              <h4 class="stats-table text-center"> Asset List </h4>
            <table  class="table table-hover table-striped table-bordered stats-table" id="example">
              <tr>
                <th>#</th>
                <th   style="vertical-align:middle;text-align:center">Asset Type</th>
                <th   style="vertical-align:middle;text-align:center">Asset Name</th>
                <th  style="text-align:center">
                   Hosting Type
                </th>
                <th  style="text-align:center">
                   Hosting Provider
                </th>
                <th  style="text-align:center">
                   Country
                </th>
                <th  style="text-align:center">
                   City
                </th>
                <th style="text-align:center">
                   State
                </th>
                
              </tr>
              <?php
                 $count = 1;
               foreach ($assets as $ass): ?>
              <tr>
                <!-- <?php   ?> -->
                <td>{{$count}}</td>    <?php $count++; ?>
                <td style="text-align:center">{{$ass->asset_type}}</td>
                <td style="text-align:center">{{$ass->name}}</td>
                <td style="text-align:center">{{$ass->hosting_type}}</td>
                <td style="text-align:center">{{$ass->hosting_provider}}</td>
                <td style="text-align:center">{{$ass->country}}</td>
                <td style="text-align:center">{{$ass->city}}</td>
                <td style="text-align:center">{{$ass->state}}</td>

               
              </tr> 
              <?php endforeach; ?>
            </table>
            </div>
          </div>
        <?php endif; ?>
        <hr>
     






        <?php if (!empty($form_completion_stats)): ?>
          <div class="row">
             <div class="col-lg-12">
              <h4 class="stats-table text-center">  Form List </h4>
            <table  class="table table-hover table-striped table-bordered stats-table" id="table-id">
              <tr>
                <th style="vertical-align:middle;text-align:center">#</th>
                <th colspan="1"  style="vertical-align:middle;text-align:center">Form Name</th>
                <th colspan="1"  style="vertical-align:middle;text-align:center">No. of Subforms</th>
                <th colspan="2" style="text-align:center">
                    External User Forms <br> <p> <span class="cmplt"> Complete </span> | <span class="not_cmplt"> Not Complete </span> </p>
                </th>
                <th colspan="2" style="text-align:center">
                    Org. User Forms <br>     <p> <span class="cmplt"> Complete </span> | <span class="not_cmplt"> Not Complete </span> </p>
                </th>
              </tr>
              <?php 
              $count = 1;
              foreach ($form_completion_stats as $key => $stats): ?>
              <tr>
                <td>{{$count}}</td>    <?php $count++; ?>
                <td>{{$stats['form_name']}}</td>
                <td><a href="{{url('Forms/SubFormsList/'.$key)}}">{{$stats['subforms_count']}}</a></td>
                <td>{{isset($stats['external'])?($stats['external']['completed']):(0)}}</td>
                <td>{{isset($stats['external'])?($stats['external']['not_completed']):(0)}}</td>
                <td>{{isset($stats['internal'])?($stats['internal']['completed']):(0)}}</td>
                <td>{{isset($stats['internal'])?($stats['internal']['not_completed']):(0)}}</td>
              </tr> 
              <?php endforeach; ?>
            </table>
            <div class="table_footer">
            <div class="table_pegination">
              <nav>
                <ul class="pager pagination">
                  <li data-page="prev" class="pager__item pager__item--prev"><span class="pager__link fa fa-angle-left">
                  <span class="sr-only">(current)</span></span></li>
                  <li data-page="next" id="prev" class="pager__item pager__item--prev"><span class="pager__link fa fa-angle-right">
                  <span class="sr-only">(current)</span></span></li>
                </ul>
              </nav>
            </div>
            <div class="table_rows">
              <div class="rows_main">
                <p>Rows per page</p>
                <select name="state" id="maxRows">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                </select>
              </div>
            </div>
          </div>
      </div>

    </div>

  </div>

</div>
            </div>
          </div>
        <?php endif; ?>




        <!-- incident controll -->
           <?php  
            

      $incident_type = DB::table('incident_type')->get();
      // dd($incident_type);
      $organization  = DB::table('users')->where('role',4)->get();
      $user_type = Auth::user()->role;
      $currentuserid = Auth::user()->id;
      if ($user_type == 2 || Auth::user()->user_type == 1){
        $incident_front = DB::table('incident_register')->where('organization_id',Auth::user()->client_id)->where('incident_status' , '!=', 'Resolved')
        ->orderBy('date_discovered', 'ASC')
        ->get();
      }
      else {
        $incident_front = DB::table('incident_register')->where('created_by',$currentuserid)->where('incident_status' , '!=', 'Resolved')
        ->orderBy('date_discovered', 'ASC')
        ->get();

      }


      $incident_register = DB::table('incident_register')->where('incident_status' , '!=', 'Resolved')->orderBy('date_discovered', 'ASC')->get();





            ?>

  <hr>
            <div class="row">
  <div class="col-md-12">
    <div class="tile">
              <h4 class="stats-table text-center">  Incident List </h4>

      
      <div class=" table table-responsive">
        <table class="table table-hover table-striped table-bordered stats-table" id="">
          <thead class=" ">
            <tr>
              <th>#</th>
              <th style="text-align:center">Incident Name</th>
               <th style="text-align:center">Type</th>
                <th style="text-align:center">Organization</th>
                <th style="text-align:center">Assignee</th>
                            <th style="text-align:center">Root Cause</th>
                            <th style="text-align:center">Date Discovered</th>
                            <th style="text-align:center">Deadline Date</th>
                            <th style="text-align:center">Status</th>
                            <th style="text-align:center">Date</th>
             
            </tr>
          </thead>
                    @if($user_type=='1')
          <tbody>
            <?php $count = 1; ?>
            @foreach($incident_register as $row)
            <tr>
                <td>{{$count}}</td>    <?php $count++; ?>
                <td style="text-align:center">{{$row->name}}</td>
                <td style="text-align:center"><?php $incident  = DB::table('incident_type')->where('id',$row->incident_type)->first();?> {{ $incident->name}}</td>
                <td style="text-align:center"><?php $org  = DB::table('users')->where('id',$row->organization_id)->first();?> {{ $org->company}}</td>
                            <td style="text-align:center">{{$row->assignee}}</td>
                            <td style="text-align:center">{{$row->root_cause}}</td>
                            <td><a href="" class="btn btn-dark btn-sm nowrap_btn"  data-toggle="modal" data-val="{{$row->root_cause}}"  data-target='#practice_modal' ><i class="fa fa-eye mr-2"></i>See Detail</a></td>
                            <td style="text-align:center">{{$row->date_discovered}}</td>
                            <td style="text-align:center">{{$row->deadline_date}}</td>
                            <td style="text-align:center">{{$row->incident_status}}</td>
                            <td style="text-align:center">{{$row->created_at}}</td>
             
            </tr>
            @endforeach
          </tbody>
                    @else
                    <tbody>
    <?php $count = 1; ?>
                        @foreach($incident_front as $row)
                        <tr>
                          <td>{{$count}}</td>    <?php $count++; ?>

                            <td>{{$row->name}}</td>
                            <td><?php $incident  = DB::table('incident_type')->where('id',$row->incident_type)->first();?> {{ $incident->name}}</td>
                            <td><?php $org  = DB::table('users')->where('id',$row->organization_id)->first();?> {{ $org->company}}</td>
                            <td>{{$row->assignee}}</td>
                            <td><a href="" class="btn btn-dark btn-sm nowrap_btn"  data-toggle="modal" data-val="{{$row->root_cause}}"  data-target='#practice_modal' ><i class="fa fa-eye mr-2"></i>See Detail</a></td>
                            <td>{{$row->date_discovered}}</td>
                            <td>{{$row->deadline_date}}</td>
                            <td>{{$row->incident_status}}</td>
                            <td>{{$row->created_at}}</td>
                            
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
            $(document).ready(function() {

              $('#example').DataTable();

            $('#orgs').DataTable( {

                "order": [[ 5, "asc" ]]

            } );

        } );



        </script>
    
        <!-- end of incident -->
          <!-- <div class="set_bg">
              <div class="top_table">
                <h4>Sources</h4>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
          </div> -->

          <!-- Content Row -->
        <!--  <div class="row">-->

            <!-- Content Column -->
        <!--    <div class="col-lg-6 mb-4">-->

              <!-- Project Card Example -->
        <!--      <div class="card shadow mb-4">-->
        <!--        <div class="card-header py-3">-->
        <!--          <h6 class="m-0 font-weight-bold text-primary">Projects</h6>-->
        <!--        </div>-->
        <!--        <div class="card-body">-->
        <!--          <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>-->
        <!--          <div class="progress mb-4">-->
        <!--            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>-->
        <!--          </div>-->
        <!--          <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>-->
        <!--          <div class="progress mb-4">-->
        <!--            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>-->
        <!--          </div>-->
        <!--          <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>-->
        <!--          <div class="progress mb-4">-->
        <!--            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>-->
        <!--          </div>-->
        <!--          <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>-->
        <!--          <div class="progress mb-4">-->
        <!--            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>-->
        <!--          </div>-->
        <!--          <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>-->
        <!--          <div class="progress">-->
        <!--            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>-->
        <!--          </div>-->
        <!--        </div>-->
        <!--      </div>-->

              
              

        <!--    </div>-->

        <!--    <div class="col-lg-6 mb-4">-->

              <!-- Illustrations -->
        <!--      <div class="card shadow mb-4">-->
        <!--        <div class="card-header py-3">-->
        <!--          <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>-->
        <!--        </div>-->
        <!--        <div class="card-body">-->
        <!--          <div class="text-center">-->
        <!--            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="frontend/images/undraw_posting_photo.svg" alt="">-->
        <!--          </div>-->
        <!--          <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>-->
        <!--          <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>-->
        <!--        </div>-->
        <!--      </div>-->

             
              
        <!--    </div>-->
        <!--  </div>-->

        <!--</div>-->

  <script type="text/javascript" src="//www.gstatic.com/charts/loader.js"></script>
<script src="https://knockoutjs.com/downloads/knockout-2.2.1.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&.js"></script>
<script src="https://rawgit.com/kangax/fabric.js/master/dist/fabric.js"></script>
<script src="https://knockoutjs.com/downloads/jquery.tmpl.min.js"></script>






    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      //google.charts.setOnLoadCallback(drawChart);
      
      google.charts.setOnLoadCallback(formUsers);

    //   function drawChart() {
    //     var data = google.visualization.arrayToDataTable([
    //       ['Forms', 'Total Users', 'Filled'],
    //       ['2014', 232, 23],
    //       ['2015', 67, 76],
    //       ['2016', 789, 73],
    //       ['2017', 345, 46]
    //     ]);
    
        function formUsers ()
        {
            var data = google.visualization.arrayToDataTable([
                ['Number of Form Users', 'Total Users', 'Internal', 'External'],
            <?php
                $last_element = end($num_of_form_users);
                foreach ($num_of_form_users as $key => $form_info):
                    $name     = $form_info['name'];
                    $internal = $form_info['internal']??0;
                    $external = $form_info['external']??0;
                    $total    = $form_info['total'];
                    $comma    = ',';
                    if ($form_info == $last_element)
                    {
                        $comma = '';
                    }
                    
            ?>
                ['{{$name}}', {{$total}}, {{$internal}}, {{$external}}]{{$comma}}
            <?php endforeach; ?>
            ]);

        var options = {
            chart: {
                // title: 'Company Performance',
                // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
            },
            //bars:    'vertical', // Required for Material Bar Charts.
            bars: 'horizontal',
            colors: ['#4e72df', '#f26925', '#f6c23e'],
            hAxis:  {
                      showTextEvery:1,
                      textStyle: {
           //           'fontSize':'5'
                    }
            },
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <input type="hidden" id="lat_value" value="<?php echo htmlentities(json_encode($lat_value)); ?>">
    <input type="hidden" id="lat_detail" value="<?php echo htmlentities(json_encode($lat_detail)); ?>">

    <script>






      
      var lat_value = [];
      var lat_detail = [];
      jQuery(function($) {

        lat_value = JSON.parse(document.getElementById("lat_value").value);
        lat_detail = JSON.parse(document.getElementById("lat_detail").value);
        console.log({
          "lat_value": lat_value
        });
        

    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyDaCml5EZAy3vVRySTNP7_GophMR8Niqmg&callback=initialize&libraries=&v=beta&map_ids=66b6b123dade7a4d";
    document.body.appendChild(script);
});
 
function initialize() {


//above lines were put for var map, for api key

			
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap' 
        
    };

    
                    
    map = new google.maps.Map(document.getElementById("map_canvas"), {
    mapId: "66b6b123dade7a4d",
    
  });
    
	
	
	


	
	
	var markers = lat_value;
    var html = '';
    var windowArray = [];

     var ct = "";

    var windowArray = [];

    for(var r = 0; r < lat_detail.length; r++){
      ct = "";
        
        if ( lat_detail[r][1]  != null )
        {
           ct += '<p class="info_content"><strong>City :</strong>  '+lat_detail[r][1]+'</p>';
        }


    if ( lat_detail[r][2]  != null )
    {
        ct += '<p class="info_content"><strong>State :</strong> '+lat_detail[r][2]+'</p></div>';
    }
    
    


// var html = [''. $string];

      var html = ['<div class="info_content"><p> <strong>Country :</strong> '+lat_detail[r][0]+'</p>' +
         '<p><strong>Asset Name :</strong> '+lat_detail[r][3]+'</p>'  + '<p class="info_content"><strong>Hosting provider  :</strong> '+lat_detail[r][4]+'</p>' + '<p class="info_content"><strong>Asset type :</strong> '+lat_detail[r][5]+'</p>' + ct];
         // html+=string;

        windowArray.push(html);

    }

    console.log(windowArray);

    

    for(var r = 0; r < markers.length; r++){

      bounds = new google.maps.LatLngBounds();



        var position = new google.maps.LatLng(markers[r][1], markers[r][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[r][0]
        });

        


        var infoWindow = new google.maps.InfoWindow(), marker, r;

         google.maps.event.addListener(marker, 'click', (function(marker, r) {
            return function() {
                infoWindow.setContent(windowArray[r][0]);
                infoWindow.open(map, marker);
            }
        })(marker, r));

         console.log(bounds);

        map.fitBounds(bounds);

    }
    

        
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(1.7);
        // this.setTilt('pakistan');
        google.maps.event.removeListener(boundsListener);
    });
	
    
}



    </script>

     <script>
    getPagination('#table-id');
  
    function getPagination(table) {
      var lastPage = 1;

      $('#maxRows')
        .on('change', function(evt) {
          //$('.paginationprev').html('');            // reset pagination

        lastPage = 1;
          $('.pagination')
            .find('li')
            .slice(1, -1)
            .remove();
          var trnum = 0; // reset tr counter
          var maxRows = parseInt($(this).val()); // get Max Rows from select option

          if (maxRows == 5000) {
            $('.pagination').hide();
          } else {
            $('.pagination').show();
          }

          var totalRows = $(table + ' tbody tr').length; // numbers of rows
          $(table + ' tr:gt(0)').each(function() {
            // each TR in  table and not the header
            trnum++; // Start Counter
            if (trnum > maxRows) {
              // if tr number gt maxRows

              $(this).hide(); // fade it out
            }
            if (trnum <= maxRows) {
              $(this).show();
            } // else fade in Important in case if it ..
          }); //  was fade out to fade it in
          if (totalRows > maxRows) {
            // if tr total rows gt max rows option
            var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
            //  numbers of pages
            for (var i = 1; i <= pagenum; ) {
              // for each page append pagination li
              $('.pagination #prev')
                .before(
                  '<li data-page="' +
                    i +
                    '" class="pager__item">\
                      <span class="pager__link">' +
                    i++ +
                    '<span class="sr-only">(current)</span></span>\
                    </li>'
                )
                .show();
            } // end for i
          } // end if row count > max rows
          $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
          $('.pagination li').on('click', function(evt) {
            // on click each page
            evt.stopImmediatePropagation();
            evt.preventDefault();
            var pageNum = $(this).attr('data-page'); // get it's number

            var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

            if (pageNum == 'prev') {
              if (lastPage == 1) {
                return;
              }
              pageNum = --lastPage;
            }
            if (pageNum == 'next') {
              if (lastPage == $('.pagination li').length - 2) {
                return;
              }
              pageNum = ++lastPage;
            }

            lastPage = pageNum;
            var trIndex = 0; // reset tr counter
            $('.pagination li').removeClass('active'); // remove active class from all li
            $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
            // $(this).addClass('active');          // add active class to the clicked
          limitPagging();
            $(table + ' tr:gt(0)').each(function() {
              // each tr in table not the header
              trIndex++; // tr index counter
              // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
              if (
                trIndex > maxRows * pageNum ||
                trIndex <= maxRows * pageNum - maxRows
              ) {
                $(this).hide();
              } else {
                $(this).show();
              } //else fade in
            }); // end of for each tr in table
          }); // end of on click pagination list
        limitPagging();
        })
        .val(5)
        .change();

      // end of on select change

      // END OF PAGINATION
    }

    function limitPagging(){
      // alert($('.pagination li').length)

      if($('.pagination li').length > 7 ){
          if( $('.pagination li.active').attr('data-page') <= 3 ){
          $('.pagination li:gt(5)').hide();
          $('.pagination li:lt(5)').show();
          $('.pagination [data-page="next"]').show();
        }if ($('.pagination li.active').attr('data-page') > 3){
          $('.pagination li:gt(0)').hide();
          $('.pagination [data-page="next"]').show();
          for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
            $('.pagination [data-page="'+i+'"]').show();

          }

        }
      }
      if($('.pagination li').length == 2){
        document.getElementsByClassName('pagination').hide();
      }
    }
    
  </script>

 @endsection
