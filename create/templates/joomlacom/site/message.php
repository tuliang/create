<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the basecontroller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specificcontroller if requested
if($controller = JRequest::getWord('controller')) {

    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

// Create thecontroller
$classname    = 'AppController'.$controller;
$controller   = new $classname();

// Perform the Requesttask
$controller->execute( JRequest::getWord( 'task' ) );

// Redirect if set bythe controller
$controller->redirect();
?>