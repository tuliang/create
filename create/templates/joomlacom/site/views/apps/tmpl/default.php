<?php
defined('_JEXEC') or die('Restricted access');
//var_dump($this->keyword);exit;
$collect = $this->collect;
$count = 0;
$collection = array();
foreach($collect as $list){
	$collection[$count] = $list->itemid;
	$count++;	
}
?>
<script>
jQuery(function(){
	function scrollBar(){
		jQuery(".apps").jscroll({ W:"12px"//设置滚动条宽度
			,BgUrl:""//设置滚动条背景图片地址
			,Bg:"#7a004e"//设置滚动条背景图片position,颜色等
			,Bar:{  Pos:"up"//设置滚动条初始化位置在底部
					,Bd:{Out:"#000",Hover:"red"}//设置滚动滚轴边框颜色：鼠标离开(默认)，经过
					,Bg:{Out:"#ea1b9f",Hover:"#fff",Focus:"orange"}}//设置滚动条滚轴背景：鼠标离开(默认)，经过，点击
			,Btn:{  btn:true//是否显示上下按钮 false为不显示
					,uBg:{Out:"#a02a77",Hover:"#fff",Focus:"orange"}//设置上按钮背景：鼠标离开(默认)，经过，点击
					,dBg:{Out:"#ea1b9f",Hover:"#fff",Focus:"orange"}}//设置下按钮背景：鼠标离开(默认)，经过，点击
			,Fn:function(){}//滚动时候触发的方法
			});
			
	}
	scrollBar();

	
	jQuery("#more").click(function(){
		//jQuery("#more a").html();
		var pageVal = parseInt(jQuery("#page").val());
		var sortVal = jQuery("#sort").val();
		var apptypeVal = jQuery("#apptype").val();
		var keywordVal = jQuery("#keyword").val();
		jQuery.post("index.php?option=com_app&task=more", {page:pageVal,sort:sortVal,keyword:keywordVal,apptype:apptypeVal}, function(result){		

			if('' == result){
				jQuery("#more").hide();
				return;
			}
				
			jQuery("#page").val(pageVal+1);
			jQuery("#clr_list").before(result);
			scrollBar();
			collect();
		});
	});

	jQuery('#search').click(function(){
		var search = jQuery(this).val();
		if(search == '搜索应用'){
			jQuery(this).val('');
		}
	});
	
	jQuery("#search").blur(function(){
		var searchcontent = jQuery(this).val();
		if(searchcontent == ''){
			jQuery(this).val("搜索应用");			
		}
	});
	
	function collect(){
		jQuery(".favicons").bind('click',function(){
			var item_id = jQuery(this).attr('itemid');
			jQuery.ajax({
				type: 'POST',
				url: 'index.php?option=com_users&task=collect',
				data: { 'item_id' : item_id,'type' : 'app' },
				success: function(data){
				  if(data.ok){
					  alert('你已经成功收藏');
					  jQuery(".favicons"+item_id).html('<a><img src="components/com_app/images/stars.png" /></a>');				
				  }else if(data.done){
					  alert('您已取消收藏');
					  jQuery(".favicons"+item_id ).html('<a><img src="components/com_app/images/favicons.png" /></a>');
				  }
				  else if(data.error){
					  alert('请先登录');
					  window.location.href='index.php?option=com_users&view=login&Itemid=128';
				  }
				  
				},
				dataType:"json"
			  });
		});
	}
	collect();
	
	jQuery(".applist div.leftsearch1").bind('mouseover',function(){
		jQuery(".applist ul.order").css("display","block");
	});
	jQuery(".applist div.leftsearch1").bind('mouseout',function(){
		jQuery(".applist ul.order").css("display","none");
	});
	jQuery(".applist div.leftsearch2").bind('mouseover',function(){
		jQuery(".applist ul.game").css("display","block");
	});
	jQuery(".applist div.leftsearch2").bind('mouseout',function(){
		jQuery(".applist ul.game").css("display","none");
	});
	
	jQuery(document).ready(function(){
		var sortVal = jQuery("#sort").val();
		var apptypeVal = jQuery("#apptype").val();
		var apptype = jQuery("li.gameitem"+apptypeVal+" a").html();
		var sort = "";
		if(sortVal == "newest"){
			sort = "最新";	
		}
		else if(sortVal == "hotest"){
			sort = "最热";	
		}
		else{
			sort = "排序";	
		}
		var type = "";
		if(!apptypeVal){
			type = '游戏';	
		}
		else{
			type=apptype;	
		}
		
		jQuery(".leftsearch1 div.order span").html(sort);
		jQuery(".leftsearch2 div.game span").html(type);
	});
	
});
</script>

