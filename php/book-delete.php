<?php 
    if (!isset($_SESSION)){
        session_start();
    }
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
        if (isset($_GET['id'])){    
			include "functions.php";
        include "../db_conn.php";
			$book_id = filter_var( $_GET['id'] , FILTER_SANITIZE_NUMBER_INT);

                if (checkidbooks($book_id , $conn)){
                        $book = getbookbyid($book_id , $conn);
                            $cover_url = $book['cover']; 
                            $cover_url1 = "uploads/cover/$cover_url";   
                     //   unlink($cover_url1);
                        $file_url = $book['file'];   
                        $file_url1 = "uploads/files/$file_url";   
 
                      //  unlink($file_url1);


                        $sql = "DELETE FROM books WHERE id = ?";
                            $stmt = $conn ->prepare($sql);
                            $stmt->execute([$book_id]);
                            header("location: ../admin.php?success=Successfully deleted!");
                            exit();


                }








        }else{
            header("location: ../admin.php");
            exit();
        }


                }else{
                header("location: login.php");
                exit();
                }

    