<?php
// src/Model/Table/GamesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class GamesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}