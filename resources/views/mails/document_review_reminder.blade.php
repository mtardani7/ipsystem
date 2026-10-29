<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Annual Document Review</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#333333;">
	<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f5f5f5;">
		<tr>
			<td align="center" style="padding:20px 10px;">
				<table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;background-color:#ffffff;border:1px solid #dddddd;">
					<tr>
						<td style="padding:18px 22px;border-bottom:1px solid #dddddd;font-size:20px;font-weight:bold;color:#333333;">IPSystem</td>
					</tr>
					<tr>
						<td style="padding:22px;font-size:14px;line-height:1.6;color:#333333;">
							<p style="margin:0 0 16px;">Dear Bapak/Ibu {{ $ownerName }},</p>
							<p style="margin:0 0 12px;">Dokumen yang menjadi tanggung jawab Bapak/Ibu telah mencapai waktu yang ditentukan untuk dilakukan annual review.</p>
							<p style="margin:0 0 18px;">Review tetap wajib dilakukan meskipun tidak diperlukan perubahan pada dokumen.</p>

							<p style="margin:0 0 10px;font-weight:bold;">Documents requiring review:</p>
							@foreach($documents as $document)
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 12px;border:1px solid #dddddd;">
								<tr>
									<td style="padding:12px;font-size:14px;line-height:1.55;color:#333333;word-break:break-word;">
										<strong>{{ $document->DOCID }}</strong><br>
										{{ $document->DOCDESC }}<br>
										Revision: {{ $document->REVISION_LABEL }}<br>
										Revision Date: {{ $document->REVISION_DATE_LABEL }}<br>
										Review Due: {{ $document->NEXT_REVIEW_DATE_LABEL }}
									</td>
								</tr>
							</table>
							@endforeach

							<p style="margin:18px 0 8px;font-weight:bold;">Hasil review:</p>
							<p style="margin:0 0 12px;"><strong>OK — Dokumen masih valid</strong><br>
							Dokumen masih sesuai dengan kondisi/proses saat ini dan tidak memerlukan perubahan.</p>
							<p style="margin:0 0 20px;"><strong>NOK — Dokumen memerlukan perubahan</strong><br>
							Dokumen membutuhkan perubahan dan proses akan dilanjutkan melalui Request Form yang tersedia di IPSystem.</p>

							<table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 20px;">
								<tr>
									<td bgcolor="#337ab7" style="border-radius:3px;">
										<a href="{{ $reviewUrl }}" style="display:inline-block;padding:10px 16px;color:#ffffff;text-decoration:none;font-size:14px;font-weight:bold;">Review Documents</a>
									</td>
								</tr>
							</table>

							<p style="margin:0 0 16px;">Terima kasih atas perhatian, bantuan, dan kerja samanya.</p>
							<p style="margin:0;">Best regards,<br>ISO Document Controller<br>IPSystem</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
