<?php

	require 'db.account.php';	
	
	$table='notif';$drop=NULL;
	$DROP_TABLE='DROP TABLE IF EXISTS '.$table;
	$drop=mysql_query($DROP_TABLE);
	if(isset($drop) && $drop!=NULL){
		echo 'TABLE '.$table.' DROPED '."<br />"; 
	}

		$CREATE_TABLE=
		'CREATE TABLE IF NOT EXISTS '.$table.' ('
		.'notif_id INT(8) PRIMARY KEY NOT NULL AUTO_INCREMENT,'
		.'target VARCHAR(16),'
		.'booking_id int(8),'
		.'user_id int(8),'
		.'section varchar(16),'
		.'pesan varchar(256),'
		.'link varchar(128),'
		.'time int(24)'
		.')';

		$create_notif=mysql_query($CREATE_TABLE);
		if(isset($create_notif))
		{
			// echo 'TABLE '.$table.' CREATED'; exit;
		
		}

	