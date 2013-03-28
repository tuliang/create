<?php
class BaselAction extends Action {
	
	//初始化
	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		header('P3P: CP=CAO PSA OUR');
	}
	
    public function index(){
    	
    	$this->display();
    }
    
    public function createCode(){}
    
    /**
     +----------------------------------------------------------
     * 函数用来生成新文件
     +----------------------------------------------------------
     * @param string $tpath 模板路径
     * @param string $val 需要替换的值
     * @param string $outpath 文件输出路径（末尾必须有/）
     * @param string $name 文件名称
     +----------------------------------------------------------
     * @return 无
     +----------------------------------------------------------
     */
    public function createFile($tpath, $val, $outpath, $name){
    	//读取模板
    	$text = file_get_contents($tpath);
    
    	//替换文本
    	foreach ($val as $key=>$item){
    		$text = str_replace('{'.$key.'}', $item, $text);
    	}
    
    	//创建目录
    	mkdir($outpath, 0777, true);
    	//创建文件
    	file_put_contents($outpath.strtolower($name), $text);
    }
    
    /**
     +----------------------------------------------------------
     * 函数将字符串去除空格然后全部小写最后将首字母大写
     +----------------------------------------------------------
     * @param string $str 字符串
     +----------------------------------------------------------
     * @return string 字符串
     +----------------------------------------------------------
     */
    public function strtolowerThenUcfirst($str){
    	return ucfirst(strtolower(str_replace(' ', '', $str)));
    }
    
    /**
     +----------------------------------------------------------
     * 函数将字符串去除空格然后按英文逗号分割
     +----------------------------------------------------------
     * @param string $str 字符串
     +----------------------------------------------------------
     * @return string 字符串
     +----------------------------------------------------------
     */
    public function strtokList($str){
    	return explode(',', str_replace(' ', '', $str));
    }
    
    //清理POST中的无关值
    public function cleanPostValue(){
    
    	unset($_POST['__hash__']);
    
    	return $_POST;
    }
}