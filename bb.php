<?php 
   /*  $current_cover = "uploads/cover/cd.jpg";
    include "db_conn.php";
    include "php/upload_editbook.php";

    $a = array('jpg' , 'jpeg' , 'png');
$cover_loc = uploadfiles($_FILES['book_cover'] , $a , 'cover' );
            print_r( $cover_loc ); */

                $key = "cdcddcevwevnewv";
            $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);

                

            include "php/functions.php";
            include "db_conn.php";
            $key = "pp";
            $search = '%'.$key.'%' ;
        $sql  = "SELECT * FROM books WHERE title LIKE ? OR description LIKE ?";
        $stmt = $conn ->prepare($sql);
        $stmt->execute([$search , $search]);

         $datas  = $stmt ->fetchAll();

    print_r($datas);
        