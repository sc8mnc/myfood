<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="The MyFood Message Board">      
  <title>MyFood - Message Board</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Icon from https://www.clipsafari.com/clips/o237408-sprouting-green-leaves -->
  <link rel="icon" type="image/png" href="images/siteicon.png" />

  <style>
    .addmsg {
        justify-content: center;
        margin-bottom: 50px;
    }

    .submit {
        float: right;
        width: 12%;
        height: 25%;
        margin-top: 2%;
    }

    .messages {
        margin-left: 15%;
        margin-right: 15%;
    }

    .messages .card {
        margin-top: 45px;
        background: #E8f1e8;
    }

    .card-img {
        width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .poster {
        font-weight: bold;
    }

    .msgnopic {
        padding-left: 20px;
        padding-right: 20px;
    }

    </style>

    <?php 
        // Include config file
        require_once "connect-db.php";
    ?>

</head>

<body>

    <div class="fixed-top">
    <?php include 'protect.php'?>
        <?php include('site_heading.html') ?>
        <?php include('navbar.html') ?>
        
    </div>

    <div style="padding-top:225px;">

    </div>
    
    <?php
        $message_err = "";

        if (isset($_POST['msg'])) {
            // Check if message is empty
            if(empty(trim($_POST['msg']))){
                $message_err = "Please enter a message.";
            }

            // Check input errors before updating the database
            if(empty($message_err)){ 
                $msg = $_POST['msg'];
                $userid = $_SESSION['id'];
                // Prepare an insert statement
                $sql = "INSERT INTO board_message (message_text) VALUES (?)";
                
                if($stmt = mysqli_prepare($db, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_message);
                    
                    // Set parameters
                    $param_message = $msg;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Retrieve message id based on latest added message
                        $latest_msg_row = mysqli_query($db, "SELECT message_id FROM board_message ORDER BY message_id DESC LIMIT 1");
                        $msgid = mysqli_fetch_row($latest_msg_row)[0];

                        // Link user and message ids
                        mysqli_query($db, "INSERT INTO posts (user_id, message_id) VALUES ($userid, $msgid)");
                    } else{
                        echo "Your post could not be added at this time.";
                    }

                // Close statement
                mysqli_stmt_close($stmt);
                }
            }
        }
    ?>

    <!-- Add Message Textbox -->
    <div class="row addmsg text-right">
        <form class="col-sm-8 mb-3" method="post">
            <label for="msg" class="form-label">Post on the MyFood message board!</label>
            <textarea class="form-control" name="msg" maxlength="255" rows="3"></textarea>
            <span class="text-danger"><?php echo $message_err; ?></span>
            <button type="submit" name="submit" class="submit btn btn-primary">Post</button>
        </form>
    </div>
    
    <!-- Board messages -->
    <div class="messages">
    <?php
        // Get all messages and data
        $message_rows = mysqli_query($db, "SELECT * FROM board_message ORDER BY message_id DESC");
        foreach ($message_rows as $message) {
            $msgid = $message['message_id'];
            $msgtxt = $message['message_text'];
            $msgtime = $message['timestamp'];
            // Get poster's username
            $poster_rows = mysqli_query($db, "SELECT username FROM user where user_id=
                                                (SELECT user_id FROM posts where message_id=$msgid);");
            $poster_username = mysqli_fetch_row($poster_rows)[0];
            // Check if message has a picture
            $haspic = false;
            $pic_rows = mysqli_query($db, "SELECT picture FROM board_pictures WHERE message_id=$msgid");
            if (mysqli_num_rows($pic_rows) != 0) {
                $haspic = true;
                // Save the picture
                $msgpic = mysqli_fetch_row($pic_rows)[0];
            }
            // Messages w/ pics
            if ($haspic) { ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="images/genericrecipe.jpg" class="card-img img-fluid rounded-start" alt="<?= $msgpic ?>">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h4 class="card-title poster"><?= $poster_username ?></h4>
                                <p class="card-text"><small class="text-muted"><?= $msgtime ?></small></p>
                                <p class="card-text"><?= $msgtxt ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            
            // Messages w/o pics
            else { ?>
                <div class="card mb-3 msgnopic">
                    <div class="row g-0">
                        <div class="card-body">
                            <h4 class="card-title poster"><?= $poster_username ?></h4>
                            <p class="card-text"><small class="text-muted"><?= $msgtime ?></small></p>
                            <p class="card-text"><?= $msgtxt ?></p>
                        </div>
                    </div>
                </div>
            <?php 
            }
        }
    ?>


    </div>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>