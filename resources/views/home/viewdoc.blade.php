<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
	<style>
		* { box-sizing: border-box; }
		html, body { min-height: 100%; margin: 0; }
		body { background: #f3f5f7; color: #252a30; font: 14px/1.5 Arial, sans-serif; }
		.viewer { width: 100%; max-width: 1600px; margin: 0 auto; padding: 20px; }
		.viewer-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 16px; }
		.viewer-heading { min-width: 0; }
		.viewer-heading h1 { margin: 0; font-size: 22px; line-height: 1.25; overflow-wrap: anywhere; }
		.viewer-heading p { margin: 4px 0 0; color: #626b75; }
		.viewer-actions { display: flex; flex: 0 0 auto; gap: 8px; }
		.viewer-button { display: inline-block; padding: 9px 13px; border: 1px solid #c7cdd3; border-radius: 4px; background: #fff; color: #252a30; font: inherit; text-decoration: none; cursor: pointer; }
		.viewer-button:hover, .viewer-button:focus { background: #e9edf1; text-decoration: none; }
		.viewer-button-primary { border-color: #1769aa; background: #1769aa; color: #fff; }
		.viewer-button-primary:hover, .viewer-button-primary:focus { background: #125787; color: #fff; }
		.document-info { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin: 0 0 16px; padding: 14px 16px; border: 1px solid #d9dee3; border-radius: 5px; background: #fff; }
		.document-info div { min-width: 0; }
		.document-info dt { color: #626b75; font-size: 12px; font-weight: normal; }
		.document-info dd { margin: 2px 0 0; overflow-wrap: anywhere; font-weight: 600; }
		.viewer-error { margin: 0 0 12px; padding: 10px 12px; border: 1px solid #e7c7a2; border-radius: 4px; background: #fff8ed; color: #704b20; overflow-wrap: anywhere; }
		.pdf-frame { display: block; width: 100%; height: 76vh; max-height: 1000px; min-height: 520px; border: 1px solid #cbd1d7; border-radius: 4px; background: #dfe3e7; }
		.viewer-footer { padding: 14px 0 2px; color: #68717a; text-align: center; font-size: 12px; }
		@media (max-width: 767px) {
			.viewer { padding: 12px; }
			.viewer-header { align-items: flex-start; flex-direction: column; gap: 12px; }
			.viewer-heading h1 { font-size: 19px; }
			.viewer-actions { width: 100%; }
			.viewer-button { flex: 1; text-align: center; }
			.document-info { grid-template-columns: minmax(0, 1fr); gap: 9px; padding: 12px; }
			.pdf-frame { height: 72vh; min-height: 360px; }
		}
		@media (max-width: 380px) {
			.viewer { padding: 8px; }
			.viewer-actions { flex-direction: column; }
			.viewer-button { width: 100%; }
			.pdf-frame { height: 70vh; min-height: 320px; }
		}
	</style>
</head>
<body>
	<main class="viewer">
		<header class="viewer-header">
			<div class="viewer-heading">
				<h1>{{ $dist->DOCDESC }}</h1>
				<p>Document viewer</p>
			</div>
			<div class="viewer-actions">
				<button class="viewer-button" type="button" onclick="window.history.back()">Back</button>
				<a class="viewer-button viewer-button-primary" href="{{ URL::to('/') }}/public/files/1/{{ $dist->PDFPRINT }}" download>Download PDF</a>
			</div>
		</header>

		<dl class="document-info">
			<div><dt>Document ID</dt><dd>{{ $dist->DOCID }}</dd></div>
			<div><dt>Revision</dt><dd>{{ $dist->DOCREV }}</dd></div>
			<div><dt>Document name</dt><dd>{{ $dist->DOCDESC }}</dd></div>
		</dl>

		@if (Session()->has('not found'))
			<div class="viewer-error" role="alert">Document not found on server: {{ $document_name }}</div>
		@endif

		@if ($view_type == 'uncontrolled')
			<embed class="pdf-frame" src="{{ URL::to('/') }}/public/files/1/{{ $dist->PDFPRINT }}" type="application/pdf" aria-label="PDF document viewer">
		@elseif ($view_type == 'original')
			<embed class="pdf-frame" src="{{ URL::to('/') }}/public/files/1/{{ $dist->PDFVIEW }}" type="application/pdf" aria-label="Original PDF document viewer">
		@endif

		<footer class="viewer-footer">Copyright &copy; {{ date('Y') }} PT. Rapid Plast Indonesia</footer>
	</main>
</body>
</html>
