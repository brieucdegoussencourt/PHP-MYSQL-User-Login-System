<?php
// Start the session to allow session variables to be used.
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      include "connection.php";

      // Check if the login form has been submitted.
      if (isset($_POST['login'])) {

        // Retrieve email and password from POST request.
        $email = $_POST['email'];
        $pass = $_POST['password'];

        // SQL query to fetch user data based on the provided email.
        $sql = "select * from users where email='$email'";

        // Execute the SQL query.
        $res = mysqli_query($conn, $sql);

        // Check if the query returned any results.
        if (mysqli_num_rows($res) > 0) {

          // Fetch the associative array of the first result row.
          $row = mysqli_fetch_assoc($res);

          // Get the password hash from the database.
          $password = $row['password'];

          // Verify the provided password against the hashed password.
          $decrypt = password_verify($pass, $password);

          // If the password is correct, set session variables and redirect to home.php.
          if ($decrypt) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: home.php");

          } else {
            // If the password is incorrect, display an error message.
            echo "<div class='message'>
                    <p>Wrong Password</p>
                    </div><br>";
            echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
          }

        } else {
          // If no user is found with the provided email, display an error message.
          echo "<div class='message'>
                    <p>Wrong Email or Password</p>
                    </div><br>";
          echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
        }

      } else {
        // If the form has not been submitted, display the login form.
        ?>

        <header>Login</header>
        <hr>
        <form action="#" method="POST">

          <div class="form-box">

            <!-- Email input field with Font Awesome icon -->
            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" placeholder="Email Address" name="email">
            </div>

            <!-- Password input field with Font Awesome icon and toggle for show/hide password -->
            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Password" name="password">
              <i class="fa fa-eye toggle icon"></i>
            </div>

            <!-- Remember me checkbox and forgot password link -->
            <div class="remember">
              <input type="checkbox" class="check" name="remember_me">
              <label for="remember">Remember me</label>
              <span><a href="forgot.php">Forgot password</a></span>
            </div>

          </div>

          <!-- Submit button for the form -->
          <input type="submit" name="login" id="submit" value="Login" class="button">

          <!-- Link to signup page for users without an account -->
          <div class="links">
            Don't have an account? <a href="signup.php">Signup Now</a>
          </div>

        </form>
      </div>
      <?php
      }
      ?>
  </div>
  <script>
    // JavaScript to toggle the visibility of the password field.
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      } else {
        input.type = "password";
      }
    })
  </script>
</body>

</html>