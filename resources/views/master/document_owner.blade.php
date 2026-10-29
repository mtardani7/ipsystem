@extends('layouts.app')

@section('content')
<div class="container document-review-page">
	<div class="page-header document-review-header">
		<div>
			<h2>Document Review &amp; Owner Management</h2>
			<p class="text-muted">Manage SOP/WI document owners, revision dates, and annual review status.</p>
		</div>
		@if($canManageOwner && empty($missingColumns))
		<button type="button" class="btn btn-primary" id="preview-review-reminders"
			data-preview-url="{{ route('document_owner.reminders.preview') }}"
			data-tracking-available="{{ $reminderTrackingAvailable ? '1' : '0' }}">
			<i class="fa fa-envelope" aria-hidden="true"></i> Kirim Reminder Review
		</button>
		@endif
	</div>

	@if(!empty($missingColumns))
	<div class="alert alert-warning">
		The application connection cannot find these columns in <code>mysql3.masterlist</code>:
		<strong>{{ implode(', ', $missingColumns) }}</strong>.
	</div>
	@else
	@if(Session::has('data'))
	<div class="alert alert-danger">{{ Session::get('data') }}</div>
	@endif
	@if(Session::has('success'))
	<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif
	@if(Session::has('reminder_result'))
	<?php $reminderResult = Session::get('reminder_result'); ?>
	<div class="alert {{ $reminderResult['failed'] > 0 ? 'alert-warning' : 'alert-success' }}" role="status">
		<strong>Annual Review Reminder Result</strong>
		<div>Owners: {{ $reminderResult['owners'] }} | Documents: {{ $reminderResult['documents'] }}</div>
		<div>Emails sent: {{ $reminderResult['emails_sent'] }} | Failed: {{ $reminderResult['failed'] }}</div>
		@if(!empty($reminderResult['failures']))
		<ul class="reminder-failures">
			@foreach($reminderResult['failures'] as $failure)
			<li>{{ $failure['owner'] }} ({{ $failure['email'] }}): {{ $failure['reason'] }}</li>
			@endforeach
		</ul>
		@endif
	</div>
	@endif
	<div id="owner-update-notice" class="alert alert-success owner-update-notice" role="status" aria-live="polite" hidden></div>

	<div class="row summary-cards">
		<div class="col-sm-3 col-xs-6"><div class="summary-card"><span>Active SOP/WI</span><strong>{{ $summary['active'] }}</strong></div></div>
		<div class="col-sm-3 col-xs-6"><div class="summary-card"><span>Without Owner</span><strong>{{ $summary['without_owner'] }}</strong></div></div>
		<div class="col-sm-3 col-xs-6"><div class="summary-card"><span>Ready for Review</span><strong>{{ $summary['review_needed'] }}</strong></div></div>
		<div class="col-sm-3 col-xs-6"><div class="summary-card"><span>Review Completed</span><strong>{{ $summary['review_completed'] }}</strong></div></div>
	</div>

	<div class="filter-panel">
		<form method="GET" action="{{ route('document_owner') }}">
			<div class="row">
				<div class="col-sm-4 col-md-2">
					<div class="form-group">
						<label for="owner_filter_division">Division / Dept</label>
						<select id="owner_filter_division" name="division" class="form-control">
							<option value="">All</option>
							@foreach($divisions as $divisionOption)
							<option value="{{ $divisionOption->DIVID }}" {{ $division == $divisionOption->DIVID ? 'selected' : '' }}>{{ $divisionOption->DIVID }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-4 col-md-2">
					<div class="form-group">
						<label for="owner_filter_category">Category</label>
						<select id="owner_filter_category" name="category" class="form-control">
							<option value="ALL" {{ $category == 'ALL' ? 'selected' : '' }}>All SOP/WI</option>
							<option value="SOP" {{ $category == 'SOP' ? 'selected' : '' }}>SOP</option>
							<option value="WI" {{ $category == 'WI' ? 'selected' : '' }}>WI</option>
						</select>
					</div>
				</div>
				@if($canManageOwner)
				<div class="col-sm-4 col-md-2">
					<div class="form-group">
						<label for="owner_filter_owner">Owner</label>
						<select id="owner_filter_owner" name="owner" class="form-control">
							<option value="">All</option>
							<option value="unassigned" {{ $owner == 'unassigned' ? 'selected' : '' }}>Not Assigned</option>
							@foreach($ownerOptions as $ownerOption)
							<option value="{{ $ownerOption->id }}" {{ $owner == $ownerOption->id ? 'selected' : '' }}>{{ $ownerOption->username }} - {{ $ownerOption->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				@endif
				<div class="col-sm-4 col-md-2">
					<div class="form-group">
						<label for="owner_filter_status">Review Status</label>
						<select id="owner_filter_status" name="status" class="form-control">
							<option value="ALL" {{ $status == 'ALL' ? 'selected' : '' }}>All</option>
							<option value="NOT_SET" {{ $status == 'NOT_SET' ? 'selected' : '' }}>Not Set</option>
							<option value="NOT_DUE" {{ $status == 'NOT_DUE' ? 'selected' : '' }}>Not Due</option>
							<option value="OK" {{ $status == 'OK' ? 'selected' : '' }}>OK</option>
							<option value="NOK" {{ $status == 'NOK' ? 'selected' : '' }}>NOK</option>
							<option value="NEEDS_REVIEW" {{ $status == 'NEEDS_REVIEW' ? 'selected' : '' }}>Needs Review</option>
						</select>
					</div>
				</div>
				<div class="col-sm-4 col-md-2">
					<div class="form-group">
						<label for="owner_filter_document_status">Document Status</label>
						<select id="owner_filter_document_status" name="document_status" class="form-control">
							<option value="ACTIVE" {{ $documentStatus == 'ACTIVE' ? 'selected' : '' }}>Active</option>
							<option value="OBSOLETE" {{ $documentStatus == 'OBSOLETE' ? 'selected' : '' }}>Obsolete</option>
							<option value="ALL" {{ $documentStatus == 'ALL' ? 'selected' : '' }}>All</option>
						</select>
					</div>
				</div>
				<div class="col-sm-8 col-md-2">
					<div class="form-group">
						<label for="owner_filter_search">Search</label>
						<input id="owner_filter_search" type="search" name="search" class="form-control" value="{{ $search }}" placeholder="Doc ID / Description">
					</div>
				</div>
			</div>
			<div class="filter-actions">
				<label class="checkbox-inline"><input type="checkbox" name="need_review" value="1" {{ $needReview ? 'checked' : '' }}> Need Review Only</label>
				@if($canManageOwner)
				<label class="checkbox-inline"><input type="checkbox" name="my_documents" value="1" {{ $myDocuments ? 'checked' : '' }}> My Documents</label>
				@endif
				<div>
					<a href="{{ route('document_owner') }}" class="btn btn-default">Reset</a>
					<button type="submit" class="btn btn-primary">Apply Filter</button>
				</div>
			</div>
		</form>
	</div>
	@if($hasActiveFilters)
	<div class="active-filter-indicator"><i class="fa fa-filter"></i> Filters are active <a href="{{ route('document_owner') }}">Clear filters</a></div>
	@endif

	@if($canManageOwner)
	<div class="bulk-toolbar">
		<div><strong>Selected:</strong> <span id="selected-document-count">0 documents</span></div>
		<div class="bulk-actions">
			<label class="checkbox-inline"><input type="checkbox" class="select-all-documents"> Select All on this page</label>
			<button type="button" class="btn btn-primary bulk-action-button" data-bulk-action="owner" disabled>Set Owner</button>
			<button type="button" class="btn btn-default bulk-action-button" data-bulk-action="revision_date" disabled>Set Revision Date</button>
		</div>
	</div>
	@endif

	<div class="table-responsive document-table-wrap">
		<table class="table table-bordered table-hover document-table">
			<thead><tr>
				@if($canManageOwner)<th class="selection-column"><input type="checkbox" class="select-all-documents" aria-label="Select all current page"></th>@endif
				<th>Doc ID</th><th>Description</th><th>Division</th><th>Category</th><th>Owner</th><th>Review</th><th>Review Note</th><th>Action</th>
			</tr></thead>
			<tbody>
				@forelse($documents as $document)
				<?php
					$reviewStatus = strtoupper((string) $document->REVIEWED);
					$reviewIsDue = (bool) $document->ANNUAL_REVIEW_DUE;
					$isCurrentReview = (bool) $document->REVIEWED_FOR_CURRENT_REVISION;
					$showReviewAction = $currentUserId && (int) $document->OWNER_ID === (int) $currentUserId
						&& $document->DOCSTATUS === 'Active';
					$canReviewDocument = $showReviewAction && $reviewIsDue;
					if (!$document->EFFECTIVE_REVISION_DATE && !$document->REVIEWED_AT) {
						$reviewLabel = 'NOT SET';
					} elseif ($reviewIsDue) {
						$reviewLabel = 'NEEDS REVIEW';
					} elseif ($isCurrentReview && in_array($reviewStatus, ['OK', 'NOK'], true)) {
						$reviewLabel = $reviewStatus;
					} else {
						$reviewLabel = 'NOT DUE';
					}
					$reviewClass = $reviewLabel === 'OK' ? 'label-success' : ($reviewLabel === 'NOK' ? 'label-danger' : ($reviewLabel === 'NEEDS REVIEW' ? 'label-warning' : 'label-default'));
				?>
				<tr>
					@if($canManageOwner)
					<td><input type="checkbox" class="document-selection" value="{{ base64_encode(json_encode([$document->DOCID, $document->DOCREV])) }}"
						data-current-owner="{{ $document->owner ? $document->owner->name : 'Not Assigned' }}"></td>
					@endif
					<td class="document-id">{{ $document->DOCID }}<small>Rev {{ $document->DOCREV }}</small></td>
					<td>{{ $document->DOCDESC }}</td>
					<td>{{ $document->DIVID }}</td>
					<td><span class="category-badge">{{ $document->CATID }}</span></td>
					<td>
						@if($canManageOwner)
						<form method="post" action="{{ route('document_owner.single') }}" class="single-owner-form">
							{{ csrf_field() }}
							<input type="hidden" name="document_id" value="{{ $document->DOCID }}">
							<input type="hidden" name="document_revision" value="{{ $document->DOCREV }}">
							<button type="button" class="btn btn-default btn-xs single-owner-trigger" aria-expanded="false">
								<span class="single-owner-label">{{ $document->owner ? $document->owner->name : 'Not Assigned' }}</span> <span class="caret"></span>
							</button>
							<div class="owner-picker single-owner-picker" hidden>
								<input type="search" class="form-control input-sm owner-picker-search" placeholder="Search owner..." autocomplete="off" aria-label="Search owner for {{ $document->DOCID }}">
								<div class="owner-picker-options" role="listbox" aria-label="Owners">
									<button type="button" class="owner-picker-option" data-owner-id="">Not Assigned</button>
									@foreach($ownerUsers as $ownerUser)
									<button type="button" class="owner-picker-option" data-owner-id="{{ $ownerUser->id }}">{{ $ownerUser->username }} - {{ $ownerUser->name }}</button>
									@endforeach
									<div class="owner-picker-empty" hidden>No users found.</div>
								</div>
							</div>
						</form>
						@elseif($document->owner)
						{{ $document->owner->name }}
						@else
						<span class="label label-default">Not Assigned</span>
						@endif
					</td>
					<td><span class="label {{ $reviewClass }}">{{ $reviewLabel }}</span></td>
					<td class="review-note">{{ $document->REVIEW_NOTE ?: 'No review note' }}</td>
					<td>
						<div class="document-actions">
						@if($showReviewAction && $canReviewDocument)
						<button type="button" class="btn btn-primary btn-xs document-review-trigger"
							data-document-id="{{ $document->DOCID }}"
							data-document-revision="{{ $document->DOCREV }}"
							data-document-description="{{ $document->DOCDESC }}"
							data-revision-date="{{ $document->EFFECTIVE_REVISION_DATE ? date('d-m-Y', strtotime($document->EFFECTIVE_REVISION_DATE)) : 'Not Set' }}"
							data-next-review-date="{{ $document->NEXT_REVIEW_DATE ? date('d-m-Y', strtotime($document->NEXT_REVIEW_DATE)) : 'Not Set' }}"
							data-owner-name="{{ $document->owner ? $document->owner->name : '' }}">Review</button>
						@elseif($showReviewAction)
						<button type="button" class="btn btn-default btn-xs document-review-disabled" disabled title="Annual review belum jatuh tempo." aria-label="Review belum jatuh tempo">Review</button>
						@endif
						<form method="post" action="{{ route('viewdoc') }}" class="document-view-form">
							{{ csrf_field() }}
							<input type="hidden" name="view_type" value="uncontrolled">
							<input type="hidden" name="id" value="{{ $document->DOCID }}">
							<input type="hidden" name="rev" value="{{ $document->DOCREV }}">
							<button type="submit" class="btn btn-default btn-xs document-view-button"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
						</form>
						</div>
					</td>
				</tr>
				@empty
				<tr><td colspan="{{ $canManageOwner ? 8 : 7 }}" class="empty-state">
					@if(!$canManageOwner)
					<strong>Tidak ada dokumen untuk direview.</strong><br>
					Belum ada SOP/WI yang ditugaskan kepada Anda sebagai Document Owner.
					@else
					No SOP/WI documents found.
					@endif
				</td></tr>
				@endforelse
			</tbody>
		</table>
	</div>
	{{ $documents->links() }}

	@if($canManageOwner)
	<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog" aria-labelledby="bulkActionTitle">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" action="{{ route('document_owner.bulk') }}" id="bulk-action-form">
					{{ csrf_field() }}
					<input type="hidden" name="bulk_action" id="bulk_action">
					<div id="selected-document-inputs"></div>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="bulkActionTitle">Bulk Document Action</h4>
					</div>
					<div class="modal-body">
						<p>Selected documents: <strong id="modal-selected-count">0</strong></p>
						<p id="modal-current-owners" class="text-muted"></p>
						<div class="form-group action-owner">
							<label>Document Owner</label>
							<input type="hidden" id="bulk_owner_id" name="owner_id">
							<div class="owner-picker bulk-owner-picker">
								<input type="search" class="form-control input-sm owner-picker-search" placeholder="Search username or name..." autocomplete="off" aria-label="Search bulk document owners">
								<div class="owner-picker-options" role="listbox" aria-label="Owners">
									<button type="button" class="owner-picker-option" data-owner-id="">Not Assigned</button>
								@foreach($ownerUsers as $ownerUser)
									<button type="button" class="owner-picker-option" data-owner-id="{{ $ownerUser->id }}">{{ $ownerUser->username }} - {{ $ownerUser->name }}</button>
								@endforeach
									<div class="owner-picker-empty" hidden>No users found.</div>
								</div>
							</div>
							<p class="help-block">Selected owner: <strong id="bulk-owner-selected">None</strong></p>
						</div>
						<div class="form-group action-revision-date">
							<label for="bulk_revision_date">Revision Date</label>
							<input type="date" id="bulk_revision_date" name="revision_date" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="save-bulk-action">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif
	@if($canManageOwner)
	<div class="modal fade" id="reviewReminderModal" tabindex="-1" role="dialog" aria-labelledby="reviewReminderTitle">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" action="{{ route('document_owner.reminders.send') }}" id="review-reminder-form">
					{{ csrf_field() }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="reviewReminderTitle">Annual Review Reminder</h4>
					</div>
					@endif
					<div class="modal-body">
						<p>Ready to send:</p>
						<ul class="list-unstyled reminder-preview-counts">
							<li><strong id="reminder-preview-documents">0</strong> Documents</li>
							<li><strong id="reminder-preview-owners">0</strong> Owners</li>
						</ul>
						<div class="alert alert-warning">
							<strong>Not assigned: <span id="reminder-preview-unassigned">0</span> Documents</strong><br>
							Documents without an Owner will NOT receive a reminder.
						</div>
						<p>Each Owner will receive one email containing all of their due documents.</p>
						<div id="reminder-tracking-warning" class="alert alert-danger" hidden>
							Reminder sending requires the additive cycle-tracking migration. No emails can be sent until it is applied.
						</div>
						<div id="reminder-preview-error" class="alert alert-danger" hidden></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="send-review-reminders" disabled>Review &amp; Send</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="documentReviewModal" tabindex="-1" role="dialog" aria-labelledby="documentReviewTitle">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" action="{{ route('document_owner.review') }}" id="document-review-form">
					{{ csrf_field() }}
					<input type="hidden" name="document_id" id="review-document-id">
					<input type="hidden" name="document_revision" id="review-document-revision">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="documentReviewTitle">Document Review</h4>
					</div>
					<div class="modal-body">
						<dl class="dl-horizontal">
							<dt>Document</dt><dd id="review-document-label"></dd>
							<dt>Description</dt><dd id="review-document-description"></dd>
							<dt>Revision</dt><dd id="review-document-revision-label"></dd>
							<dt>Revision Date</dt><dd id="review-revision-date"></dd>
							<dt>Review Due</dt><dd id="review-next-review-date"></dd>
							<dt>Owner</dt><dd id="review-owner-name"></dd>
						</dl>
						<div class="form-group">
							<label>Review Result</label>
							<div>
								<label class="radio-inline"><input type="radio" name="review_status" value="OK" required> OK</label>
								<label class="radio-inline"><input type="radio" name="review_status" value="NOK" required> NOK</label>
							</div>
						</div>
						<div class="form-group">
							<label for="review-note">Review Note</label>
							<textarea id="review-note" name="review_note" class="form-control" rows="3"></textarea>
						</div>
						<div id="review-form-error" class="alert alert-danger" hidden></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="submit-document-review">Submit Review</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif
</div>

<style>
	.document-review-page { max-width: 1440px; }
	.document-review-header { display:flex; align-items:center; justify-content:space-between; gap:16px; border-bottom:1px solid #ddd; margin:20px 0; padding-bottom:12px; }
	.document-review-header h2 { margin:0 0 6px; font-size:22px; font-weight:500; color:#333; }
	.document-review-header p { margin:0; }
	.summary-cards { margin-bottom:8px; }
	.summary-card { display:flex; flex-direction:column; min-height:82px; margin-bottom:15px; padding:14px 16px; border:1px solid #ccc; border-left:4px solid #337ab7; border-radius:3px; background:#fff; }
	.summary-card span { color:#555; font-size:13px; }
	.summary-card strong { margin-top:5px; color:#333; font-size:24px; line-height:1.1; }
	.reminder-preview-counts { display:flex; gap:24px; margin:10px 0 16px; font-size:16px; }
	.reminder-failures { margin:8px 0 0; }
	.filter-panel { margin-bottom:15px; padding:15px; border:1px solid #ccc; border-radius:3px; background:#fff; }
	.filter-panel .form-group { width:100%; margin-bottom:10px; }
	.filter-panel label { color:#333; font-size:12px; font-weight:600; }
	.filter-panel .form-control { width:100%; }
	.filter-actions { display:flex; align-items:center; justify-content:space-between; gap:12px; }
	.filter-actions > div { white-space:nowrap; }
	.active-filter-indicator { margin:-5px 0 12px; color:#555; font-size:12px; }
	.active-filter-indicator a { margin-left:8px; }
	.bulk-toolbar { display:flex; justify-content:space-between; align-items:center; gap:12px; margin:16px 0 10px; padding:12px 14px; border:1px solid #ccc; border-radius:3px; background:#f5f5f5; }
	.bulk-actions { display:flex; align-items:center; gap:8px; }
	.document-table-wrap { border:1px solid #ccc; border-radius:3px; }
	.document-table { margin:0; background:#fff; }
	.document-table thead th { position:sticky; top:0; z-index:1; background:#666; color:#fff; font-size:12px; font-weight:700; }
	.document-table td, .document-table th { vertical-align:middle !important; padding:10px 12px !important; }
	.document-id { min-width:135px; font-weight:600; color:#333; }
	.document-id small { display:block; margin-top:3px; color:#666; font-weight:400; }
	.category-badge { display:inline-block; min-width:36px; padding:3px 7px; border-radius:3px; background:#777; color:#fff; text-align:center; font-size:11px; font-weight:600; }
	.document-table .label { display:inline-block; padding:5px 7px; }
	.document-actions { display:flex; align-items:center; justify-content:center; gap:6px; white-space:nowrap; }
	.document-view-form { display:inline-block; margin:0; }
	.document-actions .btn { min-width:64px; }
	.document-review-disabled { cursor:not-allowed; opacity:.65; }
	.document-view-button { color:#333; }
	.document-view-button:hover, .document-view-button:focus { color:#23527c; border-color:#adadad; background:#e6e6e6; }
	.empty-state { padding:32px !important; color:#555; text-align:center; }
	.action-owner, .action-revision-date { display:none; }
	.single-owner-form { min-width:150px; }
	.single-owner-form { position:relative; }
	.owner-picker { padding:8px; border:1px solid #ccc; border-radius:3px; background:#fff; box-shadow:0 3px 9px rgba(0,0,0,.18); }
	.single-owner-picker { position:fixed; z-index:1100; width:230px; }
	.owner-picker-search { margin-bottom:6px; }
	.owner-picker-options { max-height:190px; overflow-y:auto; }
	.owner-picker-option { display:block; width:100%; padding:6px 8px; border:0; background:#fff; color:#333; text-align:left; }
	.owner-picker-option:hover, .owner-picker-option:focus { background:#337ab7; color:#fff; outline:0; }
	.owner-picker-option.active { background:#337ab7; color:#fff; }
	.owner-picker-option[hidden], .owner-picker-empty[hidden], .owner-update-notice[hidden] { display:none !important; }
	.owner-picker-empty { padding:7px 8px; color:#666; }
	.bulk-owner-picker { max-width:420px; }
	.owner-update-notice { position:fixed; top:15px; right:20px; z-index:1100; box-shadow:0 2px 7px rgba(0,0,0,.18); }
	@media (max-width:767px) {
		.document-review-header { align-items:flex-start; }
		.document-review-header h2 { font-size:20px; }
		.filter-actions, .bulk-toolbar { align-items:flex-start; flex-direction:column; }
		.bulk-actions { flex-wrap:wrap; }
		.summary-card { min-height:76px; padding:12px; }
		.summary-card strong { font-size:21px; }
		.document-table { min-width:760px; }
		.document-actions { gap:4px; }
		.document-actions .btn { min-width:58px; }
	}
</style>
<script>
	(function ($) {
		var selectedAction = '';
		function updateSelectionState() {
			var count = $('.document-selection:checked').length;
			$('#selected-document-count').text(count + ' document' + (count === 1 ? '' : 's'));
			$('.bulk-action-button').prop('disabled', count === 0);
			$('.select-all-documents').prop('checked',
				$('.document-selection').length > 0 && count === $('.document-selection').length);
		}
		$('.select-all-documents').on('change', function () {
			$('.document-selection').prop('checked', this.checked);
			updateSelectionState();
		});
		$(document).on('change', '.document-selection', updateSelectionState);
		$(document).on('click', '.single-owner-trigger', function () {
			var picker = $(this).siblings('.single-owner-picker');
			var position = this.getBoundingClientRect();
			$('.single-owner-picker').not(picker).prop('hidden', true);
			$('.single-owner-trigger').not(this).attr('aria-expanded', 'false');
			picker.css({top: position.bottom + 'px', left: Math.min(position.left, window.innerWidth - 240) + 'px'})
				.prop('hidden', false).find('.owner-picker-search').val('').trigger('input').trigger('focus');
			$(this).attr('aria-expanded', 'true');
		});
		$(document).on('click', function (event) {
			if (!$(event.target).closest('.single-owner-form').length) {
				$('.single-owner-picker').prop('hidden', true);
				$('.single-owner-trigger').attr('aria-expanded', 'false');
			}
		});
		$(document).on('input', '.owner-picker-search', function () {
			var search = $(this).val().toLowerCase();
			var picker = $(this).closest('.owner-picker');
			var visibleCount = 0;
			picker.find('.owner-picker-option').each(function () {
				var option = $(this);
				var matches = option.text().toLowerCase().indexOf(search) !== -1;
				option.prop('hidden', !matches);
				if (matches) visibleCount++;
			});
			picker.find('.owner-picker-empty').prop('hidden', visibleCount !== 0);
		});
		$(document).on('click', '.single-owner-picker .owner-picker-option', function () {
			var option = $(this);
			var form = option.closest('.single-owner-form');
			$.ajax({
				url: form.attr('action'),
				method: 'POST',
				dataType: 'json',
				data: form.serialize() + '&owner_id=' + encodeURIComponent(option.attr('data-owner-id')),
				headers: {'Accept': 'application/json'}
			}).done(function (response) {
				form.find('.single-owner-label').text(response.owner_name || 'Not Assigned');
				form.find('.single-owner-trigger').attr('aria-expanded', 'false');
				form.find('.single-owner-picker').prop('hidden', true);
				$('#owner-update-notice').removeClass('alert-danger').addClass('alert-success')
					.text(response.message).prop('hidden', false);
				window.setTimeout(function () { $('#owner-update-notice').prop('hidden', true); }, 3000);
			}).fail(function (xhr) {
				var response = xhr.responseJSON || {};
				$('#owner-update-notice').removeClass('alert-success').addClass('alert-danger')
					.text(response.message || 'Owner update failed. Please try again.').prop('hidden', false);
			});
		});
		$('.bulk-action-button').on('click', function () {
			selectedAction = $(this).data('bulk-action');
			$('#bulk_action').val(selectedAction);
			$('#bulkActionTitle').text(selectedAction === 'owner' ? 'Set Document Owner' : 'Set Revision Date');
			$('#save-bulk-action').text(selectedAction === 'owner' ? 'Save Owner' : 'Save');
			$('.action-owner, .action-revision-date').hide();
			$('.action-' + (selectedAction === 'owner' ? 'owner' : 'revision-date')).show();
			var inputContainer = $('#selected-document-inputs').empty();
			$('.document-selection:checked').each(function () {
				$('<input>').attr({type: 'hidden', name: 'selected_documents[]', value: $(this).val()}).appendTo(inputContainer);
			});
			$('#modal-selected-count').text($('.document-selection:checked').length);
			var currentOwners = $('.document-selection:checked').map(function () {
				return $(this).attr('data-current-owner');
			}).get().filter(function (owner, index, owners) {
				return owners.indexOf(owner) === index;
			});
			$('#modal-current-owners').text('Current owners: ' + (currentOwners.length > 1 ? 'Mixed' : (currentOwners[0] || 'Not Assigned')));
			$('#bulk_owner_id').val('').attr('data-owner-selected', 'false');
			$('#bulk-owner-selected').text('None');
			$('.bulk-owner-picker .owner-picker-search').val('').trigger('input');
			$('#bulk_owner_id, #bulk_revision_date').prop('required', false);
			if (selectedAction === 'revision_date') $('#bulk_revision_date').prop('required', true);
			$('#bulkActionModal').modal('show');
		});
		$('#preview-review-reminders').on('click', function () {
			var button = $(this);
			var sendButton = $('#send-review-reminders').prop('disabled', true);
			$('#reminder-preview-error').prop('hidden', true).text('');
			$('#reminder-tracking-warning').prop('hidden', true);
			$('#reminder-preview-documents, #reminder-preview-owners, #reminder-preview-unassigned').text('…');
			$('#reviewReminderModal').modal('show');
			$.ajax({
				url: button.attr('data-preview-url'),
				method: 'GET',
				dataType: 'json',
				headers: {'Accept': 'application/json'}
			}).done(function (preview) {
				$('#reminder-preview-documents').text(preview.documents);
				$('#reminder-preview-owners').text(preview.owners);
				$('#reminder-preview-unassigned').text(preview.without_owner);
				$('#reminder-tracking-warning').prop('hidden', preview.tracking_available);
				sendButton.prop('disabled', preview.documents === 0 || !preview.tracking_available);
			}).fail(function (xhr) {
				var response = xhr.responseJSON || {};
				$('#reminder-preview-error').text(response.message || 'Reminder preview could not be loaded.').prop('hidden', false);
			});
		});
		$('#review-reminder-form').on('submit', function () {
			$('#send-review-reminders').prop('disabled', true).text('Sending…');
		});
		$(document).on('click', '.bulk-owner-picker .owner-picker-option', function () {
			var option = $(this);
			$('#bulk_owner_id').val(option.attr('data-owner-id')).attr('data-owner-selected', 'true');
			$('#bulk-owner-selected').text(option.text());
			option.addClass('active').siblings('.owner-picker-option').removeClass('active');
		});
		$('#bulk-action-form').on('submit', function (event) {
			if (!$('#selected-document-inputs input').length) {
				event.preventDefault();
				alert('Select at least one SOP/WI document.');
			} else if (selectedAction === 'owner' && $('#bulk_owner_id').attr('data-owner-selected') !== 'true') {
				event.preventDefault();
				alert('Select a document owner.');
			}
		});
		$(document).on('click', '.document-review-trigger', function () {
			var button = $(this);
			$('#review-document-id').val(button.attr('data-document-id'));
			$('#review-document-revision').val(button.attr('data-document-revision'));
			$('#review-document-label').text(button.attr('data-document-id'));
			$('#review-document-description').text(button.attr('data-document-description'));
			$('#review-document-revision-label').text('Rev ' + button.attr('data-document-revision'));
			$('#review-revision-date').text(button.attr('data-revision-date'));
			$('#review-next-review-date').text(button.attr('data-next-review-date'));
			$('#review-owner-name').text(button.attr('data-owner-name'));
			$('#document-review-form')[0].reset();
			$('#review-document-id').val(button.attr('data-document-id'));
			$('#review-document-revision').val(button.attr('data-document-revision'));
			$('#review-form-error').prop('hidden', true).text('');
			$('#documentReviewModal').modal('show');
		});
		$('#document-review-form').on('submit', function (event) {
			event.preventDefault();
			var form = $(this);
			var submitButton = $('#submit-document-review').prop('disabled', true);
			$.ajax({
				url: form.attr('action'),
				method: 'POST',
				dataType: 'json',
				data: form.serialize(),
				headers: {'Accept': 'application/json'}
			}).done(function (response) {
				if (response.request_url) {
					window.location.href = response.request_url;
					return;
				}
				$('#documentReviewModal').modal('hide');
				$('#owner-update-notice').removeClass('alert-danger').addClass('alert-success')
					.text(response.message).prop('hidden', false);
				window.setTimeout(function () { window.location.reload(); }, 1200);
			}).fail(function (xhr) {
				var response = xhr.responseJSON || {};
				$('#review-form-error').text(response.message || 'Review submission failed.').prop('hidden', false);
			}).always(function () {
				submitButton.prop('disabled', false);
			});
		});
	})(jQuery);
</script>
@endsection
