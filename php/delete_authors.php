<?php 


if (!isset($_SESSION)){
    session_start();
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
        include "../db_conn.php";
        include "functions.php";
            if (isset($_GET['id'])){
                    $id = validate($_GET['id']);
                        $sql = "DELETE FROM authors WHERE id = ?";
                            $stmt = $conn ->prepare($sql);
                            $stmt->execute([$id]);
                            header("location: ../admin.php?success=Successfully deleted!");
                            exit();

            }else{
                header("location: ../admin.php?error=an error occurred in delete author");
                exit;
            }
            



}else{
    header("Location: ../login.php");
    exit;
  } 