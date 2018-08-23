@extends('layouts.appcompanies')

@section('content')
	<div class="row">
		<div class="col-md-12">
      <div class="card">
	      <div class="content table-responsive table-full-width">
	        <table class="table table-striped">
            <thead>
              <th>Company</th>
			        <th>Address</th>
              <th>Categories</th>
            </thead>
            <tbody>
              @foreach($pages as $page)
 								<tr>
									<td style="width:200px"><a href="/{{ $page->slug }}/{{ $page->id }}">{{ $page->title }}</a></td>
									<td style="width:500px">{{ $page->address }}</td>
                  <td style="max-width:500px">{{ $page->categories }}</td>
				       </tr>
			        @endforeach
            </tbody>
          </table>
        </div>
	    </div>
      <div class="card">
        <div class="content table-responsive table-full-width">
          <table class="table table-striped">
              <thead>
                <th></th>
                <th>First name</th>
                <th>Last name</th>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>
                      <a href="/user/{{ $user->slug }}/{{ $user->id }}/public">
                        @if($user->picture)
                          <img class="avatar" src="{{ $user->picture }}" alt="profile image">
                        @else
                          <img class="avatar" src="/img/avatar-sign.png" alt="profile image"/>
                        @endif
                      </a>
                    </td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
		</div>
	</div>
@endsection
