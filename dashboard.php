<?php session_start();?>
<html>
    <head>
        <title>Welcome!!!</title> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel = "stylesheet" href = "dashboard.css">
        <style>
            a{
                text-decoration: none;
                color : white;
            }
            .nav-bar button:hover{
                border : 1px solid violet;
                background:transparent;
                width: 120px;
            }
            .genre i{
                cursor: pointer;
                position: relative;
            }
            .genre i:hover{
                color: white;
            }
        </style> 
        <script>
            function movieBtn(){
                document.getElementById('col4').style.display = "block";
                document.getElementById('all-movie').style.display = "block";
                document.getElementById('all-theater').style.display = "none";
            }
            function theaterBtn(){
                document.getElementById('col4').style.display = "block";
                document.getElementById('all-movie').style.display = "none";
                document.getElementById('all-theater').style.display = "block";
            }
            function leftScroll1(){
                document.getElementById('movie-select-container1').scrollLeft += 100;
            }
            function leftScroll2(){
                document.getElementById('movie-select-container2').scrollLeft += 100;
            }
            function leftScroll3(){
                document.getElementById('movie-select-container3').scrollLeft += 100;
            }
        </script>
    </head>
    <body>
        <?php
            $movies = $cinema = "";
            $conn = mysqli_connect ("localhost","root","","new-gen");
            if(!$conn){
                echo "<script>alert('Connection not established...');</script>";
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
        <header>
        <div class = header >
            <label class = "logo"><a style = "color: white; text-decoration: none;"href = "home.html">New-Gen</a></label>
           <form  id = "myForm" method = "POST"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <label  class = "search-box"><input type = "text" name = "search-key" placeholder="Search for movies ... "> </label>
                <label class = "search-button"   ><button onclick= "col3()" type="submit" name = "search-submit"><i class = "fa fa-search"></i></button></div>
            </form>
            <span class = "username" ><a href='logout.php'><p><?php echo $_SESSION['username'];?>  <i class ="fa fa-sign-out"></i></p></a></label>  
        </div>
        </header>
        <navigation-bar>
            <div onclick = "navBar()" class = "nav-bar">
                <button onclick = "theaterBtn()" class = "theater-btn">Theaters <i class="fa fa-ticket"></i> </button>
                <button onclick = "movieBtn()" class = "movie-btn">Movies <i class="fa fa-film"></i></button>
            </div>
        </navigation-bar>
        <content>
            <div class = "content" >
                <div class = "movie-list" >
                    <div class = "col col1" id ="col1">
                        <h1 style = "text-align : center">Top Movies</h1>
                            <marquee direction ="up">
                            <p class = "p_tab"><?php $count = 0 ;
                                $sql_movie = "SELECT * FROM movie_view WHERE movie_rating > 4.30 ORDER BY movie_rating desc";
                                $sql_movie_res = mysqli_query($conn , $sql_movie);
                                if(mysqli_num_rows($sql_movie_res) > 0){
                                    while($row = mysqli_fetch_assoc($sql_movie_res)){
                                        echo $row['movie_name']."       [".$row['movie_rating']. "]<br><br>";
                                    }
                                }
                            ?></p></marquee>
                    </div>
                    <div class = "col col2" id ="col2">
                        <h1 style = "text-align : center">Top Theaters</h1>
                        <marquee direction ="down">
                        <p><?php
                                $sql_theater = "SELECT * FROM theater_view WHERE theater_rating > 4.0 ORDER BY Theater_Rating desc";
                                $sql_theater_res = mysqli_query($conn , $sql_theater);
                                if(mysqli_num_rows($sql_theater_res) > 0){
                                    while($row = mysqli_fetch_assoc($sql_theater_res)){
                                        echo $row['Theater_Name']."     [".$row['Theater_Rating'] ."]<br><br>";
                                    }
                                }
                            ?></p></marquee>
                    </div>
                    <div class = "col col3" id ="col3" >
                        <h1 style = "text-align : center">Search results</h1>
                    </div>
                    <div id ="col4" class = "col col4" >
                        <div id = "all-movie" style = "display : none;" >
                            <h1>Movies List</h1>
                            <p><?php
                                $sql_mov = "SELECT *FROM movie ORDER BY movie_name ";
                                $res_mov = mysqli_query($conn , $sql_mov);

                                if(mysqli_num_rows($res_mov) > 0){
                                    while($row = mysqli_fetch_assoc($res_mov)){
                                        echo "<a href ='theater.php?movie_id=".$row['movie_id']."'>".$row['movie_name'] ."   [".$row['movie_rating']."]</a><br><br>";
                                    }
                                }
                            ?></p>
                        </div>
                        <div id = "all-theater" style = "display : none;">
                        <h1>Theaters List</h1>
                            <p><?php  
                                mysqli_query($conn , "SET @names_list ='' ");
                                mysqli_query($conn , "CALL theater_list(@names_list) ");
                                $res_mov = mysqli_query($conn , "SELECT @names_list; ");
                                if(mysqli_num_rows($res_mov) > 0){
                                    while($row = mysqli_fetch_assoc($res_mov)){
                                        echo $row['@names_list'];
                                    }
                                }
                            ?>
                            </p>
                        </div>
                        <div class = "genre">
                        <h1 >Kids and Comedy <i onclick = "leftScroll1()" class="fa fa-arrow-right" style ="float : right;font-size:large;margin-top:10px;"></i></h1>
                        
                            <div id = "movie-select-container1" class = "movie-select-container">   
                                <p><?php
                                $sql = "SELECT * FROM movie WHERE genre = 'kids'";
                                $res = mysqli_query($conn , $sql);
                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_assoc($res)){
                                            echo "<a class = 'movie-select' href = 'theater.php?movie_id=".$row['movie_id']."'>".$row['movie_name']."</a>";
                                    }
                                }
                                ?></p>
                            </div>
                            <h1 >Action and Thriller <i onclick = "leftScroll2()" class="fa fa-arrow-right" style ="font-size:large;float : right;margin-top:10px;" aria-hidden="true"></i></h1> 
                            <div id = "movie-select-container2" class = "movie-select-container">   
                                <p><?php
                                $sql = "SELECT * FROM movie WHERE genre = 'action'";
                                $res = mysqli_query($conn , $sql);
                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_assoc($res)){
                                            echo "<a class = 'movie-select' href = 'theater.php?movie_id=".$row['movie_id']."'>".$row['movie_name']."</a>";
                                    }
                                }
                                ?></p>
                            </div>
                            <h1 >Science Fiction <i onclick = "leftScroll3()" class="fa fa-arrow-right" style ="font-size:large;float : right;margin-top:10px;" aria-hidden="true"></i></h1> 
                            <div id = "movie-select-container3" class = "movie-select-container">   
                                <p><?php
                                $sql = "SELECT * FROM movie WHERE genre = 'sci-fi'";
                                $res = mysqli_query($conn , $sql);
                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_assoc($res)){
                                            echo "<a class = 'movie-select' href = 'theater.php?movie_id=".$row['movie_id']."'>".$row['movie_name']."</a>";
                                    }
                                }
                                ?></p>
                            </div>
                        </div>
                    </div> 
                </div> 
                
            </div>
        </content>
    </body>
</html>

