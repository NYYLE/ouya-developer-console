<?php
// src/Model/Table/GamesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GamesTable extends Table
{
    // public function validationDefault(Validator $validator)
    // {
    //     $validator
    //     ->add('apk', 'file', [
    //         'rule' => ['uploadedFile', ['types' => ['apk']]],
    //         'message' => __("authorized extensions: apk")
    //         ]);
    //
    //         return $validator;
    // }

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}
