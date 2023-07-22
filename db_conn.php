<?php 


        $host = "localhost";
        $u = "root";    
        $p = '';
        $db_name = "online_book_store_db";

            try{
                    $conn = new PDO("mysql:host=$host;dbname=$db_name" , $u , $p);
                        $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "connection failed! " . $e->getMessage();
            }