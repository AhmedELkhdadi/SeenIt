<? 
    include_once "secondary/connexion.php";

    $conn = connectdb(); 

    $login= $_COOKIE['userLogin'];

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
    
    if(isset($_POST['watchListAfterRemoval'])){
    
    $position = $_POST['watchListAfterRemoval'];
    $sqlToWatchList = "SELECT code,imgUrl,title from towatcharticle WHERE login = '$login' LIMIT $position,1 ";
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
        $date = date("Y-m-d",strtotime($_POST['currentDate']));
        $idWatched = uniqid();
        $status = $_POST['status'];
        $sql = "INSERT INTO watchedarticle (id_w,code,login,imgUrl,title,date,status) VALUES ('$idWatched','$code','$login','$poster','$title','$date','$status')";
        $deleteFromList ="DELETE FROM towatcharticle WHERE code='$code' AND login = '$login'";
        mysqli_query($conn,$deleteFromList);
        if(mysqli_query($conn,$sql)){

            echo json_encode(array("idWatched" => $idWatched,"watchDate" => date('Y-m-d'))) ;
        }
        else
            echo( "A problem occured");
    }
    if(isset($_POST['changeStatus'])){
        $code = addslashes($_POST['changeStatus']);
        $status = $_POST['status'];
        $sql = "UPDATE watchedarticle SET status='$status' where code = '$code' AND login = '$login' ";
        if(mysqli_query($conn,$sql)){
            echo $status;
        }
        else
            echo( "A problem occured");
    }
    if(isset($_POST['removeFromHistory'])){
        $code = addslashes($_POST['removeFromHistory']);
        $imgsToDelete = "SELECT m.img_moment,m.id_moment From moment m ,watchedarticle w 
        WHERE m.article = w.id_w AND w.code= '$code' AND w.login='$login'";
        $imgsQuery = mysqli_query($conn,$imgsToDelete);
        if(mysqli_num_rows($imgsQuery)>0){
            while($row = mysqli_fetch_assoc($imgsQuery)){
                 unlink("Moments/".$row['img_moment']);
                 $id = $row['id_moment'];
                 mysqli_query($conn,"DELETE FROM moment WHERE id_moment ='$id'");
            }
        // $momentsDelete = "DELETE moment
        // FROM moment m,watchedarticle w
        // WHERE m.article = w.id_w AND w.code= '$code' AND w.login='$login'";
        // mysqli_query($conn,$momentsDelete);
    }
        
        $quotesDelete = "DELETE quotes
        FROM quotes m,watchedarticle w
        WHERE q.article = w.id_w AND w.code= '$code' AND w.login='$login'";
        mysqli_query($conn,$quotesDelete);
        $sql ="DELETE FROM watchedarticle WHERE code= '$code' AND login='$login'";
        
        if(mysqli_query($conn,$sql)){
            echo "Removed from history";
        }
        else
            echo( "A problem occured");
        }
    
        if(isset($_POST['loadHistory'])){
    
            $position = $_POST['loadHistory'];
            $sqlHisto = "SELECT code,imgUrl,title,status from watchedarticle WHERE login = '$login' ORDER BY id_w DESC LIMIT $position,10 ";
            $resultHisto = mysqli_query($conn,$sqlHisto);
            $responseHisto = [];
            while($row = mysqli_fetch_assoc($resultHisto)){
                $responseHisto[]= array("link"=> $row['code'],"title"=>$row['title'],"imgSrc" => $row['imgUrl'],"status" => $row['status'] );
             }
            echo json_encode($responseHisto);
            
            }
            if(isset($_POST['loadAfterRemoval'])){
    
                $position = $_POST['loadAfterRemoval'];
                $sqlHisto = "SELECT code,imgUrl,title,status from watchedarticle WHERE login = '$login' ORDER BY id_w DESC LIMIT $position,1 ";
                $resultHisto = mysqli_query($conn,$sqlHisto);
                $responseHisto = [];
                while($row = mysqli_fetch_assoc($resultHisto)){
                    $responseHisto[]= array("link"=> $row['code'],"title"=>$row['title'],"imgSrc" => $row['imgUrl'],"status" => $row['status'] );
                 }
                echo json_encode($responseHisto);
                
                }
            
        if(isset($_POST['thought'])){
            $thought = addslashes(ucfirst($_POST['thought']));
            $code = $_POST['code'];
            $sql = "UPDATE watchedarticle SET thought='$thought' WHERE code = '$code' AND login = '$login'";
            mysqli_query($conn,$sql);
        }

        if(isset($_POST['note'])){
            $note = $_POST['note'];
            $code = $_POST['code'];
            $sql = "UPDATE watchedarticle SET rating='$note' WHERE code = '$code' AND login = '$login'";
            mysqli_query($conn,$sql);
        }
        if(isset($_POST['codeNoteDeleted'])){
            $code = $_POST['codeNoteDeleted'];
            $sql = "UPDATE watchedarticle SET rating = NULL WHERE code = '$code' AND login = '$login'";
            mysqli_query($conn,$sql);
        } 

        if(isset($_POST['quote'])){
            $quote = addslashes(ucfirst($_POST['quote']));
            $idArticle = $_POST['watchedId'];
            $idQuote = uniqid();
            $sql = "INSERT INTO quotes (id_quote,article,quote) values('$idQuote','$idArticle','$quote')";
            if(mysqli_query($conn,$sql))
                echo json_encode(array("idQuote"=>$idQuote,"quote"=>ucfirst($_POST['quote'])));
            else 
                echo 0;
        }
        if(isset($_POST['quoteToDelete'])){
            $idQuote = $_POST['quoteToDelete'];
            $sql = "DELETE FROM quotes WHERE id_quote ='$idQuote'";
            if(mysqli_query($conn,$sql))
                echo 1;  
        }


        if(isset($_POST['momDes']))
        {   
            $response = [];
            $momentsFile = 'Moments/'; //
            $tmp_name = $_FILES['momImg']['tmp_name'];
            if (!is_uploaded_file($tmp_name)) {
                $response['status']= 0;
                $response['message']= "Image not found";
                exit(json_encode($response));
            }
            $imageInfo = pathinfo($_FILES['momImg']['name']);
            $extension_upload = $imageInfo['extension'];
            if ($_FILES['momImg']['size'] >= 5000000) {
                $response['status']= 0;
                $response['message']= "Error,file selected too big";
                exit(json_encode($response));
            }
            $extension_upload = strtolower($extension_upload);
            $extensions_autorisees = array('png', 'jpeg', 'jpg');
            if (!in_array($extension_upload, $extensions_autorisees)) {
                $response['status']= 0;
                $response['message']= "Error,Please select an image(extensions autorised: png, jpg, jpeg)";
                exit(json_encode($response));
                
            }
            $idMom = uniqid();
            $moment_img = $idMom . "." . $extension_upload; 
            if (!move_uploaded_file($tmp_name, $momentsFile . $moment_img)) {
                exit("A probleme occured while downloading the image");
                $response['status']= 0;
                $response['message']= "A probleme occured while downloading the image";
                exit(json_encode($response));
            }

            $momDes = addslashes($_POST['momDes']);
            $idArticle =$_POST['watchedId'];
            $momentSql = "INSERT INTO moment (id_moment,Description,img_moment,article) VALUES ('$idMom','$momDes','$moment_img','$idArticle')";
            if(mysqli_query($conn,$momentSql)){
                $response['status']= 1;
                $response['moment_img']= $moment_img;
                $response['moment_id']=$idMom;
                exit(json_encode($response));
            }
            else{
                $response['status']= 0;
                $response['message']= "Couldn't add moment to the database";
                exit(json_encode($response));
            }
        
        }
                
        if(isset($_POST['momentToDelete'])){
            $moment = $_POST['momentToDelete'];
            $img = "Moments/".$_POST['momentImg'];
            $sql = "DELETE FROM moment WHERE id_moment ='$moment'";
            echo $img;
            if(mysqli_query($conn,$sql) && unlink($img))
                echo 1;  
            else 
                echo 0;
        }

        
?>