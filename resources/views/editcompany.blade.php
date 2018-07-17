@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Company Details</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pages/'.$page->id.'/updatePage') }}">
                            <label class="col-md-4 control-label">Company Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" placeholder="{{ $page->title }}" value="{{ $page->title }}">
                            </div>
                            <label class="col-md-4 control-label">About</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="about" placeholder="{{ $page->about }}" value="{{ $page->about }}">
                            </div>
                            <label class="col-md-4 control-label">Categories</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="categories" placeholder=" {{$page->categories }}" value=" {{$page->categories }}">
                            </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-rounded">
                                    <i class="fa fa-btn fa-sign-in"></i>Save
                                </button>
                                <a href="/page/{{ $page->slug }}/{{ $page->unique_id }}?current_user_id={{ $page->user_id }}">
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
