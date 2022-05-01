<?php

include("connection.php");
include("style.php");


error_reporting(0);
    $title = $_POST['title'] ?? null; 
    $date_published = $_POST['date_published'] ?? null;
    $authors = $_POST['authors'] ?? null;
    $contents = $_POST['contents'] ?? null;
    $category = $_POST['category'] ?? null;
    $image = $_FILES['files']['name'] ?? null;
    $terms_privacy = $_POST['agree'] ?? null;
    $has_error = 0;
    $error = '';


if(isset($_POST['submit']))
{
    // var_dump($_POST)
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
    if(!isset($terms_privacy) || strlen(trim($terms_privacy))==0){
        $has_error = 1;
        $error_msg .= '&bull; Terms And Privacy is required! <br>';
    }
        if(!isset($image) || strlen(trim($image))==0)
    {
        $has_error = 1;
        $error_msg .= '&bull; Headline Photo is required! <br>';
    } 
    //count total files
    $countfiles = count($_FILES['files']['name']);

    //prepared statement
    $query = "INSERT INTO users (headline_photo, title, author, category, content) VALUES ('$image', '$title', '$authors', '$category', '$contents')";
    $statement = $conn->prepare($query);

    //filename
    $filename = $_FILES['files']['name'];

    //location
    $target_file = "uploads/". $filename;

    //file extension
    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

    //valid file format
    $valid_extension = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp');

    if (in_array($file_extension, $valid_extension) && !empty($image) && !empty($title) && !empty($authors) && !empty($category) && !empty($contents)) 
    {
        //upload file
        if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) 
        {
            //execute query
            $statement->execute(array($filename, $target_file));
            header("Location: success.php");
        }
    }else
        {
            header("Location: error.php");
        }
}
 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article Screen</title>
    <!--Bootstrap Core css and JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Bootstrap Core css and JS-->
</head>

<body style=" background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg')"> 

<div class="container py-5">
    <div class="">

        <?php if($has_error == 1): ?>
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <strong class="">Warning!</strong>
                    <p><?php echo $error_msg?></p>
                </div>
            </div>
        <?php endif; ?>



        <!-- header -->
        <nav class="navbar navbar-light py-6">
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
        <div class="row mb-2" style = "color:#E3735E; font-weight: 500">
            <div class="col">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" >
                    <div class="col p-4 d-flex flex-column position-static" style="background-color: #FFF5EE">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                <div class="py-5 text-center">
                                    <h3 style="color: #7B1818">Write an article</h3>
                                </div> 
                                    <div class="row">   
                                    <!-- title -->
                                    <div class="col-6">
                                            <label for="title" class="form-label">Title <b style="color: #FA5F55">*</b></label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="">                              
                                    </div>
                                    
                                    <!-- date -->
                                    <div class="col-6">
                                       
                                        <label for="date_published" class="form-label">Date <b style="color: #FA5F55">*</b></label>
                                        <input type="date" class="form-text text-muted form-control" id="date_published" name="date_published">                    
                                    </div>
                                    </div>

                                    <div class="row">
                                    <!-- authors-->
                                    <div class="col-6">
                                            <label for="authors" class="form-label">Author(s) <b style="color: #FA5F55">*</b></label>
                                            <input type="text" class="form-control" id="authors" name="authors" placeholder="Name of Authors" value="">
                                    </div>                                       
                                    <!-- category -->
                                    <div class="col-6">
                                        <label for="category" class="form-label">Category <b style="color: #FA5F55">*</b></label>
                                        <select class="form-select" name="category" aria-label="Default select example">
                                            <option selected>Select</option>
                                            <option value="Action">Action</option>
                                            <option value="Drama">Drama</option>
                                            <option value="Sci-Fi">Sci-Fi</option>
                                        </select>
                                    </div>
                                </div>
                                    <!-- contents -->
                                    <div class="col-12 pb-5">                                     
                                            <label for="contents" class="form-label">Contents <b style="color: #FA5F55">*</b></label>
                                            <textarea type="text" class="form-control" rows="9" id="contents" name="contents" placeholder="Write your article here." value=""></textarea>     
                                    </div>

                                    <div class="row">
                                    <!-- headline_photo -->
                                    <div class="col-12">
                                        <label for="headline_photo" class="form-label">
                                            Headline Photo <b style="color: #FA5F55">*</b>
                                        </label>
                                            <div class="text-justified">
                                                <form method="post" action="" enctype="multipart/form-data">
                                                    
                                                    <!-- <input type="submit" name="submit" value="Upload"> -->
                                                </form>

                                                <div class="form-check ">
                                                   
                                                    <label class="form-check-label" for="invalidCheck2">
                                                        <abbr title= "('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp')"><u> <input type="file" name="files"> <u></abbr>
                                                    </label>
                                                </div>
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
                                                Before you continue using our website, we advice you read our privacy policy regarding our user data collection."><u>Terms and Conditions <b style="color: #FA5F55;">*</b><u></abbr>
                                            </label>
                                        </div>
                                    </div>                   
                                    <!-- SUBMIT BUTTON -->
                                    <div class="center pt-2">
                                        <button style="background-color:#D22B2B; border: none" class="btn btn-primary" type="upload" name="submit">Submit</button>
                                    </div>


                                        
                        <form>            
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</div>                       
        
</body>
</html>