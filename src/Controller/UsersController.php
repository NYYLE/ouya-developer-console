<?php
// src/Controller/UsersController.php

namespace App\Controller;

use Cake\Network\Http\Client;#
use Cake\Event\Event;
use Cake\Core\Configure;

class UsersController extends AppController {

     public function index()
     {
         $this->set('users', $this->Users->find('all'));
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
