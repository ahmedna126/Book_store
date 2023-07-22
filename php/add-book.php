<?php 
    if (!isset($_SESSION)){
        session_start();
    }   

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
            include "../db_conn.php";
            include "functions.php";
            include "upload_editbook.php";

            
            if (isset($_POST['book_title']) 
            && isset($_POST['book_description']) 
            && isset($_POST['book_author']) 
            && isset($_POST['book_category'])
            && isset($_FILES['book_cover'])
            && isset($_FILES['file']) 
             ){

                $book_title = validate($_POST['book_title']);
                $book_description = validate($_POST['book_description']);
                $book_author = filter_var(validate($_POST['book_author']) , FILTER_SANITIZE_NUMBER_INT);
                $book_category = filter_var(validate($_POST['book_category']) , FILTER_SANITIZE_NUMBER_INT);

                $data = "title=$book_title&desc=$book_description&author=$book_author&category=$book_category" ;
                    
                
                is_empty($_POST['book_title'] , "book title" , "../add-book.php" , "error" , "&$data");
                is_empty($_POST['book_description'] , "book description" , "../add-book.php" , "error" , "&$data");
                is_empty($_POST['book_author'] , "book author" , "../add-book.php" , "error" , "&$data");
                is_empty($_POST['book_category'] , "book category" , "../add-book.php" , "error" , "&$data");
                    
                    if (empty($_FILES['book_cover']['name'])){
                        header("Location: ../add-book.php?error=the book cover is required&$data");
                        exit;
                    }else if (empty($_FILES['file']['name'])){
                        header("Location: ../add-book.php?error=the book file is required&$data");
                        exit;
                    }else{

                    
                $cover_loc = uploadfiles($_FILES['book_cover'] , array('jpg' , 'jpeg' , 'png') , 'cover');

                    if (isset($cover_loc['status'])){
                if ($cover_loc['status'] == 'error'){
                    $em = $cover_loc['data'] ;
                    header("Location: ../add-book.php?error=$em&$data");
                    exit;
                }else{
                    $file_loc = uploadfiles($_FILES['file']  ,  array('pdf' , 'docx' , 'pptx') , 'files');
                    if ($file_loc['status'] == 'error'){
                        $em = $file_loc['data'] ;
                        header("Location: ../add-book.php?error=$em&$data");
                        exit;
                    }else{

                            $cover_url = $cover_loc['data'];
                            $file_url = $file_loc['data'];

                            $sql = "INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`) VALUES ( ? , ? , ? , ? , ? , ? ) ";
                            $stmt = $conn ->prepare($sql);
                            $data = $stmt ->execute([$book_title , $book_author , $book_description , $book_category , $cover_url , $file_url]);

                            if ($data){
                                header("Location: ../add-book.php?success=Successfully updated!&$data");
                                exit;
                            }else{
                                $em = "Unknown Error Occurred!";
                                header("Location: ../add-book.php?error=$em&$data");
                                exit;
                            }

                        
                    }

                }

                
                    
            }else{
                $em = "Unknown Error Occurred!!";
                                header("Location: ../add-book.php?error=$em&$data");
                                exit;
            }

        }



    }else{
            header("Location: ../add-book.php?error=an error occurred!&$data");
            exit;
        }

        
}else{
    header("Location: login.php");
    exit;
    }
  ?>