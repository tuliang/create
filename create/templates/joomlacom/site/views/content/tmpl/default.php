<?php
defined('_JEXEC') or die('Restricted access');
if($this->id){
	$db = &JFactory::getDBO();
	$query = 'SELECT `hits` FROM `#__app` WHERE `id`="'.$this->id.'"';
	$db->setQuery($query);
	$result = $db->loadObject();
	//var_dump($hit);exit;
	if($result){
		$hit = $result->hits;
		$hit++;	
	}
	$sql = 'UPDATE `#__app` SET `hits`="'.$hit.'" WHERE `id`="'.$this->id.'"';
	$db->setQuery($sql);
	$db->query();
}
?>
