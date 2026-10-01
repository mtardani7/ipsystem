<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class MailController extends Controller
{
    //
    public function basic_email(){
      $data = array('name'=>"Virat Gandhi");

      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('saichudin@rapidplast.co.id', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   }

   public function html_email($name){
    $names = $name;
    $user = User::where('name',$names)->first();
    $approval_email = $user->email;
    if ($names == 'no')
    {return redirect('/approval_req');}
    else
    {
      $data = array('name'=> $names);
        Mail::send('mail', $data, function($message) {

          $approval_email = 'saichudin@rapidplast.co.id';
          $message->getHeaders()
                      ->addTextHeader('MIME-Version', '1');
          $message->to($approval_email)->subject
             ('IPSystem Approval Notification');
           $message->subject('IPSystem Approval Notification');
           $message->from('it@rapidplast.co.id','System Administrator');
        });
        echo "HTML Email Sent. Check your inbox.";
        return redirect('/approval_req');
    }
   }

   public function reject_email($name){
    $names = $name;
    if ($names == 'no')
    {return redirect('/approval_req');}
    else
    {
      $data = array('name'=> $names);
        Mail::send('reject-mail', $data, function($message) {
          $message->getHeaders()
                      ->addTextHeader('MIME-Version', '1');
           $message->to('saichudin@rapidplast.co.id')->subject
              ('IPSystem Reject Notification');
           $message->from('it@rapidplast.co.id','System Administrator');
        });
        echo "HTML Email Sent. Check your inbox.";
        return redirect('/approval_req');
    }
  }
   public function attachment_email(){
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('saichudin@rapidplast.co.id', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }

   public function testmail()
   {
    return view('mail');
   }

}
