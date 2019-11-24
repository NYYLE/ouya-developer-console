<?php
// src/Controller/GamesController.php

namespace App\Controller;

use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;

class GamesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'view']);
    }

    public function index()
    {
        $http = new Client();

        $response = $http->get('http://ouya.dcrich.net:35791/api/v1/gamedata/com.ATG.DU');
        $array = array($response->getJson(), $response->getJson(), $response->getJson(), $response->getJson());
        $games = $array;
        //debug($games);
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
          $screenshots = array();
         if (!empty($this->request->data('screenshots'))) {
          $screenshots = explode(',', $this->request->data('screenshots'));
        }
          $details = array();
          foreach ($screenshots as $screenshot) {
            $details[] = array(
              'type' => 'image',
              'url' => $screenshot,
              'thumb' => $screenshot . '-thumb',
            );
          }
          debug($this->request->data('apk'));
          $apk = new \ApkParser\Parser($this->request->data('apk')['tmp_name']);

          $manifest = $apk->getManifest();
          $permissions = $manifest->getPermissions();

          $package_name = $manifest->getPackageName();
          $version_name = $manifest->getVersionName();
          $version_code = $manifest->getVersionCode();
          $min_sdk_level = $manifest->getMinSdkLevel();
          $min_sdk_platform = $manifest->getMinSdk()->platform;
          $target_sdk_level = $manifest->getTargetSdkLevel();
          $target_sdk_platform = $manifest->getTargetSdk()->platform;

          $game_data = array(
            'packageName' => $package_name,
            'title' => $this->request->data('title'),
            'description' => $this->request->data('description'),
            'players' => $this->request->data('players'),
            'genres' => $this->request->data('genres'),
            'releases' => array(
               'name' => $version_name,
               'versionCode' => $version_code,
               'uuid' => $this->request->data('uuid'),
               'date' => $this->request->data('date'),
               'url' => $this->request->data('url'),
               'size' => $this->request->data('size'),
               'md5sum' => $this->request->data('md5sum'),
               'publicSize' => $this->request->data('public_size'),
               'nativeSize' => $this->request->data('native_size'),
             ),
             'media' => array(
               'discover' => $this->request->data('discover'),
               'video' => $this->request->data('video'),
               'screenshots' => $screenshots,
               'details' => $details,
             ),
             'developer' => array(
               'uuid' => $this->request->data('uuid'),
               'name' => $this->request->data('name'),
               'supportEmail' => $this->request->data('support_email'),
               'supportPhone' => $this->request->data('support_phone'),
               'founder' => $this->request->data('founder'),
             ),
             'contentRating' => $this->request->data('content_Rating'),
             'website' => $this->request->data('website'),
             'firstPublishedAt' => $this->request->data('first_published_at'),
             'inAppPurchases' => $this->request->data('in_app_purchases'),
             'overview' => $this->request->data('overview'),
             'premium' => $this->request->data('premium'),
           );


   //
   // "rating": {
   //     "likeCount": 42,
   //     "average": 3.26,
   //     "count": 98
   // }

           // Hardcoding the user_id is temporary, and will be removed later
           // when we build authentication out.
           $game->user_id = $User_user_id;
           $game->title = $this->request->data('title');
           $game->data = json_encode($game_data);
// debug(json_encode($game_data)); exit;
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
