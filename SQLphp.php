<?php
    $serverName = "DESKTOP-9N101SU\SQLEXPRESS"; //serverName \ InstanceName
    $connectionInfo = array("Database"=>"mybase");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if($conn == false)
    {
    	echo "connection cannot be established. <br />";
    	die(print_r(sqlsrv_errors(), true));
    }

    if(isset($_FILES['files']) && !empty($_FILES['files']))
    {
    	if(count($_FILES['files']['name'])>0)
    	{
    		for($i=0; $i<count($_FILES['files']['name']); $i++)
    		{
    			$fileType = $_FILES["files"]["type"][$i];
    			$tmpFilePath = $_FILES['files']['tmp_name'][$i];
    			if($tmpFilePath != "")
    			{
    				$shortname = $_FILES['files']['name'][$i];
                    $mem = $_FILES['files']['size'][$i];
                    $mem = $mem/1048576;
                    $memory = round($mem,2);
    				$path_info = pathinfo($shortname);
    				$extension = $path_info['extension'];
    				$extension = strtolower($extension);
                    $shortname = preg_replace('/\s+/', '_', $shortname);
    				if($extension=='mkv' || $extension =='mp4' || $extension=='avi' || $extension=='wmv' || $extension=='flv' || $extension=='mov' || $extension=='mpeg')
    				{
    					//$fileContent = addslashes(file_get_contents($tmpFilePath,0,4294967295)); //gets the content
				            $filePath = "C:/xampp/htdocs/testing/datafile/";
				            $targetFile = $filePath .$shortname;   //Target folder to store files and map them to database
				            if(move_uploaded_file($tmpFilePath, $filePath .$shortname))      // Moving files to the target folder
				                {
					                $query = "INSERT INTO dbo.datafile3 SELECT 'Video' AS FileType, '$shortname' AS FileName, '$memory' AS FileSize, * FROM OPENROWSET(BULK '$targetFile', SINGLE_BLOB) as X";   // Insert Query for MySqldatabase
					                //$params1 = array($shortname,$targetFile);
					                $check = sqlsrv_query($conn,$query);
					                if($check)
					                    {
						                    echo $shortname." is uploaded to SQL server successfully.";
					                    }
					                else
					                    {
						                    echo 'Error in uploading the video file';
					                    }
				                }
				            else
				                {
					                echo "File cannot be moved to directory";
				                }
    				}
    				elseif($extension == 'jpg' || $extension =='jpeg' || $extension =='tif' || $extension=='png' || $extension=='gif') // Other than video files are inserted into database
			        {
				            $fileContent = addslashes(file_get_contents($tmpFilePath));
				            $filePath = "C:/xampp/htdocs/testing/datafile/";
                            $targetFile = $filePath .$shortname;
                            
				            if(move_uploaded_file($tmpFilePath, $filePath .$shortname))
				                {
					                //$query = "INSERT INTO upfiles VALUES ('','$shortname','$fileContent')";  // images can be mapped or else directly retieved from Databse
					                $query = "INSERT INTO dbo.datafile3 SELECT 'Image' AS FileType, '$shortname' AS FileName, '$memory' AS FileSize, * FROM OPENROWSET(BULK '$targetFile', SINGLE_BLOB) as X";
					                //$params1 = array(1,$shortname,$fileContent);
					                $check = sqlsrv_query($conn,$query);
					                if($check)
					                    {
						                    echo $shortname." is uploaded to SQL server successfully.";
					                    }
					                else
					                    {
						                    echo 'Error in uploading';
						                    die( print_r( sqlsrv_errors(), true));
					                    }
				                }
				            else
				                {
					                echo "File cannot be moved to directory";
				                }

			         }
                    elseif($extension=='pdf' || $extension=='ppt' || $extension=='txt' || $extension=='odt' || $extension=='html' || $extension=='doc' || $extension=='docx' || $extension=='xls' || $extension=='xlsx' || $extension=='ods' || $extension=='csv')
                    {
                        $filePath = "C:/xampp/htdocs/testing/datafile/";
                        $targetFile = $filePath .$shortname;
                            
                            if(move_uploaded_file($tmpFilePath, $filePath .$shortname))
                                {
                                    //$query = "INSERT INTO upfiles VALUES ('','$shortname','$fileContent')";  // images can be mapped or else directly retieved from Databse
                                    $query = "INSERT INTO dbo.datafile3 SELECT 'Document' AS FileType, '$shortname' AS FileName, '$memory' AS FileSize, * FROM OPENROWSET(BULK '$targetFile', SINGLE_BLOB) as X";
                                    //$params1 = array(1,$shortname,$fileContent);
                                    $check = sqlsrv_query($conn,$query);
                                    if($check)
                                        {
                                            echo $shortname." is uploaded to SQL server successfully.";
                                        }
                                    else
                                        {
                                            echo 'Error in uploading';
                                            die( print_r( sqlsrv_errors(), true));
                                        }
                                }
                            else
                                {
                                    echo "File cannot be moved to directory";
                                }
                    }

                    elseif($extension=='mp3' || $extension=='wav' || $extension=='wma' || $extension=='ogg' || $extension=='midi' || $extension=='aif' || $extension=='ea')
                    {
                        $filePath = "C:/xampp/htdocs/testing/datafile/";
                        $targetFile = $filePath .$shortname;
                            
                            if(move_uploaded_file($tmpFilePath, $filePath .$shortname))
                                {
                                    //$query = "INSERT INTO upfiles VALUES ('','$shortname','$fileContent')";  // images can be mapped or else directly retieved from Databse
                                    $query = "INSERT INTO dbo.datafile3 SELECT 'Audio' AS FileType, '$shortname' AS FileName, '$memory' AS FileSize, * FROM OPENROWSET(BULK '$targetFile', SINGLE_BLOB) as X";
                                    //$params1 = array(1,$shortname,$fileContent);
                                    $check = sqlsrv_query($conn,$query);
                                    if($check)
                                        {
                                            echo $shortname." is uploaded to SQL server successfully.";
                                        }
                                    else
                                        {
                                            echo 'Error in uploading';
                                            die( print_r( sqlsrv_errors(), true));
                                        }
                                }
                            else
                                {
                                    echo "File cannot be moved to directory";
                                }
                    }
    			}
    		}
    	}
    }
    else
    {
    	echo "Please choose a atleast one file";
    }

    sqlsrv_close($conn);
?>