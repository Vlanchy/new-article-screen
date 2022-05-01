<?php

include("connection.php");
include("style.php");

    // var_dump($_SERVER["REQUEST_METHOD"]);
    $postArticle = $_POST['postArticle'] ?? null;
    $error_msg = '';

    // var_dump($_POST);
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!isset($postArticle) || strlen(trim($postArticle))==0)
        {
            $has_error = 1;
            $error_msg .= '&bull; Review terms and condition <br>';
        }
    }

 // var_dump($_SERVER["REQUEST_METHOD"]);
error_reporting(0);
 $title = $_POST['title'] ?? null; 
 $date_published = $_POST['date_published'] ?? null;
 $authors = $_POST['authors'] ?? null;
 $contents = $_POST['contents'] ?? null;
 $has_error = 0;
 $error_msg = '';
 

 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
    if(!isset($title) || strlen(trim($title))==0)
    {
        $has_error = 1;
        $error_msg .= '&bull; Title is required! <br>';
    } 
    if(!isset($date_published) || strlen(trim($date_published))==0)
    {
        $has_error = 1;
        $error_msg .= '&bull; Date is required! <br>';
    } 
    if(!isset($authors) || strlen(trim($authors))==0)
    {
        $has_error = 1;
        $error_msg .= '&bull; Authors is required! <br>';
    } 
    if(!isset($contents) || strlen(trim($contents))==0)
    {
        $has_error = 1;
        $error_msg .= '&bull; Contents is required! <br>';
    }

    if(!empty($title && !empty($authors) && !empty($contents)))
    {
            //save to database
        $query = "INSERT INTO users (title, author, content) VALUES ('$title', '$authors', '$contents')";
       
        if ($conn-> query($query) === TRUE) 
        {
        } else 
        {
            header("Location: finish.php");
        }
    }
}
      //var_dump($_POST);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap Core css and JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Bootstrap Core css and JS-->
    <title>New Article Screen</title>
</head>

<body style=" background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg')"> 

<div class="container">
    <div class="">


        <!-- alerts -->
        <?php if($has_error == 1): ?>
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <strong class="">Warning!</strong>
                    <p><?php echo $error_msg?></p>
                </div>
            </div>
        <?php endif; ?>


        <!-- header -->
        <nav class="navbar navbar-light">
        <img src="https://www.pngarts.com/files/3/Logo-PNG-Transparent-Image.png" height= "150" width= "50" class="img-fluid" alt="...">
            <h3>New Article Screen</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--offcanvas  -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Article Screen</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                        <?php echo '<br>'?>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                </div>
            </div>
        </nav>

        <!-- body -->

  
        <!-- upload article -->
        <div class="row mx-3">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static" style="background-color: white">

                    <div class="py-5 text-center">
                        <h3>Write an article</h3>
                    </div> 
                        <div class="row">
                            <!-- title -->
                            <div class="col-6">
                                <div class="<?php echo ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( !isset($title) || strlen(trim($title)) == 0 ) ? 'has_error' : '' ); ?>">                        
                                    <label for="title" class="form-label">Title*</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title;?>">
                                </div>
                            </div>
                            
                            <!-- birthday -->
                            <div class="col-6">
                                <div class="<?php echo ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( !isset($date_published) || strlen(trim($date_published)) == 0 ) ? 'has_error' : '' ); ?>">
                                <label for="date_published" class="form-label">Date*</label>
                                <input type="date" class="form-text text-muted form-control" id="date_published" name="date_published">
                            </div>
                        </div>
                            <!-- authors format: see pic in mssngr -->
                            <div class="col-12">
                                <div class="<?php echo ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( !isset($authors) || strlen(trim($authors)) == 0 ) ? 'has_error' : '' ); ?>">                        
                                    <label for="authors" class="form-label">Author(s)*</label>
                                    <input type="text" class="form-control" id="authors" name="authors" placeholder="Name of Authors" value="">
                                </div>
                            </div>


                            <div class="row mt-3">
                              
                            <!-- category -->
                            <div class="col-6">
                                <label for="category" class="form-label">Category </label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Select</option>
                                    <option value="1">Action</option>
                                    <option value="2">Drama</option>
                                    <option value="3">Sci-Fi</option>
                                    </select>
                            </div>
                        
                            <div class="col-12">
                                <div class="<?php echo ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( !isset($contents) || strlen(trim($contents)) == 0 ) ? 'has_error' : '' ); ?>">                        
                                    <label for="contents" class="form-label">Contents*</label>
                                    <input type="text" class="form-control" id="contents" name="contents" placeholder="Write your article here." value="">
                                </div>
                            </div>
                            
                            <!-- TERMS OF SERVICE -->
                    
                    <div class="col-12 mt-5">
                        <div class="form-check ">
                          <input class="form-check-input" type="checkbox" value="0" id="invalidCheck2" name="agree">
                          <label class="form-check-label" for="invalidCheck2">
                            I Agree to <abbr title= "TERMS AND CONDITIONS:  
        Please read these terms and conditions carefully before submiting this form.
By using the website, you certify that your have read and reviewed this agreement and that you agree to comply with this terms.
Before you continue using our website, we advice you read our privacy policy regarding our user data collection."><u>Terms and Conditions<u></abbr>
                          </label>
                        </div>
                    </div>
                    
                    <!-- SUBMIT BUTTON -->
                    
                    <div class="center">

                        <button class="btn btn-primary" type="submit" >Submit</button>
                    </div>
                    <div class="py-5 text-center">
                        <h3>Upload an Article.</h3>
                    </div> 
                    <div class="col-6">                               
                                <label for="bday" class="form-label">Upload An Article.</label>
                                <div id="button" class="text">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <a id="button" class="text-center" style="color: white" href="upload.php">Click Here to Upload.</a>
                                </form>
                                </div>
                            </div>  

                    </div>
                </div>
            </form>
        </div>
</body>
</html>