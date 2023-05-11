<?php
    session_start();
        $conn = mysqli_connect("localhost","root","","new-gen");
        if(!$conn){
            echo "<script>alert('Database not connected, Contact Admin!!!')</script>";
        }
    if(!empty($_GET['seat'])){
        $_SESSION['seat'] .= $_GET['seat'];
        $str = $_SESSION['seat'];
        $_SESSION['seat'] = count_chars($str, 3);
    }
    if(!empty($_GET['show_id'])){
        $_SESSION['show_id'] = $_GET['show_id']; 
    }
    if(isset($_GET['reset'])){
        $_SESSION['seat'] = "";
    }
    if(isset($_GET['submit'])){
        if(strlen($_SESSION['seat']) > 0){
            $out = $_SESSION['seat_str'].$_SESSION['seat'];
            $out = count_chars($out, 3);
            $sql = "UPDATE seat SET seat_booked = '$out' WHERE show_id = '{$_SESSION['show_id']}'";
            if($res = mysqli_query($conn,$sql)){
                $seat = $_SESSION['seat'] ;
                header("location:ticket.php?seat=$seat");
            }else{
                    echo mysqli_error($conn);
            }
        }else{
            echo "<script>alert('Select at least one seat...');</script>";
        }
    }
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
<head>
    <head>
        <title><?php echo $_SESSION['username'];?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <link rel ="stylesheet" href = "seat.css">
        <style>            
            .light-indicator{
                width : 60%;
                margin  : auto;
            }
            @keyframes tab {
                0%{box-shadow:0 0 20px limegreen;border:2px solid limegreen;}
                50%{box-shadow:0 0 20px white;border:2px solid white;}
                100%{box-shadow:0 0 20px limegreen;border:2px solid limegreen;}
            }
            .table{
                color: white;
                width : 100%;
                height : 300px;
                padding  : 10px;
                text-align : center;
                background-color:rgba(0,0,0,0.5);
                animation-name:tab;
                animation-iteration-count:infinite;
                animation-duration:2s;
                border:2px solid limegreen;
            }
            .table:hover{
               padding:20px; 
            }
            i{
                text-shadow : 0 0 2px white;
            }
            table a{
                cursor : pointer;
                color: limegreen;
                font-size : 20px;
            }
            .result{
                margin : auto ;
                width : 60%;
                background-color:rgba(0,0,0,0.5);
                box-shadow : 0 0 10px limegreen;
                animation-name:tab;
                animation-iteration-count:infinite;
                animation-duration:2s;
            }
            .result_display{
                padding : 10px;
            }
            .result a:hover{
                background-color : transparent;
                padding : 15px;
            }
            .result a{
                text-decoration : none;
                color : white;
                padding : 10px;
                box-shadow : 0 0 10px white;
                border-radius : 10px;
                background-color : rgba(0 , 0, 0, 0.7);
            }
            .heading{
                font-family: cursive;
                font-size : 30px;
                text-align : center;
                text-shadow :2px 2px 10px red;
            }
            .selected-list{
                box-shadow : 0 0 10px white;
                padding : 10px;
                background-color: rgba(0,0,0,0.4);
                border-radius : 10px; 
                margin-left : 10px;
            }
            .selected-list i{
                color : white;
            }
            .light-indicator h1{
                border-top: 50px solid white;
	            border-left: 25px solid transparent;
	            border-right: 25px solid transparent;
	            height: 0;
            }
        </style>
    </head>
    <body>
        <header>
            <div class = header >
                <label class = "logo"><a style = "color: white; text-decoration: none;"href = "home.html">New-Gen</a></label>
               <form  id = "myForm" method = "POST"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <label  class = "search-box"><input type = "text" name = "search-key" placeholder="Search for movies  ... "> </label>
                    <label class = "search-button"   ><button onclick= "col3()" type="submit" name = "search-submit"><i class = "fa fa-search"></i></button></div>
                </form>
                <span class = "username" ><a href='logout.php'><p><?php echo $_SESSION['username'];?>  <i class ="fas fa-sign-out-alt"></i></p></a></label>  
            </div>
        </header>
        <content>
            <div class = "content">
                <h3 class = 'heading'>Select Your Seats</h3>
                <div class = 'container'>
                    <div class= "light-indicator">
                    <h1 style = "text-align : center;text-shadow : 0 0 10px white;"></h1>    
                    <table class = "table"> 
                            <tr>
                                <td ><a id = 'a' href = "seat.php?seat=a"><i class="fas fa-couch"></i></a>(a)</td>
                                <td ><a id = 'b' href = "seat.php?seat=b"><i class="fas fa-couch"></i></a>(b)</td>
                                <td ><a id = 'c' href = "seat.php?seat=c"><i class="fas fa-couch"></i></a>(c)</td>
                                <td ><a id = 'd' href = "seat.php?seat=d"><i class="fas fa-couch"></i></a>(d)</td>
                            </tr>
                            <tr>
                                <td ><a id = 'e' href = "seat.php?seat=e"><i class="fas fa-couch"></i></a>(e)</td>
                                <td ><a id = 'f' href = "seat.php?seat=f"><i class="fas fa-couch"></i></a>(f)</td>
                                <td ><a id = 'g' href = "seat.php?seat=g"><i class="fas fa-couch"></i></a>(g)</td>
                                <td ><a id = 'h' href = "seat.php?seat=h"><i class="fas fa-couch"></i></a>(h)</td>
                            </tr>
                            <tr>
                                <td ><a id = 'i' href = "seat.php?seat=i"><i class="fas fa-couch"></i></a>(i)</td>
                                <td ><a id = 'j' href = "seat.php?seat=j"><i class="fas fa-couch"></i></a>(j)</td>
                                <td ><a id = 'k' href = "seat.php?seat=k"><i class="fas fa-couch"></i></a>(k)</td>
                                <td ><a id = 'l' href = "seat.php?seat=l"><i class="fas fa-couch"></i></a>(l)</td>
                            </tr>
                            <tr>
                                <td ><a id = 'm' href = "seat.php?seat=m"><i class="fas fa-couch"></i></a>(m)</td>
                                <td ><a id = 'n' href = "seat.php?seat=n"><i class="fas fa-couch"></i></a>(n)</td>
                                <td ><a id = 'o' href = "seat.php?seat=o"><i class="fas fa-couch"></i></a>(o)</td>
                                <td ><a id = 'p' href = "seat.php?seat=p"><i class="fas fa-couch"></i></a>(p)</td>
                            </tr>
                        </table>
                    </div>
                    
                    <?php
                        $sql = "SELECT seat_booked FROM seat WHERE show_id = '{$_SESSION['show_id']}'";
                        $res = mysqli_query($conn , $sql);
                        if(mysqli_num_rows($res) >= 1 ){
                            while($row = mysqli_fetch_assoc($res)){
                                $string = $row['seat_booked'];
                                $_SESSION['seat_str'] = $row['seat_booked'];
                                for($i=0 ; $i < strlen($string) ; $i++){
                                    echo "<script>document.getElementById('$string[$i]').style.color = 'red';
                                    document.getElementById('$string[$i]').style.pointerEvents = 'none';</script>";
                                }
                            }
                        }
                        $sql = "SELECT social_distancing FROM shows WHERE show_id='{$_SESSION['show_id']}'";
                        $res = mysqli_query($conn , $sql);
                        if($res){
                            $row = mysqli_fetch_assoc($res);
                            if($row['social_distancing'] == "Yes"){
                                $i='a' ;
                                $j = 1;
                                $count =0;
                                for($j = 1 ; $j <= 16 ; $j += 2){
                                    $ch = chr(96+$j);
                                    echo "<script>document.getElementById('$ch').style.pointerEvents = 'none';
                                        document.getElementById('$ch').style.color = 'white';</script>"; 
                                    $count++;
                                    if($count == 2){
                                        if($j%2){
                                            $j++;
                                            $prev = $i;
                                            $i++;
                                        }else{
                                            $j--;
                                            $i = $prev;
                                        }
                                        $count = 0;
                                        $i++;
                                        $i++;
                                    }
                                }    
                            }
                        }
                    ?>
                </div><br>
                <div class = 'result'>
                    <div class = result_display>
                        <h3 style ="font-family:cursive;">Selected Seats : </h3>
                        <div class='selected'>
                            <?php
                                $res = $_SESSION['seat'];
                                for($i=0 ; $i < strlen($res) ; $i++){
                                    echo "<p style = 'display:inline-block;' class = 'selected-list'><i class='fas fa-couch'></i>-".$res[$i]."</p>";
                                }
                            ?>
                        </div>
                        <a href = 'seat.php?reset=true'>Reset Choice <i class="fas fa-trash-restore-alt"></i></a>
                        <a href = 'seat.php?submit=true'>Book Now <i class="far fa-check-circle"></i></a>
                        <p><i style= "color : red;" class="fas fa-couch"></i> - Booked Seats</p>
                        <p><i style= "color : white;" class="fas fa-couch"></i> - Safety Seats</p>
                        <p><i style= "color : limegreen;" class="fas fa-couch"></i> - Available Seats</p>
                    </div>
                </div>
            </div>
        </content>
    </body>
</head>