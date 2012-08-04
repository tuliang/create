<?php
defined('_JEXEC') or die('Restricted access');

?>
<form name="adminForm" method="post" action="#">
	<div>类别名称：<input type="text" name="name" value="<?php echo $this->detail->name; ?>"  /></div>
	<div>
		<input type="hidden" name="task" value=""  />
		<input type="hidden" name="option" value="com_app" />
	</div>
</form>