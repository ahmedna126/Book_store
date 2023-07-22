<?php 
    if (!isset($_SESSION)){
        session_start();
    }   

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
            include "../db_conn.php";
            include "functions.php";
            is_empty($_POST['book_id'] , "id" , "../book-edit.php" , "error" , "");
            $book_id = filter_var( $_POST['book_id'] , FILTER_SANITIZE_NUMBER_INT);
        if (checkidbooks($book_id , $conn)){
            if (isset($_POST['book_id']) 
            && isset($_POST['book_title']) 
            && isset($_POST['book_description']) 
            && isset($_POST['book_author']) 
            && isset($_POST['book_category'])
            && isset($_FILES['book_cover'])
            && isset($_FILES['file']) 
             ){

                
                is_empty($_POST['book_title'] , "book title" , "../book-edit.php" , "error" , "&id=$book_id");
                is_empty($_POST['book_description'] , "book description" , "../book-edit.php" , "error" , "&id=$book_id");
                is_empty($_POST['book_author'] , "book author" , "../book-edit.php" , "error" , "&id=$book_id");
                is_empty($_POST['book_category'] , "book category" , "../book-edit.php" , "error" , "&id=$book_id");
              //  is_empty($_FILES['book_cover']['name'] , "book cover" , "../book-edit.php" , "error" , "&id=$book_id");
              //  is_empty($_FILES['file']['name'] , "file" , "../book-edit.php" , "error" , "&id=$book_id");
                      

                $book_title = validate($_POST['book_title']);
                $book_description = validate($_POST['book_description']);
                $book_author = validate($_POST['book_author']);
                $book_category = validate($_POST['book_category']);

                $current_cover = $_POST['current_cover'];
                $current_FILES = $_POST['current_file'];

                include "upload_editbook.php";

                if (!empty($_FILES['book_cover']['name'])){
                        // check if cover and file is isset
                    if (!empty($_FILES['file']['name'])){
                         $cover_loc = uploadfiles($_FILES['book_cover'] , array('jpg' , 'jpeg' , 'png') , "cover");
                         $file_loc = uploadfiles($_FILES['file']  ,  array('pdf' , 'docx' , 'pptx') , 'files');
                         
                            if ($cover_loc['status'] == 'error' || $file_loc['status'] == 'error' ){
                                $em = $cover_loc['data'];
                                    header("LOCATION: ../book-edit.php?error=$em&id=$book_id");
                                    exit;
                            }else{
                                $c_p_book_cover = "../uploads/cover/$current_cover";
                                $c_p_file = "../uploads/files/$current_FILES";

                                unlink($c_p_book_cover);
                                unlink($c_p_file);

                                $file_url = $file_loc['data'];
                                $cover_url = $cover_loc['data'];

                            $sql = "UPDATE books SET title=? , author_id=? , description=? , category_id=? , cover=? , file=?  WHERE id = ?" ;
                            $stmt = $conn ->prepare($sql);
                            $data = $stmt ->execute([$book_title , $book_author , $book_description , $book_category , $cover_url , $file_url , $book_id]);
                                
                            if ($data){
                                    header("Location: ../book-edit.php?success=Successfully updated!&id=$book_id");
                                    exit;
                                }else{
                                    $em = "Unknown Error Occurred!";
                                    header("Location: ../edit-book.php?error=$em&id=$book_id");
                                    exit;
                                }
                            }
                            
                            
                        }else{
                        $cover_loc = uploadfiles($_FILES['book_cover'] , array('jpg' , 'jpeg' , 'png') , "cover");

                        if ($cover_loc['status'] == 'error'){
                             $em = $cover_loc['data'];
                                header("LOCATION: ../book-edit.php?error=$em&id=$book_id");
                                exit;
                        }else{
                            $c_p_book_cover = "../uploads/cover/$current_cover";

                            unlink($c_p_book_cover);
                            $cover_url = $cover_loc['data'];
                            

                        $sql = "UPDATE books SET title=? , author_id=? , description=? , category_id=? , cover=?  WHERE id = ?" ;
                        $stmt = $conn ->prepare($sql);
                        $data = $stmt ->execute([$book_title , $book_author , $book_description , $book_category , $cover_url , $book_id]);
                         
                        if ($data){
                                header("Location: ../book-edit.php?success=Successfully updated!&id=$book_id");
                                exit;
                            }else{
                                $em = "Unknown Error Occurred!";
                                header("Location: ../edit-book.php?error=$em&id=$book_id");
                                exit;
                            }
                        }
                    }

                
                
                }else if (!empty($_FILES['file']['name'])) { 
                    $file_loc = uploadfiles($_FILES['file']  ,  array('pdf' , 'docx' , 'pptx') , 'files');
                    $c_p_file = "../uploads/files/$current_FILES";
                    if ($file_loc['status'] == 'error' ){
                        $em = $file_loc['data'];
                            header("LOCATION: ../book-edit.php?error=$em&id=$book_id");
                            exit;
                    }else{
                        $c_p_file = "../uploads/files/$current_FILES";

                        unlink($c_p_file);

                        $file_url = $file_loc['data'];

                    $sql = "UPDATE books SET title=? , author_id=? , description=? , category_id=? , file=?  WHERE id = ?" ;
                    $stmt = $conn ->prepare($sql);
                    $data = $stmt ->execute([$book_title , $book_author , $book_description , $book_category , $file_url , $book_id]);
                     
                    if ($data){
                            header("Location: ../book-edit.php?success=Successfully updated!&id=$book_id");
                            exit;
                        }else{
                            $em = "Unknown Error Occurred!";
                            header("Location: ../edit-book.php?error=$em&id=$book_id");
                            exit;
                        }
                    }   


                }else{
                    $sql = "UPDATE books SET title=? , author_id=? , description=? , category_id=?  WHERE id = ?" ;
                    $stmt = $conn ->prepare($sql);
                    $data = $stmt ->execute([$book_title , $book_author , $book_description , $book_category , $book_id]);
                     
                    if ($data){
                            header("Location: ../book-edit.php?success=Successfully updated!&id=$book_id");
                            exit;
                        }else{
                            $em = "Unknown Error Occurred!";
                            header("Location: ../edit-book.php?error=$em&id=$book_id");
                            exit;
                        }
                    }         


        }else{
            header("Location: ../book-edit.php?error=an error occurred!&id=$book_id");
            exit;
        }

        }else{
            header("Location: ../admin.php?error=id is not allowed in edit book");
            exit;
        }
}else{
    header("Location: login.php");
    exit;
    }
  ?>