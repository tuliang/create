<?php
class IndexAction extends Action {
	
	//初始化
	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		header('P3P: CP=CAO PSA OUR');
	}
	
    public function index(){
    	
    	$this->display();
    }
}