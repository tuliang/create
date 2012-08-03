<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
    	//定义模板地址
    	define('TPL_PATH', './create/Tpl/hotel/');
    	//读取模板
    	$text = file_get_contents(TPL_PATH.'index.html');
    	
    	preg_match_all('^\{*\}', $text, $newtext);
    	dump($newtext);
    	exit;
    	
    	//定义模板生成地址
    	define('CREATE_PATH', './result/'.time().'/');
    	//创建目录
    	mkdir(CREATE_PATH, 0777, true);
    	//创建文件
    	file_put_contents(CREATE_PATH.'index.html', $text);
        
    }
}