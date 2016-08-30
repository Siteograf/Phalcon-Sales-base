<?php

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{

    private $_headerMenu = array(
        'navbar-left' => array(
            'index' => array(
                'caption' => 'Home',
                'action' => 'index'
            ),
            'client' => array(
                'caption' => 'Клиенты',
                'action' => 'index'
            ),
            'sale' => array(
                'caption' => 'Продажи',
                'action' => 'list'
            ),
            'stat' => array(
                'caption' => 'Статистика',
                'action' => 'statPeriod'
            ),
            'contact' => array(
                'caption' => 'Contact',
                'action' => 'index'
            ),
        ),
        'navbar-right' => array(
            'session' => array(
                'caption' => 'Log In/Sign Up',
                'action' => 'index'
            ),
        )
    );

    private $_tabs = array(
        'По годам' => array(
            'controller' => 'stat',
            'action' => 'statYear',
            'any' => false
        ),
        'По месяцам' => array(
            'controller' => 'stat',
            'action' => 'statMonth',
            'any' => false
        ),
        'Период' => array(
            'controller' => 'stat',
            'action' => 'statPeriod',
            'any' => false
        ),
        'Products' => array(
            'controller' => 'products',
            'action' => 'index',
            'any' => true
        ),
        'Product Types' => array(
            'controller' => 'producttypes',
            'action' => 'index',
            'any' => true
        ),
        'Your Profile' => array(
            'controller' => 'invoices',
            'action' => 'profile',
            'any' => false
        )
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['navbar-right']['session'] = array(
                'caption' => 'Log Out',
                'action' => 'end',

            );
        } else {
            unset($this->_headerMenu['navbar-left']['invoices']);
        }

        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) {
//            echo '<div class="nav-collapse">';
            echo '<ul class="nav navbar-nav ', $position, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="nav-item active">';
                } else {
                    echo '<li class="nav-item">';
                }
                echo $this->tag->linkTo([$controller . '/' . $option['action'], $option['caption'], 'class' => 'nav-link']);
                echo '</li>';
            }
            echo '</ul>';
//            echo '</div>';
        }

    }

    /**
     * Returns menu tabs
     */
    public function getTabs()
    {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-tabs">';

        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="nav-item active">';
                $active = 'active';
            } else {
                echo '<li class="nav-item">';
                $active = '';
            }
            echo $this->tag->linkTo([$option['controller'] . '/' . $option['action'], $caption, "class" => "$active nav-link"]), '</li>';
        }

        echo '</ul>';
    }
}
