<?php
class Project
{
	public static function showAllProjects()
	{
		try{
			//$stmt is PDO Object
			$connection = DBConnection::getDBConnection();
			
			$statement = "SELECT p.project_id,
								 p.description,
					             p.start_date,
								 p.due_date
					        FROM project p";
			
			//$stmt is PDOStatement Object
			$stmt = $connection->prepare($statement);
			
			$stmt->execute();
			
			//$resultSet is matrix
			/*$resultSet = $stmt->fetchAll();
			
			foreach ($resultSet as $row)
			{
				echo "<p>";
				echo $row['description']. " " .$row['start_date'] . " " .$row['due_date'];
				echo "</p>";
			}*/
			echo "<p>All Projects</p>";
			
			while($row = $stmt->fetch())
			{				
				echo "<p>";
				echo "<a href=\"task_form.php?action=show_project&project_id=".$row['project_id']."\">" .$row['description'] . "</a>"; 
				
				echo $row['start_date'] . " " .$row['due_date'];
				echo "</p>";
			}
			
		
		}catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public static function insertProject($description, 
										 DateTime $startDate, 
										 DateTime $dueDate, 
									     $teamLeader,
										 $clientId)
	{
		$connection = DBConnection::getDBConnection();
		$stmt = "INSERT INTO `project`( `DESCRIPTION`, 
								        `START_DATE`, 
										`DUE_DATE`, 
										`TEAM_LEADER`, 
				                        `CLIENT_ID`) 
				VALUES (:DESCRIPTION,
						:START_DATE,
						:DUE_DATE,
						:TEAM_LEADER,
						:CLIENT_ID)";
		$statement = $connection->prepare($stmt);
		$statement->bindValue(':DESCRIPTION', $description, PDO::PARAM_STR);
		$statement->bindValue(':START_DATE', $startDate->format('y-m-d'), PDO::PARAM_STR);
		$statement->bindValue(':DUE_DATE', $dueDate->format('y-m-d'), PDO::PARAM_STR);
		$statement->bindValue(':TEAM_LEADER', $teamLeader, PDO::PARAM_INT);
		$statement->bindValue(':CLIENT_ID', $clientId, PDO::PARAM_INT);
		
		$statement->execute();
	}
	
	public static function getAllConsultants()
	{
	
		$connection = DBConnection::getDBConnection();
		$stmt = "SELECT consultant_id, name FROM consultant";
		
		$statement = $connection->prepare($stmt);
		$statement->execute();
		
		$result = $statement->fetchAll();
		return $result;
	}
	
	public static function showProjectForm()
	{
		$allClients = Client::getAllClients();
		$allConsultants = self::getAllConsultants();
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Insert Project</title>
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
				<script>
				$(function() {
					$("#start_date").datepicker();
				});
				
				$(function() {
					$("#due_date").datepicker();
				});
				</script>
				</head>
				<body>
				<form action="project_form.php?action=insert" method="post">
				<p>Description <input type="text" name="description"/></p>
				<p>Start Date <input type="text" name="start_date" id="start_date"/></p>
				<p>Due Date <input type="text" name="due_date" id="due_date"/></p>
							
			<p>Team Leader<select name="team_leader">';
								
	 		foreach($allConsultants as $row)
			 {
			 	echo "<option value=\"".$row['consultant_id']."\">".$row['name']."</option>";
			 }
			 echo '</select></p>
					
			 <p>Client<select name="client_id">';
			 
			 foreach($allClients as $row)
			 {
			 	echo "<option value=\"".$row['client_id']."\">".$row['name']."</option>";
			 }
			 
			 echo '</select></p>
			 <p><input type="submit"/></p>
			</form>
			</body>
			</html>';
	
	}
}