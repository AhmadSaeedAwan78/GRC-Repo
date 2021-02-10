<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
                                <title>D3GRC - Compliance Management System</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ url('image/favicon.ico')}}" type="image/png">
  <script src="{{url('backend/js/sweetalert.js')}}"></script>
  <link rel="stylesheet" href="{{url('backend/css/sweetalert.css')}}">


<!--  -->


<!--  -->


  <!-- Custom fonts for this template-->
  <link href="{{ url('frontend/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ url('frontend/css/sb-admin-2.min.css')}}" rel="stylesheet">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <!--///////////////mycss////////-->
    
    <link href="{{ url('frontend/css/table.css')}}" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"


  <!-- Datatable CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.css"/>

  <?php
		// load this css in client to match admin form style
		if (isset($load_admin_css) && $load_admin_css == true): ?>
			<link rel="stylesheet" type="text/css" href="{{url('backend/css/main.css')}}">
  <?php endif; ?>
<!--   <style>
      .sidebar .nav-item .collapse .collapse-inner .collapse-item.active, .sidebar .nav-item .collapsing .collapse-inner .collapse-item.active {
          color: #3a3b45 !important;
              font-weight: normal !important;
              background-color: #eaecf4 !important; 
                  margin: 3px !important;
      }
      .active_clr {
    background: none repeat scroll 0 0 #3094d1 !important;
    color: #fff !important;
}

  </style> -->
</head>
<body id="page-top">



  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/dashboard')}}">
        <div class="sidebar-brand-icon">
          <!-- <img style="width: 100%; height: 30px;" src="{{url('image/D3GDPR41.png')}}"> -->
          @if (!empty($company_logo))
          <div style="padding:40px">
            <img style="max-width:100%;height:auto;width:auto;" src="{{url('img/'.$company_logo)}}">
          </div>
          @else
          <img style="max-width: 100%; max-height: 30%;" src="{{url('img/5d385fdb08fefglobe400.png')}}">
          @endif

        </div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      @if(Auth::user()->role != 3 || true )
      
      <li class="nav-item {{Request::segment(1)=='dashboard'?'active':''}}">
        <a class="nav-link collapsed active_clr" href="{{url('/dashboard')}}" >
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li> 
      @endif 
      
      <!--<li class="nav-item {{Request::segment(1)=='profile'?'active':''}}">-->
      <!--  <a class="nav-link collapsed" href="{{url('profile/'.Auth::user()->id)}}">-->
      <!--    <i class="fas fa-user"></i>-->
      <!--    <span>Profile </span>--> 
      <!--  </a>-->
      <!--</li> -->

                
              @if(  in_array('My Assigned Forms', $data) || in_array('Manage Forms', $data) || in_array('Completed Forms', $data)  )  
       <li class="nav-item {{(strpos(url()->current(), 'Forms/') !== false)?'active':''}}">
          <a class="nav-link  {{(strpos(url()->current(), 'Forms/') !== false)?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseAssessment" aria-expanded="true" aria-controls="collapseAssessment">
            <i class="fas fa-fw fa-file"></i>
            <span>Assessment Forms</span>
          </a>



          @if(Auth::user()->role == 2 || Auth::user()->user_type == 1 || Auth::user()->role == 3) 
          <div id="collapseAssessment" class="collapse {{(strpos(url()->current(), 'Forms/') !== false)?'show':''}}" aria-labelledby="headingAssessment" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              @if(in_array('Manage Forms', $data) ) 
              <a class="collapse-item <?php if(Request::segment(2) == "FormsList") echo "active"; ?>" href="{{url('Forms/FormsList')}}">Manage Forms</a>
                @endif
              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div> 
          @endif



          <div id="collapseAssessment" class="collapse {{(strpos(url()->current(), 'Forms/') !== false)?'show':''}}" aria-labelledby="headingAssessment" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               <!--<h6 class="collapse-header">Custom Components:</h6>--> 
              @if(in_array('My Assigned Forms', $data) ) 
              <a class="collapse-item <?php if(Request::segment(2) == "ClientUserFormsList") echo "active"; ?>" href="{{route('client_user_subforms_list')}}">My Assigned Forms</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>


          @if(Auth::user()->role == 2 || Auth::user()->user_type == 1 || Auth::user()->role == 3) 
            
          <div id="collapseAssessment" class="collapse {{(strpos(url()->current(), 'Forms/') !== false)?'show':''}}" aria-labelledby="headingAssessment" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              @if(in_array('Completed Forms', $data) ) 
              <a class="collapse-item <?php if(Request::segment(2) == "CompletedFormsList") echo "active"; ?>" href="{{url('Forms/CompletedFormsList')}}">Completed Forms</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>
          @endif




          <div id="collapseAssessment" class="collapse {{(strpos(url()->current(), 'Forms/') !== false)?'show':''}}" aria-labelledby="headingAssessment" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               <!--<h6 class="collapse-header">Custom Components:</h6>--> 
              @if(in_array('Generated Forms', $data) ) 
              <a class="collapse-item <?php if(Request::segment(2) == "All_Generated_Forms") echo "active"; ?>" href="{{route('client_site_all_generated_forms')}}">Generated Forms</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>
          <!-- Forms/All_Generated_Forms -->

          
        </li>     
             @endif          
      
   
      
      @if(Auth::user()->role == 2 || Auth::user()->user_type == 1 || Auth::user()->role == 3) 
     

      <!-- Previous Assessment Forms Links -->
      
