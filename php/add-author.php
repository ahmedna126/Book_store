<?php 
    if (!isset($_SESSION)){
        session_start();
    }   

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
            include "../db_conn.php";
            include "functions.php";
            if (isset($_POST['author_name'])){
                if (!empty($_POST['author_name'])){
                    $author_name = validate($_POST['author_name']);

                    $sql = "INSERT INTO authors (name) VALUES (?)";
                        $stmt = $conn ->prepare($sql);
                     $r = $stmt ->execute([$author_name]);

                     if ($r){
                        header("Location: ../add-author.php?success=Successfully updated!");
                        exit;
                     }else{
                        header("Location: ../add-author.php?error=an error occurred!");
                        exit;
                     }


                }else{
                header("Location: ../add-author.php?error=author is required!");
                exit;
            }

            }else{
                header("Location: ../add-author.php?error=an error occurred!");
                exit;
            }





        }else{
            header("Location: login.php");
            exit;
            }
          ?>