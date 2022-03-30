<?php include 'connect.php';
session_start();
if(isset($_POST['score'])){
    $score = $_POST['score'];
    $uname = "Guest";
    if((isset($_SESSION['userLog']))&& ($_SESSION['userLog'] != '')){ 
        $uname = $_SESSION['userLog'];
    }
    $sql = "INSERT INTO Scores (Username, Score) VALUES ('$uname', '$score')";
    $sqlQuerry = mysqli_query($conn,$sql);
    if(!$sqlQuerry){
        die("Error in submiting score : " . $score . " for user : " . $uname);
    }else{
        echo "Score submited!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A tetris webpage">
    <meta name="author" content="SitePoint">
    <title>Tetris</title>
    <link rel="shortcut icon" href="#" />
    <script type="text/javascript" src="jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Adds the navbar-->
    <?php include 'navbar.php';?>    
    <div class="main">
        <div class="grey_box">
            <h2> Tetris Leaderboard </h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Score</th>
                </tr>
            <?php include 'connect.php';
                //Gets all data from the databse
                $score = "SELECT * FROM Scores ORDER BY Score DESC";
                $scoreQuer = mysqli_query($conn , $score);
                //While each row value is set to a varriable
                while($row = mysqli_fetch_assoc($scoreQuer))
                    {
                        //Assign the set row of a record to a username and score variables
                        $userGot = $row['Username'];
                        $scoreGot = $row['Score'];
                        //Then a its checked if they wanted to show there score on the leaderboard when making an account
                        if($userGot != 'Guest'){
                            $check = "SELECT * FROM Users WHERE UserName = '$userGot'";
                            $checkDisplay = mysqli_query($conn , $check);
                            $temp = mysqli_fetch_assoc($checkDisplay);
                            $display = $temp['Display'];
                        } else {
                            $display = 1;
                        }
                        // Then the values are placed into the table
                        if($display == 1){
                            echo "<tr><td>" . $userGot . "</td><td> " . $scoreGot ."</td></tr>";
                        }
                    };
                ?>
            </table>

        </div>
    </div>    
</body>
</html>