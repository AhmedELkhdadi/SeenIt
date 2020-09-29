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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="index.css?<?= time() ?>">
    <link rel="stylesheet" href="scrollbar.css?<?= time() ?>">
    <title>SeenIt</title>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar py-0 row">
            <h1 id="logo" class="pt-2 mx-0 col-sm-1 text-light order-sm-1">
                SEEN<span class="text-warning">IT</span>
            </h1>
            <form id="disconnect" class="pt-2 mx-0 col-sm-1 order-sm-3" methode="GET" action="../login/loginTreatement.php">
                <input name="dc" class="btn btn-warning mb-3" type="submit" value="Disconnect">
            </form>
            <div class="form-group pt-2 w-lg-25 col-sm-5 order-sm-2">
                <input type="text" class="form-control" id="search" placeholder="Movies/series/anime..." autocomplete="off">
            </div>
        </nav>
        <!-- ########## 4 Search results ######## -->
        <!-- <p id="hold1"></p> -->
        <div class="d-flex flex-column rounded mt-1" id="result" style="left: -3000px;">
            <div id="searchSpinner" class="spinner-border text-warning m-auto" hidden></div>
            <table class="table table-black table-hover  border-bottom border-light text-light" id="resultstab" hidden>
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
            <div class="mx-auto" style="position:relative;bottom:7px" id="showMoreResultsDiv" hidden>
                <button class="btn btn-light" id="showMoreResultsBut" onclick="showMoreResults()">Load more results</button>
            </div>
        </div>
        <!-- #################################### -->
        <!-- ########## Show all results ######## -->
        <!-- <div>
            <p id="hold2"></p>
            <table id="allresults">

            </table>
        </div> -->
        <!-- #################################### -->
        <div id="content" class="d-md-flex border-top mx-n3">
            <!-- ########## To Watch list ########## -->
            <div id="watchListContainer" class="border border-light rounded text-light p-2 m-2">
                <h3 class="text-warning text-center" id="">To watch</h3>
                <div id="toWatchList" class="scrollbar-light rounded">

                </div>
                <div class="d-flex justify-content-center align-items-center my-2" style="height: 50px;"><button class="btn btn-warning" id='loadMoreWatchList'>Load more</button></div>
            </div>
            <!-- ########## Watch history ########## -->
            <div id="watchHistoryContainer" class="flex-grow-1 border border-light rounded text-light p-2 m-2">
                <h3 class="text-warning text-center" id="">My watch history</h3>
                <div id="watchHistory" class="d-md-flex flex-md-wrap justify-content-xl-start justify-content-md-center align-content-start ml-md-3 rounded scrollbar-light">
                </div>
                <div class="d-flex justify-content-center align-items-center mt-1" style="height: 50px;"><button class="btn btn-warning" id='loadMoreHistory'>Load more</button></div>
            </div>
            <!-- ########## Article Detail ######## -->
            <div class="flex-grow-1 border border-light rounded text-light p-2 m-2 scrollbar-light" id="articleDetails" hidden>
                <p class="h2" id="closeDetail">&times;</p>
                <div id="spinCont" class="w-100 h-100" hidden>
                    <div class="h-100 w-100 d-flex spinner">
                        <!-- this has d-flex to center wrapped div, so whene hidden,
                     the space is still take even if we give it d-none, this is why we wrap it with another div-->
                        <div class="spinner-border text-warning m-auto spinner"></div>
                    </div>
                </div>
                <div id="detailContainer" class="" hidden>
                    <div class="d-flex flex-column w-100" hidden>
                        <div class="d-lg-flex">
                            <img class="m-2" id="articlePoster" src="" alt="poster">
                            <div class="m-2">
                                <h2 id="displayedArticleTitle" class="text-warning"></h2>
                                <h5 id="genre" class="mb-2"></h5>
                                <span class="font-weight-bold">IMDB: </span>
                                <mark class="font-weight-bold"><span id="imdbRating"></span><i class="fas fa-star text-warning"></i></mark>
                                <div class="mt-4">
                                    <h5 class="smallHeaders">Summary:</h5>
                                    <p id="articleSum"></p>
                                </div>
                            </div>
                        </div>

                        <p id="hiddenLink" hidden></p>
                        <div id='seenDetail' hidden>
                            <div class="d-flex flex-column">

                                <div class="">
                                    <h4 id="watchDate" class=""></h4>
                                    <div id='ratingStars' class="mx-2" style='display:flex;'>
                                        <h6 class="smallHeaders mx-2">Your rating: </h6>
                                        <span class="mr-2" style="position:relative;bottom:2px;" id='userRating'></span>
                                        <?
                        for($i=1;$i<=10;$i++){
                            echo "<i id='".$i."' class='fas fa-star star'></i>";
                        }
                        ?>
                                        <p class="ml-2 h3" id="deleteNote" hidden>&times;</p>
                                    </div>
                                </div>
                                <div class="d-flex mx-2 w-100">
                                    <h6 class="smallHeaders mx-2">Thoughts: </h6>
                                    <div class="w-100">
                                        <div class="text-light rounded" id="thoughts" spellcheck="false" contenteditable="true"></div>
                                        <button class="btn btn-primary my-3 ml-1" id="confThought" hidden>Validate</button>
                                    </div>
                                </div>
                                <div id="momentsContainer" class="w-100">
                                    <h6 class="smallHeaders mx-3">Moments: </h6>
                                    <div class="d-flex flex-wrap justify-content-center w-100" id="moments">
                                    </div>
                                </div>

                                <div class="modal fade" id="myModalMoments">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark">

                                            <!-- Modal Header -->
                                            <div class="modal-header text-warning">
                                                <h4 class="modal-title">Add Moment...</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form methode="post" action="" id="momentForm" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="file" class="form-control-file mb-2 btn btn-danger" name="momImg" id="momImg">
                                                        <input type="text" class="form-control text-center" name="momDes" id="momDes" placeholder="Description.." autocomplete="off">
                                                        <input type="text" name="watchedId" value="" class="hiddenWatchedId" hidden>
                                                    </div>
                                                    <span id="momProb"></span>
                                                    <input id="addMoment" class="btn btn-danger" type="submit" value="Add moment">
                                                </form>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger hideModal" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn m-2 mx-4 text-white" id='plusMoment' data-toggle="modal" data-target="#myModalMoments">
                                    New Moment
                                </button>
                                <!-- <div id="quotesContainer">
                                <div id="quotes">

                                </div>
                                <form methode="post" action="" id="quoteForm" enctype="multipart/form-data" hidden>
                                    <input type="text" name="quote" id="quoteInp" placeholder="Quote" autocomplete="off">
                                    <input type="text" name="watchedId" value="" class="hiddenWatchedId" hidden>
                                    <span id="quoteProb"></span>
                                    <input id="addQuote" type="submit" value="Add Quote">
                                </form>
                                <button id="plusQuote">New quote</button>
                            </div> -->
                                <div id="quotesContainer" class="">
                                    <h6 class="smallHeaders mx-3">Quotes: </h6>
                                    <div class="d-flex flex-column align-items-center" id="quotes">
                                    </div>
                                </div>
                                <div class="modal fade" id="myModalQuotes">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark">

                                            <!-- Modal Header -->
                                            <div class="modal-header text-warning">
                                                <h4 class="modal-title">Add Quote...</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form methode="post" action="" id="quoteForm" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-center" name="quote" id="quoteInp" placeholder="Quote.." autocomplete="off">
                                                        <input type="text" name="watchedId" value="" class="hiddenWatchedId" hidden>
                                                    </div>
                                                    <span id="quoteProb"></span>
                                                    <input id="addQuote" class="btn btn-danger" type="submit" value="Add Quote">
                                                </form>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger hideModal" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn m-2 mx-4 text-white" id='plusQuote' data-toggle="modal" data-target="#myModalQuotes">
                                    New Quote
                                </button>
                            </div>
                        </div>
                        <button id="addToList" class="btn btn-warning m-2" hidden>To Watch list</button>
                        <button id="removeFromList" class="btn btn-warning m-2" hidden>Remove from List</button>
                        <button id="seenIt" class="btn btn-warning m-2" hidden>Seen it!</button>
                        <button id="removeFromHistory" class="btn btn-warning m-2" hidden>Remove from history</button>
                        <p id="problemDetailArticle"></p>
                    </div>
                </div>
            </div> <!-- #################################### -->

            <script>
                //////////////////////////////////4 SEARCH RESLUTS/////////////////////////////////
                $("#closeDetail").click(function() {
                    $("#articleDetails").prop('hidden', true);
                    $("#watchHistoryContainer").prop('hidden', false);
                })

                var typingTimer; //timer identifier
                var doneTypingInterval = 750; //time in ms (1 seconds)
                var searched = "";
                var articles;
                var i, j, k;
                // clicking outside search result
                $(document).mouseup(function(e) {
                    var container = $("#result");
                    // if the target of the click isn't the container nor a descendant of the container
                    if (!container.is(e.target) && !$("#search").is(e.target) && container.has(e.target).length === 0) {
                        container.prop('style', "left:-3000px");
                    }
                });
                //on keyup, start the countdown
                $('#search').keyup(function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                });
                $('#search').on("focus", function() {
                    if (searched != "") {
                        $("#result").prop('style', "");
                    }
                })

                function clearSearch() {
                    $("#resultstab tr").attr("onclick", "");
                    $("#resultstab img ").attr("src", "");
                    $("#resultstab td#td2").html("");
                    $("#showMoreResultsDiv").prop('hidden', true);
                    $("#resultstab").prop("hidden", true);
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
                        $("#searchSpinner").prop('hidden', false);
                        $("#result").prop('style', ""); // remove the position relative left:-3000
                        var http = new XMLHttpRequest();
                        http.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                let firstFour = JSON.parse(this.responseText); // I get 15 first results, I show 4 results

                                $("#searchSpinner").prop('hidden', true);
                                $("#allresults").html("");
                                firstFour.forEach(printFourResults);
                                $("#resultstab").prop("hidden", false);
                                $("#showMoreResultsDiv").prop('hidden', false);

                            }
                        }
                        http.open("GET", "./../secondary/fetchresult.php?initSearch=" + searched, true);
                        http.send();

                    } else { //clear sreach results when user input is ""
                        clearSearch();
                        $("#result").prop('style', "left:-3000px");
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
                            $("#allresults").prop('hidden', false);
                            $("#allresults").html("");
                            $("#hold2").html("");
                            articles.forEach(printAllResults);
                        }
                    }
                    http.open("GET", "./../secondary/fetchresult.php?moreSearch=" + searched, true);
                    http.send();
                }
                ////////////////////////Get Info on article///////////////////////////////
                function printMoment(value) {
                    let delFuncName = "deleteMoment('" + value['moment_id'] + "','" + value['moment_img'] + "')";
                    $("#moments").append("<div class='card momentCards border border-secondary' id='moment_" + value['moment_id'] + "'><img class='card-img-top' style='width:100%;hieght:100;' src='../Moments/" +
                        value['moment_img'] + "'><p class='card-text'>" +
                        value['description'] + "</p><p class='h3 text-light deleteMoment' onclick=" + delFuncName + ">&times;</p></div>");
                }

                function printQuote(value) {
                    let delQuoteFunc = "deleteQuote('" + value['idQuote'] + "')";
                    $("#quotes").append("<div  class='d-flex justify-content-between  rounded border border-secondary oneQuote'  id='quote" +
                        value['idQuote'] + "'><blockquote class='blockquote'> - " + value['quote'] +
                        " - </blockquote><p class='h3 text-secondary' id='deleteQuote' onclick=" + delQuoteFunc + ">&times;</p></div> ");
                }

                function articleDetail(articleLink) { // this function is applied on article click
                    $("#articleDetails").prop('hidden', false);
                    $("#detailContainer").prop('hidden', true);
                    $("#spinCont").prop('hidden', false);
                    $("#watchHistoryContainer").prop('hidden', true);
                    $("#result").prop('style', "left:-3000px");
                    $("#allresults").prop('hidden', true);
                    $("#seenDetail").prop('hidden', true);
                    $("#confThought").prop('hidden', true);
                    var detailReq = new XMLHttpRequest();
                    detailReq.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                            let info = JSON.parse(this.responseText);
                            $("#spinCont").prop('hidden', true);
                            $("#detailContainer").prop('hidden', false);
                            $("#articlePoster").attr("src", info['poster']);
                            $("#displayedArticleTitle").html(info['title']);
                            $("#genre").html(info['subInfo']);
                            $("#articleSum").html(info['summary']);
                            $("#imdbRating").html(info['imdbRating']);
                            $("#problemDetailArticle").html("");
                            $("#hiddenLink").html(articleLink);
                            if (info['inList'] == 1) {
                                $("#addToList").prop('hidden', true);
                                $("#removeFromList").prop('hidden', false);
                            } else {
                                $("#addToList").prop('hidden', false);
                                $("#removeFromList").prop('hidden', true);
                            }
                            if (info['watched'] == 1) {
                                $("#seenIt").prop('hidden', true);
                                $("#addToList").prop('hidden', true);
                                $("#removeFromList").prop('hidden', true);
                                // $("#momentForm").prop('hidden', true); // in case moment form was open in another article
                                $("#moments").html("");
                                // $("#quoteForm").prop('hidden', true); // in case quote form was open in another article
                                $("#quotes").html("");
                                $("#removeFromHistory").prop('hidden', false);
                                $("#seenDetail").prop('hidden', false);
                                $(".hiddenWatchedId").val(info['id_watched']);
                                $("#watchDate").html("Watch date: " + info["watchDate"]);
                                $("#thoughts").html(info['thoughts']);
                                if (info['userRating'] != null) {
                                    let note = parseInt(info['userRating']);
                                    for (k = note + 1; k <= 10; k++) {
                                        $("#ratingStars #" + k).css("color", "grey");;
                                    }
                                    for (j = 1; j <= note; j++) {
                                        $("#ratingStars #" + j).css("color", "yellow");;
                                    }
                                    $("#userRating").html(note);
                                    $("#deleteNote").prop('hidden', false);
                                } else {
                                    for (i = 0; i <= 10; i++) {
                                        $("#ratingStars #" + i).css("color", "grey");
                                    }
                                    $("#userRating").html("");
                                    $("#deleteNote").prop('hidden', true);

                                }
                                console.log(info['moments']);
                                if (info['moments'].length > 0)
                                    info['moments'].forEach(printMoment);

                                if (info['quotes'].length > 0)
                                    info['quotes'].forEach(printQuote);
                            } else {
                                $("#seenIt").prop('hidden', false);
                                $("#removeFromHistory").prop('hidden', true);
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

                                $("#addToList").prop('hidden', true);
                                $("#removeFromList").prop('hidden', false);
                                let url = "articleDetail('" + addToList + "')";
                                $("#toWatchList").append("<div class='card my-1 rounded watchlistItem' id='list" + addToList + "' onclick=" + url +
                                    "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + posterLink +
                                    "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + title + "</h6></div></div></div></div>");
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
                                $("#addToList").prop('hidden', false);
                                $("#removeFromList").prop('hidden', true);
                                if (document.getElementById("list" + link) != null) // in the case where the article is not loaded in the List
                                    document.getElementById("list" + link).remove();

                            } else
                                $("#problemDetailArticle").html(data);
                        },
                        'text'

                    )
                })
                //////////////////////// DISPLAY TO WATCH LIST  ///////////////////////////////
                function printWatchList(value) {
                    let url = "articleDetail('" + value['link'] + "')";
                    if (document.getElementById("list" + value["link"]) == null) // in the case the article is just added and already appears in the LIST
                        $("#toWatchList").append("<div class='card my-1 mr-1 rounded watchlistItem' id='list" + value["link"] + "' onclick=" + url +
                            "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + value["imgSrc"] +
                            "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + value["title"] + "</h6></div></div></div></div>");

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
                if (watchListLoaded >= TowatchListRowsNum) {
                    $("#loadMoreWatchList").prop('hidden', true);
                }
                $(document).ready(function() {
                    $("#loadMoreWatchList").click(function() {
                        $.post(
                            "libraryTreatement.php", {
                                toWatchList: watchListLoaded,
                            },
                            function(data) {
                                //console.log(data);
                                let listArticles = JSON.parse(data);
                                listArticles.forEach(printWatchList);
                                watchListLoaded += 10;
                                if (watchListLoaded >= TowatchListRowsNum) {
                                    $("#loadMoreWatchList").prop('hidden', true);
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
                    $.post(
                        "libraryTreatement.php", {
                            addToHistory: addToHistory,
                            title: title,
                            posterLink: posterLink,

                        },
                        function(data) {
                            if (data != "A problem occured") {
                                console.log(data);
                                let info = JSON.parse(data);
                                $("#seenIt").prop('hidden', true);
                                $("#addToList").prop('hidden', true);
                                $("#removeFromList").prop('hidden', true);
                                $("#removeFromHistory").prop('hidden', false);
                                $("#thoughts").html('');
                                // $("#momentForm").prop('hidden', true); // in case moment form was open in another article
                                $("#moments").html("");
                                // $("#quoteForm").prop('hidden', true); // in case quote form was open in another article
                                $("#quotes").html("");
                                $(".hiddenWatchedId").val(info['idWatched']);
                                $("#watchDate").html("Watch date: " + info['watchDate']);
                                for (i = 0; i <= 10; i++) {
                                    $("#ratingStars #" + i).css("color", "grey");;
                                }
                                $("#userRating").html("");
                                $("#deleteNote").prop('hidden', true);
                                $("#seenDetail").prop('hidden', false);
                                let url = "articleDetail('" + addToHistory + "')";
                                $("#watchHistory").prepend("<div class='card m-1 flex-sm-grow-1 flex-xl-grow-0 rounded watchHistoryItem' id='hist" + addToHistory + "' onclick=" + url +
                                    "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + posterLink +
                                    "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + title + "</h6></div></div></div></div>");

                                if (document.getElementById("list" + addToHistory) != null)
                                    document.getElementById("list" + addToHistory).remove(); //TODO: load 1 to wacth article after every delete 

                            } else
                                $("#problemDetailArticle").html(data);
                        },
                        'text'
                    );
                });

                /////////////////////////  remove from watch history ///////////////////////////
                $("#removeFromHistory").click(function() { // TODO: add a warning and verification 
                    let link = $("#hiddenLink").html();

                    $.post(
                        "libraryTreatement.php", {
                            removeFromHistory: $("#hiddenLink").html(),
                        },
                        function(data) {
                            //console.log(data);
                            if (data == "Removed from history") {
                                $("#seenIt").prop('hidden', false);
                                $("#seenDetail").prop('hidden', true);
                                $("#addToList").prop('hidden', false);
                                $("#removeFromHistory").prop('hidden', true);

                                if (document.getElementById("hist" + link) != null) // in the case where the article is not loaded in the List
                                    document.getElementById("hist" + link).remove();

                            } else
                                $("#problemDetailArticle").html(data);
                        },
                        'text'

                    )
                })
                //////////////////////// add thought  ///////////////////////////////

                $("#thoughts").keyup(function() {
                    $("#confThought").prop('hidden', false);
                });
                $("#confThought").click(function() {
                    let thoughtToAdd = $("#thoughts").html();
                    let link = $("#hiddenLink").html();
                    $.post(
                        "libraryTreatement.php", {
                            thought: thoughtToAdd,
                            code: link,
                        },
                        function() {
                            $("#confThought").prop('hidden', true);
                        },
                        'text'
                    )
                });

                //////////////////////// add moment  ///////////////////////////////

                function printAddedMoment(value, description = "") {
                    let delFuncName = "deleteMoment('" + value['moment_id'] + "','" + value['moment_img'] + "')";
                    $("#moments").append("<div class='card momentCards border border-secondary' id='moment_" + value['moment_id'] + "'><img class='card-img-top' style='width:100%;hieght:100;' src='../Moments/" +
                        value['moment_img'] + "'><p class='card-text'>" +
                        description + "</p><p class='h3 text-light deleteMoment' onclick=" + delFuncName + ">&times;</p></div>");

                }

                // $("#plusMoment").click(function() {
                //     $("#momDes").val("");
                //     $("#momImg").val("");
                //     $("#momProb").html("");
                //     $("#momentForm").prop('hidden', false);
                // })
                $("#momentForm").on("submit", function(e) {
                    e.preventDefault();
                    $("#momProb").html("");
                    if ($("#momImg")[0].files.length == 0) {
                        $("#momProb").html("No moment Added");
                    } else {
                        $.post({
                            url: "libraryTreatement.php",
                            data: new FormData(this), //  this sends all form informations 
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                console.log(data);
                                let response = JSON.parse(data);
                                if (response['status'] == 0) {
                                    $("#momProb").html(response['message']);
                                } else {
                                    let des = $("#momDes").val();
                                    // $("#momentForm").prop('hidden', true);
                                    printAddedMoment(response, des);
                                    $(".hideModal").trigger("click");
                                }
                            },
                            dataType: 'text'

                        })
                    }
                })


                //////////////////////// Delete moments  ///////////////////////////////

                function deleteMoment(momId, momImg) { // this function is written on every moment
                    $.post(
                        "libraryTreatement.php", {
                            momentToDelete: momId,
                            momentImg: momImg
                        },
                        function(data) {
                            // console.log(data);
                            if (data == "0")
                                $("#momProb").html("A problem occured");
                            else {
                                $("#moment_" + momId).remove();
                            }
                        }, 'text'
                    )

                }


                //////////////////////// add note  ///////////////////////////////


                for (var i = 1; i < 11; i++) {
                    $("#ratingStars #" + i).click(function() {
                        let note = parseInt(this.id);
                        let link = $("#hiddenLink").html();
                        $.post(
                            "libraryTreatement.php", {
                                note: note,
                                code: link
                            },
                            function() {
                                for (let k = note + 1; k <= 10; k++) {
                                    $("#ratingStars #" + k).css("color", "grey");
                                }
                                for (let j = 1; j <= note; j++) {
                                    $("#ratingStars #" + j).css("color", "yellow");
                                }
                                $("#userRating").html(note);
                                $("#deleteNote").prop('hidden', false);
                            },
                        )
                    })
                }

                //////////////////////// delete note  ///////////////////////////////
                $("#deleteNote").click(function() {
                    let link = $("#hiddenLink").html();
                    $.post(
                        "libraryTreatement.php", {
                            codeNoteDeleted: link
                        },
                        function() {
                            for (i = 1; i <= 10; i++) {
                                $("#ratingStars #" + i).css("color", "grey");;
                            }
                            $("#deleteNote").prop('hidden', true);
                            $("#userRating").html("");
                        },
                    )
                })

                //////////////////////// add quote  ///////////////////////////////
                // $("#plusQuote").click(function() {
                //     $("#quoteInp").val("");
                //     $("#quoteProb").html("");
                //     $("#quoteForm").prop('hidden', false);
                //     $("#quoteInp").focus();
                // })
                $("#quoteForm").on("submit", function(e) {
                    e.preventDefault();
                    let quoteAdded = $("#quoteInp").val();
                    if (quoteAdded.trim() != "") {
                        $.post({
                            url: "libraryTreatement.php",
                            data: new FormData(this),
                            contentType: false,
                            cash: false,
                            processData: false,
                            success: function(data) {
                                if (data != 0) {
                                    $("#quoteProb").html("");
                                    let responseQuote = JSON.parse(data);
                                    // $("#quoteForm").prop('hidden', true);
                                    printQuote(responseQuote);
                                    $(".hideModal").trigger("click");
                                } else {
                                    $("#quoteProb").html("A problem occured")
                                }
                            },
                            dataType: 'text'
                        })
                    }

                })


                //////////////////////// delete quote  ///////////////////////////////

                function deleteQuote(id) {
                    $.post(
                        "libraryTreatement.php", {
                            quoteToDelete: id
                        },
                        function(data) {
                            // console.log(data);
                            if (data == 1)
                                $("#quote" + id).remove();
                        }, 'text'
                    )
                }

                //////////////////////// DISPLAY HISTORY  ///////////////////////////////
                function printHistory(value) {
                    let url = "articleDetail('" + value['link'] + "')";
                    if (document.getElementById(value["link"]) == null) // in the case the article is just added and already appears in the LIST
                        $("#watchHistory").append("<div class='card m-1 flex-sm-grow-1 flex-xl-grow-0 rounded watchHistoryItem' id='hist" + value["link"] + "' onclick=" + url +
                            "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + value["imgSrc"] +
                            "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + value["title"] + "</h6></div></div></div></div>");
                }

                <?php
                $sqlRows = "SELECT COUNT(*) AS count FROM watchedarticle";
                $hisRows = mysqli_fetch_assoc(mysqli_query($conn, $sqlRows))['count'];

                $sqlHistory = "SELECT code,imgUrl,title from watchedarticle WHERE login = '$login' ORDER BY id_w DESC LIMIT 0,24";
                $resultHis = mysqli_query($conn, $sqlHistory);
                $responseHis = [];
                while ($row = mysqli_fetch_assoc($resultHis)) {
                    $responseHis[] = array("link" => $row['code'], "title" => $row['title'], "imgSrc" => $row['imgUrl']);
                }

                ?>

                var historyLoaded = 0;
                var historyRowsNum = <?php echo $hisRows; ?>;
                var histArticles = <?php echo json_encode($responseHis); ?>; // this is json parsed automaticaly
                histArticles.forEach(printHistory);
                historyLoaded += 24;
                if (historyLoaded >= historyRowsNum) {
                    $("#loadMoreHistory").prop("hidden", true);
                }
                $(document).on("click", "#loadMoreHistory", function() {
                    $.post(
                        "libraryTreatement.php", {
                            loadHistory: historyLoaded,
                        },
                        function(data) {
                            // console.log(data);
                            let histArticles = JSON.parse(data);
                            histArticles.forEach(printHistory);
                            historyLoaded += 10; // in the back-end we load 10 by 10
                            if (historyLoaded >= historyRowsNum) {
                                $("#loadMoreHistory").prop("hidden", true);
                            }
                        },
                        'text'
                    )
                })
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
