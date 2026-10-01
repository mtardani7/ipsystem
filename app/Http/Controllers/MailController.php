<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Req;
use App\Mail\EmailApproval;
use App\Mail\EmailReject;
use App\Mail\EmailUpdateForm;
use App\Mail\EmailVerification;
use App\Mail\EmailApprovalDone;

class MailController extends Controller
{
  public function test_send()
  {
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = 'ReceiverName';

      Mail::to("saichudin@rapidplast.co.id")->send(new EmailApproval($obj));
      echo "Email Sent. Check your inbox.";
  }

  public function send($name)
  {
      $names = $name;
      $data = User::where('name',$names)->first();
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = $names;
      $obj->receiver_email = $data->email;
      $email_to = $data->email;

      Mail::to($email_to)->send(new EmailApproval($obj));
      return redirect('/approval_req');
  }

  public function send_reject($name)
  {
      $id = $name;
      $reqs = Req::where('id',$id)->first();
      $data_req = User::where('username',$reqs->reqby)->first();
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = $data_req->name;
      $obj->reject_by = $reqs->reject_by;
      $obj->reject_date = $reqs->reject_date;
      $obj->reject_rmk = $reqs->reject_rmk;
      $email_to = $data_req->email;

      Mail::to($email_to)->send(new EmailReject($obj));
      return redirect('/history_req');
  }

  public function send_request_verified($name)
  {
      $names = $name;
      $data = User::where('name',$names)->first();
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = $names;
      $obj->receiver_email = $data->email;
      $email_to = $data->email;

      Mail::to($email_to)->send(new EmailApproval($obj));
      //return redirect('/approval_req');
      return redirect()->route('incoming_req')->with('data','Form behasil diverifikasi');
  }

  public function send_verification()
  {

      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = 'Document Controller';
      $obj->receiver_email = 'doc.controller@rapidplast.id';
      $email_to = 'doc.controller@rapidplast.id';

      Mail::to($email_to)->send(new EmailVerification($obj));
      //return redirect('/approval_req');
      return redirect()->route('create_req')->with('data','Form behasil disimpan');
  }

  public function send_request($name)
  {
      $names = $name;
      $data = User::where('name',$names)->first();
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = $names;
      $obj->receiver_email = $data->email;
      $email_to = $data->email;

      Mail::to($email_to)->send(new EmailApproval($obj));
      //return redirect('/approval_req');
      return redirect()->route('create_req')->with('data','Form behasil disimpan');
  }

  public function send_approval_done()
  {
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = 'Document Controller';
      $obj->receiver_email = 'doc.controller@rapidplast.id';
      $email_to = 'doc.controller@rapidplast.id';

      Mail::to($email_to)->send(new EmailApprovalDone($obj));
      //return redirect('/approval_req');
      return redirect()->route('approval_req')->with('data','Form behasil diapprove');
  }

  public function send_update($name)
  {
      $names = $name;
      $data = User::where('name',$names)->first();
      $obj = new \stdClass();
      $obj->demo_one = 'Demo One Value';
      $obj->demo_two = 'Demo Two Value';
      $obj->sender = 'SenderUserName';
      $obj->receiver = $names;
      $obj->receiver_email = $data->email;
      $email_to = $data->email;

      Mail::to($email_to)->send(new EmailUpdateForm($obj));
      //return redirect('/approval_req');
      return redirect()->route('history_req')->with('data','Form behasil diupdate');
  }

}
