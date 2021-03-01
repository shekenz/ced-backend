<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CED</title>
	@if(config('app.env') == 'local')
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
	@else {{-- Cache bustin in production --}}
            <link rel="stylesheet" href="{{ asset(mix('css/app.css'), true) }}">
    @endif
</head>
<body class="text-custom text-gray-900">
	<div id="menu-wrapper" class="fixed w-full top-0">
		<div id="menu" class="grid grid-cols-10 m-12">
			<h1><a href="#" class="hover:bg-black hover:text-white">e.p.g.</a></h1>
			<div><a href="#" class="hover:bg-black hover:text-white">shop</a></div>
			<div><a href="#" class="hover:bg-black hover:text-white">contact</a></div>
			<div class="col-start-9"><a href="#" class="hover:bg-black hover:text-white">cart</a></div>
			<div class="justify-self-end"><a href="#" class="hover:bg-black hover:text-white">fr</a> / <a href="#" class="hover:bg-black hover:text-white">en</a></div>
		</div>
	</div>
	<div id="content" class="mt-32">
		@for ($i = 0; $i < 3; $i++)
		<article class="grid grid-cols-10 mx-12">
			<div class="slider col-span-8 mr-12">
				<img src="img/test.png" alt="test image">
			</div>
			<div id="info" class=" col-start-9 col-span-2">
				<p class="mb-6">
					Title<br>Artist
				</p>
				<p class="mb-6">
					Size<br>Cover type<br>XXX pages<br>Edition
				</p>
				<p class="mb-6">
					XX €<br><a href="#" class="underline hover:bg-black hover:text-white">add to cart</a>
				</p>
				<p class="mb-6 mr-6">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh.
				</p>
			</div>
			<div class="col-span-10 my-8">1/12.</div>
		</article>
		@endfor
	</div>
</body>
</html>