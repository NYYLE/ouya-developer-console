<?php
// src/Controller/GamesController.php

namespace App\Controller;

use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Validation\Validator;

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

    public function admin()
    {
        $game_records = $this->Games->find('all', array(
          'conditions' => array(
            'status' => 0
          ),
        ));

        $games = array();
        foreach ($game_records as $game) {
          $game['game_data'] = json_decode($game['data'], true);
          $games[] = $game;
        }

        //debug($games);
        $this->set('games', $games);
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

          $validator = new Validator();
          $validator
              ->add('apk', 'file', [
                  'rule' => ['uploadedFile', ['types' => ['apk']]],
                  'message' => 'File is not an APK'
              ])
              ->add('discover', 'file', [
                  'rule' => ['uploadedFile', ['types' => ['png']]],
                  'message' => 'Please only upload PNGs'
              ])
              ->add('screenshot', 'file', [
                  'rule' => ['uploadedFile', ['types' => ['png']]],
                  'message' => 'Please only upload PNGs'
              ])
              ->add('video', 'file', [
                  'rule' => ['uploadedFile', ['types' => ['mp4']]],
                  'message' => 'Please only upload MP4s'
              ]);

          $errors = $validator->errors($this->request->data());
          debug($errors);
          if (!empty($errors)) {
              $this->Flash->error(__('Please fix the errors below.'));
              return $this->redirect(['controller' => 'games', 'action' => 'add']);
          }

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
          $md5_sum = md5_file($this->request->data('apk')['tmp_name']);

          $host = 'statics.ouya.world';
          $username = 'dh_q4dnv3';
          $password = 'av^6H2^7';
          $dev_uuid = '635c4cf6-6245-4100-a1a9-121759ad0323';
          $remote_file = '/home/' . $username . '/statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/';

          ini_set('default_socket_timeout', 2);

          $context = stream_context_create(
            array(
              'http' => array(
                'header'=>'Connection: close\r\n',
                'timeout' => .5
              )
            )
          );

          $connection = ssh2_connect($host, 22);
          ssh2_auth_password($connection, $username, $password);

          $sftp = ssh2_sftp($connection);

          if ($sftp != false) {
            debug($this->request->data);

          $result = ssh2_sftp_mkdir($sftp , '/home/' . $username . '/statics.ouya.world/' . $dev_uuid);
          $result2 = ssh2_sftp_mkdir($sftp , '/home/' . $username . '/statics.ouya.world/' . $dev_uuid . '/' . $package_name);

          $stream = fopen("ssh2.sftp://$sftp$remote_file" . $package_name . '_' . $version_name . '.apk', 'w');
          $file = htmlspecialchars(file_get_contents($this->request->data('apk')['tmp_name'],false,$context));
          $write = fwrite($stream, $file);
          fclose($stream);

          $stream = fopen("ssh2.sftp://$sftp$remote_file" . 'discover.png', 'w');
          $file = file_get_contents($this->request->data('discover')['tmp_name']);
          $write = fwrite($stream, $file);
          fclose($stream);

          $screenshots = array();
          if (!empty($this->request->data('screenshot'))) {
              $details = array();
              $index = 1;
             foreach ($this->request->data('screenshot') as $screenshot) {
               $stream = fopen("ssh2.sftp://$sftp$remote_file" . "ss" . $index . '.png', 'w');
               $file = file_get_contents($screenshot['tmp_name']);
               $write = fwrite($stream, $file);
               fclose($stream);

               $stream = fopen("ssh2.sftp://$sftp$remote_file" . "ss" . $index . '-thumb.png', 'w');
               $thumb_file = file_get_contents($screenshot['tmp_name']);
               fwrite($stream, $thumb_file);
               fclose($stream);

               $details[] = array(
                 'type' => 'image',
                 'url' => 'statics.ouya.world/home/' . $username . '/statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'.png',
                 'thumb' => 'statics.ouya.world/home/' . $username . '/statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'-thumb.png',
               );
               $index++;
             }
           // }

            $game_data = array(
              'packageName' => $package_name,
              'title' => $this->request->data('title'),
              'description' => $this->request->data('description'),
              'players' => $this->request->data('players'),
              'genres' => $this->request->data('genres'),
              'releases' => array(
                 'name' => $version_name,
                 'versionCode' => $version_code,
                 'uuid' => $this->request->session()->read('Auth.User.uuid'),
                 'date' => date("Y-m-d")."T".date("H:i:s")."Z",
                 'url' => 'statics.ouya.world/' . $this->request->session()->read('Auth.User.uuid') . '/' . $package_name . '_' . $version_name . '.apk',
                 'size' => filesize($this->request->data('apk')['tmp_name']),
                 'md5sum' => $md5_sum,
                 'publicSize' => 0,
                 'nativeSize' => 0,
               ),
               'media' => array(
                 'discover' => 'statics.ouya.world/' . $this->request->session()->read('Auth.User.uuid') . '/' . $remote_file . 'discover.png',
                 'video' => $this->request->data('video'),
                 'screenshots' => $screenshots,
                 'details' => $details,
               ),
               'developer' => array(
                 'uuid' => $this->request->session()->read('Auth.User.uuid'),
                 'name' => $this->request->session()->read('Auth.User.username'),
                 'supportEmail' => $this->request->session()->read('Auth.User.email'),
                 'supportPhone' => false,
                 'founder' => false,
               ),
               'contentRating' => $this->request->data('content_rating'), //
               'website' => $this->request->data('website'), //
               'firstPublishedAt' => date("Y-m-d")."T".date("H:i:s")."Z",
               'inAppPurchases' => false,
               'overview' => "Released in October 2013 by Alex Tritt Games.", //
               'premium' => false,
               "rating" => array(
                 "likeCount" => 0,
                 "average" => 0,
                 "count" => 0
               )
             );

             $game->user_id = $this->request->session()->read('Auth.User.id');
             $game->title = $this->request->data('title');
             $game->data = json_encode($game_data);

             if ($this->Games->save($game)) {
                 $this->Flash->success(__('Your game has been saved.'));
                 return $this->redirect(['action' => 'index']);
             }
             $this->Flash->error(__('Unable to add your game.'));
           } else {
             $this->Flash->error(__('Unable to upload file.'));
           }
         }
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

    public function approve($id)
    {
       $this->autoRender = false;

        $game = $this->Games->get($id);

        // TODO: SEND GAMEDATA TO API

        $game['status'] = 1;

        if ($this->Games->save($game)) {
            $this->Flash->success(__('The game has been approved.'));
            return $this->redirect(['controller' => 'games', 'action' => 'index']);
        }

        $this->Flash->error(__('Unable to approve the game.'));

        $this->set('game', $game);
    }

    public function reject($id)
    {
        $game = $this->Games->get($id);

        if ($this->request->is(['post', 'put'])) {

          $game['message'] = $this->request->data['message'];
          $game['status'] = 2;

          if ($this->Games->save($game)) {
              $this->Flash->success(__('The game has been rejected.'));
              return $this->redirect(['controller' => 'games', 'action' => 'index']);
          }

          $this->Flash->error(__('Unable to reject the game.'));
        }

        $this->set('game', $game);
    }
}
