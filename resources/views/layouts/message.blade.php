@if(Session::has('success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success') !!}</em></div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em> {!! session('error') !!}</em></div>
@endif
