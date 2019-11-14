<!-- File: src/Template/Games/view.ctp -->
<?php debug($game); ?>
<h1><?= $game['title']; ?></h1>

<?php

foreach ($game['media']['screenshots'] as $screenshot) {
    
}



?>

<p><?= $game['description']; ?></p>
<p><small>Created: <?= $game['firstPublishedAt'] ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $game]) ?></p>
