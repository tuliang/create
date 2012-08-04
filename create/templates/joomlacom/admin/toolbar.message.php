<?php
/*
 * 组件工具条控制类
 */
defined('_JEXEC') or die('Restricted access');

require_once(JApplicationHelper::getPath('toolbar_html'));

switch ($task){
	case 'category':
		TOOLBAR_App::_CATEGORY();
		break;
	case 'categories':
		TOOLBAR_App::_CATEGORYS();
		break;
	case 'app':
		TOOLBAR_App::_APP();
		break;	
	case 'apps':
	default:
		TOOLBAR_App::_APPS();
}
?>