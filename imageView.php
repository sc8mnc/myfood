<?php include 'protect.php'?>
<?php
// Include config file
require_once "connect-db.php";
if (isset($_GET['recipe_id'])){
        //$picture = file_get_contents($_FILES['picture']["tmp_name"]);        
        //$photo_mime = $_FILES['picture']["type"]; 
        $id = mysqli_real_escape_string($db,$_GET['recipe_id']);
        $sql = "SELECT picture FROM recipe_pictures WHERE recipe_id = '$id'";
        $query = mysqli_query($db,$sql);
        $result="";
        $row = mysqli_fetch_assoc($query);
        $result = $row["picture"]; 
        header("content-type: image/jpeg");
        echo $result;
        // while ($row = mysqli_fetch_assoc($query))
        // {
        //     $result = $row["picture"];
      
        // }
        // header("content-type: image/jpeg");
        // echo $row['picture'];
        // if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            // mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // // Set parameters
            // $param_recipe_id = $_GET['recipe_id'];
          
            // Attempt to execute the prepared statement
            // if(mysqli_stmt_execute($stmt)){
            //     // Redirect to login page
            //     // header("location: landing.php");
            //     $result = $stmt->get_result();
            //     $row = $result->fetch_assoc();
            //     $picture = $row->picture;
            //     echo $picture;
            //     // $result    = ibase_query("SELECT picture FROM recipe_pictures WHERE recipe_id = $_GET['recipe_id']");
            //     // $image="";
            //     // while ($row=ibase_fetch_object($result))
            //     // {
            //     //     $image = ibase_blob_get($blob_hndl,8192);
            //     //     while($data = ibase_blob_get($blob_hndl, 8192)){
            //     //         $image .= $data;
            //     //     }
            //     // }
            //     // //$data      = ibase_fetch_object($result);
            //     // $blob_data = ibase_blob_info($image->BLOB_VALUE);
            //     // $blob_hndl = ibase_blob_open($image->BLOB_VALUE);
            //     // print         ibase_blob_get($blob_hndl, $blob_data[0]);
            //     // ibase_blob_close($blob_hndl); 
            //     //header("Content-type: image/jpeg");
            //     echo "data:image/jpeg;base64,'.base64_encode($picture).'";
            // } else{
            //     echo "Oops! Something went wrong. Please try again later.";
            // }

            // Close statement
            // mysqli_stmt_close($stmt);
        // }
    }
?>
