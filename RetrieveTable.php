<?php
     header("Content-type: application/json");
     $serverName = "DESKTOP-9N101SU\SQLEXPRESS";
     $connectionInfo = array("Database"=>"mybase");
     $conn = sqlsrv_connect($serverName, $connectionInfo);
     if($conn == false)
     {
     	echo "Connection could not be established. <br />";
     	die(print_r(sqlsrv_error(),true));
     }
     //$query = "SELECT * FROM dbo.datafile2";
     $query = "SELECT id,FileType,FileName,FileSize FROM dbo.datafile3";
     $result = sqlsrv_query($conn,$query);

     if($result == false)
     {
     	echo "Error in query execution. <br />";
     	die(print_r(sqlsrv_error(),true));
     }
     $json_array = array();

     while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
     {
            $json_array[] = $row;
     }
     echo json_encode($json_array);

?>