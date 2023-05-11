<html>
    <head>
        <title>Nandha....</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel = "stylesheet" href = "home.css">  	
	</head>
    <body> <?php include 'loginphp.php';?>      
        <h2>Enjoy your cinemas with newgen cinemas!!!</h2>
        <div class="container" id="container">
	    <div class="form-container sign-up-container">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fa fa-facebook"></i></a>
				<a href="#" class="social"><i class="fa fa-google-plus"></i></a>
				<a href="#" class="social"><i class="fa fa-linkedin"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="Name" name = "name" />
			<input type="email" placeholder="Email" name = "email"/>
			<input type="password" placeholder="Password" name = "pass"/>
			<button type = "submit" id = "signup-bt" name = "signup">Sign Up</button>
		</form>
	    </div>
	    <div class="form-container sign-in-container">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
			
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fa fa-facebook"></i></a>
				<a href="#" class="social"><i class="fa fa-google-plus"></i></a>
				<a href="#" class="social"><i class="fa fa-linkedin"></i></a>
			</div>
			<span>or use your account</span>
			<input type="email" placeholder="Email" name = "loginemail" />
			<input type="password" placeholder= "Password" name = "loginpass" />
			<a href="#">Forgot your password?</a>
			<button type = "submit" id = "signin-btn" name = "signin">Sign In</button>
		</form>
	    </div>
	    <div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friends!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp" >Sign Up</button>
			</div>
		</div>
	</div>
</div>

<footer>
	<p>
		Created with <i class="fa fa-heart"></i> by
		- Nandhakumar , Aditya Lakhmanan , Suhaas Varma 
		</p>
</footer>

    </body>
    <script >
        const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');


signUpButton.addEventListener('click', () => {
container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
container.classList.remove("right-panel-active");
});
    </script>
</html>