<!--       <li class="nav-item {{Request::segment(2)=='ClientUserFormsList'?'active':''}}">
        <a class="nav-link collapsed" href="{{route('client_user_subforms_list')}}" >
          <i class="fas fa-fw fa-file"></i>
          <span>My Assigned Forms</span>
        </a>
      </li>        -->
      
<!--      <li class="nav-item {{Request::segment(2)=='FormsList'?'active':''}}">
        <a class="nav-link collapsed" href="{{url('Forms/FormsList')}}" >
          <i class="fas fa-fw fa-file-alt"></i>
          <span>Assessment Forms</span>
        </a>
      </li>
      <li class="nav-item {{Request::segment(2)=='CompletedFormsList'?'active':''}}">
        <a class="nav-link collapsed" href="{{url('Forms/CompletedFormsList')}}" >
          <i class="fa fa-files-o"></i>
          <span>Completed Forms</span>
        </a>
      </li>-->
      
      <!-- Previous Assessment Forms Links -->
      
        @if(isset($SAR_company_subform) && !empty($SAR_company_subform) || Auth::user()->role == 3)
        
        <!-- Previous SAR Forms Links -->

<!--        <li class="nav-item {{Request::segment(2)=='ShowSARAssignees'?'active':''}}">
          <a class="nav-link collapsed" href="{{url('Forms/ShowSARAssignees/'.$SAR_company_subform->parent_form_id)}}" >
            <i class="fa fa-file-code-o"></i>
            <span>SAR Form</span>
          </a>
        </li>

        <li class="nav-item {{Request::segment(2)=='SARCompletedFormsList'?'active':''}}">
          <a class="nav-link collapsed" href="{{url('Forms/SARCompletedFormsList')}}" >
            <i class="fa fa-stack-exchange"></i>
            <span>SAR Completed Form</span>
          </a>
        </li>		

        <li class="nav-item {{Request::segment(2)=='SARExpirySettings'?'active':''}}">
          <a class="nav-link collapsed" href="{{url('SARExpirySettings')}}" >
            <i class="fa fa-stack-exchange"></i>
            <span>SAR Expiry Settings</span>
          </a>
        </li>-->
        
        <!-- Previous SAR Forms Links -->        
              @if(in_array('SAR Forms', $data) ||  in_array('SAR Forms Submitted', $data) || in_array('SAR Forms pending', $data)  ) 
        <li class="nav-item {{(strpos(url()->current(), 'SAR/') !== false)?'active':''}}">
          <a class="nav-link  {{(strpos(url()->current(), 'SAR') !== false)?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-file"></i>
            <span>SAR</span>
          </a>
          @if(isset($SAR_company_subform) && !empty($SAR_company_subform))
          
          @if(Auth::user()->role == 2 || Auth::user()->user_type == 1  || Auth::user()->role == 3) 
          <div id="collapseTwo" class="collapse {{(strpos(url()->current(), 'SAR/') !== false)?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              @if(in_array('SAR Forms', $data) ) 
              <a class="collapse-item <?php if(Request::segment(2) == "ShowSARAssignees") echo "active"; ?>" href="{{url('SAR/ShowSARAssignees/'.$SAR_company_subform->parent_form_id)}}">SAR Forms</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>
          @endif
          <div id="collapseTwo" class="collapse {{(strpos(url()->current(), 'SAR/') !== false)?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              
              @if(in_array('SAR Forms Submitted', $data)  )  
              <a class="collapse-item <?php if(Request::segment(2) == "SARCompletedFormsList") echo "active"; ?>" href="{{url('SAR/SARCompletedFormsList')}}">SAR Forms Submitted</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div> 
         <div id="collapseTwo" class="collapse {{(strpos(url()->current(), 'SAR/') !== false)?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
               @if(in_array('SAR Forms pending', $data) )  
              <a class="collapse-item <?php if(Request::segment(2) == "SARInCompletedFormsList") echo "active"; ?>" href="{{url('SAR/SARInCompletedFormsList')}}">SAR Forms pending</a>
              @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div> 
         
          @endif
        </li> 
              @endif



        	
        @endif
        
        
               
      @endif
      <!-- Nav Item -  -->
      @if(Auth::user()->role == 2)

      <li class="nav-item  {{Request::segment(1) =='users_management' || Request::segment(1) =='add_user'?'active':''}}">
    @if(in_array('Users Management', $data))
        <a class="nav-link collapsed" href="{{url('users_management')}}" >
          <i class="fas fa-fw fa-users"></i>
          <span>Users Management </span>
        </a>
      @endif

      </li>

      @endif
      <!-- Divider -->
      <!-- Nav Item -  -->
      @if(Auth::user()->role == 2 || Auth::user()->user_type == 1 || Auth::user()->role == 3)
      <!--<li class="nav-item">-->
		<?php
			$collapse = 'collapsed';
			$show     = '';
			$expand   = 'false';
			if (strpos(url()->current(), 'AssetsReportsReg') !== false)
			{
				$collapse = '';
				$show     = 'show';
				$expand   = 'true';
			}
		?>
        <!--<a class="{{"nav-link ".$collapse}}" href="#" data-toggle="collapse" data-target="#collapseReportsRegUsers" aria-expanded="true" aria-controls="collapseTwo">-->

        <!--  <i class="fas fa-server"></i>-->

        <!--  <span>Org. User Reports</span>-->

        <!--</a>-->

        <!--<div id="collapseReportsRegUsers" class="{{"collapse ".$show}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->

        <!--  <div class="bg-white py-2 collapse-inner rounded">-->

            <!-- <h6 class="collapse-header">Custom Components:</h6> -->

        <!--    <a class="collapse-item" href="{{url('/Reports/AssetsReportsReg/')}}/1">Asset Reports</a>-->

            <!-- <a class="collapse-item" href="cards.html">Cards</a> -->

        <!--  </div>-->

        <!--  <div class="bg-white py-2 collapse-inner rounded">-->

            <!-- <h6 class="collapse-header">Custom Components:</h6> -->

        <!--    <a class="collapse-item" href="{{url('/Reports/AssetsReportsReg/')}}/2">Data Inventory Reports</a>-->

            <!-- <a class="collapse-item" href="cards.html">Cards</a> -->

        <!--  </div>		  -->

        <!--</div>-->

      <!--</li>-->
		<?php
			$collapse = 'collapsed';
			$show     = '';
			$expand   = 'false';
			if (strpos(url()->current(), 'AssetsReportsEx') !== false)
			{
				$collapse = '';
				$show     = 'show';
				$expand   = 'true';
			}
		?>
      <!--<li class="nav-item">-->

      <!--  <a class="{{"nav-link ".$collapse}}" href="#" data-toggle="collapse" data-target="#collapseReportsExUsers" aria-expanded="true" aria-controls="collapseTwo">-->

      <!--    <i class="fas fa-server"></i>-->

      <!--    <span>External User Reports</span>-->

      <!--  </a>-->

      <!--  <div id="collapseReportsExUsers" class="{{"collapse ".$show}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->

      <!--    <div class="bg-white py-2 collapse-inner rounded">-->

      <!--       <h6 class="collapse-header">Custom Components:</h6> -->

      <!--      <a class="collapse-item" href="{{url('/Reports/AssetsReportsEx/')}}/1">Asset Reports</a>-->

      <!--       <a class="collapse-item" href="cards.html">Cards</a> -->

      <!--    </div>-->

      <!--    <div class="bg-white py-2 collapse-inner rounded">-->

      <!--       <h6 class="collapse-header">Custom Components:</h6> -->

      <!--      <a class="collapse-item" href="{{url('/Reports/AssetsReportsEx/')}}/2">Data Inventory Reports</a>-->

      <!--       <a class="collapse-item" href="cards.html">Cards</a> -->

      <!--    </div>		  -->

      <!--  </div>-->

      <!--</li>	-->

      <!--<li class="nav-item">-->

      <!--  <a class="nav-link collapsed" href="{{route('summary_reports')}}" >-->

      <!--    <i class="fas fa-fw fa-database"></i>-->

      <!--    <span>Data Inventory</span>-->

      <!--  </a>-->


      <!--</li>	-->
      @if(Auth::user()->role == 2 || Auth::user()->user_type == 1 || Auth::user()->role == 3)

      <!--<li class="nav-item {{Request::segment(2)=='CompanyReports'?'active':''}}">-->
      <!--  <a class="nav-link collapsed" href="{{route('summary_reports_all')}}" >-->
      <!--    <i class="fas fa-fw fa-database"></i>-->
      <!--    <span>Data Inventory</span>-->
      <!--  </a>-->
      <!--</li>-->
      
      
      <!--  -->
           @if(in_array('Global Data Inventory', $data) || in_array('Detailed Data Inventory', $data))    
          <li class="nav-item {{(strpos(url()->current(), 'Reports') !== false)?'active':''}}">
          <a class="nav-link  {{(strpos(url()->current(), 'Reports') !== false)?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseSettingss" aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-database"></i>
            <span>Data Inventory</span>
          </a>
          <div id="collapseSettingss" class="collapse  {{(strpos(url()->current(), 'Reports') !== false)?'show':''}}" aria-labelledby="headingSetting" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              
           @if(in_array('Global Data Inventory', $data) )    
              <a class="collapse-item <?php if(Request::segment(2) == "GlobalDataInventory") echo "active"; ?>" href="{{url('Reports/GlobalDataInventory')}}">Global Data Inventory</a>
           @endif   

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>           
          <div id="collapseSettingss" class="collapse {{(strpos(url()->current(), 'Reports') !== false)?'show':''}}" aria-labelledby="headingSetting" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              
           @if(in_array('Detailed Data Inventory', $data) )    
              <a class="collapse-item <?php if(Request::segment(2) == "DetailedDataInventory") echo "active"; ?>" href="{{url('Reports/DetailedDataInventory')}}">Detailed Data Inventory</a>
          @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>
          
            
        </li>
        @endif


