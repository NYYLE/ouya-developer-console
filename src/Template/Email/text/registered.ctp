<p>Hello  <?php echo $username ?></p>
<p>
Welcome to the OUYA World Dev Portal, to complete your account registration, please click the link below.<br>
<br>
<?php
echo $this->Html->link('Verify Email', array('controller' => 'users', 'action' => 'verification', $token), array('class' => 'nav-link'));
 ?>
</p>
<p>

</p>
