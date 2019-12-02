<?php
// src/Model/Table/GamesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GamesTable extends Table
{
    // public function validationDefault(Validator $validator)
    // {
    //   $validator
    //       ->add('apk', 'file', [
    //           'rule' => ['uploadedFile', ['extension' => ['apk']]],
    //           'message' => 'File is not an APK'
    //       ])
    //       ->add('discover', 'file', [
    //           'rule' => ['uploadedFile', ['extension' => ['png']]],
    //           'message' => 'Please only upload PNGs'
    //       ])
    //       ->add('screenshot[]', 'file', [
    //           'rule' => ['uploadedFile', ['extension' => ['png']]],
    //           'message' => 'Please only upload PNGs'
    //       ])
    //       ->add('video', 'file', [
    //           'rule' => ['uploadedFile', ['extension' => ['mp4']]],
    //           'message' => 'Please only upload MP4s'
    //       ])
    //       ->allowEmptyFile('video')
    //       ->notEmpty('genre[]', 'Please enter at least one genre');
    //
    //         return $validator;
    // }

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}
