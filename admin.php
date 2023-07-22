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
	<title>ADMIN</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="admin.php">Admin</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-book.php">Add Book</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-category.php">Add Category</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-author.php">Add Author</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="logout.php">Logout</a>
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
       <div class="mt-5"></div>
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>

            <?php  if ($books == 0 ){ ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			  There is no book in the database in books
		  </div>
                <?php } ?>

        <!-- List of all books -->
		<?php if ($books!=0){ ?>

		<h4>All Books</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th>Description</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
            <?php $i=0; ?>
            <?php foreach($books as $book){  ?>
			<tbody>
			  

			  <tr>
                    <?php $i++; ?>
				<td>  <?=$i; ?></td>
				<td>
					<img width="100"
					     src="uploads/cover/<?=$book['cover']; ?>" >
					<a  class="link-dark d-block
					           text-center" 
					    href="uploads/files/<?=$book['file']; ?>" target="_blank">
                        <?=$book['title']; ?>
                    </a>
						
				</td>
                <?php 
                if ($authors == 0 || $authors == 'null' || $book['author_id']==0){
                    $author_name= "Undefined";
                }else{
                    $author_id = $book['author_id']; 
                    $authors = getallauthor($conn);
                    $author_name = getauthorbyid($author_id , $conn);
                    if ($author_name !=0){
                        $author_name = $author_name['name'];
                        }else{
                            $author_name= "Undefined";
                        }
                }
                

                    ?>
				<td>

					<?=$author_name;?>
				</td>
				<td><?=$book['description']; ?></td>
				
                <?php 
                 if ($categories == 0 || $categories == 'null' || $book['category_id']==0){
                    $category_name= "Undefined";
                }else{
                    $category_id = $book['category_id']; 
                    $categorys = getallcategory($conn);
                    $category_nameo = getcategorybyid($category_id , $conn);
                    if ($category_nameo !=0){
                    $category_name = $category_nameo['name'];
                    }else{
                        $category_name= "Undefined";
                    }
                }
                    ?>
				<td>
                <?=$category_name; ?>
				</td>
				<td>
					<a href="book-edit.php?id=<?=$book['id']; ?>" 
					   class="btn btn-warning">
					   Edit</a>

					<a href="php/book-delete.php?id=<?=$book['id']; ?>" 
					   class="btn btn-danger">
				       Delete</a>
				</td>
			  </tr>
              <?php } ?>
			</tbody>
		</table>
		<?php } ?>

            <?php  if ($categories == 0 ){ ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			  There is no category in the database in categories
		    </div>
            <?php } ?>

            <!-- List of all categories -->
			<?php if ($categories!=0){ ?>

		<h4 class="mt-5">All Categories</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Category Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

            
            <?php $i=0; ?>
            
            <?php foreach($categories as $category){ ?>

				<tr>
                        <?php $i++; ?>
					<td><?=$i; ?></td>
					<td><?=$category['name'];?></td>
					<td>
						<a href="category_edit.php?id=<?=$category['id']; ?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete_category.php?id=<?=$category['id']; ?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
                <?php } ?>
			</tbody>
		</table>
		<?php }?>

        <?php  if ($authors == 0 ){ ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			  There is no author in the database in authors
		    </div>
                <?php  } ?>
            <!-- List of all Authors -->

			<?php if ($authors!=0){ ?>
            <h4 class="mt-5">All Authors</h4>
         <table class="table table-bordered shadow">
			<thead>
				<tr>
                    
					<th>#</th>
					<th>Author Name</th>
					<th>Action</th>
				</tr>
			</thead>
            <?php $i=0 ; ?>
                    <?php foreach($authors as $author){ ?>
                        <?php $i++;?>
			<tbody>
				

				<tr>
					<td><?=$i; ?></td>
					<td><?=$author['name']; ?></td>
					<td>
						<a href="edit_authors.php?id=<?=$author['id']; ?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete_authors.php?id=<?=$author['id'];?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
                    <?php }?>
            </tbody>
		</table> 
    <?php } ?>
    </div>
</body>
</html>
<?php
 }else{
  header("Location: login.php");
  exit;
  }
?>