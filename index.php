<?

include_once "./../secondary/connexion.php";

$conn = connectdb(); 
if (!isset($_COOKIE['userLogin'])) {
    header("Location: ../login/login.php");
}
$login= $_COOKIE['userLogin'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>SeenIt</title>
</head>


<body>
    <form methode="GET" action="../login/loginTreatement.php">
        <input name="dc" type="submit" value="Disconnect">
    </form>

    <p> search : <input type="text" id="search" autocomplete="off"></p>

    <!-- ########## 4 Search results ######## -->
    <div id="result">
        <p id="hold1"></p>
        <table id="resultstab">

            <tr id="tr1" onclick="">
                <td id="td1">
                    <img src="" />
                </td>
                <td id="td2">

                </td>
            </tr>
            <tr id="tr2" onclick="">
                <td id="td1">
                    <img src="" />
                </td>
                <td id="td2">

                </td>
            </tr>
            <tr id="tr3" onclick="">
                <td id="td1">
                    <img src="" />
                </td>
                <td id="td2">

                </td>
            </tr>
            <tr id="tr4" onclick="">
                <td id="td1">
                    <img src="" />
                </td>
                <td id="td2">

                </td>
            </tr>

        </table>
        <button id="showMoreResultsBut" onclick="showMoreResults()" hidden>Load more results</button>
    </div>
    <!-- #################################### -->
    <!-- ########## Show all results ######## -->
    <div>
        <p id="hold2"></p>
        <table id="allresults">

        </table>
    </div>
    <!-- #################################### -->
    <!-- ########## To Watch list ########## -->
    <div style="display: flex; justify-content:space-around;">
        <fieldset>
            <h3 id="">To watch</h3>
            <table id="toWacthList">

            </table>
            <button id="loadMoreWatchList">Load more</button>
        </fieldset>

        <!-- ########## Watch history ########## -->
        <fieldset>
            <h3 id="">My watch history</h3>
            <table id="watchHistory">

            </table>
        </fieldset>

        <!-- ########## Article Detail ######## -->
        <p id="hold3"></p>
        <fieldset id="articleDetails" hidden>
            <h4 id="watch Date"></h4>
            <img style="width: 150px;height:200px" src="" alt="poster">
            <h2></h2>
            <h5></h5>
            <div>
                <p id="imdbRating"></p>
            </div>

            <p id="articleSum"></p>
            <p id="hiddenLink" hidden></p>
            <div id="seenDetail" hidden>
                <p>You can change these informations anytime you like.</p>
                <input type="number" min="0" max="10" id="userRating">/10
                <input type="text" placeholder="Thoughts">
                <div id="moments">
                    <!-- <div id="moment">
                        <img src="" alt="">
                        <p></p>
                    </div> -->
                    <button>Add moment</button>
                </div>
                <div id="quotes">
                    <button>Add moment</button>
                </div>
            </div>
            <button id="addToList">to Watch list</button>
            <button id="removeFromList" hidden>Remove from List</button>
            <button id="seenIt">Seen it!</button>
            <button id="removeFromHistory" hidden>Remove from history</button>
            <p id="problemDetailArticle"></p>

        </fieldset>


    </div> <!-- #################################### -->





</body>

<script>
    //////////////////////////////////4 SEARCH RESLUTS/////////////////////////////////
    var typingTimer; //timer identifier
    var doneTypingInterval = 500; //time in ms (1 seconds)
    var searched;
    var articles;

    //on keyup, start the countdown
    $('#search').keyup(function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    function clearSearch() {
        $("#resultstab tr").attr("onclick", "");
        $("#resultstab img ").attr("src", "");
        $("#resultstab td#td2").html("");
        $("#showMoreResultsBut").hide();
        $("#allresults").html("");
    }

    function printFourResults(value) {

        if (typeof printFourResults.counter == "undefined")
            printFourResults.counter = 1;

        $("#resultstab tr#tr" + printFourResults.counter).attr("onclick", "articleDetail('" + value['link'] + "')");
        $("#resultstab  tr#tr" + printFourResults.counter + " td#td1 img ").attr("src", value['imgSrc']);
        $("#resultstab  tr#tr" + printFourResults.counter + " td#td2 ").html(value['title']);

        if (++printFourResults.counter == 5)
            printFourResults.counter = 1;
    }


    //user is "finished typing," get search result
    function doneTyping() {
        searched = $('#search').val().trim()
        if (searched != "") {
            clearSearch();
            $("#hold1").html("...");
            var http = new XMLHttpRequest();
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let firstFour = JSON.parse(this.responseText); // I get 15 first results, I show 4 results

                    $("#hold1").html("");
                    $("#allresults").html("");
                    firstFour.forEach(printFourResults);
                    $("#showMoreResultsBut").show();

                }
            }
            http.open("GET", "./../secondary/fetchresult.php?initSearch=" + searched, true);
            http.send();

        } else { //clear sreach results when user input is ""
            clearSearch();
        }
    }
    ////////////// show 13 first results ////////////////

    function printAllResults(value) {
        let url = "articleDetail('" + value['link'] + "')";
        $("#allresults").append("<tr onclick=" + url + "><td><img src=" + value["imgSrc"] + "/></td><td>" + value["title"] + "</td></tr>");

    }
    ////////////////////////////////////////////////////  
    function showMoreResults() {
        $("#hold2").html("...");
        var http = new XMLHttpRequest();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                articles = JSON.parse(this.responseText); // I get 15 first results, I show 4 results
                $("#allresults").show();
                $("#allresults").html("");
                $("#hold2").html("");
                articles.forEach(printAllResults);
            }
        }
        http.open("GET", "./../secondary/fetchresult.php?moreSearch=" + searched, true);
        http.send();
    }
    ////////////////////////Get Info on article///////////////////////////////
    function articleDetail(articleLink) { // this function is applied on article click
        $("#hold3").html("...");
        $("#allresults").hide();
        $("#articleDetails").hide();
        $("#seenDetail").hide()
        var detailReq = new XMLHttpRequest();
        detailReq.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                let info = JSON.parse(this.responseText);
                $("#hold3").html("");
                $("#articleDetails").show();
                $("#articleDetails img").attr("src", info['poster']);
                $("#articleDetails h2").html(info['title']);
                $("#articleDetails h5").html(info['subInfo']);
                $("#articleSum").html(info['summary']);
                $("#imdbRating").html(info['imdbRating']);
                $("#problemDetailArticle").html("");
                $("#hiddenLink").html(articleLink);
                if (info['inList'] == 1) { //TODO: if seen show other elements
                    $("#addToList").hide();
                    $("#removeFromList").show();
                } else {
                    $("#addToList").show();
                    $("#removeFromList").hide();
                }
            }
        }
        detailReq.open("GET", "./../secondary/fetchresult.php?articleLink=" + articleLink, true);
        detailReq.send();
    }

    ///////////////////////////////////////////////////////////////////////////
    /////////////////////////////  WATCH LIST /////////////////////////////////


    ///////////////////////// add to  watch list ///////////////////////////////

    $("#addToList").click(function() {
        let addToList = $("#hiddenLink").html();
        let title = $("#articleDetails h2").html();
        let posterLink = $("#articleDetails img").attr("src");
        $.post(
            "libraryTreatement.php", {
                addToList: addToList,
                title: title,
                posterLink: posterLink,

            },
            function(data) {
                if (data == "Added to list") {

                    $("#addToList").hide();
                    $("#removeFromList").show();
                    $("#problemDetailArticle").html(data);
                    let url = "articleDetail('" + addToList + "')";
                    $("#toWacthList").append("<tr id='" + addToList +
                        "' onclick=" + url + "><td><img style='hight:100px;width:60px;' src='" + posterLink +
                        "'/></td><td>" + title + "</td></tr>");

                } else
                    $("#problemDetailArticle").html(data);

            },
            'text'
        );
    });
    //////////////////////// remove from watch list ///////////////////////////////
    $("#removeFromList").click(function() {
        var link = $("#hiddenLink").html();

        $.post(
            "libraryTreatement.php", {
                removeFromList: $("#hiddenLink").html(),
            },
            function(data) {
                //console.log(data);
                if (data == "Removed from list") {

                    $("#addToList").show();
                    $("#removeFromList").hide();
                    if (document.getElementById(link) != null) // in the case where the article is not loaded in the List
                        document.getElementById(link).remove();

                } else
                    $("#problemDetailArticle").html(data);
            },
            'text'

        )
    })
    //////////////////////// DISPLAY TO WATCH LIST  ///////////////////////////////
    function printWatchList(value) {
        let url = "articleDetail('" + value['link'] + "')";
        if (document.getElementById(value["link"]) == null) // in the case the article is just added and already appears in the LIST
            $("#toWacthList").append("<tr id='" + value["link"] + "' onclick=" + url +
                "><td><img style='hight:100px;width:60px;' src='" + value["imgSrc"] +
                "'/></td><td>" + value["title"] + "</td></tr>");

    }

    <?php
    $sqlRows = "SELECT COUNT(*) AS count FROM towatcharticle";
    $resRows = mysqli_fetch_assoc(mysqli_query($conn, $sqlRows))['count'];

    $sqlToWatchList = "SELECT code,imgUrl,title from towatcharticle WHERE login = '$login' LIMIT 0,10";
    $resultList = mysqli_query($conn, $sqlToWatchList);
    $responseList = [];
    while ($row = mysqli_fetch_assoc($resultList)) {
        $responseList[] = array("link" => $row['code'], "title" => $row['title'], "imgSrc" => $row['imgUrl']);
    }

    ?>

    var watchListLoaded = 0;
    var TowatchListRowsNum = <?php echo $resRows; ?>;
    var listArticles = <?php echo json_encode($responseList); ?>; // this is json parsed automaticaly
    listArticles.forEach(printWatchList);
    watchListLoaded += 10;
    if (watchListLoaded > TowatchListRowsNum) {
        $("#loadMoreWatchList").hide();
    }
    $(document).ready(function() {
        $("#loadMoreWatchList").click(function() {
            $.post(
                "libraryTreatement.php", {
                    toWatchList: watchListLoaded,
                },
                function(data) {
                    console.log(data);
                    let listArticles = JSON.parse(data);
                    listArticles.forEach(printWatchList);
                    watchListLoaded += 10;
                    if (watchListLoaded > TowatchListRowsNum) {
                        $("#loadMoreWatchList").hide();
                    }
                },
                'text'
            )
        })
    })

    ///////////////////////////////////////////////////////////////////////////
    /////////////////////////////  WATCH HISTORY  /////////////////////////////

    /////////////////////////  Add to watch history ///////////////////////////

    $("#seenIt").click(function() {
        let addToHistory = $("#hiddenLink").html();
        let title = $("#articleDetails h2").html();
        let posterLink = $("#articleDetails img").attr("src");
        $("#seenDetail").show()
        $.post(
            "libraryTreatement.php", {
                addToHistory: addToHistory,
                title: title,
                posterLink: posterLink,

            },
            function(data) {
                if (data == "Added to history") {

                    $("#seenIt").hide();
                    $("#removeFromHistory").show();
                    let url = "articleDetail('" + addToHistory + "')";
                    $("#watchHistory").append("<tr id='" + addToList +
                        "' onclick=" + url + "><td><img style='hight:100px;width:60px;' src='" + posterLink +
                        "'/></td><td>" + title + "</td></tr>");

                } else
                    $("#problemDetailArticle").html(data);
            },
            'text'
        );
    });
</script>

</html>