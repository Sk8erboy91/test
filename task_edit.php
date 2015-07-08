<?php
function __autoload($class_name)
{
	include $class_name. '.php';
}

$taskId = $_GET['task_id'];

Task::showEditForm($taskId);
?>

