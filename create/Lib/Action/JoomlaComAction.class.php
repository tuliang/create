<?php
class JoomlaComAction extends BaselAction {
    
	public function createCode(){
		if (!empty($_POST)) {
			
			//定义模板地址
			define('TPL_PATH', APP_PATH.'templates/joomlacom/');
			
			$val = $this->cleanPostValue();
			
			$com_name = strtolower($val['com_name']);
			$filename = $com_name.time();
			$ucf_com_name = $this->strtolowerThenUcfirst($com_name);
			//定义模板生成地址
			define('CREATE_PATH', APP_PATH.'result/JoomlaComCode/'.$filename.'/');
			
			$this->createFile(TPL_PATH.'com.xml', array('com_name'=>$com_name), CREATE_PATH, $com_name.'.xml');
			//后台
			$this->createAdmin($com_name, $ucf_com_name, $val);
			//前台
			$this->createSite($com_name, $ucf_com_name, $val);
						
			//ZIP打包
			import("@.ORG.PHPZip");
			$z = new PHPZip(); 
			$z->ZipAndDownload(CREATE_PATH, $filename);
			
			//$this->success('创建成功', '__URL__/index');
		}else{
			$this->error('创建失败', '__URL__/index');
		}
	}
	
	private function createAdmin($com_name, $ucf_com_name, $val){
		
		$this->createFile(TPL_PATH.'com.php', array('com_name'=>$ucf_com_name), CREATE_PATH.'admin/', $com_name.'.php');
		$this->createFile(TPL_PATH.'controller.php', array('com_name'=>$ucf_com_name), CREATE_PATH.'admin/', 'controller.php');
		$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'admin/', 'index.html');
		$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'admin/models/' ,'index.html');
		
		$adminlist = $this->strtokList($val['adminlist']);
			
		foreach ($adminlist as $item){
			$name = strtolower($item);
			$ucf_name = $this->strtolowerThenUcfirst($item);
		
			$this->createFile(TPL_PATH.'models/model.php', array('mod_name'=>$ucf_name, 'com_name'=>$ucf_com_name), CREATE_PATH.'admin/models/', $name.'.php');
			$this->createFile(TPL_PATH.'views/view.php', array('view_name'=>$ucf_name, 'com_name'=>$ucf_com_name), CREATE_PATH.'admin/views/'.$name.'/', 'view.html.php');
			$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'admin/views/'.$name.'/', 'index.html');
			$this->createFile(TPL_PATH.'views/default.php', array(), CREATE_PATH.'admin/views/'.$name.'/tmpl/', 'default.php');
			$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'admin/views/'.$name.'/tmpl/', 'index.html');
		}
	}
	
	private function createSite($com_name, $ucf_com_name, $val){
		
		$this->createFile(TPL_PATH.'com.php', array('com_name'=>$ucf_com_name), CREATE_PATH.'site/', $com_name.'.php');
		$this->createFile(TPL_PATH.'controller.php', array('com_name'=>$ucf_com_name), CREATE_PATH.'site/', 'controller.php');
		$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'site/', 'index.html');
		$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'site/models/' ,'index.html');
			
		$sitelist = $this->strtokList($val['sitelist']);
			
		foreach ($sitelist as $item){
			$name = strtolower($item);
			$ucf_name = $this->strtolowerThenUcfirst($item);
		
			$this->createFile(TPL_PATH.'models/model.php', array('mod_name'=>$ucf_name, 'com_name'=>$ucf_com_name), CREATE_PATH.'site/models/', $name.'.php');
			$this->createFile(TPL_PATH.'views/view.php', array('view_name'=>$ucf_name, 'com_name'=>$ucf_com_name), CREATE_PATH.'site/views/'.$name.'/', 'view.html.php');
			$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'site/views/'.$name.'/', 'index.html');
			$this->createFile(TPL_PATH.'views/default.php', array(), CREATE_PATH.'site/views/'.$name.'/tmpl/', 'default.php');
			$this->createFile(TPL_PATH.'index.html', array(), CREATE_PATH.'site/views/'.$name.'/tmpl/', 'index.html');
			$this->createFile(TPL_PATH.'views/default.xml', array('view_name'=>$ucf_name), CREATE_PATH.'site/views/'.$name.'/tmpl/', 'default.xml');
		}
	}
}