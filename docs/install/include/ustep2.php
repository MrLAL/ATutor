<?php
/************************************************************************/
/* ATutor																*/
/************************************************************************/
/* Copyright (c) 2002-2004 by Greg Gay, Joel Kronenberg, Heidi Hazelton	*/
/* http://atutor.ca														*/
/*																		*/
/* This program is free software. You can redistribute it and/or		*/
/* modify it under the terms of the GNU General Public License			*/
/* as published by the Free Software Foundation.						*/
/************************************************************************/
if (!defined('AT_INCLUDE_PATH')) { exit; }

	function update_one_ver($up_file) {
		global $progress;
		$update_file = implode("_",$up_file);
		queryFromFile('db/'.$update_file.'sql');
		$progress[] = 'Successful update from version '.$up_file[2].' to '.$up_file[4];
		return $up_file[4];
	} 

	unset($errors);
	//check DB & table connection

	$db = mysql_connect($_POST['db_host'] . ':' . $_POST['db_port'], $_POST['db_login'], $_POST['db_password']);

	if (!$db) {
		$errors[] = 'Unable to connect to database server.';
	} else {
		if (!mysql_select_db($_POST['db_name'], $db)) {
			$errors[] = 'Unable to connect to database <b>'.$_POST['db_name'].'</b>.';
		}

		if (!$errors) {
			$progress[] = 'Connected to database <b>'.$_POST['db_name'].'</b> successfully.';
			unset($errors);

			//get list of all update scripts minus sql extension
			$files = scandir('db'); 
			foreach ($files as $file) {
				if(count($file = explode("_",$file))==5) {
					$file[4] = substr($file[4],0,-3);
					$update_files[$file[2]] = $file;
				}
			}
			
			$curr_ver = $_POST['old_version'];
			ksort($update_files);
			foreach ($update_files as $up_file) {
				if(version_compare($curr_ver, $up_file[4], '<')) {	
					update_one_ver($up_file);
				} 
			}
			queryFromFile('db/atutor_lang_base.sql');

			if (!$errors) {
				print_progress($step);

				unset($_POST['submit']);
				store_steps(1);
				print_feedback($progress);

				echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="form">
				<input type="hidden" name="step" value="3" />
				<input type="hidden" name="upgrade_action" value="true" />';
				print_hidden(3);
				echo '<p align="center"><input type="submit" class="button" value=" Next � " name="submit" /></p></form>';
				return;
			}
		}
	}
	print_progress($step);

	unset($_POST['submit']);
	if (isset($progress)) {
		print_feedback($progress);
	}

	if (isset($errors)) {
		print_errors($errors);
	}


	echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="form">
	<input type="hidden" name="step" value="2" />';
	store_steps(1);
	print_hidden(2);
	
	echo '<input type="hidden" name="db_login" value="'.urlencode($_POST['db_login']).'" />';
	echo '<input type="hidden" name="db_password" value="'.urlencode($_POST['db_password']).'" />';
	echo '<input type="hidden" name="db_host" value="'.$_POST['db_host'].'" />';
	echo '<input type="hidden" name="db_name" value="'.$_POST['db_name'].'" />';
	echo '<input type="hidden" name="db_port" value="'.$_POST['db_port'].'" />';
	echo '<input type="hidden" name="old_version" value="'.$_POST['old_version'].'" />';
	echo '<input type="hidden" name="new_version" value="'.$_POST['new_version'].'" />';

	echo '<p align="center"><input type="submit" class="button" value=" Retry " name="submit" /></p></form>';
	return;


?>