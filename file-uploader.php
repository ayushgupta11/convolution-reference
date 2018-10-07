<?php
if(!empty($_FILES['files']['name'][0])){
	    $files = $_FILES['files'];
	    
	    $uploaded = array();
	    $failed = array();
	    
	    $allowed = array('txt', 'pdf');
	    foreach($files['name'] as $position => $file_name){
	        $file_tmp = $files['tmp_name'][$position];
	        $file_size = $files['size'][$position];
	        $file_error = $files['error'][$position];
	        
	        $file_ext = explode('.',$file_name);
	        $file_ext = strtolower(end($file_ext));
	        
	        
	        if(in_array($file_ext, $allowed)){
	            if($file_error === 0){
	                if($file_size <= 2097152){
	                    $file_name_new = $_POST['team']['email'][1] . '.' . $file_ext;
	                    $file_destination = 'uploads/' . $file_name_new;
	                    if(move_uploaded_file($file_tmp,$file_destination )){
	                        $uploaded[$position] = $file_destination;
	                    }else{
	                        $failed[$position] = "[{$file_name}] &mdash; Failed to Upload.";
	                    }
	                    
	                    
	                    
	                    
	                }else{
	                    $failed[$position] = "[{$file_name}] &mdash; File is too large. ";
	                }
	            }else{
	                $failed[$position] = "[{$file_name}] &mdash; Error with code '{$file_error} ";
	            }
	            
	        }else{
	            $failed[$position] = "[{$file_name}] File Extension '{$file_ext}' is not allowed. ";
	        }
	        
	        
	        
	    }
	    if(!empty($uploaded)){
	        $flag=1;
	    }
	    if(!empty($failed)){
	        print_r($failed);
	    }
	}
	//File Upload ends
    $filename=$file_name_new;
    
    ?>