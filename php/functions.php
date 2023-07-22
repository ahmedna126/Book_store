<?php   

        function checkidbooks ($id , $conn ){
                $sql = "SELECT * FROM books WHERE id=? ";
                    $stmt = $conn ->prepare($sql);
                    $stmt->execute([$id]);
                    if ($stmt->rowCount() >= 1 ){
                        return 1;
                    }else{
                        return 0;
                    }
        }

        function checkidcategories ($id , $conn ){
            $sql = "SELECT * FROM categories WHERE id=? ";
                $stmt = $conn ->prepare($sql);
                $stmt->execute([$id]);
                if ($stmt->rowCount() >= 1 ){
                    return 1;
                }else{
                    return 0;
                }
    }

    function checkidauthors ($id , $conn ){
        $sql = "SELECT * FROM authors WHERE id=? ";
            $stmt = $conn ->prepare($sql);
            $stmt->execute([$id]);
            if ($stmt->rowCount() >= 1 ){
                return 1;
            }else{
                return 0;
            }
}

        function validate($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            return $data ;
        }

        function is_empty($var , $text , $location , $ms , $data ){
                if (empty($var)){
                    $em = "the $text is required";
                    header("LOCATION: $location?$ms=$em$data");
                    exit();
                }else{
                    return 0;
                }
        }


        function getallbooks ($conn){
            $sql = "SELECT * FROM books ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

                if ($stmt->rowcount() >= 1){
                    $books = $stmt->fetchAll();
                }else {
                    $books = 0;
                }
                return $books;
        }

        function getallcategory ($conn){
            $sql = "SELECT * FROM categories ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

                if ($stmt->rowcount() >= 1){
                    $categories = $stmt->fetchAll();
                }else {
                    $categories = 0;
                }
                return $categories;
        }


        function getallauthor ($conn){
            $sql = "SELECT * FROM authors ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

                if ($stmt->rowcount() >= 1){
                    $authors = $stmt->fetchAll();
                }else {
                    $authors = 0;
                }
                return $authors;
        }


        function getauthorbyid ($id , $conn){
            $sql = "SELECT * FROM authors WHERE id= ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

                if ($stmt->rowcount() == 1){
                    $author = $stmt->fetch();
                }else {
                    $author = 0;
                }
                return $author;
        }


        function getcategorybyid ($id , $conn){
            $sql = "SELECT * FROM categories WHERE id= ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

                if ($stmt->rowcount() == 1){
                    $category = $stmt->fetch();
                }else {
                    $category = 0;
                }
                return $category;
        }

        function getbookbyid ($id , $conn){
            $sql = "SELECT * FROM books WHERE id= ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

                if ($stmt->rowcount() == 1){
                    $book = $stmt->fetch();
                }else {
                    $book = 0;
                }
                return $book;
        }

