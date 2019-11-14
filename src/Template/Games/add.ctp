<!-- File: src/Template/Games/add.ctp -->

<h1>Add Game</h1>
<?php
    echo $this->Form->create($game);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('title');
    echo $this->Form->control('data', ['rows' => '5']);
    echo $this->Form->button(__('Save Game'));
    echo $this->Form->end();
?>

<form method="post" action="/games/add">
