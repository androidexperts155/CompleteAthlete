@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nutrition Accuracy Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">nutrition details</li>
                </ol>
            </div>
        </div>
          <a href="{{url('/ath_list')}}">< Back</a>
    </div>
  </section>
  @include('layouts.message')
  <!-- Main content -->
  <section class="content userdata">   
    <div class="card">
      <!-- /.card-header -->
      <div id="tabs">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="1" data-toggle="tab" href="#consumed" role="tab" aria-controls="home"
            aria-selected="true">Consumed
            </a>
            
          </li>
          <li class="nav-item">
            <a class="nav-link" id="2" data-toggle="tab" href="#remaining" role="tab" aria-controls="profile"
            aria-selected="false">Remaining</a>
            
          </li>  
          <li class="nav-item">
            <a class="nav-link" id="3" data-toggle="tab" href="#calories" role="tab" aria-controls="calories"
            aria-selected="false">Calories and Percentage</a>
            
          </li>  
        </ul>
    </div>
    <div class="rr" style="width:100%;text-align: center;margin-top: 29px;
      margin-bottom: 20px;">
      <span class="test" style="background: #80A7D0;
        padding: 10px 10px;">
         <span class="labeltext"></span>
        </span> 
      <span class="labeltext1" style="background: #D28583;
        padding: 10px 31px;">total
      </span>
    </div>
    <div class="tab-content" id="myTabContent">
    <div class="row three">
      <div class="col-md-6"> 
      <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
            <?php 
            $p = $diet['calories'];
            $dataPointscal = array( 
               array("label"=>"calories", "y"=>$p)                           
            ) 
            ?>
          <div id="chartContainer31" style="height: 370px; width:90%;"></div>
        </div></div>
      <div class="col-md-6"> 
       <?php 
            $p = $diet['percentage'];
            $dataPointsper = array( 
               array("label"=>"percent", "y"=>$p)                           
            ) 
            ?>

      <div id="chartContainer32" style="height: 370px; width:90%;"></div>
      </div>
    </div>
      <div class="row one">
        <div class="col-md-4">
          <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
            <?php 
            $p = $diet['proteins'];
            $dataPoints11 = array( 
               array("label"=>"consumed", "y"=>$p), 
               array("label"=>"total", "y"=>$diet['total_proteins']),              
            ) 
            ?>
          <div id="chartContainer11" style="height: 370px; width:90%;"></div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
          <?php 
          $dataPoints12 = array( 
             array("label"=>"consumed", "y"=>$diet['carbs']), 
             array("label"=>"total", "y"=>$diet['total_carbs']),           
          ) 
          ?>
        <div id="chartContainer12" style="height: 370px; width: 90%;"></div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
            <?php 
            $dataPoints13 = array( 
               array("label"=>"consumed", "y"=>$diet['carbs']), 
               array("label"=>"total", "y"=>$diet['total_fats']),           
            ) 
            ?>
          <div id="chartContainer13" style="height: 370px; width: 90%;"></div>
          </div>
        </div>       
      </div>
   
      <div class="row two">
      <div class="col-md-4">
        <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
          <?php 
            $dataPoints21 = array( 
            array("label"=>"remaining", "y"=>$diet['total_proteins']-$diet['proteins']), 
            array("label"=>"total", "y"=>$diet['total_proteins']),           
          ) 
          ?>
        <div id="chartContainer21" style="height: 370px; width: 90%;"></div>
        </div>
      </div>
        <div class="col-md-4">
        <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
          <?php 
          $dataPoints22 = array( 
             array("label"=>"remaining", "y"=>$diet['total_carbs']-$diet['carbs']), 
             array("label"=>"total", "y"=>$diet['total_carbs']),           
          ) 
          ?>
        <div id="chartContainer22" style="height: 370px; width: 90%;"></div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="pro-tab">
            <?php 
            $dataPoints23 = array( 
               array("label"=>"remaining", "y"=>$diet['total_fats']-$diet['carbs']), 
               array("label"=>"total", "y"=>$diet['total_fats']),           
            ) 
            ?>
          <div id="chartContainer23" style="height: 370px; width: 90%;"></div>
          </div>
        </div>       
      </div>
      <!-- /.card -->
  </div> 
  </section>
  <!-- /.content -->
</div>


<script>
$('a[data-toggle=tab]').click(function(){

for(var i=1; i<=3;i++){ 
  if(this.id==1 && i==1) {
    var my =  <?php echo json_encode($dataPoints11, JSON_NUMERIC_CHECK); ?>
  }
  if(this.id==1 && i==2){
    var my =  <?php echo json_encode($dataPoints12, JSON_NUMERIC_CHECK); ?> 
  }
  if(this.id==1 && i==3){
    var my =  <?php echo json_encode($dataPoints13, JSON_NUMERIC_CHECK); ?> }
  if(this.id==3 && i==1) {
    var my =  <?php echo json_encode($dataPointscal, JSON_NUMERIC_CHECK); ?>
  }
  if(this.id==3 && i==2){
    var my =  <?php echo json_encode($dataPointsper, JSON_NUMERIC_CHECK); ?> 
  }
  if(this.id==2 && i==1){
    var my =  <?php echo json_encode($dataPoints21, JSON_NUMERIC_CHECK); ?> }
  if(this.id==2 && i==2){
     var my =  <?php echo json_encode($dataPoints22, JSON_NUMERIC_CHECK); ?> }
  if(this.id==2 && i==3){
     var my =  <?php echo json_encode($dataPoints23, JSON_NUMERIC_CHECK); ?> 
  }
  if(i==1 && this.id==1 || this.id==2) msg = "Proteins";
  if(i==2 && this.id==1 || this.id==2) msg = "Carbohydrates";
  if(i==3 && this.id==1 || this.id==2) msg = "Fats"; 
  if(i==1 && this.id==3) msg = "Calories"; 
  if(i==2 && this.id==3) msg = "Percentage"; 

  if(this.id==2) { 
    $(".one").hide(); 
    $(".two").show();
    $(".three").hide();
    $(".rr").show();
    $(".labeltext").html("remaining");

  }
  else if(this.id==1)
  {
   $(".two").hide(); 
   $(".one").show();
   $(".three").hide();
   $(".rr").show();
   $(".labeltext").html("consumed");
  }
   else if(this.id==3)
  {
   $(".two").hide(); 
   $(".one").hide();
   $(".three").show();
   $(".rr").hide();

  }

  var chart = new CanvasJS.Chart("chartContainer"+this.id+i, {
    animationEnabled: true,
    title: {     
      text: msg
    },    

    data: [{
      type: "doughnut",
      indexLabelFontSize: 20,
      indexLabelFontColor: "white",      
      indexLabel: "{y}",
      startAngle: 270,
      innerRadius: 50,
      indexLabelPlacement: "inside",      
      dataPoints: my,

    }]
  });
  chart.render();
}
})
 window.onload = function() { 
  $('a[href="#consumed"]').trigger('click'); 
  $(".labeltext").html("consumed");
 }

</script>
<body>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!-- delete ends -->
@endsection