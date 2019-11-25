<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

     public $helpers = [
            'Form' => [
                'className' => 'Bootstrap.Form'
            ],
            'Html' => [
                'className' => 'Bootstrap.Html'
            ],
            'Modal' => [
                'className' => 'Bootstrap.Modal'
            ],
            'Navbar' => [
                'className' => 'Bootstrap.Navbar'
            ],
            'Paginator' => [
                'className' => 'Bootstrap.Paginator'
            ],
            'Panel' => [
                'className' => 'Bootstrap.Panel'
            ]
    ];

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Games',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Games',
                'action' => 'index',
            ]
        ]);
    }

    public function beforeRender(Event $event) {
      $this->set('User_username', $this->request->session()->read('Auth.User.username'));
    //  $this->set('User_user_id', $this->request->session()->read('Auth.User.id'));
      $this->set('User_admin', $this->request->session()->read('Auth.User.admin'));
    }
}
