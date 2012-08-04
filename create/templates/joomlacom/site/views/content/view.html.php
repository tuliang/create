<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class AppViewContent extends JView{
	function display( $tpl = null ){	
		//$temp =& Jfactory::getDocument();
//		$temp->addStyleSheet(JURI::base().'components/com_app/css/app.css');
		
		$id=JRequest::getVar('id');
		//var_dump($id);exit;
		$this->assign('id',$id);
		
		$model =& $this->getModel();    
		
		parent::display($tpl);
	}
}

