<?php
    session_start();

    require_once('includes/connect.php');

    $search = "SELECT * FROM `login`";
    $rows = $connection -> query($search);
    if(isset($_SESSION['connected']) && $_SESSION['connected'] == true){
         $email = $_SESSION['email'];
            $queryMy = "SELECT * FROM login WHERE email='$email'";
            $myProfile = $connection -> query($queryMy);
    }
    if(isset($_POST['addUser'])){
        $idUser = $_POST['addUser'];
        $idCompany = $_SESSION['id'];
        $insert = "INSERT INTO notifications (userID, companyID) VALUES ('$idUser', '$idCompany')";
        $result = mysqli_query($connection, $insert);
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

<body class="">
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
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

    <div class="container-fluid offerContainer">
        <div class="row">
            <div class="col-md-12">
                <div class="text">
                    All offers here 
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <?php
             if($rows ->num_rows > 0){
                while($row = $rows -> fetch_assoc()){
                ?>
                 <div class="col-md-12 card-offer">
                    <div class="title">
                        <?php echo $row['mainskill']; ?>
                    </div>
                    <div class="name">
                        @<?php echo $row['name']; ?>
                    </div>
                    <div class="shortDesc">
                        <?php 
                        $body =  $row['aboutme'];
                        echo substr($body, 0, 400); 
                        echo "...";
                        ?>                        
                    </div>
                    <a href="viewProfile.php?post=<?php echo $row['id'] ?>">
                    <div class="btn btn-primary btn-offer">
                        Show more
                    </div>
                    </a>
                    <form method="post" class="disable">
                        <button class="btn btn-danger btn-add " type="submit" name="addUser" value="<?php echo $row['id'] ?>">
                            Add 
                        </button>
                    </form>
                </div>
                <?php
                }
             }
            ?>
           
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="js/index.js"></script>

</body>

</html>