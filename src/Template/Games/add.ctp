<!-- File: src/Template/Games/add.ctp -->

<h1>Add Game</h1>
<?php
    echo $this->Form->create($game);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    echo $this->Form->control('package_name', ['type' => 'text']);
    echo $this->Form->control('title', ['type' => 'text']);
    echo $this->Form->control('description', ['type' => 'text']);
    echo $this->Form->control('players', ['type' => 'number']);

    echo $this->Form->control('genres', ['type' => 'text']); // Use select 2

    echo $this->Form->control('package_name', ['type' => 'text']);

    // Releases
    echo $this->Form->control('version_name', ['type' => 'text']);

    // media
    echo $this->Form->control('discover', ['type' => 'text']);
    echo $this->Form->control('video', ['type' => 'text']);
    echo $this->Form->control('screenshots', ['type' => 'text']);

    // Releases


    echo $this->Form->control('data', ['rows' => '5']);
    echo $this->Form->button(__('Save Game'));
    echo $this->Form->end();
?>



<form method="post" action="/games/add">
