<?php
        if(!isset($_SESSION)) { 
            session_start(); 
        } 
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
                include "php/functions.php";
                include "db_conn.php";
                $authors =getallauthor($conn);   
                $books =getallbooks($conn);
                $categories =getallcategory($conn); 

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Store</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Book Store</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" 
		             aria-current="page" 
		             href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">Contact</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">About</a>
		        </li>
		        <li class="nav-item">
		          		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
		          
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<form action="search.php"
             method="get" 
             style="width: 100%; max-width: 30rem">

       	<div class="input-group my-5">
		  <input type="text" 
		         class="form-control"
		         name="key" 
		         placeholder="Search Book..." 
		         aria-label="Search Book..." 
		         aria-describedby="basic-addon2">

		  <button class="input-group-text
		                 btn btn-primary" 
		          id="basic-addon2">
		          <img src="img/search.png"
		               width="20">

		  </button>
		</div>
       </form>
		    <div class="d-flex pt-3">
			<div class="pdf-list d-flex flex-wrap">
								
                <?php
                 if ($books != 0){
                    foreach ($books as $book){
                    ?>
                    <div class="card m-1">
					<img src="uploads/cover/<?=$book['cover']; ?>"
					     class="card-img-top" style="height: 40%;">
					<div class="card-body">
						<h5 class="card-title"><?=$book['title'];  ?></h5>
						<p class="card-text">
                            <?php 
                        $author_id = $book['author_id'];
                        if (checkidauthors($author_id , $conn)){
                            if (getauthorbyid($author_id , $conn) != 0){
                                $author_name = getauthorbyid($author_id , $conn)['name'];
                            }else{
                                $author_name = "author name is not found!";
                            }
                            
                        }else{
                            $author_name = "author id is not found";
                        }
                        
                        ?>
                            
                            <i><b>By: <?=$author_name;?> <br></b></i>
							<?=$book['description']; ?>


                            <?php 
                        $Category_id = $book['category_id'];
                        if (checkidcategories($Category_id , $conn)){
                            if (getcategorybyid($Category_id , $conn) != 0){
                                $Category_name = getcategorybyid($Category_id , $conn)['name'];
                            }else{
                                $Category_name = "Category name is not found!";
                            }
                            
                        }else{
                            $Category_name = "Category id is not found";
                        }
                        
                        ?>
                            
                            <br><i><b>Category: <?=$Category_name;?><br></b></i>

						</p>
                       <a href="uploads/files/<?=$book['file']; ?>"
                          class="btn btn-success">Open</a>

                        <a href="uploads/files/<?=$book['file']; ?>"
                          class="btn btn-primary"
                          download="<?=$book['title']?>">Download</a>
					</div>
				</div>

                <?php } ?>

         <?php } ?>
                        
				</div>

                <div class="category">
                <div class="list-group">
                <a href="#"
                   class="list-group-item list-group-item-action active">Category</a>

                <?php
                if ($categories !=0 ){
                    foreach ($categories as $category){  ?>
						
                                  
                   <a href="category.php?id=<?=$category['id']; ?>"
                      class="list-group-item list-group-item-action">
                      <?=$category['name']; ?></a>
                                

<?php
                    }
                }else{ ?>
                                  
                   <a href="#"
                      class="list-group-item list-group-item-action">
                     <small> <?php echo "the category is element!"; ?></a></small>
                      <?php  } ?>
                </div>
		
		

			<!-- List of authors -->
			<div class="list-group mt-5">
								<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>

				   <?php
                if ($authors !=0 ){
                    foreach ($authors as $author){  ?>
                                  
                   <a href="author.php?id=<?=$author['id']; ?>"
                      class="list-group-item list-group-item-action">
                      <?=$author['name']; ?></a>
                                

<?php
                    }
                }else{ ?>
                                  
                   <a href="#"
                      class="list-group-item list-group-item-action">
                     <small> <?php echo "the author is element!"; ?></a></small>
                      <?php  } ?>
                </div>
				   				  
				   
		</div>
	</div>
</body>
</html>


<?php
 }else{
  header("Location: login.php");
  exit;
  }
?>
