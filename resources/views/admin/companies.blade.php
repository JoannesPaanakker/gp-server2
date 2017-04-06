@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-6">
			<h6>Order by</h6>
			<select name="order" id="" style="margin-bottom:40px" onchange="document.location='/admin/companies/' + this.value">
				<option value="title" @if($order == 'title') selected @endif>Company name</option>
				<option value="reviews" @if($order == 'reviews') selected @endif>Number of reviews</option>
			</select>
		</div>
	</div>

	<div class="row">

		<div class="col-md-12">
		    <div class="card">

		        <div class="content table-responsive table-full-width">
		            <table class="table table-striped">
		                <thead>
		                    <th>Company</th>
							<th>Address</th>
							<th>Reviews</th>
		                </thead>
		                <tbody>
		                    @foreach($companies as $company)
								<tr>
									<td>{{ $company->title }}</td>
									<td>{{ $company->address }}</td>
									<td>{{ count($company->reviews) }}</td>
								</tr>
							@endforeach
		                </tbody>
		            </table>

		        </div>
		    </div>
		</div>

	</div>

@endsection
