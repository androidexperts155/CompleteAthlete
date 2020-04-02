<style>
.msg_time_send {
    position: relative;
    right: 0;
    bottom: -15px;
    color: #fff;
    font-size: 14px;
    top: 30px;
}
</style>

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
					<a  href="{{url('/attachments').'/'.$msg->media}}" download> Video Sent.</a>
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
					<a href="{{url('/attachments').'/'.$msg->media}}" download>Video Sent.</a>
				@elseif($msg->type==4)
					<a download href="{{url('/attachments').'/'.$msg->media}}">PDF Sent.</a>
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
		</div>
	@endif	
@endforeach		