@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')

<div id="usermodal" class="modal fade" role="dialog" style="margin-left:10%;z-index:99999">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="background: #C9E2CE;">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add /Edit Coach</h4>
      </div>
      <div class="modal-body" id="adduser">
            
      </div>
    </div>
  </div>
</div>

<div id="coachathlete" class="modal fade" role="dialog" style="margin-left:10%">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="background: #C9E2CE;">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Athlete</h4>
      </div>
      <div class="modal-body" id="athletedata">
            
      </div>
    </div>
  </div>
</div>

<input type ="hidden" name="user" id="user" value= "{{@$user}}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coach Listing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">coach listing</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    @include('layouts.message')
    <!-- Main content -->
    <section class="content userdata">
        <div class="row">
         <div class="col-12"><div class="adduser"> <button type="button"data-toggle="modal" data-target="#myModal">Add Coach</button>
        </div>
            <div class="col-12">
                <!-- /.card -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive csv">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="fit">S.No.</th>
                                    <th class="fit">Coach Name</th>
                                    <th class="fit">Coach Id</th>
                                    <th class="fit">Email</th>
                                    <th class="fit">Gender</th>
                                    <th class="fit">Image</th>
                                    <th class="fit">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allcoach as $key=>$value)
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
                                          <a href="{{url('/viewuserinfo/'.base64_encode($value->id))}}">
                                              <i title="view more" class="fa fa-eye" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deletecoach('{{@$value->id}}')">
                                                <i class="fa fa-fw fa-trash" title="delete" style="color: red;"></i>
                                            </a>
                                            <a data-id="{{$value->id}}" class= "adduser">
                                            <i title="edit" class="fa fa-edit" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a>
                                             <a href= "{{url('/viewathletes/'.base64_encode($value->id))}}" data-id="{{$value->id}}" class= "adduser">
                                            <i title="athlete list" class="fa fa-user-circle" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a> 
                                            <a href= "javascript:void(0)" data-id="{{$value->id}}" class= "adduserathlete">
                                              <i title="add athlete" class="fa fa-plus" aria-hidden="true" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i>
                                            </a>
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
        </div>
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
  var user = $("#user").val();
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

$('.adduserathlete').click(function(){
 var id = $(this).attr('data-id');
  var user = $("#user").val();
  $.ajax({
    url: "{{url('/user-data')}}",
    type: 'POST', 
    data:   {    
      "_token": token,
      //'id':id,
      'user':'athlete'
    },
   success: function(response){   
      $('#athletedata').html(response);
      $('#coachathleteid').val(id);
      $('#coachathlete').modal('show');
    },    
  });
})




function deletecoach(id){
  swal({
    title: "Are you sure to delete coach?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
          url: base_url + '/delete/coach',
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
<!-- delete ends -->
@endsection