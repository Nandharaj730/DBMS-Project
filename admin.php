<?php session_start();
 $conn = mysqli_connect("localhost","root","","new-gen");
 if(!$conn){
     echo "<script>alert('Database not connected, Contact Admin!!!')</script>";
 }
 ?>
<html>
    <head>
        <title>Welcome Admin...</title>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <style>
            body{
                margin :0;
            }
            .header{
                display:inline;
            }
            .header h1{
                font-family: Brush Script MT, Brush Script Std, cursive;
                color: dodgerblue;
                font-size: 60px;
                position:relative;
                padding: 10px;
                text-shadow: 0 0 10px white;
            }
            .header a{
                right:30px;
                top:30px;
                text-decoration:none;
                position:absolute;
                color : black;
                border-radius: 20px;
                padding : 10px;
                box-shadow : 0 0 10px dodgerblue;
            }
            .header a:hover{
                background-color: rgba(0,0,0,0.4);
                padding: 12px;
            }
            .content{
                width : 50%;
                margin : auto;
                text-align:center;
                background-color: rgba(0,0,0,0.4);
                border-radius : 10px;
            }
            .content button{
                border : none;
                background-color :black;
                padding :10px;
                color:white;
                box-shadow: 0 0 10px white;
                border-radius : 20px;
                cursor: pointer;
            }
            .content button:hover{
                border-radius : 30px;
                width : 50%;
                transition-duration: 1s;
            }
            .content button:active{
                width : 100%;
            }
            select{
                padding : 10px;
                border-radius : 20px;
                box-shadow: 0 0 10px black;
                border : none;
            }
            .content input {
                padding : 10px;
                border : none;
                box-shadow : 0 0 10px black;
                border-radius : 20px;
            }
            .text-bar button{
                background-color: black;
                color:white;
                border :none;
                padding :10px;
                cursor: pointer;
            }
            .text-bar p{
                font-family:monospace;
            }
            textarea::placeholder{
                color:white;
            }
        </style>
        <script>
            function priceChange(){
                var x = document.getElementById('price-change');
                if(x.style.display =='none'){
                    x.style.display ='block';
                }else{
                    x.style.display = 'none';
                }
            }
            function movieChange(){
                var x = document.getElementById('movie-change');
                if(x.style.display =='none'){
                    x.style.display ='block';
                }else{
                    x.style.display = 'none';
                }
            }
            function movieAdd(){
                var x = document.getElementById('add-movie');
                if(x.style.display =='none'){
                    x.style.display ='block';
                }else{
                    x.style.display = 'none';
                }
            }
        </script>
    </head>
    <body>
        <div class='header'>
            <h1>New-Gen</h1>
            <a href = 'logout.php'>Logout     <i class ="fas fa-sign-out-alt"></i></a>
        </div>
        <div class='content'>
        <h3>Dear Admin You can change the basic things here...</h3>
            <button onclick ='priceChange()' >Change Price <i class="far fa-hand-point-down"></i></button><br>
            <div style='display:none;' id='price-change'>
                <p>Select Theater:</p>
                <form method ='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
                <select id = 'theater-select' name= 'select_theater'>
                    <?php $sql = "SELECT * FROM theater";
                        $res = mysqli_query($conn , $sql);
                        while($row = mysqli_fetch_assoc($res)){
                            echo "<option>".$row['Theater_Name']."</option>";
                        }   
                    ?>
                </select>
                <p>Select Screen:</p>
                <select id = 'screen-select' name= 'select_screen'>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select><br><br>
                    <input type='number' placeholder ='Enter Price' name='new_price'></input>
                    <input type='submit' name='price_change'></button>
                </form>
                <?php 
                    if(isset($_POST['price_change'])){
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            $par1 = $_POST['select_theater'] ;
                            $par2 = $_POST['select_screen'] ;
                            $price = $_POST['new_price'] ;
                            $sql = "UPDATE screen SET Price = '$price'
                                    WHERE theater_id = (SELECT theater_id FROM theater WHERE Theater_Name = '$par1')
                                    and screen_no = '$par2'";
                            if(!mysqli_query($conn , $sql)){
                                echo "<script>alert('Something went Wrong..');</script>";
                            }else{
                                echo "<script>alert('Updated..');</script>";
                            }
                        }
                    }
                ?>
            </div><hr>
            <button onclick ='movieChange()' >Change Show <i class="far fa-hand-point-down"></i></button>
            <div style = 'display:none;' id ='movie-change'>
                <form method ='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
                    <p>Select Theater :</p>
                    <select id ='theater-select' name = 'theater_select'>
                        <?php 
                            $sql = "SELECT * FROM theater";
                            $res = mysqli_query($conn , $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option>".$row['Theater_Name']."</option>";
                            }
                        ?>
                    </select>
                    <p>Select Screen :</p>
                    <select id = 'screen-select' name= 'screen_select'>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                    <p>Select Movie :</p>
                    <select id ='movie-select' name = 'movie_select2'>
                        <?php 
                            $sql = "SELECT * FROM movie";
                            $res = mysqli_query($conn , $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option>".$row['movie_name']."</option>";
                            }
                        ?>
                    </select>
                    <input type='submit' name='movie_change'></button>
                </form>
                <?php 
                    if(isset($_POST['movie_change'])){
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            $par1 = $_POST['theater_select'] ;
                            $par2 = $_POST['movie_select2'] ;
                            $par3 = $_POST['screen_select'] ;
                            $sql = "UPDATE shows SET movie_id = (SELECT movie_id FROM movie WHERE movie_name = '$par2')
                                    WHERE theater_id = (SELECT Theater_Id as th_id FROM theater WHERE Theater_Name = '$par1')
                                    and screen_id =  (SELECT screen_id FROM screen WHERE screen_no = $par3 
                                    and theater_id = (SELECT Theater_Id as th_id FROM theater WHERE Theater_Name = '$par1'))";
                            if(!mysqli_query($conn , $sql)){
                                echo "<script>alert('Something went Wrong..');</script>";
                            }else{
                                echo "<script>alert('Updated..');</script>";
                            }
                        }
                    }
                ?>
            </div><br><hr>
            <button onclick ='movieAdd()' >Add New Movie <i class="far fa-hand-point-down"></i></button><br><br>
            <div style= 'display :none;' id = 'add-movie'>
            <form method ='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
                <input type ='text' name = 'new_movie' placeholder ='Enter Movie Name...'></input><br><br>
                <input type ='text' name = 'movie_rating' placeholder ='Enter IMDB Rating...'></input><br><br>
                <input type ='text' name = 'movie_duration' placeholder ='Enter Movie Duration...'></input><br><br>
                <select id ='movie-select' name = 'movie_select'>
                        <?php 
                            $sql = "SELECT distinct(genre) FROM movie";
                            $res = mysqli_query($conn , $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option>".$row['genre']."</option>";
                            }
                        ?>
                </select>
                <input type='submit' name='add_movie'></button>
            </form><br>
            <?php 
                if(isset($_POST['add_movie'])){
                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                        $par1 = $_POST['new_movie'] ;
                        $par2 = $_POST['movie_rating'] ;
                        $par3 = $_POST['movie_duration'] ;
                        $par4 = $_POST['movie_select'] ;
                        $sql = "INSERT INTO movie VALUES('','$par1','$par4','$par2','1','$par3')";
                        if(!mysqli_query($conn , $sql)){
                            echo "<script>alert('Something went Wrong..');</script>";
                        }else{
                            echo "<script>alert('New Movie Added to the database..');</script>";
                        }
                    }
                }
            ?>
            </div>
        </div>
        <div class ='text-bar' style= 'margin :auto;width:60%;'>
        <h2>For Programers and Developers only.</h2><br>
        <form method ='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
            <h3>SELECT from the DataBase</h3>
            <textarea style = 'background-color:black;color:white;overflow:auto;width : 100%; height : 100px;' name = 'sql_code' placeholder='Your code here....'></textarea><br>
            <button type= 'submit' name='sql_submit'>Execute <i class="fas fa-angle-right"></i></button>    
        </form>
        <p style= 'background-color:black;color:white;font-size:15px;font-family:monospace;overflow:auto;padding:10px;height:300px;'>Output:<br>
        <?php 
            if(isset($_POST['sql_submit'])){
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                   if(!empty($_POST['sql_code'])){
                        $sql = $_POST['sql_code'];
                        $res = mysqli_query($conn , $sql);
                        if($res){
                            while($row= mysqli_fetch_assoc($res)){
                                print_r($row);
                                echo "<br>";
                            }
                        }else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            }
        ?></p>
        </div>
        <div class ='text-bar' style= 'margin :auto;width:60%;'>
        <form method ='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
            <h3>For others :</h3>
            <textarea style = 'background-color:black;color:white;width : 100%;overflow:auto;height : 100px;' name = 'sql_code2' placeholder='Your code here....'></textarea><br>
            <button type= 'submit' name='sql_submit2'>Execute <i class="fas fa-angle-right"></i></button>    
        </form>
        <p  style= 'background-color:black;font-size:15px;font-family:monospace;color:white;padding:10px;'>Output:<br><?php 
            if(isset($_POST['sql_submit2'])){
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    if(!empty($_POST['sql_code2'])){
                        $sql = $_POST['sql_code2'];
                        if(mysqli_query($conn , $sql)){
                            echo "Command executed successfully.";
                        }else{
                            echo mysqli_error($conn);
                        }
                    }else{
                        echo "Query was empty";
                    }
                }
            }
        ?></p>
        </div>
    </body>
</html>