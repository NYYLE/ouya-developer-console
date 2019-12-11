<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'DEVS.OUYA.WORLD';

echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
echo $this->Html->script([
    'https://code.jquery.com/jquery-1.12.4.min.js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
]);
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<link href="webroot/js/select2.min.css" rel="stylesheet" />
<script src="webroot/js/select2.min.js"></script>

<style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .top-bar {
      margin-bottom: 50px;
      border-radius: 5;
      background-color: #000000;
    }

    /* Remove the jumbotron's default bottom margin */
     .jumbotron {
      margin-bottom: 0;
    }

    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    body {
      background: linear-gradient(70deg, #e6e6e6, #f7f7f7);
      color: #514B64;
      min-height: 100vh;
    }

    code {
      background: #fff;
      padding: 0.2rem;
      border-radius: 0.2rem;
      margin: 0 0.3rem;
    }

    .select2-container .select2-selection--multiple {
      height: auto!important;
      margin: 0;
      padding: 0;
      line-height:inherit;
      border-radius:0;
    }

    .select2-container .select2-search--inline .select2-search__field {
      margin:0;
      padding:0;
      min-height:0;
    }

    .select2-container .select2-search--inline {
      line-height:inherit;
    }

    .genre-input-label {
      margin: 0 0 1rem 0;
    }

    .error-label {
      color: #b91f1f !important;
      margin: 0 0 1rem 0;
      font-weight: bold;
    }
  </style>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta(
          'favicon.ico',
          '/favicon.ico',
          ['type' => 'icon']
); ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?php echo $this->Html->script('jquery'); ?>
</head>
<body style="background-color: LightGray;">
  <!-- NAVBAR-->
<nav class="navbar navbar-expand-md py-3 navbar-dark bg-dark shadow-sm">
<div class="container">
  <a href="#" class="navbar-brand">
    <?php echo $this->Html->image('logo.png', ['alt' => 'OUYA WORLD', 'class' => 'd-inline-block align-middle mr-2', 'width' => 400, 'url' => ['controller' => 'games', 'action' => 'index']]); ?>
  </a>

  <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>

  <div id="navbarSupportedContent" class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"> <?php
      echo $this->Html->link('Games', array('controller' => 'games', 'action' => 'index'), array('class' => 'nav-link'));
      ?> </li>
      <li class="nav-item"> <?php
      echo $this->Html->link('Add', array('controller' => 'games', 'action' => 'add'), array('class' => 'nav-link'));
      ?> </li>
      <?php
      if (!empty($User_admin) && $User_admin == '1') {
        ?> <li class="nav-item"> <?php
        echo $this->Html->link('Admin Panel', array('controller' => 'games', 'action' => 'admin'), array('class' => 'nav-link'));
        ?> </li> <?php
      }
      if (!empty($User_username)) {
        ?> <li class="nav-item"> <?php
        echo $this->Html->link($User_username, array('controller' => 'users', 'action' => 'games'), array('class' => 'nav-link'));
        ?> </li> <?php
        ?> <li class="nav-item"> <?php
        echo $this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout'), array('class' => 'nav-link'));
        ?> </li> <?php
      } else {
        ?> <li class="nav-item"> <?php
        echo $this->Html->link('Log In', array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link'));
        ?> </li> <?php
      }

      ?>
    </ul>
  </div>
</div>
</nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
