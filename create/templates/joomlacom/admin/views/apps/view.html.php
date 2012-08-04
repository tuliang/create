<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AppViewApps extends JView{
	
	public function display($tpl = null){		
	
		$model =& $this->getModel();
		
		$this->apps = $model->getApps();	
		$this->pagination = $model->getPagination();	
		$this->listDirn = JRequest::getVar('filter_order_Dir');
			
		parent::display($tpl);
	}
	
}
