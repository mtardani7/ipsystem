<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataVendor;
use Excel;
use Session;
use Auth;

class DataVendorController extends Controller
{
    //
    public function index()
      {
      $datas = \App\DataVendor::where('deleted','no')->orderby('date_submit','DESC')->paginate(10);
          return view('administration/data_vendor/data_vendor', compact('datas'));
      }

    public function search(Request $request)
      {
        $word = $request->input('nama_perusahaan');
        $datas = \App\DataVendor::where('nama_perusahaan','like','%'.$word.'%')->where('deleted','no')
        ->paginate(50);
        return view('administration/data_vendor/data_vendor', compact('datas'));
      }
    public function view($id)
      {
        $data = DataVendor::find($id);
        $act = 'view';
        return view('administration//data_vendor/data_vendor_view',compact('data','act'));
      }
    public function edit($id)
      {
        $data = DataVendor::find($id);
        $act ='edit';
        return view('administration//data_vendor/data_vendor_view',compact('data','act'));
      }
      public function update_form(Request $request, $id)
        {

            $data = DataVendor::find($id);
    		try {
            $data->no_vendor = $request->input('no_vendor');
            $data->status = $request->input('status_vendor');
            $data->nama_perusahaan  = $request->input('nama_perusahaan');
            $data->alamat_perusahaan  = $request->input('alamat_perusahaan');
            $data->telp_perusahaan  = $request->input('telp_perusahaan');
            $data->fax_perusahaan  = $request->input('fax_perusahaan');
            $data->email_perusahaan  = $request->input('email_perusahaan');
            $data->cp_perusahaan   = $request->input('cp_perusahaan');
            $data->posisi   = $request->input('posisi');
            $data->SIUP  = $request->input('siup');
            $data->TDP  = $request->input('tdp');
            $data->NPWP  = $request->input('npwp');
            $data->term_payment   = $request->input('term_of_pay');
            $data->nama_acc_bank  = $request->input('nama_account');
            $data->nama_bank  = $request->input('nama_bank');
            $data->no_rekening  = $request->input('no_rek');
            $data->customer = $request->input('cust_vendor');
            $data->brand_fasilitas = $request->input('brand_fasilitas_vendor');
            $data->remark = $request->input('remark');
            $data->nama_pengisi  = $request->input('nama_pengisi');
            $data->posisi_pengisi = $request->input('posisi_pengisi');
            $data->hp_pengisi  = $request->input('hp_pengisi');
            $data->email_pengisi  = $request->input('email_pengisi');
            $data->no_ktp = $request->input('ktp');

            $data->save();
            return redirect('/data_vendor');
    		 }
    		catch(\Exception $e)
    		 {return redirect()->back()->with('data',$e->getMessage()); }
        }

    public function prints($id)
        {
          $data = DataVendor::find($id);
          return view('administration//data_vendor/print-data_vendor',compact('data'));
        }

    public function getxls()
    {

      $lists =  \App\DataVendor::where('active',1)->where('deleted','no')->orderby('date_submit','DESC')->get();

      Excel::create('Masterlist', function($excel) use($lists) {
        $excel->sheet('Data Vendor', function($sheet) use($lists) {
          $sheet->row(1, array(
            'No. Vendor', 'Status','Nama Perusahaan','Alamat','Telp','Fax','Email','Contact Person','Posisi','Tipe Bisnis',
            'SIUP','TDP','NPWP','Term of Payment','Nama Account Bank','Nama Bank','No. Rekening','Customer yang pernah dilayani',
            'Brand yang disupply','Catatan','Nama Pengisi','Posisi','No. HP','Email','No. KTP'
          ));

          //$sheet->setBorder('A1:I1', 'medium');

          $sheet->cell('A1:Z1', function($cells) {

            // manipulate the cell
            $cells->setBackground('#009933');
            $cells->setFontSize(14);
            $cells->setFontWeight('bold');
            $cells->setFontColor('#ffffff');
            $cells->setAlignment('center');

          });
          $no=1;
          foreach ($lists as $list)
          {
            $sheet->row($no+1, array(
              $list->no_vendor,$list->status,$list->nama_perusahaan,$list->alamat_perusahaan,$list->telp_perusahaan,$list->fax_perusahaan,
              $list->email_perusahaan,$list->cp_perusahaan,$list->posisi,$list->tipe_bisnis,$list->SIUP,$list->TDP,$list->NPWP,$list->term_payment,
              $list->nama_acc_bank,$list->nama_bank,$list->no_rekening,$list->customer,$list->brand_fasilitas,$list->remark,$list->nama_pengisi,
              $list->posisi_pengisi,$list->hp_pengisi,$list->email_pengisi,$list->no_ktp
            ));
            $no++;
          }
        });
      })->export('xls');
    }

    public function delete_vendor($id)
      {
      $username = Auth::user()->username;
  		$data = DataVendor::find($id);
      try {
          $data->deleted = 'Delete by '.$username;
          $data->save();
      	  Session::put('success', 'Your Record <b>'.$data->nama_perusahaan. '</b> Deleted Successfully.');
      	//notify()->flash('Berhasil menghapus data !', 'success');
  		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
  		return redirect('/data_vendor');
          }
      catch(\Exception $e)
      {return redirect()->back()->with('data',$e->getMessage()); }

      }
}
