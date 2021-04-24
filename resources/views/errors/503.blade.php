<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>503 - e.p.g.</title>
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
			<div class="flex-item"><h1>e.p.g.</h1></div>
			<div class="flex-item mb"><span class="little">We'll be back soon.</span></div>
			{{-- <div class="flex-item"><img src="img/logo.png" srcset="img/logo.png 1x, img/logo@2x.png 2x"></div> --}}
			<div class="flex-item little"><a class="link" href="https://instagram.com/esteban_pablo_gonzalez"><x-tabler-brand-instagram class="logo"/></a> <a class="link" href="https://www.facebook.com/stneue"><x-tabler-brand-facebook class="logo"/></a></div>
		</div>
	</div>
</body>
</html>