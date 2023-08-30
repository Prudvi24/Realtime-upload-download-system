<?php
    $serverName = "DESKTOP-9N101SU\SQLEXPRESS";                               //serverName \ InstanceName
    $connectionInfo = array("Database"=>"mybase");                           // Choosing a particular database
    $conn = sqlsrv_connect($serverName, $connectionInfo);                   //Connection to the SQL database
    if($conn == false)
    {
    	echo "connection cannot be established. <br />";                     
    	die(print_r(sqlsrv_errors(), true));                                  // Display the error
    }

    $id = $_GET['id'];                                                      //Get id when download is clicked

    $sql = "SELECT FileName From dbo.datafile3 WHERE id=$id";               // Get the filename using the id
    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_BOTH);
    $name = $row[0];
    $path_info = pathinfo($row[0]);
    $extension = $path_info['extension'];   // Extracting the file extension
    $extension = strtolower($extension);
    $filePath = "datafile/" . $row[0];
    $query = "SELECT StoredType FROM dbo.datafile3 WHERE id=$id";
    $stmt = sqlsrv_query($conn,$query);

    if($stmt == false)
    {
      echo "Error occured in downloading. <br />";
      die(print_r(sqlsrv_error(),true));
    }

    // Retrieve and display the data
    //The return data is retrieved as a binary stream
    if(sqlsrv_fetch($stmt))
    {
      if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
      {
        $image = sqlsrv_get_field($stmt,0,SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY));
        //$fileName = time().".".$extension;
        $fileName = $name;
        header('Content-Description: File Transfer');
        header("Content-Type: image/jpg/jpeg/png/gif");
        header("Content-disposition: attachment; filename=".$fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header("Content-Length: " .filesize($filePath));
        fpassthru($image);
        exit;
      }
      elseif($extension=='mkv' || $extension =='mp4' || $extension=='avi' || $extension=='wmv' || $extension=='flv' || $extension=='mov' || $extension=='mpeg')
      {
        $video = sqlsrv_get_field($stmt,0,SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY));
        //$fileName = time(). ".".$extension;
        $fileName = $name;
        header('Content-Description: File Transfer');
        header("Content-Type: video/mp4/mkv/avi/wmv/flv/mov/mpeg");
        header("Content-disposition: attachment; filename=".$fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header("Content-Length: " .filesize($filePath));
        fpassthru($video);
        exit;
      }
      elseif($extension=='doc' || $extension=='docx' || $extension=='pdf' || $extension=='odt' || $extension=='xls' || $extension=='xlsv' || $extension=='ods' || $extension=='ppt' || $extension=='pptx' || $extension=='txt')
      {
        $document = sqlsrv_get_field($stmt,0,SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY));
        //$fileName = time().".".$extension;
        $fileName = $name;
        header('Content-Description: File Transfer');
        header("Content-Type: application/pdf/doc/docx/odt/xls/xlsv/ods/ppt/pptx/txt");
        header("Content-disposition: attachment; filename=".$fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header("Content-Length: " .filesize($filePath));
        fpassthru($document);
        exit;
      }
      elseif($extension=='mp3' || $extension=='wav' || $extension=='wma' || $extension=='ogg' || $extension=='midi' || $extension=='aif' || $extension=='ea')
      {
        $audio = sqlsrv_get_field($stmt,0,SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY));
        //$fileName = time().".".$extension;
        $fileName = $name;
        header('Content-Description: File Transfer');
        header("Content-Type: Audio/mp3/wav/wma/ogg/midi/aif/ea");
        header("Content-disposition: attachment; filename=".$fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header("Content-Length: " .filesize($filePath));
        fpassthru($audio);
        exit;
      }
      
    }
    else
    {
      echo "Error in retrieving data. <br />";
      die(print_r(sqlsrv_errors(),true));
    }
  // Free statement and connection resources
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

?>