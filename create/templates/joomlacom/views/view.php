<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class {com_name}View{view_name} extends JView{
	
	function display($tpl = null){
		
		$model =& $this->getModel();
		
		parent::display($tpl);
	}
}
