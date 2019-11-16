<!-- File: src/Template/Games/index.ctp -->

<h1>Games</h1>
<p><?= $this->Html->link("Add Game", ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

<!-- Here's where we iterate through our $games query object, printing out article info -->

<?php foreach ($games as $game):?>
    <tr>
        <td>
            <?= $this->Html->link($game['title'], ['action' => 'view', 'com.ATG.DU']) ?>
        </td>
        <td>
            <?= $game['firstPublishedAt'] ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $game['packageName']]) ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>
