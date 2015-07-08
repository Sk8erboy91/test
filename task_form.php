<?php
function __autoload($class_name)
{
	include $class_name. '.php';
}

if(isset($_GET['action']))
{
	if($_GET['action'] == 'show_project')
	{
		$projectId = $_GET['project_id'];
		Task::showTask($projectId);
	}
	
}