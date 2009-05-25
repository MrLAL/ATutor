<?php
	global $addslashes;

	//escape all strings
	$university  = $addslashes($this->university);
	$country	 = $addslashes($this->country);
	$province	 = $addslashes($this->province);
	$degree		 = $addslashes($this->degree);
	$field		 = $addslashes($this->field);
	$from		 = $addslashes($this->from);
	$to			 = $addslashes($this->to);
	$description = $addslashes($this->description);
?>
<script type='text/javascript' src='jscripts/calendar.js'></script>
<div class="headingbox"><h3><?php if($_GET['id']){echo _AT('edit_education');}else{echo  _AT('add_new_education');}?></h3></a></div>
<div class="contentbox">
<form method="POST" action="<?php echo url_rewrite(AT_SOCIAL_BASENAME.'edit_profile.php'); ?>">
	<dl id="public-profile">
		<dt><label for="university"><?php echo _AT('university'); ?></label></dt>
		<dd><input type="text" id="university" name="university" value="<?php echo $university; ?>" /></dd>
	
		<dt><label for="country"><?php echo _AT('country'); ?></label></dt>
		<dd><input type="text" id="country"  name="country" value="<?php echo $country; ?>" /></dd>
	
		<dt><label for="province"><?php echo _AT('province'); ?></label></dt>
		<dd><input type="text" id="province"  name="province" value="<?php echo $province; ?>" /></dd>
		
		<dt><label for="degree"><?php echo _AT('degree'); ?></label></dt>
		<dd><input type="text" id="degree"  name="degree" value="<?php echo $degree; ?>" /></dd>
	
		<dt><label for="field"><?php echo _AT('field'); ?></label></dt>
		<dd><input type="text" id="field"  name="field" value="<?php echo $field; ?>" /></dd>
		
		<dt><label for="from"><?php echo _AT('from'); ?></label></dt>
		<dd><input type="text" id="from"  name="from" value="<?php echo $from; ?>" />
		<img src='images/calendar.gif' style="vertical-align: middle; cursor: pointer;" onclick="scwShow(scwID('from'),event);" /></dd>
	
		<dt><label for="to"><?php echo _AT('to'); ?></label></dt>	
		<dd><input type="text" id="to"  name="to" value="<?php echo $to; ?>" />
		<img src='images/calendar.gif' style="vertical-align: middle; cursor: pointer;" onclick="scwShow(scwID('to'),event);" /></dd>
	
		<dt><label for="description"><?php echo _AT('description'); ?></label></dt>	
		<dd><textarea name="description" id="description" cols="40" rows="5" ><?php echo $description; ?></textarea></dd>
	
		<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
		<?php if($_GET['id']){ ?>
		<input type="hidden" name="edit" value="education" />
		<?php }else { ?>
		<input type="hidden" name="add" value="education" />
		<?php } ?>
	
		<input type="submit" name="submit" class="button" value="<?php echo _AT('save'); ?>" />
		<input type="submit" name="cancel" class="button" value="<?php echo _AT('cancel'); ?>" />
	</dl>
</div>
</form>