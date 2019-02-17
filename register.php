<?php
    session_start();

    require_once('includes/connect.php');
if(isset($_SESSION['connected']) && $_SESSION['connected'] == true){
         $email = $_SESSION['email'];
            $queryMy = "SELECT * FROM login WHERE email='$email'";
            $myProfile = $connection -> query($queryMy);
    }
    if(isset($_POST['save']) ){
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $name = $_POST['name'];
        $motto = $_POST['motto'];
        $mainSkill = $_POST['mainSkill'];
        $location = $_POST['location'];
        $aboutMe = $_POST['aboutMe'];
        $allSkills = $_POST['allSkills'];

        if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
            echo "Please select an avatar";
        }else{
            $image = addslashes($_FILES['image']['tmp_name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
        }

        $insert = "INSERT INTO login (email, password, name, motto, mainSkill, location, aboutme, allskills, avatar) VALUES ('$email', '$password', '$name', '$motto', '$mainSkill', '$location', '$aboutMe', '$allSkills', '$image')";
        $result = mysqli_query($connection, $insert);

        $search = "SELECT * FROM `login` WHERE email='$email' AND password='$password'";
        $result = mysqli_query($connection, $search);
        $count = mysqli_num_rows($result);
        $rows = $connection -> query($search);
        if($rows ->num_rows > 0){
            while($row = $rows -> fetch_assoc()){
                 $_SESSION['id']  = $row['id'];
                 echo $_SESSION['id'];
            }
        }

        if($count == 1){
            $_SESSION['email'] = $email;
            $_SESSION['connected'] = true;
        }
        else{
            $fsmg = "Invalide username/password";

        }

        if($result){
            $smsg = "User registration successfull";
            $id = $_SESSION['id'];
            header("Location: viewProfile.php?post=$id");
        }else{
            $fsmg = "User registration failed";
        }

    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">

    <title>Platform Job</title>
</head>

<body style="overflow: auto;">
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light " style="z-index: 100;">
        <a class="navbar-brand" href="#">Platform Jobs</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link textCap" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link textCap" href="offers.php">View Offers</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle textCap" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        User
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <?php 
                        if(isset($_SESSION['connected']) && $_SESSION['connected'] == true){
                             if($myProfile ->num_rows > 0){
                                 while($row = $myProfile -> fetch_assoc()){    
                        ?>
                        <a class="dropdown-item textCap" href="viewProfile.php?post=<?php echo $row['id']; ?>"> My Profile</a>
                        <a class="dropdown-item textCap" href="logout.php">Logout</a>
                        <?php  } } } else { ?>
                        <a class="dropdown-item textCap" href="login.php">Sign In</a>
                        <a class="dropdown-item textCap" href="register.php">Register</a>
                        <?php } ?>

                    </div>
                </li>

            </ul>
        </div>
    </nav>
    <!-- ./NAVIGATION BAR -->

    <!-- JUMBOTRON -->
    <div class="div" style="background: rgba(0, 89, 255, 0.3);">
        <div class="overlay"></div>
        <img src="assets/bgMain.jpg" alt="" class="imgABS">
        <div class="container">
         <center>
            <h1 class="display-4" style="font-weight: bold;">Register - Platform Jobs</h1>
           
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Your Name</label>
                        <input type="text" class="form-control" id="exampleInputName1"  placeholder="Enter name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputMotto1">Motto</label>
                        <input type="text" class="form-control" id="exampleInputMotto1" placeholder="Enter motto" name="motto">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputMainSkill1">Main Skill</label>
                        <input type="text" class="form-control" id="exampleInputMainSkull1"  placeholder="Enter main skill" name="mainSkill">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputLocation1">Location</label>
                        <input type="text" class="form-control" id="exampleInputLocation1" placeholder="Enter location" name="location">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">About me</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="aboutMe"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea2">All my skills</label>
                        <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" name="allSkills"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Avatar</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                    </div>
                    <?php if(isset($smsg)){ ?> <div class="alert alert-succes" role="alert"> <?php echo $smsg; ?> </div> <?php } ?>
                    <?php if(isset($fsmg)){ ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmg; ?> </div> <?php } ?>
                    <button type="submit" class="btn btn-primary" name="save">Register account</button>
                </form>
            </center>
        </div>
    </div>
    <!-- ./JUMBOTRON -->

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="js/index.js"></script>

</body>

</html>