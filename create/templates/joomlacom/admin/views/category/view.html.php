<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AppViewCategory extends JView{
	
	function display($tpl = null){	
		$model =& $this->getModel();
		
		$this->detail = $model->getDetail();
        
		parent::display($tpl);
	}
}
