<?php
class Task
{
	public static function getTask($project)
	{
		$connection = DBConnection::getDBConnection();
		$stmt = "SELECT task_id, 
				        description, 
				        start_date, 
				        due_date
				   FROM task
				  WHERE project_id = :PROJECT_ID";
		
		$statement = $connection->prepare($stmt);
		$statement->bindValue(":PROJECT_ID", $project, PDO::PARAM_INT);
		$statement->execute();
		
		return $statement->fetchAll();
	}
	
	public static function showTask($project)
	{
		$allTasks = self::getTask($project);
		
		foreach($allTasks as $row)
		{
			echo "<p><a href=\"task_edit.php?task_id=".$row['task_id']."\">" . $row['description'] . " " . $row['start_date']." " .$row['due_date']. "</a></p>";
		}
	}
	
	public static function getTaskByTaskId($taskId)
	{
		$connection = DBConnection::getDBConnection();
		$stmt = "SELECT task_id,
				        description,
				        start_date,
				        due_date
				   FROM task
				  WHERE task_id = :TASK_ID";
	
		$statement = $connection->prepare($stmt);
		$statement->bindValue(":TASK_ID", $taskId, PDO::PARAM_INT);
		$statement->execute();
	
		return $statement->fetch();
	}
	
	public static function showEditForm($taskId)
	{
		$row = self::getTaskByTaskId($taskId);
		
		echo '	
		<form method="post">				
			<p>Task Id <input type="text" name="task_id" disabled value="'.$row['task_id'].'"/></p>
			<p>Description <input type="text" name="description" value="'.$row['description'].'"/></p>
			<p>Start Date <input type="text" name="start_date" value="'.$row['start_date'].'"/></p>
			<p>Due Date <input type="text" name="due_date" value="'.$row['due_date'].'"/></p>
			<p><input type="submit"></p>
		</form>';
	}
	
}