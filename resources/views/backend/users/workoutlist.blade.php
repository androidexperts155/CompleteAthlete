@extends('layouts.master')
@section('title', 'Workouts Listing')
@section('content')
<style>
  .workoutcontent  {padding:20px;}
  .modal .modal-content{ overflow:hidden;height:600px; }
  .modal-body{overflow-y:scroll;}
  .modal-header{display:block;}
</style>

<div id="usermodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add /Edit User</h4>
      </div>
      <div class="modal-body" id="adduser">            
      </div>
    </div>
  </div>
</div>

<input type ="hidden" name="user" id="user" value= "{{@$user}}">

<div class="content-wrapper">
  <div  class="workout" style="background-color: #fff!important;width:100%;height:0px; color:#fff; margin:10px;font-size:16px;font-size: 20px;padding: 3px 0px 3px 16px;"><span class="glyphicon glyphicon-ok"></span></div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Workout Listing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">workout  listing</li>
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
         <div class="col-12">
            <div class="col-12">
                <!-- /.card -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped full-width">
                            <thead>
                                <tr>
                                    <th class="fit">S.No.</th>
                                    <th class="fit">workout ID</th>
                                    <th class="fit">Title</th>
                                    <th class="fit">Description</th>
                                    <th class="fit">Prepare Notes</th>
                                    <th class="fit">Type</th>
                                    <th class="fit">Subtype</th>
                                    <th class="fit">Category</th>
                                    <th class="fit">Scoring Type</th>
                                    <th class="fit">workout date</th>
                                   <!--  <th class="fit">Video</th> -->
                                    <!-- <th class="fit">Image</th> -->
                                    <th class="fit">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(@$allworkouts as $key=>$value)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $value->id }}</td>
                                        <td class="fit" width=100%> 
                                        <?php 
                                        $len = strlen($value->title);
                                        echo substr(strip_tags($value->title),0,$len) ?></td>                                       
                                        <td class="fit" width=100%>             
                                          <span class="descriptionshow{{$value->id}}" style="display:none"><?php echo html_entity_decode($value->description);?>
                                          </span>
                                          <a href="#" class="workdescription{{$value->id}}" onclick ="showallcontent({{$value->id}})"><span style="color:#2B2F33">
                                            <?php 
                                              echo substr(strip_tags($value->description),0,10);  ?></span>
                                              <?php
                                              if(strlen($value->description)>10) echo '  read more... ';
                                             ?>
                                           </a>
                                         </td>
                                         <td class="fit" width=100%>
                                            <a href="#" class="preparenotes" onclick="showallcontentnotes({{$value->id}})"><span class="preparenotesshow{{$value->id}}" style="display:none"><?php echo html_entity_decode($value->prepare);?>
                                            </span>
                                            <span style="color:#2B2F33">
                                             <?php echo substr(strip_tags($value->prepare),0,10);?></span>
                                              <?php
                                                if(strlen($value->prepare)>10) echo '  read more... ';
                                               ?>
                                              </a>
                                          </td>
                                        <td>{{ $value->type }}</td>
                                        <td>{{ $value->subtype }}</td>
                                        <td>{{ $value->category }}</td>
                                        <td>
                                        <?php
                                        if($value->scoring_type==1) echo "Minutes and Seconds";
                                          else if($value->scoring_type==2) echo "Rounds and Reps";
                                          else if($value->scoring_type==3) echo "Reps";
                                          else if($value->scoring_type==4) echo "Meters";
                                          else if($value->scoring_type==5) echo "Lbs";
                                          else if($value->scoring_type==6) echo "Calories";
                                        ?>
                                        </td>
                                         <td>{{ $value->workout_date }}</td>
                                         <!-- <td>
                                         @if($value->videofile!="")
                                         <img src = "{{url('/images').'/'.$value->image }}" width=50 height=50>
                                         @else
                                          <img src = "{{url('/images').'/user.png' }}" width=50 height=50>
                                          @endif
                                         </td>
                                         <td>
                                         @if($value->videoimage!="")
                                         <img src = "{{url('/thumbnails').'/'.$value->videoimage }}" width=50 height=50>
                                         @else
                                          <img src = "{{url('/thumbnails').'/user.png' }}" width=50 height=50>
                                          @endif
                                         </td> -->
                                      
                                       <td class="fit" style="text-align:center;">
                                          <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deleteworkout('{{@$value->id}}')">
                                              <i class="fa fa-fw fa-trash" title="delete" style="color: red;"></i>
                                          </a>
                                          <a data-id="{{$value->id}}" class= "editworkout">
                                          <i title="edit" class="fa fa-edit " style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a> 
                                          <a href= "{{url('/viewusersworkout/'.base64_encode($value->id))}}" data-id="{{$value->id}}" class= "viewusers" title="users worked">
                                          <i class="fa fa-users" aria-hidden="true" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a>   
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
    <!-- /.content -->
<!-- Modal -->


<div id="myModal" class="modal fade" role="dialog" style="margin-left:20%;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
      </div>
      <div class="modal-body" style="background: #C9E2CE;">
      <p class="workoutcontent" align="left"></p>
      </div>
      <div class="modal-footer">        
      </div>
    </div>
  </div>
</div>

<div id="MyModalworkout" class="modal fade" role="dialog" style="margin-left:20%;z-index: 99999">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close_workout" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit workout</h4>    
      </div>
      <div class="modal-body MyModalworkoutcontent" style="background: #C9E2CE;">     
      </div>
      <div class="modal-footer">        
      </div>
    </div>
  </div>
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
  var user = $('#user').val();  
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


function deleteworkout(id){
  swal({
    title: "Are you sure to delete workout?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
          url: base_url + '/delete/workout',
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

$(document).ready(function(){
  $('.preparenotes').on('click',function(e){
    e.preventDefault();
    $("#myModal").modal('show');
    $(".workoutcontent").html($('.preparenotesshow').html());
  });
});

$(".editworkout").on('click',function(){
  var workid = $(this).attr('data-id');  
  $.ajax({
    url: "{{url('/edit-workout')}}",
    type: 'POST', 
    data:   {    
      "_token": token,
      "workid": workid,
      "type":'edit'
  },
  success: function(response){ 
    $("#MyModalworkout").modal('show');
    $(".MyModalworkoutcontent").html(response.html);
    }   
  })
 });

function showallcontent(id)
{ 
  var divtext = $(".descriptionshow"+id).html(); 
  $("#myModal").modal('show');  
  $(".workoutcontent").html(divtext);
}
function showallcontentnotes(id)
{ 
  var divtext = $(".preparenotesshow"+id).html(); 
  $("#myModal").modal('show');
  $(".workoutcontent").html(divtext);
}
$('.close_workout').on('click',function(){
 location.reload();
})
</script>
<!-- delete ends -->
@endsection