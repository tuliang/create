<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	
	//初始化
	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		header('P3P: CP=CAO PSA OUR');
	}
	
    public function index(){
    	
    	$this->display();
    }
    
    public function createHotelCode(){
    	
    	if (!empty($_POST)) {
    		 
    		$post = $this->cleanPostValue();
    		//定义模板地址
    		define('TPL_PATH', './create/Tpl/hotel/');
    		//读取模板
    		$text = file_get_contents(TPL_PATH.'index.html');
    		
    		//替换文本
    		foreach ($post as $key=>$item){
    			$text = str_replace('{'.$key.'}', $item, $text);
    		}
    		
    		//定义模板生成地址
    		define('CREATE_PATH', './result/'.$post['hotel_name'].'/');
    		
    		//创建目录
    		mkdir(CREATE_PATH, 0777, true);
    		//创建文件
    		file_put_contents(CREATE_PATH.'index.html', $text);
    		file_put_contents(CREATE_PATH.$post['hotel_name'].'txt', $text);
    		 
    		//创建其他文件
    		mkdir(CREATE_PATH.'css/', 0777, true);
    		file_put_contents(CREATE_PATH.'css/style.css', file_get_contents(TPL_PATH.'css/style.css'));  

    		mkdir(CREATE_PATH.'images/', 0777, true);
    		file_put_contents(CREATE_PATH.'images/left_button.png', file_get_contents(TPL_PATH.'images/left_button.png'));
    		file_put_contents(CREATE_PATH.'images/right_button.png', file_get_contents(TPL_PATH.'images/right_button.png'));
    		//$this->upload();//上传图片   			
    		 
    		$this->success('创建成功', '__URL__/index');
    	}else{
    		$this->error('创建失败', '__URL__/index');
    	}  	
    }
    
    //清理POST中的无关值
    private function cleanPostValue(){
    	 
    	unset($_POST['__hash__']);
    
    	return $_POST;
    }
    
    //上传图片
    public function upload() {
    	 
    	if (!empty($_POST)) {
    
    		import("@.ORG.UploadFile");
    		$upload = new UploadFile('', 'jpg,gif,png,jpeg', '', CREATE_PATH.'images/', 'picture');
    		//开启缩略图功能
    		$upload->thumb = true;
    		//缩略图前缀
    		$upload->thumbPrefix = '';
    		//缩略图大小
    		$upload->thumbMaxWidth = '185';
    		$upload->thumbMaxHeight = '220';
    
    		if (!$upload->upload()) {
    			$this->error($upload->getErrorMsg());
    		} 
    		
    		//return $this->getUploadFileInfo();
    	}
    }
    
    //删除图片
//     public function unlink() {
//     	sae_unlink('./Public/upload/' . $_GET['filename']);
//     	$this->success('删除成功');
//     }
}