@extends('layouts.master')
@section('title', 'Customer Listing')
@section('content')


<style>

.gallery { text-align: center; }
.current-image-wrapper {
  background-position: 50% 50%;
  background-repeat: no-repeat;
}
.current-image-wrapper img {
  display: block;
  max-width: 100%;
  margin: 0 auto;
  opacity: 1;
  transition: opacity 1.85s;
}
.current-image-wrapper .hideme {
  opacity: 0;
  transition: opacity 0s;
}
.thumbnails li, .thumbnails a, .thumbnails img {
  display: inline-block;
  width: 4.5em;
  height: 3em;
  border: none;
}
.thumbnails a { outline: none; }
</style>
<div class="content-wrapper">

<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Progress Pics</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">progress pics</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
<div id='gallery' class='gallery'>
  <div id='lg-wrap' class='current-image-wrapper'>
   @if(count($pics)>0)
    <img id='large' data-idx='0' src="{{url('/progresspics').'/'.$firstpic['image']}}">
    @endif
  </div>
  <ul id='thumbnails' class='thumbnails'>
  @if(count($pics)>0)
    @foreach($pics as $key=>$pic)
    <li>
      <a href="{{url('/progresspics').'/'.$pic['image']}}">
        <img data-idx={{$key}} src="{{url('/progresspics').'/'.$pic['image']}}" width="">
      </a>
    </li>
    @endforeach
    @else
    <img src="{{url('/progresspics').'/'.'noimage.jpg'}}" style="width:100%;height:100%">   
    @endif
    
  </ul>
</div>
</div>
<script type="text/javascript">

var th = document.getElementById('thumbnails');

th.addEventListener('click', function(e) {
  var t = e.target, new_src = t.parentNode.href, 
      large = document.getElementById('large'),
      cl = large.classList,
      lgwrap = document.getElementById('lg-wrap');
  lgwrap.style.backgroundImage = 'url(' +large.src + ')';
  if(cl) cl.add('hideme');
  window.setTimeout(function(){
    large.src = new_src;
    if(cl) cl.remove('hideme');
  }, 50);
  e.preventDefault();
}, false);

</script>

@endsection