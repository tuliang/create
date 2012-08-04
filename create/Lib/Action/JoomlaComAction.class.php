<?php
class JoomlaComAction extends BaselAction {
    
	public function createCode(){
		
		//定义模板地址
		define('TPL_PATH', APP_PATH.'templates/joomlacom/');
		
		$val = array('com_name'=>'Test', 'author'=>'涂亮', 'mod_name'=>'List, Detail');
		
		$com_name = strtolower($val['com_name']);
		//定义模板生成地址
		define('CREATE_PATH', APP_PATH.'result/JoomlaComCode/'.$com_name.'/');
		
		$this->createFile(TPL_PATH.'tpl.xml', $val, CREATE_PATH, $com_name.'.xml');
		
		$mods = $this->strtokList($val['mod_name']);
		
		foreach ($mods as $item){
			$this->createFile(TPL_PATH.'admin/models/tpl.php', array('mod_name'=>$item, 'com_name'=>$com_name), CREATE_PATH.'admin/models/', $item.'.php');
		}	
	}
}