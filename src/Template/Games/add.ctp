<!-- File: src/Template/Games/add.ctp -->

<h1>Add Game</h1>
<?php
    echo $this->Form->create($game, array('type' => 'file'));
    // Hard code the user for now.

    echo $this->Form->control('title', array('type' => 'text', 'required' => true));
    echo $this->Form->control('description', array('type' => 'text', 'rows' => 5, 'required' => true));
    echo $this->Form->control('players', array('type' => 'number', 'required' => true));

    echo $this->Form->control('genres', array('type' => 'text', 'required' => true)); // Use select 2
    echo $this->Form->control('content_rating', array('type' => 'text', 'required' => true)); // Use select 2

    // media
    echo $this->Form->input('discover', array('label' => 'Discover Image', 'type' => 'file', 'required' => true));
    echo $this->Form->input('video', array('label' => 'Video', 'type' => 'file', 'required' => false));
    echo $this->Form->input('screenshot[]', array('label' => 'Screenshots', 'type' => 'file', 'multiple' => 'multiple', 'required' => true));
    echo $this->Form->input('apk', array('label' => 'APK File', 'type' => 'file', 'required' => true));
    echo $this->Form->control('website', array('type' => 'number', 'required' => false));

  //  echo $this->Form->control('data', [));
    echo $this->Form->button('Add Game', array('class' => 'btn btn-success', 'type' => 'submit'));
    echo $this->Form->end();
?>
