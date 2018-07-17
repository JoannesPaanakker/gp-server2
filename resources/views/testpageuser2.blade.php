@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <a href="/fbredirect">
<button type="button" class="btn">FB login</button>
</a>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">List of Game of Thrones Characters</div>

                    @if(Auth::check())
                      <p>You're authorised</p>
                    @endif


            </div>
            @if(Auth::guest())
              <a href="/login" class="btn btn-info"> You need to login to see the text 😜😜 >></a>
            @endif
        </div>
    </div>
</div>
@endsection
