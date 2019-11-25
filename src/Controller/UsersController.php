<?php
// src/Controller/UsersController.php

namespace App\Controller;

use Cake\Network\Http\Client;#
use Cake\Event\Event;
use Cake\Core\Configure;

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
             $user = $this->Users->patchEntity($user, $this->request->getData());
             if ($this->Users->save($user)) {
                 $this->Flash->success(__('The user has been saved.'));
                 return $this->redirect(['action' => 'register']);
             }
             $this->Flash->error(__('Unable to add the user.'));
         }
         $this->set('user', $user);
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
