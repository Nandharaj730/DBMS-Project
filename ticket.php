<?php 
    session_start();
    $conn = mysqli_connect('localhost','root','','new-gen');
    if(!$conn){
        echo "<script>alert('Unable to connect the database!!!');</script>";
    }
    if(!empty($_GET['seat'])){
        $seat = $_GET['seat'];
    }
    if(!empty($_GET['rating'])){
        $rate = $_GET['rating'];
        $sql = "SELECT movie_rating , no_of_rating FROM movie WHERE movie_id = '{$_SESSION['movie_id']}'";
        $res = mysqli_query($conn , $sql);
        while($row = mysqli_fetch_assoc($res)){
            $rate = $rate + $row['movie_rating'];
            $count = $row['no_of_rating']+1;
            $sql2 = "UPDATE movie SET movie_rating = $rate/2 , no_of_rating = $count WHERE movie_id = '{$_SESSION['movie_id']}'";
            if(mysqli_query($conn , $sql2)){
                header('location: dashboard.php');
                echo "<script>alert('Thanks For Your Rating...');</script>" ;
            }
        }
    }
?>
<html>
    <head>
        <title>Congratulation....</title>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <link rel='stylesheet' href = 'ticket.css'>
       
    </head>
    <body>
        <div class='content'>
            <h1>Your Ticket has been Booked Successfully.</h1>
            <div class='icon'><i class="far fa-check-circle"></i></div>
                <table class='result'>
                    <tr>
                        <td>Customer Name </td>
                        <td><?php echo $_SESSION['username']; $arr = array($_SESSION['show_id']); ?></td>
                    </tr>
                    <tr>
                        <td>Movie Name </td>
                        <td><?php $sql="SELECT movie_name FROM movie WHERE movie_id = '{$_SESSION['movie_id']}'";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['movie_name'];
                            array_push($arr,$_SESSION['userid']);
                        ?></td>
                    </tr>
                    <tr>
                        <td>Theater Name </td>
                        <td><?php $sql="SELECT theater.theater_name FROM theater,shows 
                                        WHERE shows.show_id = '{$_SESSION['show_id']}' and theater.theater_id = shows.theater_id";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['theater_name'];
                            array_push($arr,$row['theater_name']);
                        ?></td>
                    </tr>
                    <tr>
                        <td>Screen No </td>
                        <td><?php $sql="SELECT screen.screen_no FROM screen , shows 
                                        WHERE shows.show_id = '{$_SESSION['show_id']}' and screen.screen_id = shows.screen_id";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['screen_no'];
                            array_push($arr,$row['screen_no']);
                        ?></td>
                    </tr>
                    <tr>
                        <td>Timing </td>
                        <td><?php 
                            $sql = "SELECT show_date_time FROM shows WHERE show_id ='{$_SESSION['show_id']}'";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['show_date_time'];
                        ?></td>
                    </tr>
                    <tr>
                        <td>Seats Booked </td>
                        <td><?php
                            for($i=0;$i<strlen($seat);$i++){
                                echo $seat[$i]."  ";
                            }
                            unset($_SESSION['seat']);
                            $_SESSION['seat'] = "";
                            array_push($arr,$seat);
                            echo "(".strlen($seat).")";
                        ?></td>
                    </tr>
                    <tr>
                        <td>Ticket Price </td>
                        <td><?php $sql="SELECT screen.price FROM screen , shows 
                                        WHERE shows.show_id = '{$_SESSION['show_id']}' and screen.screen_id = shows.screen_id";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            echo "Rs.".$row['price'].$_SESSION['seat'];
                            array_push($arr,$row['price']);
                        ?></td>
                    </tr>
                    <tr>
                        <td>Movie Duration </td>
                        <td><?php $sql="SELECT movie.duration FROM movie , shows 
                                        WHERE shows.show_id = '{$_SESSION['show_id']}' and movie.movie_id = shows.movie_id";
                            $res = mysqli_query($conn , $sql);
                            $row = mysqli_fetch_assoc($res);
                            $dur = $row['duration'];
                            echo (int)($dur/60)."-Hours ".($dur%60)."-Mins";
                        ?></td>
                    </tr>
                </table><br>
                <?php
                    $sql = "INSERT INTO ticket VALUES('','$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')";
                    if(!mysqli_query($conn , $sql)){
                        echo "<script>alert('Try Again! Later.');</script>";
                    }
                              
                ?>
                <p>Make sure that the above mentioned details are correct , 
                if there is any mistake kindly contact admins.</p><br>
                
                <a href='dashboard.php'>Goto Dashboard</a>
               
        </div><br><br>
        <div class='rating-column'>
            <table style="width:100%;">
            <tr>
                <h3 style= "text-align : center;color :white;text-shadow :0 0 5px black;">Rate this Movie</h3>
            </tr>
            <tr>
            <td >
                <a id = 'rate' href='ticket.php?rating=5'><i style= 'font-size : 20px;' class="fas fa-star"></i>Excellent</a><br><br>
                <a  href='ticket.php?rating=4'><i style= 'font-size : 20px;' class="fas fa-star"></i>Very Good</a><br><br>
                <a  href='ticket.php?rating=3'><i style= 'font-size : 20px;' class="fas fa-star"></i>Good</a><br><br>
                <a  href='ticket.php?rating=2'><i style= 'font-size : 20px;' class="fas fa-star"></i>Average</a><br><br>
                <a  href='ticket.php?rating=1'><i style= 'font-size : 20px;' class="fas fa-star"></i>Worst</a><br><br>
            </td>
            <td >
                <i id = 'em1' style ='font-size:100px;color:white;text-shadow:0 0 5px white;'class="far fa-smile-wink"></i>
               </td>
            </tr>
        </div>
    </body>
</html>