<?php 
	if($this->sort == ""){
		$link_sort = "index.php?option=com_app&view=apps";	
	}
	else{
		$link_sort = "index.php?option=com_app&view=apps&sort=".$this->sort;	
	}
	if($this->apptype == ""){
		$link_apptype = "index.php?option=com_app&view=apps";	
	}
	else{
		$link_apptype = "index.php?option=com_app&view=apps&apptype=".$this->apptype;	
	}
?>
<div class="applist">
	<div class="search">
    	<form name="search" method="post" action="<?php echo $link;?>">
            <div class="left leftsearch1"><div class="order"><span>排序</span><div class="left_list"><ul class="order"><li><a href="<?php echo $link_apptype.'&sort=newest&Itemid=121';?>">最新</a></li><li><a href="<?php echo $link_apptype.'&sort=hotest&Itemid=121';?>">最热</a></li></ul></div><img class="droplist" src="components/com_event/images/droplist.png" /></div></div>
            <div class="left separate"></div>
            <div class="left leftsearch2"><div class="game"><span>游戏</span><div class="left_list"><div class="dropdown">
            	<ul class="game">
                	<li><a href="<?php echo $link_sort; ?>">全部</a></li>
            	<?php foreach($this->cat as $gameitem): ?>
                	<li class="gameitem<?php echo $gameitem->id; ?>"><a href="<?php echo $link_sort.'&apptype='.$gameitem->id.'&Itemid=121';?>"><?php echo $gameitem->name; ?></a></li>
                <?php endforeach; ?>
            	</ul>
            </div></div><img class="droplist" src="components/com_event/images/droplist.png" /></div></div>
            <div class="left input"><input id="search" name="keyword" value="<?php echo $this->keyword ? $this->keyword : '搜索应用'; ?>"/><img src="components/com_event/images/fdj.png" onclick="document.search.submit();"/></div>
            <div class="clr"></div>
            <input type="hidden" id="sort" value="<?php echo $this->sort;?>" />
            <input type="hidden" id="apptype" value="<?php echo $this->apptype;?>" />
            <input type="hidden" id="keyword" value="<?php echo $this->keyword ? $this->keyword : '搜索应用'; ?>" />
        </form>
	</div>
	<div class="apps">
    	<div class="list_app">
        <?php if($this->rows){?>
			<?php foreach ($this->rows as $item):?>
                <div class="app">
                    <div class="img"><a href="index.php?option=com_app&view=app&id=<?php echo $item->id?>&Itemid=123"><img src="images/apps/<?php echo $item->id?>.png" /></a></div>
                    <div class="details">
                        <div class="title"><a href="index.php?option=com_app&view=app&id=<?php echo $item->id?>&Itemid=123"><?php echo $item->name?></a></div>
                        <div class="text"><?php echo strip_tags($item->brief)?></div>
                    </div>
                    <?php 
                    if( in_array($item->id, $collection) ){?>
                        <div class="favicons favicons<?php echo $item->id;?>" itemid="<?php echo $item->id;?>"><a><img src="components/com_app/images/stars.png" /></a></div>
                    <?php }else{ ?>
                    	<div class="favicons favicons<?php echo $item->id;?>" itemid="<?php echo $item->id;?>"><a><img src="components/com_app/images/favicons.png" /></a></div>		
					<?php }?>
                    <div class="clr"></div>
                </div>	
            <?php endforeach;?>
        <?php }else{ ?>
        	<div class="empty"><p>对不起，无相关搜索结果</p></div>
        <?php } ?>
        </div>
		<div id="clr_list"></div>
		<div id="more">
			<a>点 击 更 多</a>
			<input type="hidden" value="1" id="page" />
		</div>		
	</div>	
</div>