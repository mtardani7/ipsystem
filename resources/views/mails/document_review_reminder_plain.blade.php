Dear Bapak/Ibu {{ $ownerName }},

Dokumen yang menjadi tanggung jawab Bapak/Ibu telah mencapai waktu yang ditentukan untuk dilakukan annual review.

Review tetap wajib dilakukan meskipun tidak diperlukan perubahan pada dokumen.

Documents requiring review:
@foreach($documents as $index => $document)

{{ $index + 1 }}. {{ $document->DOCID }}
   {{ $document->DOCDESC }}
   Revision: {{ $document->REVISION_LABEL }}
   Revision Date: {{ $document->REVISION_DATE_LABEL }}
   Review Due: {{ $document->NEXT_REVIEW_DATE_LABEL }}
@endforeach

Hasil review:

OK — Dokumen masih valid
Dokumen masih sesuai dengan kondisi/proses saat ini dan tidak memerlukan perubahan.

NOK — Dokumen memerlukan perubahan
Dokumen membutuhkan perubahan dan proses akan dilanjutkan melalui Request Form yang tersedia di IPSystem.

Review Documents: {{ $reviewUrl }}

Terima kasih atas perhatian, bantuan, dan kerja samanya.

Best regards,
ISO Document Controller
IPSystem
