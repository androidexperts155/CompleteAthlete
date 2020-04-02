@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                  @if($errors->any()) 
                    <div class="error-data" style="text-align:center;background:#D4493B;padding: 10px;
                        margin-bottom: 29px;font-size:20px;color:#fff">
                       @foreach ($errors->all() as $error)
                          <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                    <!-- <?php if(isset($success)){ ?>
                    <div class="error-data" style="text-align:center;background:green;padding: 10px;
                        margin-bottom: 29px;font-size:20px;color:#fff">{{@$success}}
                    </div>
                    <?php }?> -->
                    <?php if(isset($oldmsg)) ?>
                    {{@$oldmsg}}
                    <form method="POST" action="{{ route('changepassword',['id'=>$id])}} ">
                        @csrf
                        <input type ="hidden" value="{{@$id}}" name="userid">
                        <!-- <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">
                                {{ __('Old Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="oldpassword" type="password" class="form-control" name="oldpassword" value="{{ old('password') }}"   autofocus>
                            </div>
                            @if ($errors->has('userpassword'))
                                <div class="error">{{ $errors->first('userpassword') }}</div>
                            @endif
                        </div> -->

                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">
                                {{ __('New Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control" name="newpassword" value="{{ old('newpassword') }}"   autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-md-4 col-form-label text-md-right">
                                {{ __('Re-enter New Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="confirmpassword" type="password" class="form-control" name="confirmpassword" value="{{ old('confirmpassword') }}"   autofocus>
                            </div>
                        </div>

                       


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('submit') }}
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
