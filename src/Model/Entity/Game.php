<?php
// src/Model/Entity/Game.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Game extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
    ];

    public $validate = array(
      'screenshots' => array(
              'extension' => array(
                  //'rule' => array('extension', array('jpeg', 'jpg', 'gif', 'png')),
                  'rule' => array('isValidExtension', array('png'), false),
                  'message' => 'You must supply a GIF, PNG, or JPG file.',
                  'allowEmpty' => true,
                  'required' => false,
                  //'on' => 'create'
              ),
          ),
          'discover' => array(
                  'extension' => array(
                      //'rule' => array('extension', array('jpeg', 'jpg', 'gif', 'png')),
                      'rule' => array('isValidExtension', array('png'), false),
                      'message' => 'You must supply a GIF, PNG, or JPG file.',
                      'allowEmpty' => true,
                      'required' => false,
                      //'on' => 'create'
                  ),
              ),
              'apk' => array(
                      'extension' => array(
                          //'rule' => array('extension', array('jpeg', 'jpg', 'gif', 'png')),
                          'rule' => array('isValidExtension', array('apk'), false),
                          'message' => 'You must supply a GIF, PNG, or JPG file.',
                          'allowEmpty' => true,
                          'required' => false,
                          //'on' => 'create'
                      ),
                  ),
    );

}
