@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')

<div id="videomodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header cat_header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Video</h4>
      </div>
      <div class="modal-body" id="videodata">
         
      </div>
    </div>
  </div>
</div>

<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload Video and Listing</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">video upload and listing</li>
                </ol>
            </div>
        </div>
      </div>
      <!-- /.container-fluid -->
  </section>
  @include('layouts.message')
  <!-- Main content -->
   <div class="alert alert-success" style="display:none;color:#fff"></div>
  <section>     
      <div class="col-12">
          <div class="card">
              <div class="card-body">
                <form method="post" action ="{{url('/video_upload')}}" enctype="multipart/form-data" class="videoform">
                {{csrf_field()}}
                  <table width="100%" class="table table-bordered table-striped">
                  <tr><td width="50%" style="background: #C9E2CE"><b>Upload Video Here</b></td>
                  <td width="50%" style="background: lightblue">
                    <input type="file" name="videofile"  class="videofile" required="" ></td>
                  </td></tr>
                  <tr>
                  <td width="50%" style="background: #C9E2CE"><b>Select date</b>
                   </td>
                    <td width="50%" style="background: lightblue">
                     <input type="date" name="videodate1" class="videodate" required="">
                  
                     <div class="errmsg" style="color:red">
                    
                     </div>
                  </tr>
                  <td width="50%" colspan="2" align="center" style="background: #C9E2CE">
                    <button type="submit" class="btn btn-default"  id="btn_video" style="width:30%;margin-top: 20px;background: lightblue"><b>Submit</b></button>
                  </td>
                  <tr>
                     <td width="100%" style="background: lightblue">
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow=""
                          aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            0%
                        </div>
                      </div>
                      <div id="success">

                    </div>
                    </td>
                  </tr>

                  </table>
                </form>
              </div>
                          
          </div>
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive csv">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th class="fit">S.No.</th>
                        <th class="fit">Video</th>
                        <th class="fit">Date created</th>
                        <th class="fit">Action</th>
                    </tr>
                  </thead>
                    <tbody>
                    @foreach($videodata as $key=>$value)
                      <tr>
                         <td>{{$key++}}</td>
                        <td><a href="" class= "videoplay" data-video="{{url('/workouts').'/'.$value->video}}">{{$value->video}}<br>click to open/download</a></td>
                        <td>{{$value->created_at}}</td>
                        <td>
                          <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deletevideo('{{@$value->id}}')">
                            <i class="fa fa-fw fa-trash" ptitle="delete" style="color: red;"></i>
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
  </section>
  <!-- /.content -->
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 

<script>

 var token = "{{ csrf_token() }}";
  var base_url = "<?php echo url('/'); ?>";
  $(document).ready(function(){
   if ( $('.videodate').prop('type') != 'date' ) $('.videodate').datepicker(); });


$(".videodate").on('change',function(){
  var dateval = $(this).val();
  $.ajax({
    url : "{{url('/video_datecheck')}}",
    type:'POST',
     cache: false,
    data:{"_token":token , "dateval": dateval},
    success:function(response)
    {
      if(response==1){
        $(".errmsg").html("video already uploaded for this date");
        $("#btn_video").prop('disabled',true);
      }
      else{
         $(".errmsg").html("");
        $("#btn_video").prop('disabled',false);
      }
    }
  });
})


function deletevideo(id){
  swal({
    title: "Are you sure to delete video?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
          url: base_url + '/delete/video',
          type: 'POST',
          dataType: 'JSON',
          cache: false,
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
$(".videoplay").on('click',function(){
  var videolink = $(this).attr('data-video');
  $("#videosrc").attr('src',videolink);
  window.open(videolink, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
  
})


})

$(document).ready(function(){

    $('form').ajaxForm({
     
      beforeSend:function(){

        $('#success').empty();
      },
      uploadProgress:function(event, position, total, percentComplete)
      {
        
        $('.progress-bar').text(percentComplete + '%');
        $('.progress-bar').css('width', percentComplete + '%');
      },
      success:function(data)
      {

        if(data.errors)
        {
          $('.progress-bar').text('0%');
          $('.progress-bar').css('width', '0%');
          $('#success').html('<span class="text-danger"><b>'+data.errors+'</b></span>');
          
        }
        
        
        if(data.success)
        {
         
          $('.progress-bar').text('Uploaded');
          $('.progress-bar').css('width', '100%');
          $('#success').html('<span class="text-success"><b>'+data.success+'</b></span><br /><br />');
          $('#success').append(data.image);
          $(".alert-success").show().html("video uploaded successfully");
          $(".videodate").val("");
         $(".videofile").val("");

        setTimeout(function(){ $(".alert-success").hide('slow'); }, 1000);
         setTimeout(function(){ location.reload(); }, 1500);
       
        }
      }
    });

});


</script>
@endsection