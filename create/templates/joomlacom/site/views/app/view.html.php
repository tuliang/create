<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class AppViewApp extends JView{
	function display( $tpl = null ){	
		$temp =& Jfactory::getDocument();
		$temp->addStyleSheet(JURI::base().'components/com_app/css/app.css');
		$id=JRequest::getVar('id');
		$model =& $this->getModel();    
		$row=$model->getItem($id);   
		$comments=$model->getComments($id);
		foreach ($comments as $comment){
			$user=JFactory::getUser($comment->uid);
			$comment->userName=$user->get('name');
		}
		$this->assign('comments',$comments);
		$this->assign('row',$row);
		
		$slide = $model->getSlide();
		$this->assign('slide', $slide);
		
		$score = $model->getScore();
		$this->assignRef('score', $score);
		
		$appid = JRequest::getVar('id');
		
		$collect = $model->Collect($appid);
		$this->assignRef('collect', $collect);
		
		parent::display($tpl);
	}
}

