
	                    <form name="frmworkout" id="frmworkout" enctype="multipart/form-data">
	                    <input type="hidden" value="edit" name="editworkout">
	                    <input type="hidden" value="{{@$workout->id}}"" name="editworkoutid">

	                    <div class="row">
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="title">Title</label>
					            <input type="text" name="title" class="form-control" id="title" required value="{{@$workout->title}}">
					          </div>  
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="description">Description</label>
					              <textarea class="mceEditor" id="editor1">   
					              <?php echo html_entity_decode($workout->description);?>
					             </textarea>
					          </div>  
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workouttype">Select workout type</label><br>
					            <select name="workouttype" id="workouttype" style="width:100%">
					            <option value="1" {{@$workout->type=='simple'?'selected':''}}>Daily Workout</option>
					            <option value="2" {{@$workout->type=='Benchmark'?'selected':''}}>Benchmark</option>
					            <option value="3" {{@$workout->type=='Barbell PRs'?'selected':''}}>Barbell PRs</option>
					            </select>
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workouttype">Select scoring type</label><br>
					            <select name="workoutscore" id="workoutscore" style="width:100%">
					            <option value="1" {{@$workout->scoring_type==1?'selected':''}}>Minutes and Seconds</option>
						        <option value="2" {{@$workout->scoring_type==2?'selected':''}}>Rounds and Reps</option>
						        <option value="3" {{@$workout->scoring_type==3?'selected':''}}>Reps</option>
						        <option value="4" {{@$workout->scoring_type==4?'selected':''}}>Meters</option>
						        <option value="5" {{@$workout->scoring_type==5?'selected':''}}>Lbs</option>
						        <option value="6" {{@$workout->scoring_type==6?'selected':''}}>Calories</option>
					            </select>
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>
					        @if (@$workout->type!='simple')
					        <div class="col-md-12 workoutsubtype">
					          <div class="form-group">
					            <label for="workoutsubtype" >Workout subtype</label><br>
					            <input type="text" name="workoutsubtype"  style="width:100%" value="{{@$workout->subtype}}">	
					          </div>  
					          <!-- <div class="videoerr" style="color:red"></div> -->
					        </div>
					        @endif
					        <div class="col-md-12">
						        <div class="form-group">
						            <label for="workouttype">Select Category</label><br>
						            <select name="workoutcategory" id="workoutcategory" style="width:100%">
						            @if(Auth::user()->role==2 && $workout->category==0)
						            <option value="0" {{@$workout->category==0?'selected':''}}>Global</option>

						            @else
						            <option value="1" {{@$workout->category==1?'selected':''}}>Personal</option>
						           
						            <option value="2" {{@$workout->category==2?'selected':''}}>Games Prep</option>
						          
						            <option value="3" {{@$workout->category==3?'selected':''}}>Complete 60</option>
						         
						            <option value="4" {{@$workout->category==4?'selected':''}}>Sweat Session</option>
						           
						            <option value="5" {{@$workout->category==5?'selected':''}}>Weightlifting</option>
						            @endif
						            </select>
						        </div> 
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="workoutdate">Workout date</label><br>
					            <input type="date" name="workoutdate" id="workoutdate" style="width:100%" required="" onchange="" value="{{@$workout->workout_date}}">
					            <div id="workerr" style="color:red"></div> 	
					          </div>  
					        </div>
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="description">Prepare Notes</label>
					            <textarea  class="mceEditor" id="editor2">
					            <?php echo html_entity_decode($workout->prepare);?>
					            </textarea>
					          </div>  
					        </div>
					       @if(Auth::user()->role==0)
					        <div class="col-md-12">
					          <div class="form-group">
					            <label for="athleteworkout">Assign to Athlete</label><br>
					            <select name="athleteworkout" id="athleteworkout" style="width:100%" required>
					            	<option value="">Select athlete</option>
					            	@foreach(@$allathletes as $allath)
						            <option value="{{$allath['id']}}" {{@$workout->assigned_to==$allath['id']?'selected':''}}>{{$allath['name']}}-{{$allath['id']}}</option>
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
					            </div>
	                           </form>
	   
	              
	    <script>
    		var token = "{{ csrf_token() }}";
    		var base_url = "<?php echo url('/'); ?>";
    		$(document).ready(function(){ 
				tinyMCE.init({
		        mode : "specific_textareas",
		        editor_selector : "mceEditor" ,
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
	    	event.preventDefault();
	    	
	    	var form = $(this)[0];
	       event.preventDefault(); 
	       var form_data = new FormData(form);
	       var description = tinyMCE.get('editor1').getContent();
	       var notes = tinyMCE.get('editor2').getContent();

	       var worktext = $('#workerr').text().length;

	        if(worktext==0){} else{
	        	$('html, body').animate({
				        scrollTop: $("#workerr").offset().top-200
				    	}, 1000);
	        	return false;}
	       if(notes.length==0){alert("Please enter prepare notes text"); return false;}
	        form_data.append('notes',notes);
	        form_data.append('description',description);
			form_data.append('_token',token); 
			
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
				   	$('#MyModalworkout').modal('hide');

				   		$(".workout").show();
				   		$('html, body').animate({
				        scrollTop: $(".workout").offset().top-1000
				    	}, 1000);
				   		$(".workout").html("workout edited successfully");
				   		$(".workout").css('background-color', '#28a745');
				   		$(".workout").css('height', '40px');
				   		setTimeout(function(){$(".workout").hide(1000); }, 3000);
				   		setTimeout(function(){location.reload(); }, 700);

				   		$("#title").val("");
				   		$("#description").val("");
				   		tinyMCE.activeEditor.setContent('');
				   		$("#videofile").val(''); 
			        	         
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




