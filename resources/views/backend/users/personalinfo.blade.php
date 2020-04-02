@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@if($role==0) Coach 
                        @else Athlete 
                    @endif 
                    Personal information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">athlete personal information</li>
                    </ol>

                </div>
            </div>
            @if(Route::currentRouteName() == 'viewuserinfo') 
              @if($role==0 && $type=="")
                  <a href="{{url('/coach_list')}}">< Back</a>
                @elseif($role==1 && $type=="")
                  <a href="{{url('/ath_list')}}">< Back</a>
                @elseif($role==1 && $type=="coach")
                  <a href="{{url('/viewathletes'.'/'.base64_encode(@$coachid))}}">< Back</a>
              @endif
            @endif
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
                    <div class="card-body table-responsive csv">
                        <table  class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(@$athletedata as $key=>$value) 
                                  <tr>
                                    <th class="fit">Name</th><td>{{ $value->name }}</td>
                                  </tr>
                                  <tr>
                                    <th class="fit">ID</th> <td>{{ $value->id }}</td>
                                  </tr>
                                  <tr> 
                                  <th class="fit">Email</th><td>{{ $value->email }}</td>
                                  </tr>
                                  <tr> 
                                    <th class="fit">DOB</th><td>{{ $value->dob }}</td>
                                  </tr>
                                  <tr> 
                                    <th class="fit">Gender</th>
                                   <td>{{ $value->gender }}</td>
                                  </tr>
                                  <tr>
                                  @if($value->role==0)
                                    <tr> 
                                      <th class="fit">Phone No</th>
                                       <td>{{ $value->phone }}</td>
                                    </tr>
                                    <tr> 
                                      <th class="fit">Country</th>
                                       <td>{{ $value->country }}</td>
                                    </tr>
                                    <tr> 
                                      <th class="fit">State</th>
                                       <td>{{ $value->state }}</td>
                                    </tr>
                                     <tr> 
                                      <th class="fit">City</th>
                                       <td>{{ $value->city }}</td>
                                    </tr>
                                     <tr> 
                                      <th class="fit">Zipcode</th>
                                       <td>{{ $value->zipcode }}</td>
                                    </tr>
                                     <tr> 
                                      <th class="fit">Coach Bio</th>
                                       <td>{{ $value->bio }}</td>
                                    </tr>
                                   
                                   
                                  @endif
                                  @if($value->role==1)
                                    <th class="fit">Age</th>
                                      <td>{{ $value->age }}</td>
                                    </tr>
                                    <tr> 
                                      <th class="fit">Weight(in lbs)</th>
                                      <td>{{ $value->weight }}</td>
                                    </tr>
                                    <tr>
                                      <th class="fit">Height(total inches)</th>
                                      <td>{{ $value->height }}</td></tr>
                                 
                                  <tr>
                                  <tr>
                                   <th class="fit">Image</th>
                                    <td>
                                       @if($value->image!="")
                                       <img src = "{{url('/images').'/'.$value->image }}" width=50 height=50>
                                       @else
                                        <img src = "{{url('/images').'/noimage.png' }}" width=100 height=100>
                                        @endif
                                      </td>
                                       
                                    </tr>
                                     @endif
                                    <tr>
                                    <th class="fit">Cover Image</th>
                                    <td>
                                       @if($value->cover_image!="")
                                       <img src = "{{url('/images').'/'.$value->cover_image }}" width=50 height=50>
                                       @else
                                        <img src = "{{url('/images').'/noimage.png' }}" width=100 height=100>
                                        @endif
                                      </td>
                                      </tr>
                                   <tr>
                                      <th class="fit">Coach Name</th>
                                      <td>{{ @$coachName }}</td>
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

<!-- delete ends -->
@endsection