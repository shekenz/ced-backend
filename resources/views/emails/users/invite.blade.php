{{ __('mails.general.salutation') }},
<br><br><br>
{{ __('mails.users.invite.main') }}
<br><br>
{{ __('mails.users.invite.link') }} :
<br>
<a href="{{ config('app.url').'/register/'.$token }}">https://www.epg.works/register/{{ $token }}</a>
<br><br>
{{ __('mails.users.invite.warning') }}.
<br><br><br>
{{ __('mails.general.regards') }},
<br>
{{ __('mails.general.signature') }}
<br><br>
<a href="https://www.epg.works">https://www.epg.works</a>