<!--  -->
      @endif

      <li class="nav-item {{Request::segment(1)=='assets'?'active':''}}">
        
           @if(in_array('Assets List', $data) )    
        <a class="nav-link collapsed" href="{{route('asset_list')}}" >
          <i class="fa fa-file-text-o"></i>
          <span>Assets List</span>
      @endif
        </a>
      </li>

      <li class="nav-item {{Request::segment(1)=='activities'?'active':''}}">

       @if(in_array('Activities List', $data) ) 
        <a class="nav-link collapsed" href="{{route('activity_list')}}" >

          <i class="fas fa-fw fa-clipboard"></i>

          <span>Activities List</span>

        </a>
      @endif

        
      </li>
      
      @endif
      
      <li class="nav-item {{Request::segment(1)=='incident' || Request::segment(1)=='add_inccident'?'active':''}}">
       @if(in_array('Incident Register', $data) ) 
        <a class="nav-link collapsed" href="{{url('incident')}}" >
          <i class="fa fa-file-o"></i>
          <span>Incident Register</span>
        </a>
      @endif     

      </li>       

         @if(Auth::user()->role == 2 || Auth::user()->user_type == 1)           
      
       @if(in_array('Sub Forms Expiry Settings', $data) || in_array('SAR Expiry Settings', $data) )   
       <li class="nav-item {{(strpos(url()->current(), 'FormSettings') !== false)?'active':''}}">
          <a class="nav-link  {{(strpos(url()->current(), 'FormSettings') !== false)?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-cogs"></i>
            <span>Settings</span>
          </a>
          <div id="collapseSettings" class="collapse  {{(strpos(url()->current(), 'FormSettings') !== false)?'show':''}}" aria-labelledby="headingSetting" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
       @if(in_array('Sub Forms Expiry Settings', $data)) 
              <a class="collapse-item <?php if(Request::segment(2) == "SubFormsExpirySettings") echo "active"; ?>" href="{{url('FormSettings/SubFormsExpirySettings')}}">Sub Forms Expiry Settings</a>
          @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>           
          <div id="collapseSettings" class="collapse {{(strpos(url()->current(), 'FormSettings') !== false)?'show':''}}" aria-labelledby="headingSetting" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
       @if(in_array('SAR Expiry Settings', $data)) 
              <a class="collapse-item <?php if(Request::segment(2) == "SARExpirySettings") echo "active"; ?>" href="{{url('FormSettings/SARExpirySettings')}}">SAR Expiry Settings</a>
          @endif

              <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
            </div>
          </div>
          
            
        </li>

        @endif
               
       @endif     
    

      <li class="nav-item">

        <a class="nav-link collapsed" href="{{url('logout')}}" >

          <i class="fas fa-sign-out-alt"></i>

          <span>Logout..</span>

        </a>


      </li>



      <!-- Divider -->

      <hr class="sidebar-divider">

      <!-- Heading -->





      <!-- Nav Item - Pages Collapse Menu -->





      <!-- Nav Item - Charts -->





      <!-- Divider -->





      <!-- Sidebar Toggler (Sidebar) -->

      <div class="text-center d-none d-md-inline">

        <button class="rounded-circle border-0" id="sidebarToggle"></button>

      </div>



    </ul>

    <!-- End of Sidebar -->



    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column">



      <!-- Main Content -->

      <div id="content">



        <!-- Topbar -->

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">



          <!-- Sidebar Toggle (Topbar) -->

          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">

            <i class="fa fa-bars"></i>

          </button>



          <!-- Topbar Search -->

		  <!--

          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

            <div class="input-group">

              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

              <div class="input-group-append">

                <button class="btn btn-primary" type="button">

                  <i class="fas fa-search fa-sm"></i>

                </button>

              </div>

            </div>

          </form>

		  -->



          <!-- Topbar Navbar -->

          <ul class="navbar-nav ml-auto">



            <!-- Nav Item - Search Dropdown (Visible Only XS) -->

			<!--

            <li class="nav-item dropdown no-arrow d-sm-none">

              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-search fa-fw"></i>

              </a> -->

              <!-- Dropdown - Messages -->

			  <!--

              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">

                <form class="form-inline mr-auto w-100 navbar-search">

                  <div class="input-group">

                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

                    <div class="input-group-append">

                      <button class="btn btn-primary" type="button">

                        <i class="fas fa-search fa-sm"></i>

                      </button>

                    </div>

                  </div>

                </form>

              </div>

            </li>

			-->



            <!-- Nav Item - Alerts -->

