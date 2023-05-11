<?php session_start();
    if(!empty($_GET['movie_id'])){
        $_SESSION['movie_id'] = $_GET['movie_id']; 
    }
    $conn = mysqli_connect("localhost","root","","new-gen");
    if(!$conn){
        echo "<script>alert('Database not connected, Contact Admin!!!')</script>";
    }
    $_SESSION['seat'] = "";
    if(isset($_POST['search-submit'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $value = $_POST['search-key'];
            $sql = "SELECT movie_id FROM movie WHERE movie_name = '$value'";
            $res = mysqli_query($conn , $sql);
            if(mysqli_num_rows($res) == 1){
                $row = mysqli_fetch_assoc($res);
                header("location:theater.php?movie_id=".$row['movie_id']);
            }else{
                echo "<script>alert('Movie Name is not Available..');</script>";
            }
        }
    }
?>
<html>
    <head>
        <title><?php $sql = "SELECT movie_name FROM movie WHERE movie_id = '{$_SESSION['movie_id']}'";
                    $res = mysqli_query($conn , $sql);
                    $row = mysqli_fetch_assoc($res);
                    echo $row['movie_name'];
        ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel ="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel ="stylesheet" href = "theater.css">
        <style>
            .links{
                padding : 10px;
                box-shadow :  0 0 10px white;
                margin-left : 10px;
                text-decoration: none;
                border-radius : 10px;
                color :white;
                text-shadow : 0 0 10px blue;
                width : 60%;
            }
            @keyframes link-name {
                0%{box-shadow:0 0 20px limegreen;border:2px solid limegreen;}
                50%{box-shadow:0 0 20px white;border:2px solid white;}
                100%{box-shadow:0 0 20px limegreen;border:2px solid limegreen;}
            }
            .link-name{
                margin : auto;
                padding : 10px;
                text-align : left;
                margin-top : 40px;
                width : 60%;
                background-color:rgba(0,0,0,0.6);
                color:violet;
                animation-name:link-name;
                animation-duration:2s;
                animation-iteration-count: infinite;
            }
            .link-container{
                text-align : center;
                height : 600px;
            }
            .link-container a{
                font-family : monospace;
                color:dodgerblue;
                border-radius : 20px;
                background-color:rgba(0,0,0,0.6);
            }
            .link-container a:hover{
                width : 30px;
                box-shadow:0 0 10px dodgerblue;
                background-color:transparent;
                color:limegreen;
            }
            @keyframes h1{
                0%{color: limegreen;font-size:30px;text-shadow:0 0 10px limegreen;}
                50%{color: white;font-size:32px;text-shadow:0 0 10px white;}
                100%{color: limegreen;font-size:30px;text-shadow:0 0 10px limegreen;}
            }
            .content h1{
                text-align:center;
                animation-name:h1;
                animation-duration:2s;
                animation-iteration-count: infinite;
            }
        </style>
    </head>
    <body>
        <header>
        <div class = header >
            <label class = "logo"><a style = "color: blueviolet; text-decoration: none;"href = "home.html">New-Gen</a></label>
           <form  id = "myForm" method = "POST"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <label  class = "search-box"><input type = "text" name = "search-key" placeholder="Search for movies  ... "> </label>
                <label class = "search-button"   ><button onclick= "col3()" type="submit" name = "search-submit"><i class = "fa fa-search"></i></button></div>
            </form>
            <span class = "username" ><a href='logout.php'><p><?php echo $_SESSION['username'];?>  <i class ="fa fa-sign-out"></i></p></a></label>  
        </div>
        </header>
        <content>
            <div class = "content">
                <h1>Select Your Theater...</h1>
                <div class = "theater-box">
                        <p class = "theater-container">
                            <?php
                                $sql = "SELECT cast(shows.show_date_time as time)time, theater.theater_name , theater.theater_rating , shows.show_id ,shows.social_distancing, screen.screen_no 
                                FROM screen , theater , shows 
                                WHERE shows.movie_id = '{$_SESSION['movie_id']}' 
                                and theater.theater_id = shows.theater_id 
                                and screen.screen_id = shows.screen_id ";
                                $prev = "";
                                $res = mysqli_query($conn , $sql);
                                if(mysqli_num_rows($res) > 0){
                                   echo "<div class = 'link-container'>";
                                    while($row = mysqli_fetch_assoc($res)){
                                        if($prev != $row['theater_name']){
                                            echo "<br><p class ='link-name'>Theater Name : ".$row['theater_name']."<br>
                                            Theater Rating : ".$row['theater_rating']."<br>
                                            Screen No : ".$row['screen_no']."<br>Social Distancing Seats : ".$row['social_distancing']."</p><br><a class ='links' href = 'seat.php?show_id=".$row['show_id']."'>".$row['time']."</a>";
                                        }else{
                                            echo "<a align ='center' class='links' href = 'seat.php?show_id=".$row['show_id']."'>".$row['time']."</a>";
                                        }
                                        $prev = $row['theater_name']; 
                                    }
                                    echo "</div>";                             
                                }
                            ?>
                        </p>
                </div>
            </div>
        </content>
    </body>
</html>