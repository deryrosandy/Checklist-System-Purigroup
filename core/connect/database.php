<?php
	$pdo = new PDO("mysql:dbname=checklist_system_db;host:localhost", 'root', 'ilovejkt48');
	$db = new NotORM($pdo);
?>