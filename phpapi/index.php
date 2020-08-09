<?php
	
	require 'functions.php';
session_start();
if(!isset($_SESSION['users']) || count($_SESSION['users'])==0)
{
	$_SESSION['users']=array();
	/*
				$input=[];
				$input["first_name"]="dodi";
				$input["last_name"]="dahudi";
				$input["uid"]="dahudi";
				array_push($_SESSION['users'],$input);
	*/
	
}
// unset($_SESSION['users']); echo json_encode($_SESSION);
if(isset($_POST['ajax'])=="1"){		
	switch($_POST['act'])
	{
		case 'create':
				$input=[];
				$input["first_name"]=$_POST["first_name"];
				$input["last_name"]=$_POST["last_name"];
				$uid="$jumlah_users";
				$input["uid"]=count($_SESSION['users']);
				array_push($_SESSION['users'],$input);
				echo '200';
			break;
		case 'read':
			$read=[];
			$read['count']=count($_SESSION['users']);
			$read['data']="null";
			if(count($_SESSION['users'])>0)
			$_SESSION['users']=array_values($_SESSION['users']);
			$read['data']=$_SESSION['users'];		
			echo json_encode($read);
			break;
		case 'update':
			echo 'update';
			break;
		case 'delete':
			for($i=0; $i<count($_SESSION['users']); $i++)
			{
				if($_SESSION['users'][$i]["uid"] == $_POST["key"])
				{
					unset($_SESSION['users'][$i]);
				}
			}
			echo '200';
			break;
		default :
			echo '404';
			break;	
	}
	exit;
}else{



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD</title>
	<script src="//<?php echo $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']; ?>jquery.min.213.js"></script>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
	<style type="text/css">
	.wrapper{ display:table; width:100%; min-width: 350px; max-width: 475px; margin: 25px auto;}
	.row_add{ display: none;}
	</style>
</head>
<body>
<div class="container-fluid"><div class="row">
	<div class="wrapper">
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
					<tr class="row_add"><td><input type="text" name="first_name" placeholder="input first name"></td><td><input type="text" name="last_name" placeholder="input last name"></td><td colspan="2"><input type="submit" value="submit" name="submit" id="submit" class="btn btn-success"></td></tr>
					<tr class="row_info"><td colspan="4"><em>Pleas wait while data loaded..</em></td></tr>
			</tbody>
		</table>	
	<div class="row_button_add"><button type="button" class="btn btn-primary delete" value="add">Add</button></div>
	
	</div>
</div></div>
<script type="text/javascript">
$(document).ready(function(){
	readData();
	$('.row_button_add button').click(function(){
		var countRow=$('table.table tbody tr').length;
		$("tr.row_add").show();		
		$("tr.row_info").hide();
		$(this).hide();		
	});
	$('table.table #submit').click(function(){
		var data='';
		data+='first_name='+$('table.table input[name=first_name]').val();
		data+='&last_name='+$('table.table input[name=last_name]').val();
		data+='&ajax=1&act=create';
		$.ajax({
			url:document.location,
			type:'POST',
			data:data,
			success:function(response){
				readData();
				$('table.table input[name=first_name]').val("");
				$('table.table input[name=last_name]').val("");
			}
		});
	});
});
</script>
	<script type="text/javascript">
		function deleteROW(i){
		$.ajax({
			url:document.location,
			type:'POST',
			data:'ajax=1&act=delete&key='+i+"",
			success:function(response){
				if(response=="200"){
					$('table.table tbody tr#'+i+'').remove();
					readData();
				}
			}
			});
		}
		function readData(){
		$.ajax({
			url:document.location,
			type:'POST',
			data:'ajax=1&act=read',
			success:function(response){
				
				responseJSON=JSON.parse(response);
				var jumlah=responseJSON["count"];
				$('table.table .row_info td').html("No Record Found");
				$('table.table .row_add').hide();
				if(jumlah>0)
					{
					// alert(JSON.stringify(responseJSON["data"]["uid"]));
						var newRow="";
						for(var i=0; i<jumlah; i++)
						{
							var uid=responseJSON["data"][i]["uid"];
							newRow+='<tr id="'+uid+'" class="data">';
								newRow+='<td>'+responseJSON["data"][i]["first_name"]+'</td>';
								newRow+='<td>'+responseJSON["data"][i]["last_name"]+'</td>';
								newRow+='<td><button type="button" class="btn btn-warning edit" onclick="editROW('+uid+');">edit</td>';
								newRow+='<td><button type="button" class="btn btn-danger delete" onclick="deleteROW('+uid+');">delete</td>';
							newRow+='</tr>';
						}
						$("table.table tbody tr").not('.row_info,.row_add').remove();
						$(newRow).insertBefore("table.table tbody tr.row_add");
						$('table.table .row_info td').html("");
					}else{
					}
					$('.row_button_add button').show();
				}
			
			});
		}
	</script>

</body>
</html>
<?php } ?>