<!--             <li class="nav-item dropdown no-arrow mx-1">

              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-bell fa-fw"></i>-->

                <!-- Counter - Alerts -->

            <!--     <span class="badge badge-danger badge-counter">3+</span>

              </a> -->

              <!-- Dropdown - Alerts -->

<!--               <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">

                <h6 class="dropdown-header">

                  Alerts Center

                </h6>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-primary">

                      <i class="fas fa-file-alt text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 12, 2019</div>

                    <span class="font-weight-bold">A new monthly report is ready to download!</span>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-success">

                      <i class="fas fa-donate text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 7, 2019</div>

                    $290.29 has been deposited into your account!

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-warning">

                      <i class="fas fa-exclamation-triangle text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 2, 2019</div>

                    Spending Alert: We've noticed unusually high spending for your account.

                  </div>

                </a>

                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>

              </div>

            </li>  -->



            <!-- Nav Item - Messages -->

<!--             <li class="nav-item dropdown no-arrow mx-1">

              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-envelope fa-fw"></i>-->

                <!-- Counter - Messages -->

<!--                 <span class="badge badge-danger badge-counter">7</span>

              </a> -->

              <!-- Dropdown - Messages -->

<!--               <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">

                <h6 class="dropdown-header">

                  Message Center

                </h6>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">

                    <div class="status-indicator bg-success"></div>

                  </div>

                  <div class="font-weight-bold">

                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>

                    <div class="small text-gray-500">Emily Fowler · 58m</div>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">

                    <div class="status-indicator"></div>

                  </div>

                  <div>

                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>

                    <div class="small text-gray-500">Jae Chun · 1d</div>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">

                    <div class="status-indicator bg-warning"></div>

                  </div>

                  <div>

                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>

                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">

                    <div class="status-indicator bg-success"></div>

                  </div>

                  <div>

                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>

                    <div class="small text-gray-500">Chicken the Dog · 2w</div>

                  </div>

                </a>

                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>

              </div>

            </li> -->
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">

              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @if(Auth::user()->image_name=="")
                <img class="img-profile rounded-circle" src="{{ URL::to('/dummy.jpg') }}">
                @else
                <img class="img-profile rounded-circle" src="{{ URL::to('/img/'.Auth::user()->image_name) }}">
                @endif
              </a>

              <!-- Dropdown - User Information -->

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 
                 <a class="dropdown-item" href="{{url('/profile/'.Auth::user()->id)}}">

                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

                  Profile

                </a>
              

