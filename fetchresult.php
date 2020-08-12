<?
include ('../../simpleHTMLdom/simple_html_dom.php');
include_once "./../secondary/connexion.php";
$conn = connectdb(); 

$login= $_COOKIE['userLogin'];

if(isset($_GET['initSearch'])){
    $str = preg_replace("/[ ]+/", "+", $_GET['initSearch']);     // Replace spaces (1 or more) by a "+" to be url freindly
    if ($str !="") {
    $html = file_get_html("https://www.imdb.com/find?q=".$str."&s=tt&ref_=fn_al_tt_mr");
    $response=[];
    
    $title= $html->find("tr[class=findResult even],tr[class=findResult odd]");
    
    for ($i=0; $i < 4 ; $i++) { 
        $link = $title[$i]->find('a',0)->href;
        $imgSrc = $title[$i]->find('img')[0]->src;

        $response[] = array( "title" => $title[$i]->plaintext,"imgSrc" => $imgSrc ,"link" => $link);
    }

    echo json_encode($response);
}}

if(isset($_GET['moreSearch'])){
    $str = preg_replace("/[ ]+/", "+", $_GET['moreSearch']);     // Replace spaces (1 or more) by a "+" to be url freindly
    if ($str !="") {
    $html = file_get_html("https://www.imdb.com/find?q=".$str."&s=tt&ref_=fn_al_tt_mr");
    $response=[];
    
    $title= $html->find("tr[class=findResult even],tr[class=findResult odd]");
    $count = count($title);
    if($count > 13)
        $count= 13;
    for ($i=0; $i < $count ; $i++) { 
        $link = $title[$i]->find('a',0)->href;
        $imgSrc = $title[$i]->find('img')[0]->src;

        $response[] = array( "title" => $title[$i]->plaintext,"imgSrc" => $imgSrc ,"link" => $link);
    }

    echo json_encode($response);
}}

if(isset($_GET['articleLink'])){
    $articleLink = $_GET['articleLink'];

    $html = file_get_html("https://www.imdb.com".$_GET['articleLink']);
    $firstInfo = $html->find(".title_wrapper");
    $title = $firstInfo[0]->find("h1")[0]->plaintext;
    
    if($firstInfo[0]->find("div.subtext")!= NULL  )
        $genreRelease = $firstInfo[0]->find("div.subtext")[0]->plaintext;
    else
        $genreRelease="";

    if($html->find("div.ratingValue") != NULL)
        $rating = $html->find("div.ratingValue")[0]->plaintext;
    else 
        $rating = "";
    if($html->find("div.slate_wrapper div.poster img") !=NULL)
        $img = $html->find("div.slate_wrapper div.poster img")[0]->src;
    elseif ($html->find("div.posterWithPlotSummary") != NULL) {
            $img = $html->find("div.posterWithPlotSummary div.poster img")[0]->src;
        }
    else
        $img = "../images/no_poster.png";
    
    if($html->find("div.summary_text a")== NULL  )              // in IMDB there a link <a> if there is no summary
        $summary = $html->find("div.summary_text")[0]->plaintext;
    else
        $summary="";
    
    $sql = "SELECT * FROM towatcharticle WHERE login='$login' AND code='$articleLink' ";
    $num = mysqli_num_rows(mysqli_query($conn,$sql));
    if($num > 0)
        $inList = 1;
    else
        $inList = 0;
    //TODO: check if Seen
    $info = array("title" => $title, "subInfo" => $genreRelease,
     "imdbRating" => $rating,"summary" => $summary, "poster"=> $img, "inList" => $inList);
    echo json_encode($info);
      
}

if(isset($_GET['articleLinkBasic'])){
    $articleLink = $_GET['articleLink'];
    $html = file_get_html("https://www.imdb.com".$_GET['articleLink']);
    $firstInfo = $html->find(".title_wrapper");
    $title = $firstInfo[0]->find("h1")[0]->plaintext;

    if($html->find("div.slate_wrapper div.poster img") !=NULL)
        $img = $html->find("div.slate_wrapper div.poster img")[0]->src;
    elseif ($html->find("div.posterWithPlotSummary") != NULL) {
            $img = $html->find("div.posterWithPlotSummary div.poster img")[0]->src;
        }
    else
        $img = "../images/no_poster.png";

    //TODO: check if Seen
    $info = array("title" => $title, "poster"=> $img);
    echo json_encode($info);

}