<!-- File: src/Template/Users/register.ctp -->
<h1>Register In</h1>
<?php
echo $this->Form->create();
echo $this->Form->control('username');
echo $this->Form->control('email', array('label' => 'Contact Email'));
echo $this->Form->control('password');
echo $this->Form->button('Create Account', array('class' => 'btn btn-secondary', 'type' => 'submit'));
echo $this->Form->end()
?>
