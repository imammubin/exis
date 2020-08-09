<?php

	function write_row_table($uid,$first_name,$last_name)
	{
		return 
		'<tr id="'.$uid.'">'
		.'<td>'.$first_name.'</td>'
		.'<td>'.$last_name.'</td>'
		.'<td class="edit"></td>'
		.'<td class="delete"></td>'
		.'</tr>';
	}