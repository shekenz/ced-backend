<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="img/favicon.png">
	<title>404 - e.p.g.</title>
	<style type="text/css">
		@font-face {
			font-family: "Monument Grotesk";
			font-weight: 400;
			src: url(fonts/MonumentGroteskTrial-Regular.woff) format("woff");
		}

		@font-face {
			font-family: "Monument Grotesk";
			font-weight: 500;
			src: url(fonts/MonumentGroteskTrial-Medium.woff) format("woff");
		}

		@font-face {
			font-family: "Monument Grotesk";
			font-weight: 700;
			src: url(fonts/MonumentGroteskTrial-Bold.woff) format("woff");
		}

		html, body {
			color: #111;
			background-color: #eee;
			font-family: "Monument Grotesk", sans-serif;
			display: flex;
			flex-direction: column;
			align-content: center;
    		height: 100%;
		}

		body {
			margin: 0;
		}

		.flex-container {
			height: 80%;
			padding: 0;
			margin: 0;
			display: -webkit-box;
			display: -moz-box;
			display: -ms-flexbox;
			display: -webkit-flex;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.row {
			width: auto;
		}

		.flex-item {
			text-align: center;
		}

		h1 {
			margin: 0;
			font-size: 3.5em;
			padding: 0;
			font-weight: 700;
		}

		.little {
			font-size: 1em;
			color: #666;
		}

		.link {
			color: #999;
		}

		.logo {
			width: 32px;
			height: 32px;
			transition: color 300ms;
		}

		.logo:hover {
			color: #111;
		}

		img {
			display: block;
			margin-bottom: 35px;
		}

		.mb {
			margin-bottom: 35px;
		}
	</style>
</head>
<body>
	<div class="flex-container">
		<div class="row">
			<div class="flex-item"><h1>404</h1></div>
			<div class="flex-item mb"><span class="little">Page not found.</span></div>
		</div>
	</div>
</body>
</html>