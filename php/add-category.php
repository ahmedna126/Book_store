<?php 
    if (!isset($_SESSION)){
        session_start();
    }   

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
            include "../db_conn.php";
            include "functions.php";
            if (isset($_POST['category_name'])){
                if (!empty($_POST['category_name'])){
                    $category_name = validate($_POST['category_name']);

                    $sql = "INSERT INTO categories (name) VALUES (?)";
                        $stmt = $conn ->prepare($sql);
                     $r = $stmt ->execute([$category_name]);

                     if ($r){
                        header("Location: ../add-category.php?success=Successfully updated!");
                        exit;
                     }else{
                        header("Location: ../add-category.php?error=an error occurred!");
                        exit;
                     }


                }else{
                header("Location: ../add-category.php?error=category is required!");
                exit;
            }





            }else{
                header("Location: ../add-category.php?error=an error occurred!");
                exit;
            }





        }else{
            header("Location: login.php");
            exit;
            }
          ?>