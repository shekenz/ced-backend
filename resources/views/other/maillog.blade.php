<x-app-layout>
	<x-slot name="title">
		Mails log
	</x-slot>

	<table class="w-full app-table">
	@foreach ($mails as $mail)
		<tr>
			<td>{{ $mail->sent }}</td><td>{{ $mail->email }}</td>
		</tr>
	@endforeach
	</table>
</x-app-layout>