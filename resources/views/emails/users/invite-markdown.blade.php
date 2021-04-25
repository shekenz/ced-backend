@component('mail::message')
# Introduction

{{ __('mails.invite') }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
