<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	<?php $randMax = rand(3,10) ?>
	@for ($i = 0; $i < $randMax; $i++)
		@include('index.article')
	@endfor
</x-index-layout>