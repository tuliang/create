<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class AppModelApps extends JModel{
	
	function getList($page = 0,$keyword = '搜索应用',$sort,$apptype){
		//$params = JFactory::getApplication()->getParams();
		if(!$sort){
			$sort = "newest";	
		}
		$page_count = 7;// $params->get('page_count');//exit;
		
		$begin = $page * $page_count;//exit;
		
		if($keyword == '搜索应用'){
			$where_keyword = "";
		}
		else{
			$keyword = $this->_db->Quote("%".$keyword."%");
			$where_keyword = "AND (name like $keyword OR brief like $keyword OR introduction like $keyword)";		
		}
		
		if(!$sort){
			$where_sort = "";	
		}
		if($sort == 'newest'){
			$where_sort = "ORDER BY `id` DESC";	
		}
		if($sort == 'hotest'){
			$where_sort = "ORDER BY `hits` DESC";	
		}
		
		//var_dump($id_app);exit;
		if(!$apptype){
			$where_apptype = "";	
		}
		else{
			$query = 'SELECT * FROM `#__app_category` WHERE `catID`="'.$apptype.'"';
			$this->_db->setQuery($query);
			$result = $this->_db->loadObjectList();
			$count = 0;
			foreach($result as $resultitem){
				$appid[$count] = $resultitem->appID;
				$count++;	
			}
			$id_app = implode(",",$appid);
			$where_apptype = "AND `id` IN ($id_app)";	
		}

		
		
		$sql = "SELECT * FROM #__app WHERE state=1 $where_keyword $where_apptype $where_sort LIMIT $begin, $page_count";
		$this->_db->setQuery($sql);
		$rows = $this->_db->loadObjectList();
		
		foreach ($rows as $row){
			if(mb_strlen($row->brief)>30){
				$row->brief = mb_substr($row->brief, 0,28, 'utf-8').'...';
			}			
		}
		return $rows;
	}
	
	function getAppCat(){
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM `#__appcat` WHERE `status`=1';
		$db->setQuery($query);
		$cat = $db->loadObjectList();
		return $cat;	
	}
	
	function Collect(){
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$uid = $user->id;
		//var_dump($uid);exit;
		$query = 'SELECT * FROM `#__collection` WHERE `uid`="'.$uid.'" AND `type`= "app"';
		$db->setQuery($query);
		$collect = $db->loadObjectList();
		
		return $collect;	
	}
}
?>