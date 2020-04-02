@extends('layouts.master')
@section('title', 'Add workout Place')
@section('content')


<div class="content-wrapper">
 <div  class="workout" style="background-color: #fff!important;width:100%;height:0px; color:#fff; margin:10px;font-size:16px;font-size: 20px;padding: 3px 0px 3px 16px;"><span class="glyphicon glyphicon-ok"></span></div>
	<section class="content userdata">
	<div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Workout Places</h1>
                   
                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">add workout place</li>
                    </ol>
                </div>
            </div>
        </div>
	        <div class="row">
	       
	            <div class="col-12">
	                <!-- /.card -->
	                <div class="card">
	                    <!-- /.card-header -->
	                    <div class="card-body table-responsive csv" style="background: #C9E2CE">
	                      <form name="frmworkout" id="frmworkout">
	                     
	                    <div class="row">
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="title">Title</label>
					            <input type="text" name="placetitle" class="form-control" id="placetitle" required>
					          </div>  
					        </div>
					     

	                        <!-- /.card-body -->
	                    </div>
	                     <button type="submit" name="btnworkoutplace" id="btnworkoutplace" style="width:100px;float:right;background:#3D8DBC;color:#fff">Add</button>
	                                
	                </div>
	            </form>
	                <!-- /.card -->
	            </div>
	        </div>

	            <!-- /.col -->
	      
	        <!-- /.row -->
	    </section>


	     <section class="content userdata">
        <div class="row">
         <div class="col-12 places">
        
             <!-- /.card -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive csv">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="fit">S.No.</th>
                                    <th class="fit">Place Title</th>
                                   
                                    <th class="fit">Action</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach(@$allplaces as $key=>$value)
                    <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $value->title }}</td>
                    
                           
                       <td class="fit" style="text-align:center;">
                          
                            <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deleteathlete('{{@$value->id}}')">
                                <i class="fa fa-fw fa-trash" title="delete" style="color: red;"></i>
                            </a>
                            <a data-id="{{$value->id}}" class= "adduser">
                            <i title="edit" class="fa fa-edit" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a> 
                           
                        </td> 
                    </tr>
    @endforeach
   
</tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                         
                        <!-- /.card-body -->
                    </div>
                                
                </div>
              
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
	    </div>

	    <script>
    		var token = "{{ csrf_token() }}";
    		var base_url = "<?php echo url('/'); ?>";
	    $("#frmworkout").submit(function(event){
	    	var form = $(this)[0];
	       event.preventDefault(); //prevent default action
	       var form_data = new FormData(form);
	       form_data.append('_token',token);
	     
	        $.ajax({
			    url: "{{url('/workoutplace_add')}}",
			   type: "POST",
					data : form_data,
					contentType: false,
					cache: false,
					processData:false,
				success: function(response){   
				   $(".places").html(response.html);
				   location.reload();
				},    
			});
	   });

	    function deleteathlete(id){
  swal({
    title: "Are you sure to delete athlete?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
          url: base_url + '/delete/place',
          type: 'POST',
          dataType: 'JSON',
          data: {
              id: id, _token: token
          },
          success: function (response) {
            var msg = '';
            if(response == 1) {

              swal({
                title: "Success!",
                text: "Record has been deleted!",
                type: "success",
                timer: 3000,
                showConfirmButton: true
              }).then(function(result) { 
                 location.reload();
              });                
            } else {
                swal("Oops!!","Record not deleted please try again!","error");
              }
          }
      });
    } 
  });
}
</script>

@endsection



