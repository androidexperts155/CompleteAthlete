@extends('layouts.master')
@section('title', 'AdminProfile')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        @include('layouts.message')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('/images/'.Auth::user()->image) }}"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                                <!-- <p class="text-muted text-center">Software Engineer</p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane active show" id="settings">
                                        <form class="form-horizontal" id="form_profile" action="{{ url('admin_profile') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <?php //echo "<pre>";print_r($errors); ?>
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" value="{{ Auth::user()->name }}">
                                                    @if ($errors->has('firstname'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('firstname') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                                                    @if ($errors->has('email'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Phone Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputEmail" placeholder="Phone Number" name="phone_number" value="{{ Auth::user()->phone_number }}">
                                                    @if ($errors->has('phone_number'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div> -->
                                           <!--  <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Location</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Address" name="location" value="{{ Auth::user()->location }}" value="{{ Auth::user()->location }}">
                                                    @if ($errors->has('location'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('location') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="inputp"  name="new_password" >
                                                    @if ($errors->has('new_password'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('new_password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">New Image</label>
                                                <div class="col-sm-10">
                                                    <input type="file" class="form-control" id="inputI"  name="new_image" >
                                                    @if ($errors->has('new_image'))
                                                        <span class="error">
                                                            <strong>{{ $errors->first('new_image') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection