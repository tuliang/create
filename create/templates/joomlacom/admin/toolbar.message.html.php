<?php
/*
 * 组件工具条类
 */
defined('_JEXEC') or die('Restricted access');

class TOOLBAR_App{
	function _CATEGORY(){
		JToolBarHelper::title(JText::_('分类管理'), 'user.png');
		JToolBarHelper::save('saveCategory');
		JToolBarHelper::apply('applyCategory');
		JToolBarHelper::cancel('closeCategory', 'Close');
	}

	function _CATEGORYS(){
		JToolBarHelper::title(JText::_('分类列表'), 'user.png');
		JToolBarHelper::addNewX('newCategorys');
		JToolBarHelper::deleteList('', 'deleteCategorys');
		JToolBarHelper::cancel('closeCategorys', 'Close');
	}
	function _APP(){
		JToolBarHelper::title(JText::_('应用管理'), 'user.png');
		JToolBarHelper::save('saveApp');
		JToolBarHelper::apply('applyApp');
		JToolBarHelper::cancel('closeApp', 'Close');
	}
	
	function _APPS(){
		JToolBarHelper::title(JText::_('应用列表'), 'user.png');
		JToolBarHelper::publishList('publishApps');
		JToolBarHelper::unpublishList('unpublishApps');
		JToolBarHelper::addNewX('newApps');
		JToolBarHelper::deleteList('', 'deleteApps');
		JToolBarHelper::cancel('closeApps', 'Close');
	}
}
?>