<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class AppViewApps extends JView{
	function display( $tpl = null ){	
		$temp =& Jfactory::getDocument();
		$temp->addStyleSheet(JURI::base().'components/com_app/css/apps.css');
		
		$model =& $this->getModel(); 
		
		$sort = &JRequest::getVar('sort');
		$this->assign('sort',$sort);
		$apptype = &JRequest::getVar('apptype');
		$this->assign('apptype',$apptype);
		  
		$keyword =&JRequest::getVar('keyword','搜索应用');
		$this->assign('keyword',$keyword);
		//var_dump($keyword);exit;
		$rows = $model->getList('0',$keyword,$sort,$apptype);
		$this->assign('rows',$rows);
		
		$cat = $model->getAppCat();
		$this->assignRef('cat', $cat);
		
		$collect = $model->Collect();
		$this->assignRef('collect', $collect);
		
		parent::display($tpl);
	}
}