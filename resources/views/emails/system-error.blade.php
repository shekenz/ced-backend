<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="x-apple-disable-message-reformatting">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="telephone=no" name="format-detection">
	<title>Critical Error Report</title>
	<!--[if (mso 16)]>
<style type="text/css">
a {text-decoration: none;}
</style>
<![endif]-->
	<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
	<!--[if gte mso 9]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG></o:AllowPNG>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
	<!--[if !mso]><!-- -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet">
	<!--<![endif]-->
</head>

<body
	style="width:100%;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
	<div style="background-color:#F8F9FD">
		<!--[if gte mso 9]>
<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
<v:fill type="tile" color="#f8f9fd"></v:fill>
</v:background>
<![endif]-->
		<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
			<tr>
				<td align="left" bgcolor="#fe5b55"
					style="Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;background-color:#fe5b55">
					<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:45px;color:#ffffff;font-size:30px">
					Critical Error Report
					</p>
				</td>
			</tr>
			<tr>
				<td align="left" style="padding:12px;Margin:0">
					<p style="margin-top:16px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#131313;font-size:16px">
					<b>On : </b>{{ $now }}
					</p>
					<p style="margin-top:16px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#131313;font-size:16px">
					<b>Error : </b>{{ $customMessage }}
					</p>
					<p style="margin:0px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#131313;font-size:16px">
					In file <b>{{ $e->getFile() }}</b> at line <b>{{ $e->getLine() }}</b>
					</p>
					<p style="margin-top:16px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#131313;font-size:16px">
					<b>Exception : </b>{{ $e->getMessage() }}
					</p>
					<p style="margin-top:16px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#131313;font-size:16px">
					Debug data :
					</p>
					<pre style="margin-top:16px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:monospace;line-height:24px;color:#131313;font-size:16px; border: 1px solid #bbbbdd; padding:12px;">
					{{ print_r($debugData, true) }}
					</pre>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
