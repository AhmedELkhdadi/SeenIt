<?
include_once "./../secondary/connexion.php";
$conn = connectdb();

if(isset($_GET['loginEntered'])){
$entered = $_GET['loginEntered'];
$sql = "SELECT * FROM users WHERE login = '$entered'";
$num = mysqli_num_rows(mysqli_query($conn,$sql));
if($num>0){
    echo "used";
}
else 
    echo "avalable";
}
if(isset($_GET['dc'])){

    if (isset($_COOKIE['userLogin'])) {
        unset($_COOKIE['userLogin']); 
        setcookie('userLogin', null, -1, '/'); }
        
        header("Location: ../index/index.php");
}
?>