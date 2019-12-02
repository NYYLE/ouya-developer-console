<!-- File: src/Template/Users/login.ctp -->
<h1>Log In</h1>
<?php
echo $this->Form->create();
echo $this->Form->control('username');
echo $this->Form->control('password');
echo $this->Form->button('Log In', array('class' => 'btn btn-secondary', 'type' => 'submit'));
echo $this->Html->link('Create Account', array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-secondary'));
echo $this->Form->end()
?>
