<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class AppModelApp extends JModel{
	
	function getItem($id){
		$db=JFactory::getDbo();
		$sql="SELECT * FROM #__app WHERE id=$id";
		$db->setQuery($sql);
		$row=$db->loadObject();
		return $row;
	}
	
	function getComments($id){
		$db=JFactory::getDbo();
		$sql="SELECT * FROM #__comment WHERE appid=$id ORDER BY ID DESC";
		$db->setQuery($sql);
		$rows=$db->loadObjectlist();
		return $rows;		
	}
	function sendComment($post){
		$user=JFactory::getUser();
		$db=JFactory::getDbo();
		$appid=$post['appid'];
		$uid=$user->get('id');
		$content=$post['content'];
		$sql="INSERT INTO #__comment VALUES('','$appid','$uid','$content')";
		$db->setQuery($sql);
		$res=$db->query();
		return $res;			
	}
	
	function getSlide(){
		$id=JRequest::getVar('id');
		$query = "SELECT * FROM `#__app_img` WHERE appID=$id ORDER BY `id` DESC LIMIT 0,20";
		$this->_db->setQuery($query);
		$slide = $this->_db->loadObjectList();
		
		//unset($slide->id);
		//unset($slide->aid);
		//var_dump($slide);exit;
		foreach ($slide as $key=>$item){
			if (!$item->id){
				//unset($slide->$key);
				continue;
			}else {
				$images[$key] = $item->id.'.jpg';
			}
		}
		return $images;
	}
	
	function getScore(){
		$id = &JRequest::getVar('id');
		$db =& JFactory::getDBO();
		$query = 'SELECT * FROM `#__score` WHERE `appID` ='.$id;
		$db->setQuery( $query );
		$scores = $db->loadObjectList();		
		$count = 0;
		$score = 0;
		foreach($scores as $item){
			$score += $item->score;
			$count++;
		}
		if($count != 0 && $score != 0){
			$score = $score / $count;
			$score = round($score, 1);
			$avg = floor($score);
			//var_dump($img);exit;
			$i = 1;
			$j = 1;
			$k = 1;
			while($i<=$avg){
				$img .= '<img src="components/com_app/images/score_light.png" />';
				$i++;
			}
			while($j<=(5-$avg)){
				$img .= '<img src="components/com_app/images/score_dark.png" />';
				$j++;	
			}
			
			//echo $img;exit;
		}else{
			while($k<5){
				$img .= '<img src="components/com_app/images/score_dark.png" />';
				$k++;
			}
		}
		//var_dump($img);exit;
		$html = $img;
		return $html;	

	}
	function Collect($appid){
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$uid = $user->id;
		//var_dump($uid);exit;
		$query = 'SELECT * FROM `#__collection` WHERE `uid`="'.$uid.'" AND `type`= "app" AND `itemid`="'.$appid.'" limit 1';
		$db->setQuery($query);
		$collect = $db->loadObject();
		//var_dump($collect);exit;
		return $collect;	
	}
}
?>