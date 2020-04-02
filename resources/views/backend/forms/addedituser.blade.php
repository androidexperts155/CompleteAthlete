  <form id= "addathlete" action ="{{url('/save-user-data')}}" method="post" enctype="multipart/form-data" onsubmit="return check()">
  {{csrf_field()}}
   @if(@$type == 'edit')
    <input type="hidden" name="athedit" id ="athedit" value="{{@$athdata['id']}}">
   @endif
    <input type="hidden" name="usertype" id ="usertype" value="{{$user}}">
    <input type="hidden" id="coachathleteid"  name="coachathleteid" value="">
    <input type="hidden" id="coachathid"  name="coachathid" value="{{@$athdata['coach_id']}}">
 
    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="usrname" value="{{@$athdata['name']}}">
          </div>  
        </div>
         <div class="col-md-6">
           <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" required onkeyup ="checkemail()" value="{{@$athdata['email']}}" required>
          </div>
          <div id = "emailmsg"></div>
        </div>   
        @if(@$type != 'edit')
          <div class="col-md-6">
             <div class="form-group">
              <label for="email">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
          </div> 
        @endif   
        <div class="col-md-6">
           <div class="form-group">
            <div><label for="email">DOB</label></div>
            <input type="date" name="dob" class="form-control" id="dob" value="{{@$athdata['dob']}}">
          </div>
        </div>   
        
        <div class="col-md-6">
          <div class="form-group" style="background: #E8F0FE; margin:10px 0px;">
          <div class ="row">
            <div class="col-md-12"> <label for="gender">Gender</label></div>
           <div class="col-md-6"><input type = "radio" name="gender" value="m"  required {{@$athdata['gender']=='m'?'checked':''}}>Male</div>
           <div class="col-md-6"><input type = "radio" name="gender" value="f" {{@$athdata['gender']=='f'?'checked':''}}>Female</div>
          </div> 
        </div>
        </div>
        @if(@$user=='athlete')
          <div class="col-md-6">
            <div class="form-group">
              <label for="phoneno">Coach</label>
              <select name = "coach" id="coach" style="width:100%">

              @foreach(@$coachName as $key=>$coach)
                <option value="{{$key}}" {{@$athdata['coach_id']==$key?'selected':''}}>{{$coach}}</option>
              @endforeach
              </select>
            </div>
          </div>
        @endif
         @if(@$user=='athlete')
          <div  @if(@$type != 'edit') class="col-md-6" @else  class="col-md-6" @endif>
             <div class="form-group">
              <label for="age">Age</label>
              <input type="text" name="age" class="form-control" id="age" value="{{@$athdata['age']}}">
            </div>
          </div> 
           <div @if(@$type != 'edit') class="col-md-6" @else  class="col-md-6" @endif>
             <div class="form-group">
              <label for="weight">Weight(in lbs)</label>
              <input type="text" name="weight" class="form-control" id="weight" value="{{@$athdata['weight']}}">
            </div>
          </div> 

          @if(@$type == 'edit')
             <div class="col-md-6">
               <div class="form-group">
                <label for="height">Height(in inches)</label>
                <input type="text" name="height" class="form-control" id="height" value="{{@$athdata['height']}}">
              </div>
            </div>
         
           @elseif(@$type != 'edit')
              <div class="col-md-6">
                  <label for="height_ft">Height(in feet)</label>
                  <input type="text" name="height_ft" class="form-control" id="height_ft">
              </div>
              <div @if(@$type != 'edit') class="col-md-6" @endif>
                  <label for="height">Height(in inches)</label>
                  <input type="text" name="height_in" class="form-control" id="height_in">
              </div>
            @endif         
        @endif 
         @if(@$user=='coach')
          <div class="col-md-6">
               <div class="form-group">
                <div><label for="country">Country</label></div>
                <input type="text" name="country" class="form-control" id="country" value="{{@$athdata['country']}}">
              </div>
            </div>   

             <div class="col-md-6">
               <div class="form-group">
                <div><label for="state">State</label></div>
                <input type="text" name="state" class="form-control" id="state" value="{{@$athdata['state']}}">
              </div>
            </div>

            <div class="col-md-6">
               <div class="form-group">
                <div><label for="text">City</label></div>
                <input type="text" name="city" class="form-control" id="city" value="{{@$athdata['city']}}">
              </div>
            </div>
             <div class="col-md-6">
               <div class="form-group">
                <div><label for="text">Zipcode</label></div>
                <input type="text" name="zipcode" class="form-control" id="zipcode" value="{{@$athdata['zipcode']}}">
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                <div><label for="text">Phone</label></div>
                <input type="text" name="phone" class="form-control" id="phone" value="{{@$athdata['phone']}}">
              </div>
            </div>
             <div class="col-md-12">
               <div class="form-group">
                <div><label for="text">Bio</label></div>
                <textarea name="bio" class="form-control" id="bio" value="{{@$athdata['bio']}}" rows="10">{{@$athdata['bio']}}</textarea>
              </div>
            </div>
            @endif
          <div class="col-md-6">
            <div class="form-control" style="margin-top: 20px;">
              <label for="image">Image</label>
              <input type="file" name="image" class="form-control" id="image">
              @if(@$type == 'edit') 
                @if(@$athdata['image']!="")
                  <img src = "{{url('/images'.'/'.@$athdata['image'])}}"  width=100 height=100>
                  @else
                   <img src = "{{url('/images/noimage.png')}}"  width=100 height=100>
                @endif
              @endif
            </div>
        </div> 
          @if(@$user=='athlete')
           <div class="col-md-6">
             <div class="form-control" style="margin-top: 20px;">
              <div><label for="email">Cover Image</label></div>
              <input type="file" name="cover_image" class="form-control" id="cover_image">
                @if(@$type == 'edit') 
                 @if(@$athdata['cover_image']!="")
                  <img src = "{{url('/images'.'/'.@$athdata['cover_image'])}}"  width=100 height=100>
                  @else
                   <img src = "{{url('/images/noimage.png')}}"  width=100 height=100>
                   @endif            
                @endif
            </div>
          </div> 
            @endif
          @if(@$user=='athlete')
            <div class="col-md-6">
             <div class="form-control" style="margin-top: 20px;">
              <div><label for="tracks">Select multiple Tracks(Press CTRL+click)</label></div>
              <?php
               $track = explode(",",@$athdata['tracks']);
              ?>
              <select name="tracks[]" multiple=""> 
               <option value="1" selected="true" disabled >Personal</option>                       
                  <option value="2" <?php if(in_array(2,$track)) echo "selected"; ?>>Games Prep</option>                      
                  <option value="3" <?php if(in_array(3,$track)) echo "selected"; ?>>Complete 60</option>               
                  <option value="4" <?php if(in_array(4,$track)) echo "selected"; ?>>Sweat Session</option>                 
                  <option value="5" <?php if(in_array(5,$track)) echo "selected"; ?>>Weightlifting</option>
              </select>               
              </div>
            </div> 
          @endif

       </div>
      <div class="box-footer add_cat">
        <button type="submit" class="btn btn-default" style="width:30%;margin-top: 20px;">Submit</button>
      </div>
      </form>

      <script>   
       var token = "{{ csrf_token() }}";
       var base_url = "<?php echo url('/'); ?>";  
        function checkemail()
        {
          var email = $('#email').val();        
          $.ajax({
          url: "{{url('/checkemail')}}",
          type: 'POST', 
          data:   {    
            "_token": token,
            "email": email
          },
          success: function(response){ 
            if(response==1)
              $('#emailmsg').html("email already exists");
            else
               $('#emailmsg').html("");
            },    
          });
        } 

     function check(){
       if($('#emailmsg').text().length==0)
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      </script>
  
 