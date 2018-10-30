@extends('layouts.appuser')
@section('content')

<form id="tfnewsearch" method="get" action="/users/">
  <input type="text" name="qry" size="21" maxlength="120" placeholder="Name">
  <input type="submit" value="Search" class="search-button">
</form>


<div class="row">
  <div class="col-md-12">
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
                      <a href="/user/{{ $user->slug }}/{{ $user->id }}">
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
