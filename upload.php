<?php 

include("connection.php");
include("style.php");

if (isset($_POST['submit'])) {
    //count total files
    $countfiles = count($_FILES['files']['name']);

    //prepared statement
    $query = "INSERT INTO users (headline_photo) VALUES (?)";
    $statement = $conn->prepare($query);

    //loop all files
    for ($i=0; $i < $countfiles; $i++) { 
        //filename
        $filename = $_FILES['files']['name'][$i];

        //location
        $target_file = "uploads/". $filename;

        //file extension
        $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);

        //valid file format
        $valid_extension = array('pdf', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp');

        if (in_array($file_extension, $valid_extension)) {
            //upload file
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {
                //execute query
                $statement->execute(array($filename, $target_file));
            }
            header("Location: success.php");
        }else
        {
            header("Location: error.php");
        }
    }
}


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
    <title>Upload An Article</title>
</head>
<body style=" background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg')"> 
    <div id="box">
    <!-- POST AN ARTICLE -->
    <div id="text" class="col-6">                               
        <div class="text-center">
                        <h3 id="text">
                            Upload an article
                        </h3>
                        <p id="text" style="color: red">
                                ('pdf', 'doc', 'docs', 'docx', 'txt', 'ppt', 'pptx', 'odp', 'key')*
                        </p>
        </div> 
        <div class="text-center">
            <form method="post" action="" enctype="multipart/form-data">
                <input type="file" name="files[]" multiple>
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </div>
    </div>
</body>
</html>