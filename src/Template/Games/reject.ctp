<!-- File: src/Template/Games/reject.ctp -->

<h1>Reject <?php echo $game['game_data']['title'] ;?></h1>
<?php
    echo $this->Form->create($game);

    echo $this->Form->control('message', array('label' => 'Rejection Reason','type' => 'text', 'required' => true));

    echo $this->Form->button('Reject Game', array('class' => 'btn btn-danger', 'type' => 'submit'));
    echo $this->Form->end();
?>
