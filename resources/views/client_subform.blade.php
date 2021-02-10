@extends('admin.client.client_app')
@section('content')
<style>
  #sub-form-area {
      width:200px;

  }
  .sub-form {
    margin-top:20px;
  }
</style>
<div class="responsive" style="margin-left:30px;">
<h3 class="tile-title">Forms List</h3>
<div id="sub-form-area">
   
</div>
     <table class="table">
        <thead>
          <tr>
			<th scope="col">Sr No.</th>
            <th scope="col">Form Name</th>
			<th scope="col">Show Form</th>
			<th scope="col">Fill Form</th>
          </tr>
        </thead>
        <tbody>
    @if (!empty($sub_forms))
      @for ($i = 0; $i < count($sub_forms); $i++)          
          <tr>
            <td>{{ $i + 1 }}</td>	  
            <td>{{ $sub_forms[$i]->title }}</td>
			<td><a href={{ url('Forms/ViewForm/'.$sub_forms[$i]->parent_form_id) }} > <i class="far fa-eye"></i> View Form</a></td></td>
			<td>
			    @if ($sub_forms[$i]->form_link_id != '')
			    <a href={{ url('Forms/CompanyUserForm/'.$sub_forms[$i]->form_link_id) }} >Open</a>
                @endif
            </td>
          </tr>
      @endfor
    @endif          
        </tbody>
      </table>
</div>

@endsection
