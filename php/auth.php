<?php 
        if (isset($_POST['email']) && isset($_POST['password'])){
                    include "functions.php"; 
                    include "../db_conn.php";   

                $email = validate($_POST['email']);
                $pass = validate($_POST['password']);

                is_empty($email , "email" , '../login.php' , "error" ,'');

                is_empty($pass , "password" , "../login.php" , "error" , "&email=$email");
                include "../db_conn.php";   
                    $sql = "SELECT * FROM admin WHERE email= ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$email]);
                    
                    if ($stmt->rowCount() == 1){
                        $user = $stmt->fetch();
                        $user_id = $user['id'];
                        $user_name = $user['full_name'];
                        $user_email = $user['email'];
                        $user_pass = $user['password'];

                        if ($email == $user_email){
                            if (password_verify($pass , $user_pass)){
                                session_start();
                                session_regenerate_id();
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['user_email'] = $user_email;
                                header("LOCATION: ../admin.php");

                            }else{
                                header("LOCATION: ../login.php?error=incorrect email or password&email=$email");
                                exit;
                            }

                        }else{
                            header("LOCATION: ../login.php?error=incorrect email&email=$email");
                            exit;
                        }
                            
                    }else{
                        header("LOCATION: ../login.php?error=incorrect email&email=$email");
                        exit;
                    }

        }else{
            header("LOCATION: ../login.php");
            exit();
        }
    