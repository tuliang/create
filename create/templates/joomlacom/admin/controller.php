<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class AppController extends JController{
	
	private $db;
	private $lication;
	private $url;
	
	function __construct($config = array()){
		$this->db =& JFactory::getDBO();
		$this->lication = new JApplication();
		$this->url = 'index.php?option=com_app';
		
		parent::__construct($config);
	}

    function display($tpl = null){
    	
   		switch($this->getTask()){
			case 'category':
   				JRequest::setVar( 'view', 'category' );
   				JRequest::setVar( 'layout', 'default' );
   				break;
			case 'categories':
				JRequest::setVar( 'view', 'categories' );	
				JRequest::setVar( 'layout', 'default' );
				break;
			case 'app':
				JRequest::setVar( 'view', 'app' );	
				JRequest::setVar( 'layout', 'default' );
				break;
			case 'apps':
			default:
				JRequest::setVar( 'view', 'apps' );	
				JRequest::setVar( 'layout', 'default' );		
		}
		$this->addSubmenu($this->getTask());
        parent::display($tpl);
    }
    
    //	排序
    function saveorder(){
    	$order = $_POST['order'];
    	$post_value = $this->cleanPostValue();
    	
    	$count = 0;
    	foreach ($post_value as $item){
    		$query = "UPDATE `#__app` SET `ordering` ='{$order[$count]}' WHERE `id` ='$item' LIMIT 1";
    		$this->query($query);
    		$count++;
    	}
    	$this->lication->redirect($this->url, '成功排序');
    }
     
    //	保存并退出数据页面
    function saveApp(){
    	$this->setApp();
    	$this->lication->redirect($this->url, '成功发布');
    }
    
    //	保存数据
    function applyApp(){
    	 $id = $this->setApp();
    	 $this->lication->redirect("{$this->url}&task=app&id=$id", '成功发布');
    }

    
    //	设置数据
    function setApp(){
    	//	参数
    	$post_value = $this->cleanPostValue();
    	$name = $post_value['name'];
    	$brief = $post_value['brief'];
    	$introduction = $post_value['introduction'];  
		$cat = $post_value['app_cat']; 
		//var_dump($post_value);exit;	    	
    	$id =& JRequest::getInt('id');
    	
    	if ($id > 0){// 修改已有应用的数据
    		$query = "UPDATE `#__app` SET `name` ='$name', `brief` ='$brief', `introduction` ='$introduction'  WHERE `id` ='$id' LIMIT 1";
    		$this->query($query);
			$sql = 'UPDATE `#__app_category` SET `catID` = "'.$cat.'" WHERE `appID` = "'.$id.'" LIMIT 1';
			$this->query($sql);
    	}else{// 新建应用
    		$timestamp = mktime();
    		$query = "INSERT INTO `#__app` (`id` ,`uid` ,`name` ,`state` ,`brief` ,`introduction` ,`timestamp` ,`ordering` ,`hits`"
      				.") VALUES ( NULL , '', '$name', '0', '$brief', '$introduction', '$timestamp', '', '')";
    		$this->query($query);
			$id = $this->db->insertid();
			$sql = 'INSERT INTO `#__app_category` ( `id`, `appID`, `catID` ) VALUES ( NULL, "'.$id.'", "'.$cat.'")';
			$this->query($sql);
    		//	取得输入数据的id
     		
     		//$query="INSERT INTO #__app_img VALUES('','$id','','','','','','','','','','','','','','','','','','','','')";
     		//$this->query($query);
    	}
    	
    	$this->imgUp($id);
    	
    	return $id;
    }
    
    //	图片上传
    private function imgUp($id){
    			
    	$file = $_FILES["photo"];
    	
    	$filename = $file["tmp_name"];
    	$image_size = getimagesize($filename);
     
    	//生成缩略图
    	switch($file["type"]){
    		case 'image/jpeg':
    			$img = imagecreatefromjpeg($filename);
    			break;
    		case 'image/gif':
    			$img = imagecreatefromgif($filename);
    			break;  
    		case 'image/png':
    			$img = imagecreatefrompng($filename);
    			break;
    	}
    			 			
    	$imgWidth = $image_size[0];//获取图片的宽度
    	$imgHeight = $image_size[1];//获取图片的高度  
    			
    	$path = '../images/apps/'.$id.'.png';
    	$this->newImg($img, $imgWidth, $imgHeight, 114, 90, $path);
    }
    
    //	新建图片
    private function newImg($type, $width, $height, $newWidth, $newHeight, $path){
    
    	if($width >= $height){
    		$newHeight = ($newWidth/$width)*$height;
    	}
    	else{
    		$newWidth = ($newHeight/$height)*$width;
    	}
    
    	$newImg = imagecreatetruecolor($newWidth, $newHeight);
    	//生成图片
    	imagecopyresampled($newImg, $type, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    	imagepng($newImg, $path);
    	imagedestroy ($newImg);
    }
    
    //	退出应用数据页面
    function closeApp(){
    	$this->lication->redirect($this->url);
    }
    
    //	状态按钮-开启
   	function publishAppsunpublishpublish(){
   		$this->publishApps();
   	}
   	
   	//	状态按钮-关闭
    function publishAppsunpublishunpublish(){
    	$this->unpublishApps();
    }
    
    //	发布应用
    function publishApps(){
    	$this->setStateApps('1', '成功发布');
    }
    
    //	停止发布应用
    function unpublishApps(){
    	$this->setStateApps('0', '成功停止发布');
    }
    
    //	新建应用
    function newApps(){
    	$this->lication->redirect("{$this->url}&task=app");
    }
    
    //	删除应用
    function deleteApps(){   	
    	$this->setStateApps('-1', '成功删除');
    }
    
    //	退出组件
    function closeApps(){
    	$this->lication->redirect('index.php');
    }
    
    //	设置应用发布状态
    private function setStateApps($state, $message = ''){
    	 
    	//	得到列表
    	$apps = $this->cleanPostValue();
    	
    	foreach ($apps as $app){
    		$query = "UPDATE `#__app` SET `state` ='$state' WHERE `id` ='$app' LIMIT 1";
    		$this->query($query);
    	}
    	 
    	$this->lication->redirect($this->url, $message);
    }
    
    //	清理POST中的无关值
    private function cleanPostValue(){
    	
    	unset($_POST['limit']);
    	unset($_POST['limitstart']);
    	unset($_POST['task']);
    	unset($_POST['option']);
    	unset($_POST['boxchecked']);
    	unset($_POST['toggle']);
    	unset($_POST['order']);
    	unset($_POST['filter_order']);
    	unset($_POST['filter_order_Dir']);
    
    	return $_POST;
    }
    
    //	执行SQL语句
    private function query($query){
    	$this->db->setQuery( $query );
    	$this->db->query();
    }
    
    function upimages(){
		$aid=JRequest::getInt('id');
		$model =& $this->getModel();
		$res=$model->saveimages($aid);
		$app=new JApplication();
		$url="index.php?option=com_app&task=app&id=$aid";
		switch($res){
			case'1':
				$msg='成功上传文件';
				$msgtype="";
				break;
			case'2':
				$msg='您上传的不是图片，请重新上传';
				$msgtype="error";
				break;
			case'3':
				$msg='更新数据库失败，请联系管理员';
				$msgtype="error";
				break;
		}
		$app->redirect($url,$msg,$msgtype);
    }
	
	function deleteSlide(){
		$aid=JRequest::getInt('id');
		//var_dump($aid);exit;
		$slide=$_POST['slide'];	
		
		//var_dump($slide);exit;
		
		$model =& $this->getModel();
		$delete = $model->delete($slide,$aid);
		//var_dump($slide_id);exit;	
		$app=new JApplication();
		$url="index.php?option=com_app&task=app&id=$aid";
		$app->redirect($url);
	}
	function closeCategory(){
    	$this->lication->redirect("{$this->url}&task=categorys");
    }
    
    function closeCategorys(){
    	$this->lication->redirect($this->url);
    }
    
    function deleteCategorys(){
    	
    	//	得到列表
    	$list = $this->cleanPostValue();
    	foreach ($list as $item){
    		$query = "UPDATE `#__appcat` SET `status` ='-1' WHERE `id` =$item LIMIT 1";
    		$this->query($query);
    	}
    	$this->lication->redirect("{$this->url}&task=categorys");
    }
    
    function newCategorys(){
    	$this->lication->redirect("{$this->url}&task=category");
    }
    
    //	保存并退出
    function saveCategory(){
    	$this->setCategory();
    	$this->lication->redirect("{$this->url}&task=categorys", '成功发布');
    }
    
    //	保存
    function applyCategory(){
    	$id = $this->setCategory();
    	$this->lication->redirect("{$this->url}&task=category&id=$id", '成功发布');
    }
    
    
    //	设置数据
    function setCategory(){
    	
    	$name = $_POST['name'];
    	$id =& JRequest::getInt('id');
    	 
    	if ($id > 0){// 修改已有的数据
    		$query = "UPDATE `#__appcat` SET `name` ='$name' WHERE `id` ='$id' LIMIT 1";
    		$this->query($query);
    	}else{// 新建
    		$timestamp = mktime();
    		$query = "INSERT INTO `#__appcat` (`id` , `name` ,`status`"
    		.") VALUES ( NULL , '$name', '1')";
    		$this->query($query);
    		//	取得输入数据的id
    		$id = $this->db->insertid();
    	}
    	 
    	return $id;
    }
    
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('应用列表'),
		                         'index.php?option=com_app&task=apps', $submenu == 'apps');
		JSubMenuHelper::addEntry(JText::_('应用分类'),
		                         'index.php?option=com_app&task=categories',
		                         $submenu == 'categories');
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-helloworld ' .
		                               '{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('应用分类'));
		}
	}
	
}
?>