<? include_once "./../secondary/connexion.php";
$conn = connectdb();
if(isset($_POST['signup'])){
    $login = $_POST['login'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (login,pwd,name,Email)
    Values ('$login','$pass','$name','$email') ";
    if(mysqli_query($conn,$sql))
    {   
        //TODO: Creat cookies
        setcookie("userLogin",$login,time()+(86400 * 30),"/"); //(86400 * 30) is a day 
        header("Location: ../index/index.php");
    }
    else{
        $problemSigneUp = "A probleme has occured.";
    }
}
if(isset($_POST['connect'])){
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $sql = "SELECT login FROM users WHERE login = '$login' AND pwd = '$pass';";
    if(mysqli_fetch_assoc(mysqli_query($conn,$sql)))
    {
        //TODO: Creat cookies
        setcookie("userLogin",$login,time()+(86400 * 30),"/"); //(86400 * 30) is a day 
        header("Location: ../index/index.php");
    }
    else{
        $logExist = "SELECT login FROM users WHERE login = '$login';";
        if(mysqli_fetch_assoc(mysqli_query($conn,$logExist)))
            $problemConnect = "Password incorrect.";
        else
            $problemConnect = "Login not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>SeenIt</title>
    <style>
        body {
            display: flex;
            justify-content: space-around;
        }

        fieldset {
            width: 40%;
        }

        form {
            display: flex;
            flex-direction: column;

        }

        input[type="submit"] {
            width: 20%;
            margin: auto;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <fieldset>
        <div id="signupdiv">
            <form method="POST" action="#">
                <label for="login">Login :<span id="loginAvailablity"></span> </label>
                <input type="text" name="login" id="loginsignup" required>
                <label for="name">Name : </label>
                <input type="text" name="name" required>
                <label for="email">Email (Needed in case password is forgotten): </label>
                <input type="email" name="email">
                <label for="pass">Password : </label>
                <input type="password" name="pass" id="pass" pattern=".{6,}" title="six or more characters" required>
                <label for="passConf">Confirme Password : </label>
                <input type="password" name="passConf" id="passConf" required>
                <input type="submit" value="Signe up" name="signup" id="signup">
            </form>
            <?if(isset($problemSigneUp)){
                echo "<p>".$problemSigneUp."</p>";
            }
            ?>
        </div>
    </fieldset>
    <fieldset>
        <div id="logindiv">
            <form method="POST" action="#">
                <label for="login">Login : </label>
                <input type="text" name="login" required>
                <label for="pass">Password : </label>
                <input type="password" name="pass" required>
                <input type="submit" value="Connect" name="connect">
            </form>

            <?if(isset($problemConnect )){
                echo "<p>".$problemConnect."</p>";
            }
            //TODO: Forgot password
            ?>
        </div>
    </fieldset>
    <script>
        $("#loginsignup").keyup(function() { // this sends request to server to see if login exits already or not on keyup
            $.get(
                "loginTreatement.php", {
                    loginEntered: $("#loginsignup").val().trim()
                },
                function(data) {

                    if (data == "used" && $("#loginsignup").val() != "") {
                        $("#loginAvailablity").html("Login not available");
                        $("#loginAvailablity").css("color", "red");
                        $("#loginsignup").css("outline-color", "red");
                        $("#signup").attr("disabled", "disabled");
                    } else if ($("#loginsignup").val() != "") {
                        $("#loginAvailablity").html("Login available");
                        $("#loginAvailablity").css("color", "green");
                        $("#loginsignup").css("outline-color", "green");
                        $("#signup").attr("disabled", false);
                    } else {
                        $("#loginAvailablity").html("");
                        $("#loginAvailablity").css("color", "black");
                        $("#loginsignup").css("outline-color", "black");
                        $("#signup").attr("disabled", false);
                    }
                },
                'text'
            )
        })
        $(Document).ready(function() { // this checks if password confirmation is verified or not 
            $("#passConf").keyup(function() {
                if ($("#passConf").val() == $("#pass").val() && $("#passConf").val() != "") {
                    $("#passConf").css("outline-color", "green");
                    $("#signup").attr("disabled", false);
                } else {
                    $("#passConf").css("outline-color", "red");
                    $("#signup").attr("disabled", "disabled");
                }
            });
        });
        $(Document).ready(function() { // this is for the case where user changes password to the valuie of confirmation 
            $("#pass").keyup(function() {
                if ($("#passConf").val() == $("#pass").val() && $("#passConf").val() != "") {
                    $("#passConf").css("outline-color", "green");
                    $("#signup").attr("disabled", false);
                } else {
                    $("#passConf").css("outline-color", "red");
                    $("#signup").attr("disabled", "disabled");
                }
            });
        });
    </script>
</body>

</html>