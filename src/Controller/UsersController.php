<?php
// src/Controller/UsersController.php

namespace App\Controller;

use Cake\Network\Http\Client;#
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\Mailer\TransportFactory;

class UsersController extends AppController {

     public function games()
     {
        $this->loadModel('Games');
         $http = new Client();

         $response = $http->get('http://ouya.dcrich.net:35791/api/v1/gamedata/com.ATG.DU');
         $array = array($response->getJson(), $response->getJson(), $response->getJson(), $response->getJson());
         $submitted_games = $array;
         //debug($games);

         $rejected_game_find = $this->Games->find('all', array(
           'conditions' => array(
             'status' => 2,
             'user_id' => $this->request->session()->read('Auth.User.id')
           ),
         ));

         $rejected_games = array();
         foreach ($rejected_game_find as $game) {
           $game['game_data'] = json_decode($game['data'], true);
           $rejected_games[] = $game;
         }

         //debug($games);
         $this->set('rejected_games', $rejected_games);
         $this->set('submitted_games', $submitted_games);
     }

     public function view($id)
     {
         $user = $this->Users->get($id);
         $this->set(compact('user'));
     }

     public function register()
     {
         $user = $this->Users->newEntity();
         if ($this->request->is('post')) {
             // Prior to 3.4.0 $this->request->data() was used.

             $users = $this->Users->find('all', array(
               'conditions' => array(
                 'OR' => array(
                   array('username' => $this->request->data('username')),
                   array('email' => $this->request->data('email')),
                 )
               ),
             ));

             if (empty($users[0]['username'])) {
               $user = $this->Users->patchEntity($user, $this->request->getData());
               $user->devUUID = com_create_guid();
               $user->status = 1;
               $user->email = $this->request->data('email');

               $my_token = Security::hash(Security::randomBytes(32));
               $user->token = $my_token;

               if ($this->Users->save($user)) {
                   $this->Flash->success(__('Registration successful. Your confirmation email has been sent'));

                   $email = new Email('default');

                  $email->from(['dev.ouya.world@gmail.com' => 'DEV.OUYA.WORLD'])
                      ->to($this->request->data('email'))
                      ->subject('Email Confirmation')
                      ->send('My message');
                   return $this->redirect(['action' => 'login']);
               }
               $this->Flash->error(__('Unable to add the user.'));
             } else {
                $this->Flash->error(__('Username or email is already taken.'));
             }
         }
         $this->set('user', $user);
     }

     public function verification($token)
     {
         $user = $this->Users->find('first', array(
           'conditions' => array(
             'token' => $token
           )
         ));
         $this->Users->id = $user['User']['id'];
         $user->status = 0;
         $this->Users->save($user);
     }

     public function beforeFilter(Event $event)
     {
         parent::beforeFilter($event);
         // Allow users to register and logout.
         // You should not add the "login" action to allow list. Doing so would
         // cause problems with normal functioning of AuthComponent.
         $this->Auth->allow(['register', 'logout']);
     }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                Configure::write('User.username', $this->request->data['username']);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
