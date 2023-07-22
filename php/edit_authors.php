<?php 


if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
    if (isset($_POST['author_id']) && isset($_POST['author_name']) ){
    include "functions.php";
    include "../db_conn.php";
        
    $author_id = filter_var( $_POST['author_id'] , FILTER_SANITIZE_NUMBER_INT);
        if (checkidauthors($author_id , $conn)){
    $author_name= validate($_POST['author_name']);

            $sql= "UPDATE authors SET name = ? WHERE id = ?;";
            $stmt = $conn->prepare($sql);
            $stmt ->execute([$author_name , $author_id]);
            header("location: ../edit_authors.php?success=Successfully updated!&id=$author_id");
                exit();


            }else{
                header("Location: ../admin.php?error=id is not allowed in edit author");
                exit;
            }
}else{
    header("location: ../edit_authors.php?error=an error occurred");
    exit;
  } 

}else{
    header("Location: ../login.php");
    exit;
  } 