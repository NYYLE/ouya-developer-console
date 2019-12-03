<?php
namespace App\Mailer;
use Cake\Mailer\Mailer;
use Cake\Mailer\Email;

class UserMailer extends Mailer
{
  public function registered($user)
  {
    $email = new Email('default');
    $email->from(['ouya.world.dev@gmail.com' => 'OUYA World Dev Portal'])
    ->to($user['email']) // add email recipient
    ->emailFormat('html') // email format
    ->subject(sprintf('Welcome to the OUYA World Dev Portal %s', $user['username'])) //  subject of email
    ->viewVars([   // these variables will be passed to email template defined in step 5 with
    //name registered.ctp
    'username'=> $user->username,
    'email'=>$user->email,
    'token'=>$user->token
    ])
    // the template file you will use in this email
    ->template('registered')
    ->send(); // By default template with same name as method name is used.
  }
}
