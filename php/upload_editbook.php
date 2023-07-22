<?php 

    function uploadfiles ($file , $allowextenstions, $path){

        $file_name = $file['name'];
        $file_size = $file['size'];
        $tmp_name = $file['tmp_name'];
        $error = $file['error'];

            if ($error == 0 ){
                $file_ex = pathinfo($file_name , PATHINFO_EXTENSION);
                    $file_ex_lo = strtolower($file_ex);
                    if (in_array($file_ex_lo , $allowextenstions)){

                        $new_file_name = uniqid("" , true) . '.' . $file_ex_lo; 
                        $uploadlocation = "../uploads/$path/$new_file_name"; 
                        move_uploaded_file($tmp_name , $uploadlocation);

                        $sm['status'] = 'success';
                        $sm['data']   = $new_file_name;

                            return $sm ;
                    
                    
                }else{
                    if (in_array('jpg' , $allowextenstions)){
                        $oo = "book cover";
                    }else{
                        $oo = "file";
                    }
                    $em['status'] = 'error';
	                     $em['data']   = "the extenstions is not allowed in $oo";        
                        return $em;
            }

                    $em['status'] = 'error';
	                $em['data']   = "error an accouried!";        
                        return $em;
    }
    
}
