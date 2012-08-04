<?php 
defined('_JEXEC') or die('Restricted access');

$apps = $this->apps;
$listDirn = $this->listDirn;
$listOrder= 'ordering';
$canOrder = 1;
$saveOrder = $listOrder;

?>
<form name="adminForm" method="post" action="#">
<table class="adminlist">
    <thead>
    	<tr>	
    		<th width="5%">
				<input type="checkbox" name="toggle" value="all" onclick="checkAll(<?php echo count($apps)?>);" />
			</th>	
    		<th class="title">应用名称</th>
    		<th width="5%">状态</th>
    		<th width="15%">创建时间</th>
    		<th width="15%">
    			<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
				<?php if ($canOrder && $saveOrder) :?>
					<?php echo JHtml::_('grid.order',  $this->apps, 'filesave.png', 'saveorder'); ?>
				<?php endif; ?>
    		</th>
    		<th width="5%">点击数</th>
    		<th width="1%">ID</th>
    	</tr>
    </thead>
	<tbody>
	<?php foreach ($apps as $key=>$app):
			$id = $app->id;
			$name = $app->name;
			$state = $app->state;
			$time = date('Y-m-d H:i:s', $app->timestamp);
			$ordering = ($listOrder == 'a.ordering');
			$hits = $app->hits;
			$url = 'index.php?option=com_app&task=app&id='.$id;
			$canChange	= 1;
	?>
		<tr>  		
			<td align="center">				
				<input id="cb<?php echo $key; ?>" value="<?php echo $id; ?>" name="app<?php echo $id; ?>"
						type="checkbox" onclick="isChecked(this.checked);" />	
			</td>
    		<td align="center"><a href="<?php echo $url; ?>"><?php echo $name; ?></a></td>
    		<td align="center">
    			<?php echo JHtml::_('jgrid.published', $state, $key, 'publishAppsunpublish', $canChange, 'cb'); ?>
    		</td> 
    		<td align="center"><?php echo $time; ?></td>   		
    		<td align="center">
				<input type="text" name="order[]" size="5" value="<?php echo $app->ordering;?>" class="text-area-order" />
    		</td>
    		<td align="center"><?php echo $hits; ?></td>
    		<td align="center"><?php echo $id; ?></td>
    	</tr>
    <?php endforeach; ?>
    </tbody> 
    <tfoot>
		<tr>
			<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>	  
</table>
	<div>
		<input type="hidden" name="boxchecked" value="0" >
		<input type="hidden" name="task" value=""  />
		<input type="hidden" name="option" value="com_app" >
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>