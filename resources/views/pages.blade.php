@extends('layouts.appcompanies')

@section('content')
  <form id="tfnewsearch" method="get" action="/pages/">
    <input type="hidden" name="searchtype" value="name">
    <input type="text" id="tfq" name="qry" size="21" maxlength="120" placeholder="Name">
    <input type="submit" value="Search" class="search-button">
  </form>

  <form id="catnewsearch" method="get" action="/pages/">
    <input type="hidden" name="searchtype" value="category">
    <input type="text" id="catq" name="qry" size="21" maxlength="120" placeholder="Category">
    <input type="submit" value="Search" class="search-button">
  </form>

	<div class="row">
		<div class="col-md-12">
		    <div class="card">
		        <div class="content table-responsive table-full-width">
		            <table class="table table-striped">
		                <thead>
		                  <th>Company</th>
							        <th>Address</th>
                      <th>Categories</th>
<!-- 							<th style="text-align:center">Reviews</th>
							<th style="text-align:center"><i class="fa fa-thumbs-up"></i></th>
							<th style="text-align:center"><i class="fa fa-thumbs-down"></i></th>
							<th style="text-align:center">id</i></th>
							<th style="text-align:center">unique_id</i></th>
							<th style="text-align:center">slug</i></th> -->
		                </thead>
		                <tbody>
		                  @foreach($pages as $page)
        								<tr>
        									<td style="width:200px"><a href="/page/{{ $page->slug }}/{{ $page->id }}">{{ $page->title }}</a></td>
        									<td style="width:500px">{{ $page->address }}</td>
                          <td style="max-width:500px">{{ $page->categories }}</td>
<!-- 									<td style="text-align:center">{{ count($page->reviews) }}</td>
									<td style="text-align:center">{{ $page->num_thumbs_up }}</td>
									<td style="text-align:center">{{ $page->num_thumbs_down }}</td> -->
									{{-- <td style="text-align:center">{{ $page->id }}</td> --}}
									{{-- <td style="text-align:center">{{ $page->unique_id }}</td> --}}
									{{-- <td style="text-align:center">{{ $page->slug }}</td> --}}
								       </tr>
							        @endforeach
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
<script type="text/javascript">
// window.onload = function(){
//   //Get submit button category search
//   var submitbutton2 = document.getElementById("catq");
//   //Add listener to submit button
//   if(submitbutton2.addEventListener){
//     submitbutton2.addEventListener("click", function() {
//       if (submitbutton2.value == 'Category'){
//         submitbutton2.value = '';
//       }
//     });
//   }
//   //Get submit button Name search
//   var submitbutton = document.getElementById("tfq");
//   //Add listener to submit button
//   if(submitbutton.addEventListener){
//     submitbutton.addEventListener("click", function() {
//       if (submitbutton.value == 'Name'){
//         submitbutton.value = '';
//       }
//     });
//   }
// }
</script>
@endsection
