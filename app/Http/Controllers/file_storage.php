<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\P4no7;

class file_storage extends Controller
{
    //
    public function delete()
    {
        //
        $form = P4no7::find(69);
        unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));
        //File::delete('uploads/file/p4no7',$form->file_dokumen);
    }
}
