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
                    <h1>All users on this workout</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User workouts</li>
                    </ol>
                </div>
            </div>
           <a href="{{url('/workout_listing')}}">< Back</a>
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
                                <th colspan="5" style="text-align:center;font-size: 20px;background: #C9E2CE">
                             {{@$workname['title']}} </span>
                    </h1></th>
                                    <tr style="background: #C9E2CE">
                                    <th class="fit" rowspan="2" style="text-align: center;vertical-align: middle">S.No.</th>
                                    <th class="fit" style="text-align: center;vertical-align: middle" rowspan="2">User Id</th>
                                    <th class="fit" style="text-align: center;vertical-align: middle" rowspan="2">User Name</th>
                                    <th class="fit" style="text-align: center;vertical-align: middle" colspan="2">Action</th></tr>
                                    <tr style="background: #C9E2CE">
                                    <th class="fit" style="text-align: center;vertical-align: middle">Comments</th><th class="fit">Hi-Fives</th></tr>
                                   
                                
                            </thead>
                            <tbody>
                            @foreach(@$userwrk as $key=>$wrk)
                            <tr>
                              <td>{{ ++$key }}</td>
                              <td>{{ $wrk->userid }}</td>
                              <td>{{ $usernames[$wrk->userid] }}</td>
                             
                              <td>
                              <div class="hifive">
                              <a href="{{url('/viewuserscomments/').'/'.base64_encode($wrk->userid).'/'.base64_encode($wrk->workoutid)}}">{{$wrk['comm']}} <i class="fa fa-comments" aria-hidden="true" style="font-size:32px"></i></a></td><!-- <a href="{{url('/viewusershifives/').'/'.base64_encode($wrk->userid).'/'.base64_encode($wrk->workoutid)}}"> --><td>{{$wrk->fives}}<img src="{{url('/hifive.png')}}" width=35px height=35px style="margin-top: -10px;margin-left: 10px;"><!-- </a> -->
                              </div>
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

<div id="MyModalworkout" class="modal fade" role="dialog" style="margin-left:20%">
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



@endsection