@extends('layouts.master')
@section('title', 'DashBoard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li> -->
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        @include('layouts.message')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info" style="background:#f39c12!important">
                                                <!-- <div class="small-box bg-success"> -->

                            <div class="inner">
                                <h3>{{$athletes}}</h3>
                                <p>Number of Athletes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('/ath_list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @if(Auth::user()->role==2)
                     <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info" style="background:#28a745!important">
                                                <!-- <div class="small-box bg-success"> -->

                            <div class="inner">
                                <h3>{{$coach}}</h3>
                                <p>Number of Coaches</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('/coach_list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
           
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

          
@endsection