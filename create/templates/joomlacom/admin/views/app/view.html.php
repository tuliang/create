<?php
/*
 * 应用视图类
*/
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class APPViewApp extends JView{
	
	function display($tpl = null){
		$temp =& Jfactory::getDocument();
		$temp->addStyleSheet(JURI::base().'components/com_app/css/app.css');
		$model =& $this->getModel();
		$id=JRequest::getVar('id');	
		$this->assignRef('id' , $id); 
		
		$app = $model->getApp();
		$this->assignRef('app' , $app);
        
		$images=$model->yishangchuantupian();
		$this->assignRef('images' , $images);
		
		$cat=$model->getAppCat();
		$this->assignRef('cat' , $cat);
		
		$category=$model->getCategory($id);
		$this->assignRef('category' , $category);
		
		parent::display($tpl);
	}
}
