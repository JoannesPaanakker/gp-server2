@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-12">
		    <div class="card">

		        <div class="content table-responsive table-full-width">
		            <table class="table table-striped">
		                <thead>
		                    <th>First name</th>
							<th>Last name</th>
							<th>Email</th>
							<th>ID</th>
							<th>slug</th>							
		                </thead>
		                <tbody>
		                    @foreach($users as $user)
								<tr>
									<td>{{ $user->first_name }}</td>
									<td>{{ $user->last_name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->unique_id }}</td>
									<td>{{ $user->slug }}</td>
								</tr>
							@endforeach
		                </tbody>
		            </table>

		        </div>
		    </div>
		</div>
	</div>

@endsection
