<!-- File: src/Template/Games/add.ctp -->

<h1>Add Game</h1>
<?php
    echo $this->Form->create($game, array('type' => 'file'));
    // Hard code the user for now.

    echo $this->Form->control('title', array('type' => 'text', 'required' => true));
    echo $this->Form->control('description', array('type' => 'text', 'rows' => 5, 'required' => true));
    echo $this->Form->control('players', array('type' => 'number', 'required' => true));

    echo $this->Form->control('genres', array('type' => 'text', 'required' => true)); // Use select 2

    // media
    echo $this->Form->control('discover', array('type' => 'text', 'required' => true));
    echo $this->Form->control('video', array('type' => 'text', 'required' => false));
    echo $this->Form->control('screenshots', array('type' => 'text', 'required' => true));
    echo $this->Form->file('apk');

  //  echo $this->Form->control('data', [));
    echo $this->Form->button('Add Game', array('class' => 'btn btn-success', 'type' => 'submit'));
    echo $this->Form->end();
?>
