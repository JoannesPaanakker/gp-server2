@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Claim Company Page</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pages/'.$page->id.'/claimPage') }}">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-rounded">
                                    <i class="fa fa-btn fa-sign-in"></i>Are you sure?
                                </button>
                                <a href="/page/{{ $page->slug }}/{{ $page->unique_id }}">
                                  <button type="button" class="btn btn-rounded">Cancel</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
