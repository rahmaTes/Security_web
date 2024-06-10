<?php
require __DIR__ . '/vendor/autoload.php';

include 'config.php';
session_start();
use \Firebase\JWT\JWT;
// token jwt=json web token
function generateToken($conn, $user) {
    $payload = array(
        "user_id" => $user['id'],
        "user_type" => $user['user_type']
    );
    $token = JWT::encode($payload, 'your_secret_key', 'HS256');
    return $token;
}
// hash pass by md5
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $row = mysqli_fetch_assoc($select_users);

        // Generate JWT token and store it in the database
        $token = generateToken($conn, $row);

        // Store JWT token in session

        // Redirect based on user type
        switch ($row['user_type']) {
            case 'admin':
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['user_type'] = 'admin';
                $_SESSION['token'] = $token;
                header('location:admin_page.php');
                
                exit();
            case 'user':
            case 'premium':
            case 'author':
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['token'] = $token;
                header('location:home.php');

               
                exit();
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="Login now" class="btn">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
   </form>
</div>

<!-- Store token in session storage -->
<script>
   document.addEventListener('DOMContentLoaded', function() {
      var loginForm = document.querySelector('form');
      if (loginForm) {
         loginForm.addEventListener('submit', function(event) {
            var token = "<?php echo isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>";
            if (token) {
               sessionStorage.setItem('token', token);
            }
         });
      }
   });
</script>

</body>
</html>
