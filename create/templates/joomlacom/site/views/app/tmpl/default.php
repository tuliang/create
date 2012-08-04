<?php
defined('_JEXEC') or die('Restricted access');
$item=$this->row;
//var_dump($item);exit;
$collect = $this->collect;
?>
<script>
jQuery(function(){
	jQuery(".details").jscroll({ W:"12px"//设置滚动条宽度
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
	jQuery('#search').click(function(){
		jQuery(this).val('');
	});
	
	jQuery(".favicon").live('click',function(){
		var item_id = <?php echo $item->id?>;
		jQuery.ajax({
			  type: 'POST',
			  url: 'index.php?option=com_users&task=collect',
			  data: { 'item_id' : item_id,'type' : 'app' },
			  success: function(data){
				if(data.ok){
				  	alert('你已经成功收藏');
					jQuery(".favicon").html('<a><img src="components/com_app/images/un_favicon.png" /></a>');					
				}else if(data.done){
					alert('您已取消收藏');
					jQuery(".favicon").html('<a><img src="components/com_app/images/favicon.png" /></a>');
				}
				else if(data.error){
					alert('请先登录');
					window.location.href='index.php?option=com_users&view=login&Itemid=128';
				}
				
		      },
		      dataType:"json"
			});
	});
	
});
</script>
<div class="details">
<div class="app_top">
	<div class="img">
		<img src="images/apps/<?php echo $item->id?>.png" />
	</div>	
			
	<div class="title">
		<p><?php echo $item->name?></p>
		<div class="score">
        	<div id="grade">
            	<?php $url = 'components/com_app/images/score_dark.png';?>
            	<a class="mark" name="1" ><img src="<?php echo $url; ?>" /></a>
                <a class="mark" name="2" ><img src="<?php echo $url; ?>" /></a>
                <a class="mark" name="3" ><img src="<?php echo $url; ?>" /></a>
                <a class="mark" name="4" ><img src="<?php echo $url; ?>" /></a>
                <a class="mark" name="5" ><img src="<?php echo $url; ?>" /></a>
                <div class="clr"></div>
                <span></span>
            </div>
        </div>
        <div class="score1">
        	<div id="grade1">
        	<?php echo $this->score;?>
        	</div>
        </div>
	</div>			
	
	<div class="app_button">
		<div class="go"><a href="index.php?option=com_app&view=content&id=<?php echo $item->id;?>&Itemid=139"><img src="components/com_app/images/go.png" /></a></div>
        <?php 
            if( $collect ){?>
                <div class="favicon" ><a><img src="components/com_app/images/un_favicon.png" /></a></div>
        <?php }else{ ?>
               <div class="favicon" ><a><img src="components/com_app/images/favicon.png" /></a></div>
		<?php }?>
	</div>
	
	<div class="clr"></div>
</div>
<div class="briefing">
	<div><img src="components/com_app/images/briefing.png" /></div>
	<div class="app_content"><?php echo $item->introduction?></div>
	<div class="clr"></div>
</div>
<div class="app_slide">
	<div class="slide">
	
	<a id="back" class="slide_nav" href="#"></a>
	<div id="small_frame" class="l_frame">
		<ul id="small_list" class="list">
			<?php $slide = $this->slide;
			//var_dump($slide);exit;
	        $total = count($slide); 
	        $key = 0;
	        foreach($slide as $slide_item):
            	$index = $total - $key; ?>
                <li class="<?php if ($key == 0) echo 'cur'; ?>" id ="pic<?php echo $key;?>" style="z-index:<?php echo $index;?>;float:left;">
                	<a target="_blank" href="images/apps/detail/<?php echo $item->id?>/<?php echo $slide_item; ?>" >
                		<img width="120" height="90" src="images/apps/detail/<?php echo $item->id?>/<?php echo $slide_item; ?>" />
                	</a>
                </li>	               
            <?php $key++;
            endforeach;?>
		</ul>
	</div>
	<a id="forward" class="slide_nav" href="#"></a>
		    
	</div>
</div>
<form action="index.php?option=com_app&task=sendComment" method="post">
	<div class="app_comment">
		<div class="comment">
			<img src="components/com_app/images/comment.png" />
		</div>
		<div class="comment_text">
			<input type="text" name="content" value="" id="comment_text" />
		</div>
		<div class="comment_button">
			<input type="image" id="comment_button" src="components/com_app/images/comment_button.png" />
		</div>
		<div class="clr"></div>
	</div>
	<input type="hidden" name="appid" id="appid" value="<?php echo JRequest::getVar('id')?>" />
</form>
<div class="commentlist">
<?php foreach ($this->comments as $comment):?>
	<div class="comment_item"><p><span><?php echo $comment->userName;?>:</span><?php echo $comment->content;?></p></div>
<?php endforeach;?>
	<div class="clr"></div>
</div>
</div>

<script type="text/javascript">
jQuery(".score1").mouseover(function(){
	jQuery(this).css("display","none");
	jQuery(".score").css("display","block");
});
jQuery('#grade a.mark').mouseenter(function(){
	jQuery('#grade a.mark').html('<img src="components/com_app/images/score_dark.png" />');
	var name = jQuery(this).attr('name');
	jQuery('#grade a.mark:lt('+name+')').html('<img src="components/com_app/images/score_light.png" />');
});
jQuery('#grade a.mark').mouseleave(function(){
	jQuery('#grade a.mark').html('<img src="components/com_app/images/score_dark.png" />');
});
jQuery(".score").mouseleave(function(){
	//alert("111");
	jQuery(this).css("display","none");
	jQuery(".score1").css("display","block");
});

//初始化
function C_slider(frame,list,Lframe,Llist,forwardEle,backEle,scrollType,LscrollType,acitonType,autoInterval){
	this.frame = frame;
	this.list = list;
	this.Lframe = Lframe;
	this.Llist = Llist;
	this.forwardEle = forwardEle;
	this.backEle = backEle;
	this.scrollType = scrollType;
	this.LscrollType = LscrollType;
	this.acitonType = acitonType;
	this.autoInterval = autoInterval;
	
	this.slideLength = $("#"+this.Llist+" > li").length;//总的slider数量
	this.currentSlide = 0;
	this.FrameHeight = $("#"+this.frame).height();
	this.FrameWidth = $("#"+this.frame).width();
	this.lFrameHeight = $("#"+this.Lframe).height();
	this.lFrameWidth = $("#"+this.Lframe).width();
	this.lListHeight = $("#"+this.Llist+" >li").eq(0).outerHeight(true);
	this.lListWidth = $("#"+this.Llist+" >li").eq(0).outerWidth(true);
	
	var self = this;
	
	for(var i = 0; i<this.slideLength; i++) {
		$("#"+this.Llist+" > li").eq(i).data("index",i);
		$("#"+this.Llist+" > li").eq(i).bind(this.acitonType,function(){
			self.go($(this).data("index"));
		});
	};
	
	//给"上一个"、"下一个"按钮添加动作
	$("#"+this.forwardEle).bind('click',function(){
		self.forward();
		return false;
	});
	$("#"+this.backEle).bind('click',function(){
		self.back();
		return false;
	});
	
	//定论鼠标划过时，自动轮换的处理
	$("#"+this.frame+",#"+this.Lframe+",#"+this.forwardEle+",#"+this.backEle).bind('mouseover',function(){
		clearTimeout(self.autoExt);
	});
	
	$("#"+this.frame+",#"+this.Lframe+",#"+this.forwardEle+",#"+this.backEle).bind('mouseout',function(){
		clearTimeout(self.autoExt);
		self.autoExt = setTimeout(function(){
			self.extInterval();
		},self.autoInterval);
	});	
	
	
	//开始自动轮换
	this.autoExt = setTimeout(function(){
		self.extInterval();
	},this.autoInterval);
}
//执行运动
C_slider.prototype.go = function(index){
	this.currentSlide = index;
	if (this.scrollType == "left"){
		$("#"+this.list).animate({
			marginLeft: (-index*this.FrameWidth)+"px"
		}, {duration:600,queue:false}); 		
	} else if (this.scrollType == "top"){
		$("#"+this.list).animate({
			marginTop: (-index*this.FrameHeight)+"px"
		}, {duration:600,queue:false}); 		
	}
	
	$("#"+this.Llist+" > li").removeClass("cur");
	$("#"+this.Llist+" > li").eq(index).addClass("cur");
		
	//对于缩略图的滚动处理
	if(this.LscrollType == "left"){
		if(this.slideLength*this.lListWidth > this.lFrameWidth){
			var spaceWidth = this.lFrameWidth - this.lListWidth;
			var hiddenSpace = this.lListWidth*this.currentSlide - spaceWidth;
			
			if (hiddenSpace > 0){
				if(hiddenSpace+this.lFrameWidth <= this.slideLength*this.lListWidth){
					$("#"+this.Llist).animate({
						marginLeft: -hiddenSpace+"px"
					}, {duration:600,queue:false}); 
				} else {
					var endHidden = this.slideLength*this.lListWidth - this.lFrameWidth;
					$("#"+this.Llist).animate({
						marginLeft: -endHidden+"px"
					}, {duration:600,queue:false}); 
				}
			} else {
				$("#"+this.Llist).animate({
					marginLeft: "0px"
				}, {duration:600,queue:false}); 
			}
		}
		
	} else if (this.LscrollType == "top"){
		if(this.slideLength*this.lListHeight > this.lFrameHeight){
			var spaceHeight = (this.lFrameHeight - this.lListHeight)/2;
			var hiddenSpace = this.lListHeight*this.currentSlide - spaceHeight;
			
			if (hiddenSpace > 0){
				if(hiddenSpace+this.lFrameHeight <= this.slideLength*this.lListHeight){
					$("#"+this.Llist).animate({
						marginTop: -hiddenSpace+"px"
					}, {duration:600,queue:false}); 
				} else {
					var endHidden = this.slideLength*this.lListHeight - this.lFrameHeight;
					$("#"+this.Llist).animate({
						marginTop: -endHidden+"px"
					}, {duration:600,queue:false}); 
				}
			} else {
				$("#"+this.Llist).animate({
					marginTop: "0px"
				}, {duration:600,queue:false}); 
			}
		}
		
	}
	
}
//前进
C_slider.prototype.forward = function(){
	if(this.currentSlide<this.slideLength-1){
		this.currentSlide += 1;
		this.go(this.currentSlide);
	}else {
		this.currentSlide = 0;
		this.go(0);
	}
}
//后退
C_slider.prototype.back = function(){
	if(this.currentSlide>0){
		this.currentSlide -= 1;
		this.go(this.currentSlide);
	}else {
		this.currentSlide = this.slideLength-1;
		this.go(this.slideLength-1);
	}
}
//自动执行
C_slider.prototype.extInterval = function(){
	if(this.currentSlide<this.slideLength-1){
		this.currentSlide += 1;
		this.go(this.currentSlide);
	}else {
		this.currentSlide = 0;
		this.go(0);
	}
	
	var self = this;
	this.autoExt = setTimeout(function(){
		self.extInterval();
	},this.autoInterval);
}
//实例化对象 
var goSlide1 = new C_slider("big_frame","big_list","small_frame","small_list","forward","back","left","left","click",3000);
//打分
jQuery('#grade a.mark').click(function(){
	var name = jQuery(this).attr('name');
	var ScoreVal = name;
	var idVal = jQuery("#appid").val();
	jQuery.post("index.php?option=com_app&task=score", {score: ScoreVal,id:idVal},function(){});
	//jQuery('#grade a.mark').attr('class', 'scores');
	var i = 1;
	var j = 1;
	var myscore = '';
	//alert(ScoreVal);
	while(i<=ScoreVal){
		myscore += '<img src="components/com_app/images/score_light.png" />';	
		i++;
	}
	while(j<=(5-ScoreVal)){
		myscore += '<img src="components/com_app/images/score_dark.png" />';	
		j++;	
	}
	//alert(myscore);
	jQuery('#grade1').html(myscore);
//	jQuery(".score").mouseleave(function(){
//		jQuery(".score").css("display","block");
//		jQuery(".score1").remove();
//	});
	//jQuery("#grade span").html("感谢您的评价");
});
</script>