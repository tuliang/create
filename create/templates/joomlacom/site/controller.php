<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class AppController extends JController{

    function display(){
        parent::display();
    }
    
    function sendComment(){
    	$post=JRequest::get('post');
    	if (!$post['content']){
    		$this->setRedirect('index.php?option=com_app&view=app&id='.$post['appid'].'&Itemid=123', '评论不能为空！');
    	}else{
    		$user=JFactory::getUser();
    		$uid=$user->get('id');
    		if(!$uid){
    			$this->setRedirect('index.php?option=com_app&view=app&id='.$post['appid'].'&Itemid=123','请先登录！');
    		}else{
    			$model=$this->getModel('app');
    			$model->sendComment($post);
    			$this->setRedirect('index.php?option=com_app&view=app&id='.$post['appid'].'&Itemid=123');
    		}
    	}
    }
    
    function more(){
    	$post = JRequest::get('post');
    	$page = $post['page'];
		$sort = $post['sort'];
		$keyword = $post['keyword'];
		$apptype = $post['apptype'];
//     	$count = 1;
    	//$model =& $this->getModel();
    	// Get the model.UsersModelProfile
    	$model = $this->getModel('Apps', 'AppModel');
    	$more = $model->getList($page,$keyword,$sort,$apptype);
    	$collect = $model->Collect();
		$count = 0;
		$collection = array();
		foreach($collect as $list){
			$collection[$count] = $list->itemid;
			$count++;	
		}

    	foreach ($more as $item){
    		$html .= '<div class="app">
	    		<div class="img">
	    			<a href="index.php?option=com_app&view=app&id='.$item->id.'&Itemid=123">
	    			<img src="images/apps/'.$item->id.'.png" /></a>
	    		</div>
	    		<div class="details">
	    			<div class="title">
	    				<a href="index.php?option=com_app&view=app&id='.$item->id.'&Itemid=123">
	    				'.$item->name.'</a>
	    			</div>
	    			<div class="text">'.strip_tags($item->brief).'</div>
	    		</div>
	    		<div itemid="'.$item->id.'" class="favicons favicons'.$item->id.'">';
            if( in_array($item->id, $collection) ){
				$html .= '<a><img src="components/com_app/images/stars.png" /></a>';
			}
			else{
				$html .= '<a><img src="components/com_app/images/favicons.png" /></a>';	
			}
			$html .= '</div><div class="clr"></div></div>';			
    	}

    	echo $html;
    	exit;
    }
	
	function score(){
		$post = JRequest::get('post');
		$user = &JFactory::getUser();
		$uid = $user->id;
    	$score = $post['score'];
		$id = $post['id'];
		$app=new JApplication();
		if(!$uid){
 			$this->setRedirect('index.php?option=com_app&view=app&id='.$id.'&Itemid=123','请先登录！'); 
			exit;  		
    	}
		$db =& JFactory::getDBO();
		$sql = 'DELETE FROM `#__score` WHERE `uid`="'.$uid.'" AND `appID`="'.$id.'"';
		$db->setQuery($sql);
		$db->query();
		
		$query = "INSERT INTO `#__score` (`appID` ,`uid` ,`score`) VALUES ('".$id."', '".$uid."', '".$score."')";
		$db->setQuery($query);
		$db->query();

		exit;
	}			

}
?>