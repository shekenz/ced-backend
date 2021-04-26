{{ __('mails.general.salutation') }},
<br><br><br>
{{ __('mails.contact.notification.line1')}}.<br>
{{ __('mails.contact.notification.line2')}}.<br>
<br>
{{ __('mails.contact.notification.line3')}}.
<br><br><br>
{{ __('mails.general.regards') }},
<br>
{{ __('mails.general.signature') }}
<br><br>
<a href="https://www.epg.works">https://www.epg.works</a>
<br><br><br>
------------------------------------------------------------------------------------------------------
<br><br><br>
{{ __('Subject') }} : {{ $data['subject'] }}
<br><br>
{{ __('Message') }} :
<br><br>
{{ $data['message'] }}