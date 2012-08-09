<?php
// no direct access
defined('_JEXEC') or die;

// No access check.

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('{com_name}');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();