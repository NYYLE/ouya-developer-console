<!-- File: src/Template/Games/edit.ctp -->

<h1>Edit Game</h1>
<?php
    echo $this->Form->create($game);
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    echo $this->Form->control('title');
    echo $this->Form->control('data', ['rows' => '5']);
    echo $this->Form->button(__('Save Game'));
    echo $this->Form->end();
?>
