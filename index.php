<?php include 'connect.php';
session_start();
// Includes connection to databse and starts a session for user to log in

//When user clicks login button the username and password are passed through and then checked if are correct
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userWrong = 0;
    $passWrong = 0;
    
    //SQL queery to check if user exists in database and gets all data to go with
    $queryLog = "SELECT * FROM Users WHERE UserName = '$username'"; 
    $resultLog = mysqli_query($conn, $queryLog);

    //Checks if there is a row where username is the same
    if(mysqli_num_rows($resultLog) == 1){
        while($row = mysqli_fetch_assoc($resultLog)){
            //Checks if password is correct and then returns a welcome message
            $pass_check = $row['Password'];
            $name_welcome = $row['FirstName'];
            if($password == $pass_check){
                //Creates a session for the user so they dont have to log in again and sets userWrong and passWrong to false values
                $_SESSION['userLog'] = $username;
                $userWrong = 2;
                $passWrong = 2;
            }else{
                //Else indicates the password is wrong
                $passWrong = 1;
            };
        };
    }else{
        //Else indicates the username is wrong
        $userWrong = 1;
    }
};

//When user click register button on register.php all the data is passed through 
if(isset($_POST['reg'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmPass'];
    $display = $_POST['display'];

    //SQL querry to check if username exists already
    $queryReg = "SELECT * FROM Users WHERE UserName = '$username'";
    $resultReg = mysqli_query($conn, $queryReg);

    //If no record with that username exists password and confirm password is checked
    if(mysqli_num_rows($resultReg) == 0){
        if($password != $confirmPass){
            die("Password doesnt match!");
        }else{
            //After the checks the Display value is converted to the int value SQL table requires rather than the value passed through POST
            if($display == "yes"){
                $displayIn = 1;
            }elseif($display == "no"){
                $displayIn = 2;
            }else{
                $displayIn = 0;
            };
            //SQL querry to insert the record in the database and then is checked if it went through else throws a Error
            $inputReg = "INSERT INTO Users (UserName, FirstName, LastName, Password, Display)  VALUES ('$username', '$firstName', '$lastName', '$password', '$displayIn')";
            $queryInp = mysqli_query($conn , $inputReg);
            if(!$queryInp){
                die("Error in creating account, Please try agian later.");
            }
        };
    }else{
        //If username exists error occurs
        die("Username already exists please try a different one!");
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A tetris webpage">
    <meta name="author" content="SitePoint">
    <link rel="shortcut icon" href="#" />
    <title>Tetris</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Adds the navbar-->
    <?php include 'navbar.php';?>  
    <div class="main">
        <div class="grey_box">
            <?php 
            // Checks if there is a user logged in and if the session is not a empty name
            if((isset($_SESSION['userLog'])&& $_SESSION['userLog'] != '')) { 
                ?>
                <div class="logged">
                    <p> Welcome to Tetris </p>
                    <a href="tetris.php"><button>Click here to play!</button></a>
                    <br><br>
                    <a href = logout.php><button>Log Out</button></a>
                </div>
                <?php
            }else{ 
                ?>
                <div class="not_logged">
                    <form action="index.php" method="post">
                        <br>
                        <h1>Log In for Tetris!</h1>
                        <br>
                        <label for="username" >Username:</label>
                        <input type="text" placeholder="username" name="username" required>
                        <br>
                        <label for="password">Password:</label>
                        <input type="password" name="password">
                        <br><br>
                        <input type="submit" name="login" value="Login" required>
                        <br>
                        <?php 
                        // Uses name and pass checks to output if there is something wrong with the login
                        if ($userWrong == 1){
                            echo "Wrong Username used!<br>Try again or" .'<a href="register.php"> Register now</a>';
                        };
                        if ($passWrong == 1){
                            echo "Password is incorrect! Try again please.";
                        };
                        // Else it was sucessful and a session is created line 24 and a welcome messages outputed
                        if (($userWrong == 2 ) && ($passWrong == 2)){
                            echo "Login was successful! <br> Welcome " . $name_welcome; 

                        };
                    };
                    ?>
                    <p>Don't have a user account? <a href="register.php"> Register now</a></p>
                </form>
            </div>
        </div>
    </div>    
</body>
</html>