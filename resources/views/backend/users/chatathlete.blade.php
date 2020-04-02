@extends('layouts.master')
@section('title', 'Chat with Athlete')
@section('content')

<style>
	body,html{
			height: 100%;
			margin: 0;
			background: #7F7FD5;
	       background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
	        background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
		}
		.bg-white
		{
			background-color:#3c8dbc !important;
		}

		.chat{
			margin-top: auto;
			margin-bottom: auto;
		}
		.card{
			height: 500px;
			border-radius: 15px !important;
			background-color: rgba(0,0,0,0.4) !important;
		}
		.contacts_body{
			padding:  0.75rem 0 !important;
			overflow-y: auto;
			white-space: nowrap;
		}
		.msg_card_body{
			overflow-y: auto;
		}
		.card-header{
			border-radius: 15px 15px 0 0 !important;
			border-bottom: 0 !important;
		}
	 .card-footer{
		border-radius: 0 0 15px 15px !important;
			border-top: 0 !important;
	}
		.container{
			align-content: center;
		}
		.search{
			border-radius: 15px 0 0 15px !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
		}
		.search:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.type_msg{
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
			height: 60px !important;
			overflow-y: auto;
		}
			.type_msg:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.attach_btn{
	border-radius: 15px 0 0 15px !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.send_btn{
	border-radius: 0 15px 15px 0 !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.search_btn{
			border-radius: 0 15px 15px 0 !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.contacts{
			list-style: none;
			padding: 0;
		}
		.contacts li{
			width: 100% !important;
			padding: 5px 10px;
			margin-bottom: 15px !important;
		}
	.active{
			background-color: rgba(0,0,0,0.3);
	}
		.user_img{
			height: 70px;
			width: 70px;
			border:1.5px solid #f5f6fa;
		
		}
		.user_img_msg{
			height: 40px;
			width: 40px;
			border:1.5px solid #f5f6fa;
		
		}
	.img_cont{
			position: relative;
			height: 70px;
			width: 70px;
	}
	.img_cont_msg{
			height: 40px;
			width: 40px;
	}
	.online_icon{
		position: absolute;
		height: 15px;
		width:15px;
		background-color: #4cd137;
		border-radius: 50%;
		bottom: 0.2em;
		right: 0.4em;
		border:1.5px solid white;
	}
	.offline{
		background-color: #c23616 !important;
	}
	.user_info{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 15px;
	}
	.user_info span{
		font-size: 20px;
		color: white;
	}
	.user_info p{
	font-size: 10px;
	color: rgba(255,255,255,0.6);
	}
	.video_cam{
		margin-left: 50px;
		margin-top: 5px;
	}
	.video_cam span{
		color: white;
		font-size: 20px;
		cursor: pointer;
		margin-right: 20px;
	}
	.msg_cotainer{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 10px;
		border-radius: 25px;
		background-color: #82ccdd;
		padding: 10px;
		position: relative;
	}
	.msg_cotainer_send{
		margin-top: auto;
		margin-bottom: auto;
		margin-right: 10px;
		border-radius: 25px;
		background-color: #78e08f;
		padding: 10px;
		position: relative;
	}
	.msg_time{
		position: absolute;
		left: 0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_time_send{
		position: absolute;
		right:0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_head{
		position: relative;
	}
	#action_menu_btn{
		position: absolute;
		right: 10px;
		top: 10px;
		color: white;
		cursor: pointer;
		font-size: 20px;
	}
	.action_menu{
		z-index: 1;
		position: absolute;
		padding: 15px 0;
		background-color: rgba(0,0,0,0.5);
		color: white;
		border-radius: 15px;
		top: 30px;
		right: 15px;
		display: none;
	}
	.action_menu ul{
		list-style: none;
		padding: 0;
	margin: 0;
	}
	.action_menu ul li{
		width: 100%;
		padding: 10px 15px;
		margin-bottom: 5px;
	}
	.action_menu ul li i{
		padding-right: 10px;
	
	}
	.action_menu ul li:hover{
		cursor: pointer;
		background-color: rgba(0,0,0,0.2);
	}
	.msg_time_send {
    position: relative;
    right: 0;
    bottom: -15px;
    color: #fff;
    font-size: 14px;
    top: 30px;
}
	.chat-body {	    
	    flex: 2 0 50% !important;
	    max-width: 70% !important;
	    position: relative;
	    left: 10%;
	}
	@media(max-width: 576px){
	.contacts_card{
		margin-bottom: 15px !important;
	}
	}
</style>


		<title>Chat</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
	</head>
<div class="modal" id="media" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Media type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form>
      	 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
        <p>
	        <input type="radio" name="rdomedia" value="2">Image<br>
	        <input type="radio" name="rdomedia" value="3">Video(mp4)<br>
	        <input type="radio" name="rdomedia" value="4">File(PDF)
        </p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary mediaok">OK</button>
       
      </div>
    </div>
  </div>
</div>

	
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				
				<div class="col-md-8 col-xl-6 chat chat-body">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
								
									@if(@$athimg!="")
											<img src="{{url('/images').'/'.@$athimg}}" class="rounded-circle user_img">
											@else
											<img src="{{url('/images/noimage.png')}}"
											class="rounded-circle user_img">
											@endif
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>Chat with {{@$athname}} </span>
									<p>{{@$allmessagesno}} Messages</p>
								</div>
								
							</div>
							
						</div>
						<div class="card-body msg_card_body" id="message_details">
							@foreach($allmessages as $msg)
								@if($msg->sender_id==$athlete_id)
									<div class="d-flex justify-content-start mb-4">
										<div class="img_cont_msg">
											@if(@$athimg!="")
											<img src="{{url('/images').'/'.@$athimg}}" class="rounded-circle user_img_msg">
											@else
											<img src="{{url('/images/noimage.png')}}"
											class="rounded-circle user_img_msg">
											@endif
										</div>
										<div class="msg_cotainer">
										@if($msg->type==2)
											<img src="{{url('/attachments').'/'.$msg->media}}" width="150px" height="150px">
										@elseif($msg->type==3)
											<a  href="{{url('/attachments').'/'.$msg->media}}" download>Video Sent.</a>			 
										@elseif($msg->type==4)
											<a download href="{{url('/attachments').'/'.$msg->media}}">PDF Sent.</a>
										@else
											{{$msg->media}}
										@endif
											<span class="msg_time_send">{{$msg->time_info}}</span>
										</div>
									</div>
									@else
									<div class="d-flex justify-content-end mb-4">

										<div class="msg_cotainer_send">
										@if($msg->type==2)
											<img src="{{url('/attachments').'/'.$msg->media}}" width="150px" height="150px">
										@elseif($msg->type==3)
											<a  href="{{url('/attachments').'/'.$msg->media}}" download>Video Sent.</a>	
										@elseif($msg->type==4)
											<a download href="{{url('/attachments').'/'.$msg->media}}">PDF Sent PDF.</a>
										@else
											{{$msg->media}}
										@endif
											<span class="msg_time_send">{{$msg->time_info}}</span>
										</div>
										<div class="img_cont_msg">
											@if(@$coachimg!="")
												<img src="{{url('/images').'/'.@$coachimg}}" class="rounded-circle user_img_msg">
											@else
												<img src="{{url('/images/noimage.png')}}"
											class="rounded-circle user_img_msg">
											@endif
										</div>
										<div class="img_cont_msg">
									<img src="">
										</div>
									</div>
								@endif	
							@endforeach								
						</div>
						<form enctype='multipart/form-data'>
						<input type="hidden" id="coachid" value="{{@$coach_id}}">
						<input type="hidden" id="athleteid" value="{{@$athlete_id}}">
						<input type="hidden" id="mediatype">
						<input id="file_upload" type="file"  name="file_upload" style="display: none;" >
						<div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip" title="attachment"></i></span>
								</div>
								
									<textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
									<div class="input-group-append">
										<span class="input-group-text send_btn"><i class="fas fa-location-arrow savemessagebtn" title="send message"></i></span>
									</div>
								
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<script>	

var token = "{{ csrf_token() }}";
$(document).ready(function(){
	$("#message_details").stop().animate({ scrollTop: $("#message_details")[0].scrollHeight}, 100);
	var base_url = "<?php echo url('/'); ?>";
	var coachid = $("#coachid").val();
	var athid = $("#athleteid").val();

	setInterval(function(){  
	fetch_messages(coachid,athid);
	}, 100);

});


function fetch_messages(coachid,athid)
 { 	
 	var coachid = $("#coachid").val();
	var athid = $("#athleteid").val();
	$.ajax({

	   url:"{{url('/chatathlete')}}",
	   method:"POST",
	   data: {"_token": token,'type1':1,'coachid':coachid,'athid':athid},
	   success:function(data){
	    $('#message_details').html(data.html);
	   }
	})
 }
 $(".type_msg").on("keyup", function(event) {
  if (event.keyCode === 13) {
    $(".savemessagebtn").click();
    $(".type_msg").val("");
    $("#message_details").stop().animate({ scrollTop: $("#message_details")[0].scrollHeight}, 100);
  }
});

$(".savemessagebtn").on('click',function(){ 
	$("#message_details").stop().animate({ scrollTop: $("#message_details")[0].scrollHeight}, 100);	
 	var msg = $(".type_msg").val();
 	var coachid = $("#coachid").val();
	var athid = $("#athleteid").val();
 	
 	$.ajax({
	   url:"{{url('/savemessage')}}",
	   method:"POST",
	   data: {"_token": token,'coachid':coachid,'athid':athid,'message':msg,'typemsg':'1'},

	   success:function(data){
	    $('#message_details').html(data.html);
	    $(".type_msg").val("");
	   }
  	})
 });
 

 $(".fa-paperclip").on('click',function(){
 
	$("#media").modal('show');

 });

$(".mediaok").on('click',function(){
	
	var media = $("input[name='rdomedia']:checked").val();
	$("#media").modal('hide');
	$("#mediatype").val(media);
	$("#file_upload").click();
});

 $(document).ready(function(){

        $('input[type="file"]').change(function(e){   
        	$("#message_details").stop().animate({ scrollTop: $("#message_details")[0].scrollHeight}, 100);	     	
            var file_data = $('#file_upload').prop('files')[0];
            var form_data = new FormData();
            form_data.append('filename', file_data);
            var coachid = $("#coachid").val();
			var athid = $("#athleteid").val();
			var typemsg = $("#mediatype").val();
			var token = $("#csrf-token").val();
			form_data.append('coachid', coachid);
			form_data.append('athid', athid);
			form_data.append('typemsg', typemsg);
			form_data.append('_token', token);			
			$.ajax({
			   	url:"{{url('/savemessage')}}",
			   	method:"POST",
			   	cache: false,
	            contentType: false,
	            processData: false,
	            data: form_data,
	           
			   success:function(data){
			   
			    $('#message_details').html(data.html);
			   }
  			})          
        });
    });
	/*$("#message_details").stop().animate({ scrollTop: $("#message_details")[0].scrollHeight}, 100);	
 	var msg = $(".type_msg").val();
 	var coachid = $("#coachid").val();
	var athid = $("#athleteid").val();
	var file = $("#file_upload").val();
	alert(file);*/
 	/*$.ajax({
	   url:"{{url('/savemessage')}}",
	   method:"POST",
	   data: {"_token": token,'coachid':coachid,'athid':athid,'typemsg':typemsg,'filename':file},
	   success:function(data){
	    $('#message_details').html(data.html);
	   }
  	})*/
/*});*/ 

function openvideo(url)
{
	$("#modalvideo").modal('show');
	$(".videodata").html('<video width="200" height="200" controls> <source src='+url+' type="video/mp4"></video>');
}

 </script>	
	
@endsection
