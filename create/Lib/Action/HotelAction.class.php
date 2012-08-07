<?php
class HotelAction extends BaselAction {
    
	public function createCode(){
		
		if (!empty($_POST)) {
			//拿到POST值 
			$post = $this->cleanPostValue();
			//将名称转为小写并且将单词用下划线连接
			$post['hotel_name'] = str_replace(' ', '_', strtolower($post['hotel_name']));
			//定义模板地址
			define('TPL_PATH', APP_PATH.'templates/hotel/');
			//定义模板生成地址
			define('CREATE_PATH', APP_PATH.'result/HotelCode/'.$post['hotel_name'].'/');
			
			$this->createFile(TPL_PATH.'index.html', $post, CREATE_PATH, 'index.html');
			$this->createFile(TPL_PATH.'index.html', $post, CREATE_PATH, $post['hotel_name'].'.txt');
			 
			//创建其他文件
			mkdir(CREATE_PATH.'css/', 0777, true);
			file_put_contents(CREATE_PATH.'css/style.css', file_get_contents(TPL_PATH.'css/style.css'));
		
			mkdir(CREATE_PATH.'images/', 0777, true);
			file_put_contents(CREATE_PATH.'images/left_button.png', file_get_contents(TPL_PATH.'images/left_button.png'));
			file_put_contents(CREATE_PATH.'images/right_button.png', file_get_contents(TPL_PATH.'images/right_button.png'));
			$this->upload();//上传图片
			 
			$this->success('创建成功', '__URL__/index');
		}else{
			$this->error('创建失败', '__URL__/index');
		}
	}
	
	//上传图片
	private function upload() {
	
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
		}else{
			$this->error('创建失败', '__URL__/index');
		}
	} 
}