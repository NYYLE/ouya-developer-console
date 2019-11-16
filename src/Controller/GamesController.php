<?php
// src/Controller/GamesController.php

namespace App\Controller;

use Cake\Network\Http\Client;

class GamesController extends AppController
{
    public function index()
    {
        $http = new Client();

        $response = $http->get('http://ouya.dcrich.net:35791/api/v1/gamedata/com.ATG.DU');
        $array = array($response->getJson());
        $games = $array;
        $this->set(compact('games'));
    }

    public function view($package_name)
    {
        $http = new Client();

        $response = $http->get('http://ouya.dcrich.net:35791/api/v1/gamedata/' . $package_name);
        $game = $response->getJson();

        $this->set(compact('game'));
    }

    public function add()
    {
       $game = $this->Games->newEntity();
       if ($this->request->is('post')) {
           $game = $this->Games->patchEntity($game, $this->request->getData());

           // Hardcoding the user_id is temporary, and will be removed later
           // when we build authentication out.
           $game->user_id = 1;

           if ($this->Games->save($game)) {
               $this->Flash->success(__('Your game has been saved.'));
               return $this->redirect(['action' => 'index']);
           }
           $this->Flash->error(__('Unable to add your game.'));
       }
       $this->set('game', $game);
    }

    public function edit($id)
    {
        $game = $this->Games->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Games->patchEntity($game, $this->request->getData());
            if ($this->Games->save($game)) {
                $this->Flash->success(__('Your game has been updated.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Unable to update your game.'));
        }

        $this->set('game', $game);
    }
}
