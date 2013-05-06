<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Git Deploy Script</title>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<style>
	body, pre.bg-black { background: #000; color: #999; }
	pre.bg-black { background: #222; padding: 4px;}
	span.green { color: #6BE234; }
	span.blue { color: #729FCF; }
</style>	
</head>
<body>
	<div class="container">
		<h1>Showing some Git &hearts;</h1>
		<h2>Current ENV: <?=App::environment()?></h2>
		<div class="alert alert-info">Make sure to do composer update if needed.</div>
		<?=$output?>			
	</div>
</body>
</html>