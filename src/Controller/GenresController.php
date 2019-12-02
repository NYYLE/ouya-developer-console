<?php
// src/Controller/GenresController.php

namespace App\Controller;

use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Validation\Validator;

class GenresController extends AppController
{
    public function index()
    {
      $genres = $this->Genres->find('all');
      $this->set(compact('genres'));
    }

    public function add()
    {
      $genre = $this->Genre->newEntity();

      if ($this->request->is('post')) {


      }
    }
}
