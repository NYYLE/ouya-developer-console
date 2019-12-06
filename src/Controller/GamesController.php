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

    public function index($page = 0)
    {
        $http = new Client();

        $response = $http->get('https://dev.dcrich.net/api/v1/gamedata');
        $array = $menuItems = array_slice($response->getJson(), (10 * $page), 10 );
        $games = array();

        foreach ($array as $game) {

          $response = $http->get('http://ouya.dcrich.net:35791/api/v1/gamedata/' . $game['packageName']);
          $games[] = $response->getJson();
        }
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

        $response = $http->get('https://dev.dcrich.net/api/v1/gamedata/' . $package_name);
        $game = $response->getJson();

        $this->set(compact('game'));
    }

    public function add()
    {
       $game = $this->Games->newEntity();

       $this->loadModel('Genres');
       $genres = $this->Genres->find('all');
       $this->set(compact('genres'));

        $session = $this->getRequest()->getSession();
        $this->set('session', $session);

       if ($this->request->is('post')) {
            $display = array(
               'title' => $this->request->data('title'),
               'description' => $this->request->data('description'),
               'players' => $this->request->data('players'),
               'genre' => $this->request->data('genre[]'),
               'content_rating' => $this->request->data('content_rating'),
               'discover' => $this->request->data('discover'),
               'video' => $this->request->data('discover'),
               'screenshot' => $this->request->data('screenshot[]'),
               'apk' => $this->request->data('apk'),
               'website' => $this->request->data('website')
           );

           $session->write('Session_display', $display);

          $validator = new Validator();
          $validator
              ->notEmpty('title', 'Please add a title')
              ->notEmpty('discover', 'Please add a description')
              ->notEmpty('players', 'Please select number of players')
              ->add('apk', [
                'validExtension' => [
                    'rule' => ['extension',['apk']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Please only upload APKs')
                ]
              ])
              ->add('discover', [
                'validExtension' => [
                    'rule' => ['extension',['png']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Please only upload PNGs')
                ]
              ])
              ->add('screenshot[]', [
                'validExtension' => [
                    'rule' => ['extension',['png']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Please only upload PNGs')
                ]
              ])
              ->add('video', [
                'validExtension' => [
                    'rule' => ['extension',['mp4']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Please only upload MP4s')
                ]
              ])
              ->allowEmptyFile('video')
              ->notEmpty('genre[]', 'Please enter at least one genre');

          $errors = $validator->errors($this->request->data());
          if (!empty($errors)) {
              $session->write('Session_errors', $errors);
              $this->Flash->error(__('Please fix the errors below.'));
              return $this->redirect(['controller' => 'games', 'action' => 'add']);
          }

          $apk = new \ApkParser\Parser($this->request->data('apk')['tmp_name']);

          $manifest = $apk->getManifest();
          $permissions = $manifest->getPermissions();

          $package_name = $manifest->getPackageName();

          $package_name = 'COM.TEST.OWD';

          $version_name = $manifest->getVersionName();
          $version_code = $manifest->getVersionCode();
          $min_sdk_level = $manifest->getMinSdkLevel();
          $min_sdk_platform = $manifest->getMinSdk()->platform;
          $target_sdk_level = $manifest->getTargetSdkLevel();
          $target_sdk_platform = $manifest->getTargetSdk()->platform;
          $md5_sum = md5_file($this->request->data('apk')['tmp_name']);

          if ($package_name == null || $version_name == null || $version_code == null || $min_sdk_level == null || $min_sdk_platform == null) {
            $this->Flash->success(__('Please make sure APK has valid attributes'));
            return $this->redirect(['action' => 'add']);
          }

          $host = 'statics.ouya.world';
          $username = 'dh_q4dnv3';
          $password = 'av^6H2^7';
          $dev_uuid = $this->request->session()->read('Auth.User.uuid');
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

          $result = ssh2_sftp_mkdir($sftp , '/home/' . $username . '/statics.ouya.world/' . $dev_uuid);
          $result2 = ssh2_sftp_mkdir($sftp , '/home/' . $username . '/statics.ouya.world/' . $dev_uuid . '/' . $package_name);

          $stream = fopen("ssh2.sftp://$sftp$remote_file" . $package_name . '-' . $version_name . '.apk', 'w');
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
               if ($screenshot['error'] == 0) {
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
                     'url' => 'https://statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'.png',
                     'thumb' => 'https://statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'-thumb.png',
                   );
                   $index++;
                }
             }

           if (!empty($this->request->data('video')) && $this->request->data('video')['error'] == 0) {
             $stream = fopen("ssh2.sftp://$sftp$remote_file" . "ss" . $index . '.png', 'w');
             $file = file_get_contents($screenshot['tmp_name']);
             $write = fwrite($stream, $file);
             fclose($stream);

             $details[] = array(
               'type' => 'video',
               'url' => 'https://statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'.png',
             );
           }

            $game_data = array(
              'packageName' => $package_name,
              'title' => $this->request->data('title'),
              'description' => $this->request->data('description'),
              'players' =>  array($this->request->data('players')),
              'genres' => $this->request->data('genre'),
              'releases' => array([
                 'name' => $version_name,
                 'versionCode' => $version_code,
                 'uuid' => $this->request->session()->read('Auth.User.uuid'),
                 'date' => date("Y-m-d")."T".date("H:i:s")."Z",
                 'url' => 'https://statics.ouya.world/' . $this->request->session()->read('Auth.User.uuid') . '/' . $package_name . '/' . $package_name . '-' . $version_name . '.apk',
                 'size' => filesize($this->request->data('apk')['tmp_name']),
                 'md5sum' => $md5_sum,
                 'publicSize' => 0,
                 'nativeSize' => 0,
               ]),
               'media' => $details,
               'discover' => 'https://statics.ouya.world/' . $this->request->session()->read('Auth.User.uuid') . '/' . $package_name . '/' . 'discover.png',
               'developer' => array(
                 'uuid' => $this->request->session()->read('Auth.User.uuid'),
                 'name' => $this->request->session()->read('Auth.User.username'),
                 'supportEmail' => $this->request->session()->read('Auth.User.email'),
                 'supportPhone' => null,

               ),
               'contentRating' => $this->request->data('content_rating'),
               'website' => $this->request->data('website'),
               'firstPublishedAt' => date("Y-m-d")."T".date("H:i:s")."Z",

               'overview' => "Released in " . date('F Y') . " by " . $this->request->session()->read('Auth.User.username') .  ".",

               "rating" => array(
                 "likeCount" => 0,
                 "average" => 0,
                 "count" => 0
               )
             );

             debug(json_encode($game_data)); exit;

             $game->user_id = $this->request->session()->read('Auth.User.id');
             $game->title = $this->request->data('title');
             $game->data = json_encode($game_data);

             $http = new Client();
             $response = $http->post('https://dev.dcrich.net/api/v1/gamedata', [
              'title' => 'test',
              'body' => $game_data
            ]);

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

    public function edit($package_name)
    {
        $http = new Client();

        $this->loadModel('Genres');
        $genres = $this->Genres->find('all');
        $this->set(compact('genres'));

         $session = $this->getRequest()->getSession();
         $this->set('session', $session);

         $package_name = 'COM.TEST.ODC';

        $response = $http->get('https://dev.dcrich.net/api/v1/gamedata/' . $package_name);
        $game = $response->getJson();

        if ($this->request->is('post')) {
          $display = array(
             'title' => $this->request->data('title'),
             'description' => $this->request->data('description'),
             'players' => $this->request->data('players'),
             'genre' => $this->request->data('genre[]'),
             'content_rating' => $this->request->data('content_rating'),
             'discover' => $this->request->data('discover'),
             'video' => $this->request->data('discover'),
             'screenshot' => $this->request->data('screenshot[]'),
             'apk' => $this->request->data('apk'),
             'website' => $this->request->data('website')
         );

         $session->write('Session_display', $display);

          $changes = array();
          foreach ($this->request->data() as $field => $change) {
            switch ($field) {
              case 'screenshot[]':
                $index = 1;
                foreach ($change as $screenshot) {
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
                    'url' => 'https://statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'.png',
                    'thumb' => 'https://statics.ouya.world/' . $dev_uuid . '/' . $package_name . '/' . 'ss' . $index .'-thumb.png',
                  );

                  $index++;
                }
                $changes[$field] = $change;
                break;
              case 'apk':
                $changes[$field] = $change;
                break;
              case 'discover':
                $changes[$field] = $change;
                break;
              default:
                $changes[$field] = $change;
                break;
            }

          }

          $response = $http->patch('https://dev.dcrich.net/api/v1/gamedata/' . $package_name, [
           'title' => 'test',
           'body' => json_encode($changes)
          ]);
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
