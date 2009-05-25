<?php
/****************************************************************/
/* ATutor														*/
/****************************************************************/
/* Copyright (c) 2002-2009										*/
/* Adaptive Technology Resource Centre / University of Toronto  */
/* http://atutor.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/
// $Id$
$_user_location	= 'public';

define('AT_INCLUDE_PATH', '../../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');
require(AT_SOCIAL_INCLUDE.'constants.inc.php');
require(AT_SOCIAL_INCLUDE.'friends.inc.php');
require(AT_SOCIAL_INCLUDE.'classes/SocialGroups/SocialGroup.class.php');
require(AT_SOCIAL_INCLUDE.'classes/SocialGroups/SocialGroups.class.php');
$_custom_css = $_base_path . AT_SOCIAL_BASENAME . 'module.css'; // use a custom stylesheet
if (!$_SESSION['valid_user']) {
	require(AT_INCLUDE_PATH.'header.inc.php');
	$info = array('INVALID_USER', $_SESSION['course_id']);
	$msg->printInfos($info);
	require(AT_INCLUDE_PATH.'footer.inc.php');
	exit;
}

//social groups init
$social_groups = new SocialGroups();
$rand_key = $addslashes($_POST['rand_key']);	//should we excape?

if ($rand_key!='' && isset($_POST['search_groups_'.$rand_key])){
	$query = $addslashes($_POST['search_groups_'.$rand_key]);
	$search_result = $social_groups->search($query);
}

//if $_GET['q'] is set, handle Ajax.
if (isset($_GET['q'])){
	$query = $addslashes($_GET['q']);
	$search_result = $social_groups->search($query);
	if (!empty($search_result)){
		echo '<div style="border:1px solid #a50707; margin-left:50px; width:45%;">Suggestion:<br/>';
		$counter = 0;
		foreach($search_result as $group_id=>$group_array){
			//display 10 suggestions
			if ($counter > 10){
				break;
			}

			$group_obj = $group_array['obj'];
			/* A bit of a hack here
			 * I used group_obj->name instead of group_obj->getName() because i want the raw data. Reason is javascript will convert
			 * my html entities to plain html again.  Which reallowing XSS to be possible.  If we use the raw data, and addslashes to it
			 * javascript will escape all possible injection.
			 *
			 * @Apr 2, 2009 - Harris
			 */
			echo '<a href="javascript:void(0);" onclick="document.getElementById(\'search_groups\').value=\''.addslashes($group_obj->name).'\'; document.getElementById(\'search_group_form\').submit();">'.$group_obj->getName().'</a><br/>';
			$counter++;
		}
		echo '</div>';
	}
	exit;
}

//Display
include(AT_INCLUDE_PATH.'header.inc.php');
$savant->display('pubmenu.tmpl.php');
$savant->assign('rand_key', $rand_key);
$savant->assign('search_result', $search_result);
$savant->display('sgroup_search.tmpl.php');
include(AT_INCLUDE_PATH.'footer.inc.php');
?>
