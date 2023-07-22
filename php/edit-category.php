<?php 


if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
    if (isset($_POST['category_id']) && isset($_POST['category_name']) ){
    include "functions.php";
    include "../db_conn.php";
    $category_id = filter_var( $_POST['category_id'] , FILTER_SANITIZE_NUMBER_INT);
    if (checkidcategories($category_id , $conn)){


                $category_name= validate($_POST['category_name']);

            $sql= "UPDATE categories SET name = ? WHERE id = ?;";
            $stmt = $conn->prepare($sql);
            $stmt ->execute([$category_name , $category_id]);
            header("location: ../category_edit.php?success=Successfully updated!&id=$category_id");
                exit();


            }else{
                header("Location: ../admin.php?error=id is not allowed in edit category");
                exit;
            }
}else{
    header("location: ../category_edit.php?error=an error occurred");
    exit;
  } 

}else{
    header("Location: ../login.php");
    exit;
  } 