@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')


<div class="content-wrapper">
 <div  class="workout" style="background-color: #fff!important;width:100%;height:0px; color:#fff; margin:10px;font-size:16px;font-size: 20px;padding: 3px 0px 3px 16px;"><span class="glyphicon glyphicon-ok"></span></div>
	<section class="content userdata">
	<div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Workout</h1>
                    <a href="{{url('/ath_list')}}" class="addworkouttext" style="display:none">< Go back to athlete listing</span>
                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">add workout</li>
                    </ol>
                </div>
            </div>
        </div>
	        <div class="row">
	       
	            <div class="col-12">
	                <!-- /.card -->
	                <div class="card">
	                    <!-- /.card-header -->
	                    <div class="card-body table-responsive csv" style="background: #C9E2CE">
	                      <form name="frmworkout" id="frmworkout" enctype="multipart/form-data">
	                      <input type="hidden" name="typeworkout" id="typeworkout" value="{{@$type}}">
	                      <input type="hidden" name="athid" id="athid" value="{{@$athid}}">
	                    <div class="row">
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="title">Title</label>
					            <input type="text" name="title" class="form-control" id="title" required>
					          </div>  
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="description">Description</label>
					             <textarea class="mceEditoradd" rows="5" name="description" id="description">	
					             </textarea>
					          </div>  
					        </div>

					        @if(Auth::user()->role==2)
					         <div class="col-md-12">
						        <div class="form-group">
						            <label for="workouttype">Category</label><br>
						            <select name="workoutcategory" id="workoutcategory" style="width:100%">
						            @if($type=="personalworkout")
						             <option value="1">Personal</option>
						             @else
						             <option value="0">Global</option>
						            @endif 
						            </select>
						        </div> 
					        </div>
					        @endif
					        @if(Auth::user()->role==0)

					        <div class="col-md-12">
						        <div class="form-group">
						            <label for="workouttype">Category</label><br>
						            <select name="workoutcategory" id="workoutcategory" style="width:100%">
						           <option value="1" selected>Personal</option>
						           <option value="2">Games Prep</option>
						           <option value="3">Complete 60</option>
						           <option value="4">Sweat Session</option>
						           <option value="5">Weightlifting</option>
						            </select>
						        </div> 
					        </div>
					        @endif
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workouttype">Select workout type</label><br>
					            <select name="workouttype" id="workouttype" style="width:100%">
					            <option value="1">Daily Workout</option>
					            <option value="2">Benchmark</option>
					            <option value="3">Barbell PRs</option>
					            </select>
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>
					          <div class="col-md-12 workoutsubtype" style="display:none">
					          <div class="form-group">
					            <label for="workoutsubtype" >Workout subtype</label><br>
					            <input type="text" name="workoutsubtype"  id="workoutsubtype"  style="width:100%">	
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>

					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workoutscore">Select scoring type</label><br>
					            <select name="workoutscore" id="workoutscore" style="width:100%">
						            <option value="1">Minutes and Seconds</option>
						            <option value="2">Rounds and Reps</option>
						            <option value="3">Reps</option>
						            <option value="4">Meters</option>
						            <option value="5">Lbs</option>
						            <option value="6">Calories</option>
					            </select>
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>
					      
					      
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workoutdate">Workout date</label><br>
					            <input type="date" name="workoutdate" id="workoutdate" style="width:100%" required="" onchange="">
					            <div id="workerr" style="color:red"></div> 	
					          </div>  
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="description">Prepare Notes</label>
					            <textarea name = "myeditor" class="mceEditoradd" id="notes"></textarea>
					          </div>  
					        </div>

					         @if(Auth::user()->role==0)
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="athleteworkout">Assign to Athlete</label><br>
					            <select name="athleteworkout" id="athleteworkout" style="width:100%" required>
					            	<option value="">Select athlete</option>
					            	@foreach(@$allathletes as $allath)
						            <option value="{{$allath['id']}}">{{$allath['name']}}-{{$allath['id']}}</option>
						            @endforeach
					            </select>
					          </div>  
					        </div>
					        @endif
					        
					        <!-- <div class="col-md-12">
					          <div class="form-group">
					            <label for="videofile">Video Upload</label><br>
					            <input class="form-control" type="file" name="videofile" id="videofile">
					          </div>  
					          <div class="videoerr" style="color:red"></div>
					        </div> -->
					         <div class="col-md-12">
					        <div class="row">
					          <div class="col-md-4"></div>
					           <div class="col-md-4">
					            <input class="form-control" type="submit" name="btnsubmit" id="btnsubmit" style="background:#3D8DBC;color:#fff"></div>
					             <div class="col-md-4"></div>
					            </div>
					            </div>
	                       
	                           </form>

	                        <!-- /.card-body -->
	                    </div>
	                                
	                </div>
	                <!-- /.card -->
	            </div>
	            <!-- /.col -->
	      
	        <!-- /.row -->
	    </section>
	    </div>

	    <script>
    		var token = "{{ csrf_token() }}";
    		var base_url = "<?php echo url('/'); ?>";
    		$(document).ready(function(){ 
				tinyMCE.init({
		        mode : "specific_textareas",
		        editor_selector : "mceEditoradd" ,
		        height: "300px",
		        plugins: "lists, advlist",
 				toolbar: "numlist bullist"
			});			
    		});
    		function finddate()
        	{
	           var workdate = $('#workoutdate').val();	    
			    $.ajax({
		          url: "{{url('/find-workout')}}",
		          type: 'POST', 
		          data:   {    
		            "_token": token,
		            "workdate": workdate
		          },
		          success: function(response){ 
		            if(response == 0)
		            	$("#workerr").html("workout already added for this date");
		            else
		            	$("#workerr").html("");
		            },    
		          });
	        } 
		</script>

		<script>
		  
		$("#videofile").on("change",function(){			
			var fileType = document.getElementById('videofile').files[0].type; 		
			var video = fileType.split("/", 1);
	        if(video=="video"){$(".videoerr") .html("");}
         	else
         	{
         	 $(".videoerr") .html("Please upload only video file");
         	}
		});
		
	    $("#frmworkout").submit(function(event){
	    	var form = $(this)[0];
	       event.preventDefault(); //prevent default action
	       var form_data = new FormData(form);
	       
	       var description = tinyMCE.get('description').getContent();
	       var notes = tinyMCE.get('notes').getContent();
	       var worktext = $('#workerr').text().length;
	       var typeworkout = $("#typeworkout").val();
	       var athid = $("#athid").val();

	        if(worktext==0){} else{
	        	$('html, body').animate({
				        scrollTop: $("#workerr").offset().top-200
				    	}, 1000);
	        	return false;}
	       if(notes.length==0){alert("Please enter prepare notes text"); return false;}
	        form_data.append('notes',notes);
			form_data.append('_token',token); 
			form_data.append('description',description);
			form_data.append('typeworkout',typeworkout);
			form_data.append('athid',athid);
			
				
	       //console.log(form_data);
	        $.ajax({
			    url: "{{url('/save-workout')}}",
			   type: "POST",
					data : form_data,
					contentType: false,
					cache: false,
					processData:false,
				success: function(response){   
				   if(response == 1){
				   		$(".workout").show();
				   		$('html, body').animate({
				        scrollTop: $(".workout").offset().top-1000
				    	}, 1000);
				   		$(".workout").html("Workout added successfully");
				   		$(".workout").css('background-color', '#28a745');
				   		$(".workout").css('height', '40px');
				   		$("#title").val("");
				   		tinyMCE.get('description').setContent('');
				   		tinyMCE.get('notes').setContent('');
				   		$("#workoutscore")[0].selectedIndex = 0;
				   		$("#workouttype")[0].selectedIndex = 0;
				   		$("#athleteworkout").val('');
				   		$("#workoutsubtype").val('');
				   		$("#workoutdate").val('');
				   		
				   		setTimeout(function(){$(".workout").hide(1000); }, 2000);
				   		//setTimeout(function(){location.reload(); }, 5000);
			        	         
		        	}
		        	else if(response==2)
		        	{
		        		$(".workout").show();
				   		$('html, body').animate({
				        scrollTop: $(".workout").offset().top-1000
				    	}, 1000);
				   		$(".workout").html("Workout added successfully");
				   		$(".workout").css('background-color', '#28a745');
				   		$(".workout").css('height', '40px');
				   		$("#title").val("");
				   		tinyMCE.get('description').setContent('');
				   		tinyMCE.get('notes').setContent('');
				   		$("#workoutscore")[0].selectedIndex = 0;
				   		$("#workouttype")[0].selectedIndex = 0;
				   		$("#athleteworkout").selectedIndex = 0;
				   		$("#workoutsubtype").val('');
				   	    $("#athleteworkout").val('');
				   		$("#workoutdate").val('');
				   		setTimeout(function(){$(".workout").hide(1000); }, 2000);
				   		$(".addworkouttext").show();
				   		/*setTimeout(function(){window.location = base_url+"/ath_list"}, 2000);*/

		        	}
				},    
			});
	   });

	    $(document).on('change',"#workouttype",function(){
	    	if($(this).val()!=1)
	    		$('.workoutsubtype').show();
	    	else
	    		$('.workoutsubtype').hide();
	    });
	  
	  

</script>

@endsection



