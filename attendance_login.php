
<?php
  // Include config file
  include("config.php");
  // Define variables and initialize with empty values
  $username = $password = "";
  $username_err = $password_err =  "";
  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
      $username_err = "Please enter a username.";
    } 
    else{
      $temp_username = trim($_POST["username"]);
      $sql = "SELECT id FROM accounts WHERE user = '$temp_username'";
      $result = mysqli_query($conn,$sql);
      $count = mysqli_num_rows($result);
      if($count == 1) {
        $username_err="";
      }
      else {
        $username_err = "please enter a valid password or username";
      }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
      $password_err = "Please enter a password.";     
    } 
    else{
      $temp_password =trim($_POST["password"]);
      $sql1 = "SELECT id FROM accounts WHERE pass = '$temp_password' AND user='$temp_username'";
      $result1 = mysqli_query($conn,$sql1);
      $count1 = mysqli_num_rows($result1);
      if($count1 == 1) {
        $password_err="";
      }
      else {
        $password_err="please enter a valid password or username";
      }
    }
    if(empty($username_err) && empty($password_err) ){
      // replace link to web here
      header("Location: uploadform.html");
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>login</title>
    <style>
      body {font-family: Arial, Helvetica, sans-serif;
        /* The image used */
        background-image: url("source/school2.jpg");
        /* Full height */
        width: 100vw;
        height: 100vh;
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }

      input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }

      img.avatar {
        width: 40%;
        border-radius: 50%;
      }
      button {
        background-color: #0313e9;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
      }
      button:hover {
        opacity: 0.8;
      }
      .container {
        padding: 16px;
        background-color: #ffffff;
        width: 500px;
        margin-right: auto;
        margin-left: auto;
        margin-top: auto;
        margin-bottom: auto;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <img src="source/login-banner.png" >
      <h2 style="font-size: 250%; font-weight: bold; text-align: center;">Login</h2> 
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" placeholder="Enter Username" name="username" required  class = "<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
          <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" placeholder="Enter Password" name="password" required class = "<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
          <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
          <button type="submit" value="Submit">Login</button>
        </div>
        <p>don't have an account?<a href="register.php">register here</a>.</p>
      </form>
    </div>
  </body>
</html>