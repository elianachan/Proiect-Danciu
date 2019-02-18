<?php
    session_start();
    require_once('includes/connect.php');

     if(isset($_SESSION['connected']) && $_SESSION['connected'] == true){
         $email = $_SESSION['email'];
        $queryMy = "SELECT * FROM login WHERE email='$email'";
        $myProfile = $connection -> query($queryMy);
         
        if(isset($_GET['post'])){
            
            $id = mysqli_real_escape_string($connection, $_GET['post']);
            $nameCompany = mysqli_real_escape_string($connection, $_GET['name']);

            $query = "SELECT * FROM company WHERE id='$id' AND name='$nameCompany'";
            $profileRows = $connection -> query($query);
         }
    }else{
        $smsg = "You are not logged in";
        header('Location: loginCompany.php');
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle textCap" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Company
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php 
                        if(isset($_SESSION['connected']) && $_SESSION['connected'] == true){
                             if($myProfile ->num_rows > 0){
                                 while($row = $myProfile -> fetch_assoc()){    
                        ?>
                        <a class="dropdown-item textCap" href="viewProfile.php?post=<?php echo $row['id']; ?>"> My Profile</a>
                         <a class="nav-link dropdown-toggle textCap colorBlack" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Notifications
                            </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                   <?php  if($notifications ->num_rows > 0){
                                            while($row2 = $notifications -> fetch_assoc()){ 
                                                $idCom = $row2['companyID'];
                                                $queryCom = "SELECT * FROM company WHERE id='$idCom'";
                                                $company = $connection -> query($queryCom);
                                                if($company ->num_rows > 0){
                                                    while($row3 = $company -> fetch_assoc()){ 
                                    ?>
                                        <a class="dropdown-item textCap" href="#">Offer from company: <?php echo $row3['name'] ?> </a>
                                    <?php } } } }?>
                                 </div>
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
                <div class="name">
                    <?php 
                     if($profileRows ->num_rows > 0){
                            while($row = $profileRows -> fetch_assoc()){
                    ?>@<?php echo $row['name']; ?>

                   
                </div>
               
            </div>
        </div>
    </div>
    <div class="container mt-50">

    
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        Company Description
                    </button>
                </h5>
            </div>
    
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                   <?php echo $row['description']; ?>
                </div>
            </div>
        </div>
      
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        Contact
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                  <?php echo $row['contact']; ?>
        
                </div>
            </div>
        </div>
    </div>
</div>
       <?php
                            }
                        }
                    ?>
    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="js/index.js"></script>

</body>

</html>