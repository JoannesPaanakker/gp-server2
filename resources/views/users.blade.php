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
                    <th>Email</th>
                  </thead>
                  <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td>
                            @if($user->picture)
                              <a href="/user/{{ $user->id }}">
                                <img class="avatar" src="{{ $user->picture }}" alt="profile image">
                              </a>
                            @else
                              <a href="/user/{{ $user->id }}">
                              <img class="avatar" src="/img/avatar-sign.png" alt="profile image"/>
                              </a>
                            @endif
                          </td>
                          <td>{{ $user->first_name }}</td>
                          <td>{{ $user->last_name }}</td>
                          <td>{{ $user->email }}</td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>

          </div>
      </div>
  </div>
</div>
@endsection