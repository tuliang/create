<?php 
defined('_JEXEC') or die('Restricted access');

$list = $this->list;
?>
<form name="adminForm" method="post" action="#">
<table class="adminlist">
    <thead>
    	<tr>	
    		<th width="5%">
				<input type="checkbox" name="toggle" value="all" onclick="checkAll(<?php echo count($list)?>);" />
			</th>	
    		<th class="title">类别名称</th>
    		<th width="1%">ID</th>
    	</tr>
    </thead>
	<tbody>
	<?php foreach ($list as $key=>$item):
			$id = $item->id;
			$name = $item->name;
			$url = 'index.php?option=com_app&task=category&id='.$id;
	?>
		<tr>  		
			<td align="center">				
				<input id="cb<?php echo $key; ?>" value="<?php echo $id; ?>" name="event<?php echo $id; ?>"
						type="checkbox" onclick="isChecked(this.checked);" />	
			</td>
    		<td align="center"><a href="<?php echo $url; ?>"><?php echo $name; ?></a></td>
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
		<input type="hidden" name="task" value="categories"  />
		<input type="hidden" name="option" value="com_app" >
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>