<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A tetris webpage">
    <meta name="author" content="SitePoint">
    <title>Tetris</title>
    <link rel="shortcut icon" href="#" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Adds the navbar-->
    <?php include 'navbar.php';?>    
    <div class="main">
        <div class="grey_box">
            <form action="index.php" method="post">
                <h2>Registration form</h2>
                <label for="firstName" >First Name:</label><br>
                <input type="text" name="firstName" required>
                <br>
                <label for="lastName" >Last Name:</label><br>
                <input type="text" name="lastName" required>
                <br>
                <label for="username" >Username:</label><br>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" placeholder="Password" required>
                <br>
                <!--<label for="password">Confirm Password:</label><br>-->
                <input type="password" name="confirmPass" placeholder="Confirm Password" required>
                <br>
                <p>Display Scores on Leaderboard:</p>
                <input type="radio" name="display" value="yes" required>
                <label for="displayYes">Yes</label>
                <br>
                <input type="radio" name="display" value="no">
                <label for="displayNo">No</label>
                <br>
                <input type="submit" name="reg" value="Register">
                <br>
            </form>
</div> 
    </div>    
</body>
</html>