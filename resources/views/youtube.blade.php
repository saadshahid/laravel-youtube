<!doctype html>
<html>
	<head>
		<title>YouTube Search</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/bootstrap-theme.min.css')}}">
		<script src="{{asset('js/jquery.min.js')}}"></script>
		<script src="js/youtube.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-10">
					<h2><span class="label label-primary">Welcome! Please search YouTube videos</span></h2>
					<div class="col-sm-4">
						<span class="label label-default">Search Term:</span>
						<input class="form-control" type="search" id="q" name="q" placeholder="Enter Search Term">
					</div>
					<div class="col-sm-4">
						<span class="label label-default">Max Results:</span>
						<input class="form-control" type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="25">
					</div>
					<div class="col-sm-4" style="padding-top: 10px;">
						<input class="btn btn-primary" type="button" value="Search" onclick="search()">
					</div>
				</div>
				<div class="col-lg-2"></div>
				<div class="col-lg-12" id="search-list"></div>
			</div>
		</div>
	</body>
</html>