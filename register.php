<?php
  include("includes/config.php");
  include("includes/classes/Constants.php");
  include("includes/classes/Account.php");
  $account = new Account($dbh);
  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");
  function getInputValue($name) {
    if(isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
 ?>


<html>
<head>
    <title>  Welome to Ehapofy </title>
    <link rel="stylesheet" href="assests/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assests/javascript/register.js"></script>
</head>
<body>
  <?php
    if(isset($_POST['registerButton'])) {
      echo "<script>
          $(document).ready(function(){
            $('#loginForm').hide();
            $('#registerForm').show();
          })
          </script>";
    }
    else {
      echo "<script>
          $(document).ready(function(){
            $('#loginForm').show();
            $('#registerForm').hide();
          })
          </script>";
    }
    ?>

  <div id="background">
      <div id="loginContainer">
        <!-- Login form -->
          <div id="inputContainer">
            <form id="loginForm" action="register.php" method="POST">
              <h2>Login to your account</h2>
              <p>
                  <?php echo $account->getError(Constants::$loginFailed); ?>
                  <label for="loginUsername"> Username </lable>
                  <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. Ehab Reda" value = "<?php echo getInputValue('loginUsername') ?>" required>              </p>
              <p>
              <label for="loginPassword"> Password </label>
              <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
              </p>
              <p>
              <button type="submit" name="loginButton"> LOGIN </button>
              </p>
              <div class="hasAccountText">
                <span id="hideLogin"> Don't have an account? signup here.</span>
              </div>
            </form>


            <!-- Register form -->
            <form id="registerForm" action="register.php" method="POST">
              <h2>Create your free account</h2>
              <p>
                <?php echo $account->getError(Constants::$userNameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                  <label for="username"> Username </lable>
                  <input id="username" name="username" type="text" placeholder="e.g. Ehab Reda" value="<?php getInputValue('username'); ?>" required>
              </p>
              <p>
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                  <label for="firstName"> first name </lable>
                  <input id="firstName" name="firstName" type="text" placeholder="e.g. Ehab" value="<?php getInputValue('firstName'); ?>" required>
              </p>
              <p>
                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                  <label for="lastName"> Last name </lable>
                  <input id="lastName" name="lastName" type="text" placeholder="e.g. Reda" value="<?php getInputValue('lastName'); ?>" required>
              </p>
              <p>
                <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailWasTaken);?>
                  <label for="email"> Email </lable>
                  <input id="email" name="email" type="email" placeholder="e.g. ehab@gmail.com" value="<?php getInputValue('email'); ?>" required>
              </p>
              <p>

                  <label for="email2"> Confirm email </lable>
                  <input id="email2" name="email2" type="email" placeholder="e.g. ehab@gmail.com" value="<?php getInputValue('email2'); ?>" required >
              </p>
              <p>
              <?php echo $account->getError(Constants::$passwordNotAlphanumiric); ?>
              <?php echo $account->getError(Constants::$passwordCharacters); ?>
              <?php echo $account->getError(Constants::$passwordsDoMatch); ?>
              <label for="password"> Password </label>
              <input id="password" name="password" type="password" placeholder="Your password" required>
              </p>


              <p>
              <label for="password2"> Confirm password </label>
              <input id="password2" name="password2" type="password" placeholder="Confirm your password" required>
              </p>

              <p>
              <button type="submit" name="registerButton"> SIGNUP </button>
              </p>

              <div class="hasAccountText">
                <span id="hideRegister">Already have an account? log in here.</span>
              </div>
            </form>

            </div>

          <div id="loginText">
            <h1>Get great music, right now</h1>
            <h2>Listen to loads of songs for free</h2>
            <ul>
              <li> Discover music you fall in love with </li>
              <li> Create your own playlist </li>
              <li> Follow artists to keep up to date </li>
            </ul>
          </div>

       </div>
   </div>
<body>
</html>
