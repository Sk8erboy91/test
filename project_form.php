<?php
function __autoload($class_name)
{
	include $class_name. '.php';
}

if(isset($_GET['action']))
{
	if($_GET['action'] == 'insert')
	{
		$startDate = new DateTime($_POST['start_date']);
		$dueDate = new DateTime($_POST['due_date']);
		
		Project::insertProject($_POST['description'],
							   $startDate,
							   $dueDate,
							   $_POST['team_leader'],
							   $_POST['client_id']);
		Project::showAllProjects();
		
	}elseif($_GET['action'] == 'show')
	{
		Project::showAllProjects();
	}
}else
{
	Project::showProjectForm();
}
