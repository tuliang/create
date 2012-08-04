<?php
defined('_JEXEC') or die('Restricted access');

$app = $this->app;
$name = $app->name;
$editor = & JFactory::getEditor();
$brief = $editor->display( 'brief', $app->brief, '100%', '200', '', '', array());
$introduction = $editor->display( 'introduction', $app->introduction, '100%', '200', '', '', array());
$images=$this->images;
$cat = $this->cat;
$category = $this->category;
//var_dump($category->catID);exit;
?>

<form name="adminForm" method="post" action="#" enctype="multipart/form-data">	
	<div class="width-60 fltlft">		
		<fieldset class="adminform">
		<legend>应用</legend>
		<div class="clr"></div>
			<ul class="adminformlist">
				<li>
					<label title="" class="hasTip required">应用名称<span class="star">&nbsp;*</span></label>	
					<input type="text" size="30" class="inputbox" value="<?php echo $name; ?>" name="name">
					
				</li>
                <li>
					<label title="" class="hasTip required">应用类别<span class="star">&nbsp;*</span></label>	
					<select name="app_cat" class="app_cat">
                    	<?php foreach($cat as $catlist):?>
                        	<?php if($catlist->id == $category->catID ){?>
                        		<option value="<?php echo $catlist->id;?>" selected="selected"><?php echo $catlist->name;?></option>
                            <?php }else{ ?>
                            	<option value="<?php echo $catlist->id;?>"><?php echo $catlist->name;?></option>
                            <?php } ?>
                        <?php endforeach; ?>
					</select>
				</li>				
			</ul>		
			<div class="clr"></div>
			<label>应用列表简介</label>
			<div class="clr"></div>
			<?php echo $brief; ?>
			<div class="clr"></div><br />
			<label>应用详细简介</label>
			<div class="clr"></div>
			<?php echo $introduction; ?>
			<div class="clr"></div>
		</fieldset>	
	</div>	
	<div class="width-40 fltlft">		
		<fieldset>
		<legend>封面</legend>
		<div class="clr"></div>
		<dl>
			<dt>
				<label>上传封面：</label>
			</dt>
			<dd><input type="file" name="photo" /><div class="clr"></div></dd>							
		</dl>
		<br><br>

		</fieldset>
	</div>					
    <input type="hidden" value="app" name="task" />
    <input type="hidden" value="com_app" name="option">

</form>
<?php if($this->id){?>
<div class="width-40 fltlft">		
	<fieldset>
		<legend>幻灯片图片</legend>
            <div class="clr"></div>
        <dl>
			<form method="POST" action="" enctype="multipart/form-data" >
                <dt>
                    <label>上传图片：</label>
                </dt>
                <dd><input type="file" name="slider" /><input type="submit" name="tijiao" value="上传"/><div class="clr"></div></dd>	
			 <input type="hidden" value="upimages" name="task" />
			 <input type="hidden" value="com_app" name="option" />	
			 </form>
        </dl>
		<dl>
			<form method="post" action="" name="display_slide" enctype="multipart/form-data">
				<div class="width-100 fltlft">
					<div class="huandingpiantupian">
						<?php foreach($images as $key=>$imgitem){?>
						<div class="slide_img">
							<img src="../images/apps/detail/<?php echo $imgitem->appID;?>/<?php echo $imgitem->id;?>.jpg" /><br />
							<input type="checkbox" name="slide[]" value="<?php echo $imgitem->id;?>" />
							<?php if($key == '20'){
									break;
							} ?>
						</div>
						<?php }?>
						<div class="clr"></div>
						<input type="submit" name="delete_slide" value="删除" />
					</div>
				</div>
				<input type="hidden" value="deleteSlide" name="task" />
				<input type="hidden" value="com_app" name="option" />
			</form>
		</dl>
    </fieldset>     
</div>


<?php }?>