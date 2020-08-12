<? 
    include_once "./../secondary/connexion.php";

    $conn = connectdb(); 

    $login= $_COOKIE['userLogin'];
    // function GetbasicInfo($articleLink){
    
    //     $html = file_get_html("https://www.imdb.com".$articleLink);
    //     $firstInfo = $html->find(".title_wrapper");
    //     $title = $firstInfo[0]->find("h1")[0]->plaintext;
    
    //     if($html->find("div.slate_wrapper div.poster img") !=NULL)
    //         $img = $html->find("div.slate_wrapper div.poster img")[0]->src;
    //     elseif ($html->find("div.posterWithPlotSummary") != NULL) {
    //             $img = $html->find("div.posterWithPlotSummary div.poster img")[0]->src;
    //         }
    //     else
    //         $img = "../images/no_poster.png";
    
    //     return(array("title" => $title, "imgSrc"=> $img, "link" => $articleLink));
    // }

    if(isset($_POST['toWatchList'])){
    
    $position = $_POST['toWatchList'];
    $sqlToWatchList = "SELECT code,imgUrl,title from towatcharticle WHERE login = '$login' LIMIT $position,10 ";
    $resultList = mysqli_query($conn,$sqlToWatchList);
    $responseList = [];
    while($row = mysqli_fetch_assoc($resultList)){
        $responseList[]= array("link"=> $row['code'],"title"=>$row['title'],"imgSrc" => $row['imgUrl'] );
     }
    echo json_encode($responseList);
    
    }
    

    if(isset($_POST['addToList'])){
        $code = addslashes($_POST['addToList']);
        $title = addslashes($_POST['title']);
        $poster = addslashes($_POST['posterLink']);
        $sql = "INSERT INTO towatcharticle (code,login,imgUrl,title) VALUES ('$code','$login','$poster','$title')";
        if(mysqli_query($conn,$sql)){
            echo "Added to list";
        }
        else
            echo( "A problem occured");
    }

    if(isset($_POST['removeFromList'])){
        $code = addslashes($_POST['removeFromList']);
        $sql = "DELETE FROM towatcharticle WHERE code = '$code' AND login = '$login'";
        if(mysqli_query($conn,$sql)){
            echo "Removed from list";
        }
        else
            echo( "A problem occured");
    }
    
    if(isset($_POST['addToHistory'])){
        $code = addslashes($_POST['addToHistory']);
        $title = addslashes($_POST['title']);
        $poster = addslashes($_POST['posterLink']);
        $sql = "INSERT INTO watchedarticle (code,login,imgUrl,title) VALUES ('$code','$login','$poster','$title')";
        if(mysqli_query($conn,$sql)){
            echo "Added to history";
        }
        else
            echo( "A problem occured");
    }


?>