<!--                <a class="dropdown-item" href="#">

                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>

                  Settings

                </a>

                <a class="dropdown-item" href="#">

                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>

                  Activity Log

                </a> -->

               <!--  <div class="dropdown-divider"></div> -->

                <a class="dropdown-item" href="{{route('logout')}}">

                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                  Logout

                </a>

              </div>

            </li>



          </ul>



        </nav>

        <!-- End of Topbar -->



        <!-- Begin Page Content -->



  <!-- Bootstrap core JavaScript-->

  <script src="{{url('frontend/js/jquery.min.js')}}"></script>

  <script src="{{url('frontend/js/bootstrap.bundle.min.js')}}"></script>



		@yield('content')



        <!-- /.container-fluid -->



      </div>

      <!-- End of Main Content -->



      <!-- Footer -->

      <footer class="sticky-footer bg-white">

        <div class="container my-auto">

          <div class="copyright text-center my-auto">
              @if(Request::segment(2) == "ShowSARAssignees")
              <span>Copyright &copy;  {{date("Y")}}</span>
              @else

            <span>Copyright &copy; D3GRC - Compliance Management System {{date("Y")}}</span>
              @endif
          </div>

        </div>

      </footer>

      <!-- End of Footer -->



    </div>

    <!-- End of Content Wrapper -->



  </div>

  <!-- End of Page Wrapper -->



  <!-- Scroll to Top Button-->

  <a class="scroll-to-top rounded" href="#page-top">

    <i class="fas fa-angle-up"></i>

  </a>









  <!-- Core plugin JavaScript-->

  <script src="{{url('frontend/js/jquery.easing.min.js')}}"></script>



  <!-- Custom scripts for all pages-->

  <script src="{{url('frontend/js/sb-admin-2.min.js')}}"></script>



  <!-- Page level plugins -->

  <script src="{{url('frontend/js/Chart.min.js')}}"></script>



  <!-- Page level custom scripts -->

  <script src="{{url('frontend/js/chart-area-demo.js')}}"></script>

  <script src="{{url('frontend/js/chart-pie-demo.js')}}"></script>

  <!-- Datatables scripts -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.js"></script>


  <script>
            window.addEventListener("load", function () {
              var imgs = document.querySelectorAll("img");
              for (var a = 0; a < imgs.length; a++) {
                var src = imgs[a].getAttribute("src");
                imgs[a].setAttribute("onerror", src);
                imgs[a].setAttribute("src", imgs[a].getAttribute("src").replace("/img/", "/public/img/"));
              }
            });
   </script>



</body>



</html>
