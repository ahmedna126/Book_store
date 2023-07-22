<?php 
    if (!isset($_SESSION)){
        session_start();
    }   

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {               
            include "db_conn.php";
            include "php/functions.php";
            if (isset($_GET['id'])){
				$book_id = filter_var( $_GET['id'] , FILTER_SANITIZE_NUMBER_INT);

				if (checkidbooks($book_id , $conn)){
                $id = validate($_GET['id']);
                $books = getallbooks($conn);
                    $data_book = getbookbyid($id , $conn);

                    $authors = getallauthor($conn);
                    $categories = getallcategory($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Book</title>

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

		 

     <form action="php/edit-book.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Edit Book
     	</h1>

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

     			<div class="mb-3">
		    <label class="form-label">
		           Book Title
		           </label>
		    <input type="text" 
		           hidden
		           value="<?=$id; ?>" 
		           name="book_id">

		    <input type="text" 
		           class="form-control"
		           value="<?=$data_book['title']; ?>" 
		           name="book_title">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Description
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=$data_book['description']; ?>"
		           name="book_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Author
		           </label>
		    <select name="book_author"
		            class="form-control">
		    	    <option value="0">
		    	    	Select author
		    	    </option>
                        <?php 
                            if($authors !=0 ){
                                    $i=0;
                                foreach($authors as $author){
                                    $i++;
                                    if ($author['id'] == $data_book['author_id']){
                                        echo "<option selected value='$i'>" . $author['name'] . "</option>";
                                    }else{
                                        echo "<option value='$i'>" . $author['name'] . "</option>";
                                    }
                                 }

                            }else {
                                $aa = "not found";
                            }
                        ?>
                    
		    	         </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Category
		           </label>
		    <select name="book_category"
		            class="form-control">
		    	    <option value="0">
		    	    	Select category
		    	    </option>
            <?php 
                    if($categories !=0 ){
                            $i=0;
                        foreach($categories as $category){
                            $i++;
                            if ($category['id'] == $data_book['category_id']){
                                echo "<option selected value='$i'>" . $category['name'] . "</option>";
                            }else{
                                echo "<option value='$i'>" . $category['name'] . "</option>";
                            }
                            }

                    }else {
                        $aa = "not found";
                    }
                ?>
         </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Cover
		           </label>


		    <input type="file" 
		           class="form-control" 
		           name="book_cover">

		     <input type="text" 
		           hidden
		           value="<?=$data_book['cover']; ?>" 
		           name="current_cover">

		    <a href="uploads/cover/<?=$data_book['cover']; ?>"
		       class="link-dark">Current Cover</a>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           File
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="file">

		     <input type="text" 
		           hidden
		           value="<?=$data_book['file']; ?>" 
		           name="current_file">

		    <a href="uploads/files/<?=$data_book['file']; ?>"
		       class="link-dark">Current File</a>
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Update</button>
     </form>
	</div>
</body>
</html>

<?php
        }else{
            header("Location: ../admin.php?error=id is not allowed in edit book");
			exit;
		}
		}else{
			header("Location: admin.php?error=id book is required");
				exit;
		}

}else{
  header("Location: login.php");
  exit;
  }
?>