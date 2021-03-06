@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')
<div id="usermodal" class="modal fade" role="dialog" style="margin-left:10%">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="background: #C9E2CE;">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Athlete</h4>
      </div>
      <div class="modal-body" id="adduser">
            
      </div>
    </div>
  </div>
</div>

<div id="userdiet" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Nutrition Date Value</h4>
      </div>
      <div class="modal-body" id="addcalander">
      <form method="post" action="{{url('/viewnutritiondetails')}}" class="nutritionview">
       {{csrf_field()}}
      <input type="hidden" name="userid" id="userid">  
      <input type="hidden" name="type" id="type">      
      <input type="date" required name="caldate" id="caldate" class="form-control" onchange="checkdate()">
     <div class="box-footer add_cat">
      <div class="caldatemsg" style="color:red;float: left;"></div>
        <button type="submit" class="btn btn-default btncalsubmit" style="width:30%;margin-top:20px;">Submit</button>
      </div>
     
      </form>            
      </div>
    </div>
  </div>
</div>

<input type ="hidden" name="coach" id="user" value= "{{@$coach}}">
<input type ="hidden" name="type" id="type" value= "coach">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Athlete Listing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">coach athlete listing</li>
                    </ol>
                </div>
            </div>
            <a href="{{url('/coach_list')}}">< Back</a>
        </div>
        <!-- /.container-fluid -->
    </section>
    @include('layouts.message')
    <!-- Main content -->
    <section class="content userdata">
        <div class="row">
         <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive csv">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="fit">S.No.</th>
                                    <th class="fit">Athlete Name</th>
                                    <th class="fit">Athlete Id</th>
                                    <th class="fit">Email</th>
                                    <th class="fit">Gender</th>
                                    <th class="fit">Image</th>
                                    <th class="fit">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(@$athletes as $key=>$value)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->email }}</td>
                                         <td>{{ $value->gender }}</td>
                                         <td>
                                         @if($value->image!="")
                                         <img src = "{{url('/images').'/'.$value->image }}" width=50 height=50>
                                         @else
                                          <img src = "{{url('/images').'/user.png' }}" width=50 height=50>
                                          @endif
                                         </td>
                                           
                                       <td class="fit" style="text-align:center;">
                                            <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deleteathlete('{{@$value->id}}')">
                                                <i class="fa fa-fw fa-trash" title="delete" style="color: red;"></i>
                                            </a>
                                            <a data-id="{{$value->id}}" class= "adduser">
                                            <i title="edit" class="fa fa-edit" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a> 
                                            <a href="{{url('/viewuserinfo/'.base64_encode($value->id).'/coach')}}">
                                              <i title="view more" class="fa fa-eye" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i>
                                            </a>
                                             <a href="{{url('/viewuserimages/'.base64_encode($value->id))}}">
                                             <i title="view uploaded images" class="fa fa-picture-o" aria-hidden="true" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i>
                                            </a>
                                            <!--  <a href= "{{url('/chatathlete/'.base64_encode($value->id).'/'.base64_encode(@$coach_id))}}">
                                             <i  title="athlete list" class="fas fa-comment" style="position: relative; margin-left:7px;color:#3c8dbc !important">
                                            </i></a>  -->
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot
                            </tfoot>
                        </table>
                        
                        <!-- /.card-body -->
                    </div>
                                
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
       
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').on('click', function(){
            var user_id = $(this).attr('data-userid');
            console.log('user_id', user_id);
            /*$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });*/
            $.ajax({
                type: 'POST',
                url: '{{ url("update-user-status") }}',
                data: {
                    user_id:user_id,
                },
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    
                    if(res != '')
                    {
                        if(res.status == 'Active')
                        {
                            $(this).attr('checked', 'checked');
                        }
                        else
                        {
                            $(this).removeAttr('checked');

                        }
                    }
                    
                }
            });
        });
    });
</script>
<!-- delete starts -->
<script>
    var token = "{{ csrf_token() }}";
    var base_url = "<?php echo url('/'); ?>";
</script>
<script>

$('.adduser').click(function(){
  var id = $(this).attr('data-id'); 
  var user = 'athlete';
 
  $.ajax({
    url: "{{url('/user-data')}}",
    type: 'POST', 
    data:   {    
      "_token": token,
      'id':id,
      'user':user
    },
   success: function(response){   
    $('#adduser').html(response);
    $('#usermodal').modal('show');
    },    
  });
})


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
          url: base_url + '/delete/athlete',
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
 
$('.nutrition').click(function(){

  var userid = $(this).attr('data-userid');
  $.ajax({
    type:'POST',
    data:{
      _token: token , id:userid
    },
    url:"{{url('/viewnutritioncalender')}}",
    success:function(response)
    {
        $('.caldatemsg').html("");
      $("#userdiet").modal('show');
      $("#userid").val(response); 
      $("#type").val("view");
    }
  });  
});

function checkdate()
{
    var dateval = $('#caldate').val();
    var userid = $('#userid').val();
    $.ajax({
      type:'POST',
      data:{
        _token: token , dateval:dateval, userid :userid
      },
      url:"{{url('/checkdatevalue')}}",
      success:function(response)
      {
      if(response == 1 ){
       $('.caldatemsg').html("No Record Found");
       $('.btncalsubmit').prop('disabled', true);
      }
      
      else{
        $('.caldatemsg').html("");
        $('.btncalsubmit').prop('disabled', false);
      }
    }  
  });
}



</script>
<!-- delete ends -->
@endsection