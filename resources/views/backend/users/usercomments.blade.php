@extends('layouts.master')
@section('title', 'Workouts Listing')
@section('content')



<div class="content-wrapper">
  <div  class="workout" style="background-color: #fff!important;width:100%;height:0px; color:#fff; margin:10px;font-size:16px;font-size: 20px;padding: 3px 0px 3px 16px;"><span class="glyphicon glyphicon-ok"></span></div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{@$workname['title']}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User workouts</li>
                    </ol>
                </div>
            </div>
           <a href="{{url('viewusersworkout/').'/'.@$workid}}">< Back</a>
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
                                  <td><b>All Comments</b></td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(@$allcomments as $key=>$comment)
                            <tr>
                            <td>
                            <div class='readmore' id="readmore{{$key}}" data-id ={{$key}}>
                              <?php 
                              if(strlen($comment->comments)>80)
                              echo substr($comment->comments, 0,80)."<a href='javascript:void(0)'>Read more.....</a>";
                              else
                                 echo $comment->comments;
                              ?>

                              </div>
                              <div id="readless{{$key}}" style="display:none">
                                {{$comment->comments}}."<a href='javascript:void(0)' data-id ={{$key}} class='readless'>  Read less</a>
                                

                              </div>
                               <a style="float:right" href="{{url('/viewuserinfo/').'/'.@$userid}}"><b>Commented By:</b><u>  {{$usernames[$comment->commentedby]}}</u></a>
                                
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.readmore').on('click',function(){
     var key = $(this).attr('data-id');
    $('#readless'+key).toggle();
    $(this).toggle();

    });

     $('.readless').on('click',function(){
       var key = $(this).attr('data-id');
      $('#readmore'+key).toggle();
      $('#readless'+key).toggle();
     
    });
  });


</script>

@endsection