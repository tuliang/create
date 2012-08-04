<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AppViewCategories extends JView{
	
	function display($tpl = null){	
		$model =& $this->getModel();
		
		$this->list = $model->getList();
		$this->pagination = $model->getPagination();
		$this->listDirn = JRequest::getVar('filter_order_Dir');
     
		parent::display($tpl);
	}
}
