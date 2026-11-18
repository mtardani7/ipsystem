<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Masterlist;
use App\DocumentReviewCycle;
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;
use DB;
use App\User;
use App\UserLevel;

class MasterListController extends Controller
{
    //
	public function index()
    {

		//$list = \App\Masterlist::orderBy('DOCID')->paginate(3);
		//select all with paginate
	   $list = Masterlist::with('owner')->paginate(3);
	   $divs = \App\Division::orderBy('DIVID')->get();
	   $cats = \App\Category::orderBy('CATID')->get();
	   $users = User::orderBy('username')->get();
	   return view('master/input_list', compact('list','divs','cats','users'));
    }

	public function add(Request $request)
    {
		$canManageOwner = $this->canManageOwner();
		if (!$canManageOwner && (
			array_key_exists('owner_id', $request->all())
			|| array_key_exists('OWNER_ID', $request->all())
		)) {
			abort(403, 'Only superusers may set Document Owner.');
		}
		$masterlist = new Masterlist();
    	try {
		$masterlist->DOCID = $request->doc_id;
		$doc_rev = $request->rev1." (". $request->rev.")";
		$masterlist->DOCREV = $doc_rev;
		$masterlist->DOCDESC = $request->desc;
		$remark = addslashes($request->rmk);
		$masterlist->DOCREM = $remark;
		$masterlist->DOCSTATUS = $request->status;
		$masterlist->DIVID = $request->dept_id;
		$masterlist->CATID = $request->cat_id;
		$view = substr("$request->view",9);
		$masterlist->PDFVIEW = $view;
		if (isset($request->optradio))
			{
				if ($request->optradio == 'print')
				$print = str_replace('.pdf','_Print.pdf',$view);
				elseif ($request->optradio == 'same')
				$print = $view;
			}
		else{
		$print = substr("$request->print",9); }
		$masterlist->PDFPRINT = $print;
		$masterlist->SHARESTATUS = $request->share;
		$masterlist->SAVEPERIODE = $request->save;
		$masterlist->SORTMETHODE = $request->sort;
		$masterlist->ELIMINATEMETHODE = $request->elm;
		$masterlist->DISTRIBUTION = $request->dist;
		$masterlist->INPUTBY = $request->user;
		$masterlist->OWNER_ID = null;
		$masterlist->REVISION_DATE = null;
		$masterlist->REVIEWED = null;
		$masterlist->REVIEWED_BY = null;
		$masterlist->REVIEWED_AT = null;
		$masterlist->REVIEW_NOTE = null;
		$now = DB::raw('NOW()');
		$masterlist->INPUTDATE = $now;
    	$masterlist->save();
		//Alert::success('Success add plant');
		Session::put('success', 'Your Record <b>'.$masterlist->DOCDESC. '</b> addedd successfully.');
    	return redirect('/input_list');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }

	public function search( Request $request )
	{
		$divs = \App\Division::orderBy('DIVID')->get();
		$cats = \App\Category::orderBy('CATID')->get();
		$dept_src = $request->get('dept_id');
		$cat_src = $request->get('cat_id');
		//$div = $request->dept_id;
		//$cat = $request->cat_id;
		$lists = \App\Masterlist::with('owner')->where('divid','=', $dept_src)
				->where('catid','=', $cat_src)
				->orderby('DOCID')
				->orderby('DOCREV')
				->get();
		$users = User::orderBy('username')->get();
		//$name = $request->input( 'name' );
		 return view('master/input_list', compact('lists','divs','cats','dept_src','cat_src','users'));
	}

	public function edit(Request $request)
	 {
		// $docid = str_replace('-','/',$id);
		$docid = $request->get('docid');
		$docrev = $request->get('docrev');
		 	/*$list = \App\Masterlist::where('DOCID','=', $docid) WIN/1-IT/01
		 					->where('DOCREV','=', $rev)
							->first();*/

			$list = \App\Masterlist::with('owner')->where('DOCID','=',$docid)->where('DOCREV','=', $docrev)->first();

		//$list = DB::connection('mysql3')->table('masterlist')->where('DOCID', $docid)->first();
	//	$pdf = $list->DOCID;

		 $divs = \App\Division::orderBy('DIVID')->get();
	 	$cats = \App\Category::orderBy('CATID')->get();
		 return view('master/edit_list', compact('list','docid','docrev','divs','cats'));

	 }

    public function update(Request $request)
    {
        if ($request->input('review_action') === 'review') {
            return $this->submitAnnualReview($request);
        }
        if ($request->input('owner_action') === 'bulk') {
            return $this->updateOwners($request);
        }

        if (!$this->canAccessMasterlistUpdate()) {
            abort(403, 'You do not have access to update Masterlist.');
        }

        $canManageOwner = $this->canManageOwner();
        if (!$canManageOwner && (
            array_key_exists('owner_id', $request->all())
            || array_key_exists('OWNER_ID', $request->all())
        )) {
            abort(403, 'Only superusers may change Document Owner.');
        }

        $param_docid = $request->input('param_docid');
        $param_docrev = $request->input('param_docrev');
        $list = \App\Masterlist::where('DOCID', '=', $param_docid)
            ->where('DOCREV', '=', $param_docrev)
            ->first();
        if (!$list) {
            return redirect()->back()->with('data', 'Masterlist document was not found.');
        }

        $docrev = $request->rev1." (". $request->rev.")";
        try {
            $ownerId = $this->ownerIdForUpdatedDocument(
                $request,
                $list,
                $request->input('cat_id'),
                $canManageOwner
            );
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('data', $e->getMessage())->withInput();
        }

        if ($request->print != $list->PDFPRINT) {
            $pdf_print = substr("$request->print", 9);
        } else {
            $pdf_print = $request->print;
        }

        if ($request->view != $list->PDFVIEW) {
            $pdf_view = substr("$request->view", 9);
        } else {
            $pdf_view = $request->view;
        }

        try {
            $update = [
                'DOCID' => $request->input('doc_id'),
                'DOCREV' => $docrev,
                'DOCDESC' => $request->input('desc'),
                'DOCREM' => $request->input('rmk'),
                'DOCSTATUS' => $request->input('status'),
                'DIVID' => $request->input('dept_id'),
                'CATID' => $request->input('cat_id'),
                'PDFVIEW' => $pdf_view,
                'PDFPRINT' => $pdf_print,
                'SHARESTATUS' => $request->input('share'),
                'SAVEPERIODE' => $request->input('save'),
                'SORTMETHODE' => $request->input('sort'),
                'ELIMINATEMETHODE' => $request->input('elm'),
                'DISTRIBUTION' => $request->input('dist'),
                'OWNER_ID' => $ownerId,
            ];
            DB::connection('mysql3')->table('masterlist')
                ->where('DOCID', $param_docid)
                ->where('DOCREV', $param_docrev)
                ->update($update);

            return redirect('/input_list');
        } catch (\Exception $e) {
            return redirect()->back()->with('data', $e->getMessage());
        }
    }

    private function submitAnnualReview(Request $request)
    {
        $docid = $request->input('review_docid');
        $docrev = $request->input('review_docrev');
        $reviewStatusInput = $request->input('review_status');
        $reviewStatus = is_string($reviewStatusInput) ? strtoupper(trim($reviewStatusInput)) : '';
        $reviewNote = $request->input('review_note');
        $reviewNote = $reviewNote === null ? '' : $reviewNote;

        if (!is_string($docid) || $docid === '' || !is_string($docrev) || $docrev === '') {
            return redirect()->back()->with('data', 'The selected document is invalid.');
        }
        if (!in_array($reviewStatus, ['OK', 'NOK'], true)) {
            return redirect()->back()->with('data', 'Select OK or NOK as the review result.')->withInput();
        }
        if (!is_string($reviewNote)) {
            return redirect()->back()->with('data', 'The review note is invalid.')->withInput();
        }

        DB::connection('mysql3')->transaction(function () use ($docid, $docrev, $reviewStatus, $reviewNote) {
            $document = Masterlist::where('DOCID', $docid)
                ->where('DOCREV', $docrev)
                ->whereIn('CATID', ['SOP', 'WI'])
                ->where('DOCSTATUS', 'Active')
                ->lockForUpdate()
                ->first();

            if (!$document) {
                abort(422, 'This document is not eligible for annual review.');
            }

            $isAssignedOwner = $document->OWNER_ID !== null
                && (int) $document->OWNER_ID === (int) Auth::user()->id;
            if (!$isAssignedOwner) {
                abort(403, 'Only the assigned Document Owner may submit this review.');
            }

            if (!DocumentReviewCycle::isDue($document->REVISION_DATE, $document->REVIEWED_AT, null, $document->DOCREV)) {
                abort(422, 'Document is not yet due for annual review.');
            }

            $driver = DB::connection('mysql3')->getDriverName();
            $nextReviewDate = DocumentReviewCycle::nextReviewDateExpression($driver);
            $reviewUpdate = DB::connection('mysql3')->table('masterlist')
                ->where('DOCID', $docid)
                ->where('DOCREV', $docrev)
                ->whereIn('CATID', ['SOP', 'WI'])
                ->where('DOCSTATUS', 'Active')
                ->where('OWNER_ID', Auth::user()->id)
                ->whereRaw($nextReviewDate.' <= '.($driver === 'sqlite' ? "DATE('now')" : 'CURDATE()'));
            if ($document->REVISION_DATE === null) {
                $reviewUpdate->whereNull('REVISION_DATE');
            } else {
                $reviewUpdate->where('REVISION_DATE', $document->REVISION_DATE);
            }
            if ($document->REVIEWED_AT === null) {
                $reviewUpdate->whereNull('REVIEWED_AT');
            } else {
                $reviewUpdate->where('REVIEWED_AT', $document->REVIEWED_AT);
            }
            $reviewUpdate->update([
                    'REVIEWED' => $reviewStatus,
                    'REVIEWED_BY' => Auth::user()->id,
                    'REVIEWED_AT' => DB::raw('NOW()'),
                    'REVIEW_NOTE' => trim($reviewNote) === '' ? null : trim($reviewNote),
                ]);
        });

        return redirect()->back()->with('success', 'Annual review saved successfully.');
    }

    private function updateOwners(Request $request)
    {
        if (!$this->canManageOwner()) {
            abort(403, 'Only superusers may assign Document Owners.');
        }

        try {
            $selectedIds = $request->input('selected_documents');
            $ownerIds = $request->input('owner_ids');
            if (!is_array($selectedIds) || count($selectedIds) === 0 || !is_array($ownerIds)
                || count($selectedIds) !== count($ownerIds)) {
                throw new \InvalidArgumentException('Select at least one SOP/WI document and assign an owner to each.');
            }

            $documentsToUpdate = [];
            foreach ($selectedIds as $index => $selectedDocument) {
                if (!is_string($selectedDocument) || !array_key_exists($index, $ownerIds)
                    || (!is_string($ownerIds[$index]) && !is_int($ownerIds[$index]))) {
                    throw new \InvalidArgumentException('The selected document list is invalid.');
                }
                $decoded = base64_decode($selectedDocument, true);
                $documentKey = ($decoded === false) ? null : json_decode($decoded, true);
                if (!is_array($documentKey) || count($documentKey) !== 2
                    || !is_string($documentKey[0]) || $documentKey[0] === ''
                    || !is_string($documentKey[1]) || $documentKey[1] === '') {
                    throw new \InvalidArgumentException('The selected document list is invalid.');
                }
                $ownerId = $this->validatedOwnerId($ownerIds[$index]);
                if ($ownerId === null) {
                    throw new \InvalidArgumentException('Select an owner for every document.');
                }
                $documentsToUpdate[] = [
                    'DOCID' => $documentKey[0],
                    'DOCREV' => $documentKey[1],
                    'OWNER_ID' => $ownerId,
                ];
            }
            $documentIdentities = array_map(function ($document) {
                return json_encode([$document['DOCID'], $document['DOCREV']]);
            }, $documentsToUpdate);
            if (count(array_unique($documentIdentities)) !== count($documentsToUpdate)) {
                throw new \InvalidArgumentException('The selected document list contains duplicates.');
            }

            DB::connection('mysql3')->transaction(function () use ($documentsToUpdate) {
                $documents = Masterlist::where(function ($query) use ($documentsToUpdate) {
                    foreach ($documentsToUpdate as $documentKey) {
                        $query->orWhere(function ($pairQuery) use ($documentKey) {
                            $pairQuery->where('DOCID', $documentKey['DOCID'])
                                ->where('DOCREV', $documentKey['DOCREV']);
                        });
                    }
                })
                    ->whereIn('CATID', ['SOP', 'WI'])
                    ->lockForUpdate()
                    ->get(['DOCID', 'DOCREV']);

                if ($documents->count() !== count($documentsToUpdate)) {
                    throw new \InvalidArgumentException(
                        'One or more selected documents are missing or are not SOP/WI. No owners were changed.'
                    );
                }

                foreach ($documentsToUpdate as $documentKey) {
                    Masterlist::where('DOCID', $documentKey['DOCID'])
                        ->where('DOCREV', $documentKey['DOCREV'])
                        ->whereIn('CATID', ['SOP', 'WI'])
                        ->update(['OWNER_ID' => $documentKey['OWNER_ID']]);
                }
            });

            return redirect()->back()->with('success', count($documentsToUpdate).' Document Owner assignment(s) saved.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('data', $e->getMessage())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('data', $e->getMessage());
        }
    }

	private function canManageOwner()
	{
		if (!Auth::check()) {
			return false;
		}

		$userLevel = UserLevel::where('userid', Auth::user()->id)->first();

		return $userLevel && $userLevel->role === 'superuser';
	}

    private function canAccessMasterlistUpdate()
    {
        if (!Auth::check()) {
            return false;
        }

        $userLevel = UserLevel::where('userid', Auth::user()->id)->first();

        return $userLevel && in_array($userLevel->role, ['admin', 'superuser'], true);
    }

	private function isOwnerCategory($category)
	{
		return in_array(strtoupper((string) $category), ['SOP', 'WI'], true);
	}

	private function ownerIdForUpdatedDocument(Request $request, Masterlist $document, $newCategory, $canManageOwner)
	{
		$currentOwnerId = ($document->OWNER_ID === null) ? null : (int) $document->OWNER_ID;

		if (!$canManageOwner) {
			if (
				array_key_exists('owner_id', $request->all())
				|| array_key_exists('OWNER_ID', $request->all())
			) {
				abort(403, 'Only superusers may change Document Owner.');
			}

			return $currentOwnerId;
		}

		if (!$this->isOwnerCategory($newCategory)) {
			return null;
		}

		if (
			!array_key_exists('owner_id', $request->all())
			&& !array_key_exists('OWNER_ID', $request->all())
		) {
			return $currentOwnerId;
		}

		return $this->validatedOwnerId($request->input('owner_id', $request->input('OWNER_ID')));
	}

	private function validatedOwnerId($ownerId)
	{
		$ownerId = trim((string) $ownerId);
		if ($ownerId === '') {
			return null;
		}

		if (!ctype_digit($ownerId) || !User::where('id', (int) $ownerId)->exists()) {
			throw new \InvalidArgumentException('Document Owner is invalid. Please select a valid user.');
		}

		return (int) $ownerId;
	}

  public function destroy(Request $request)
  {
    $param_docid = $request->input('id');
    $param_docrev = $request->input('rev');
    $data = \App\Masterlist::where('DOCID','=',$param_docid)->where('DOCREV','=', $param_docrev)->first();
    $list = \App\Masterlist::where('DOCID','=',$param_docid)->where('DOCREV','=', $param_docrev);
    $list->delete();
    Session::put('success', 'Your Record <b>'.$data->DOCID. '</b> rev <b>'.$data->DOCREV.'</b> Deleted Successfully.');
    //notify()->flash('Berhasil menghapus data !', 'success');
    //Alert::success('Berhasil menghapus data !')->persistent('Confirm');
    return redirect('/input_list');

  }
}
