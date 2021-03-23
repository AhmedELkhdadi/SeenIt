<?

include_once "secondary/connexion.php";

$conn = connectdb(); 
if (!isset($_COOKIE['userLogin'])) {
    header("Location: login/login.php");
}
$login= $_COOKIE['userLogin'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="index.css?<?= time(); ?>">
    <link rel="stylesheet" href="scrollbar.css">
    <link rel="icon" type="image/png" href="images/popcorn.png">
    <title>SeenIt</title>
</head>

<body>
    <div id="fullScreenMoment" hidden>
        <img id="enlargedImg" src="">
    </div>
    <div class="container-fluid">
        <nav class="navbar py-0 row">
            <h1 id="logo" class="pt-2 mx-0 col-sm-1 text-light order-sm-1">
                SEEN<span class="text-warning">IT</span>
            </h1>
            <form id="disconnect" class="pt-2 mx-0 col-sm-1 order-sm-3" methode="GET" action="login/loginTreatement.php">
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
                <button class="btn btn-warning" id="showMoreResultsBut" onclick="showMoreResults()">Load more results</button>
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
        <div id="content" class="d-flex border-top mx-n3">
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

            <!-- ########## All results ######## -->

            <div class="flex-grow-1 border border-light rounded text-light p-2 m-2 scrollbar-light" id="moreResults" hidden>
                <p class="h2" id="closeMoreResults">&times;</p>
                <div id="spinContAllResults" class="w-100 h-100" hidden>
                    <div class="h-100 w-100 d-flex spinner">
                        <!-- this has d-flex to center wrapped div, so whene hidden,
                     the space is still take even if we give it d-none, this is why we wrap it with another div-->
                        <div class="spinner-border text-warning m-auto spinner"></div>
                    </div>
                </div>
                <p id="hold2"></p>
                <div id="allresults" class="">

                </div>
            </div>
            <!-- ########## Article Details ######## -->

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
                            <div class="d-flex flex-column border border-white mx-2 p-2 rounded">

                                <div class="">
                                    <h4 id="statusHead" class="mx-3 mb-2"></h4>
                                    <h4 id="watchDate" class="text-white mx-3 mb-3"></h4>
                                    <div class="d-flex m-2 mt-4 mb-3 w-100">
                                        <h6 class="smallHeaders mx-2">Thoughts: </h6>
                                        <div class="w-100">
                                            <div class="text-light rounded" id="thoughts" spellcheck="false" contenteditable="true"></div>
                                            <button class="btn btn-primary my-3 ml-1" id="confThought" hidden>Validate</button>
                                        </div>
                                    </div>
                                    <div id='ratingStars' class="m-2 my-2" style='display:flex;'>
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
                                                    <input id="addMoment" class="btn btn-danger" type="submit" value="Add moment">
                                                    <span id="momProb" class="text-light ml-2"></span>
                                                </form>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger hideModal" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn m-2 mx-4 w-50 text-white" id='plusMoment' data-toggle="modal" data-target="#myModalMoments">
                                        New Moment
                                    </button>
                                </div>
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
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn m-2 mx-4 w-50 text-white" id='plusQuote' data-toggle="modal" data-target="#myModalQuotes">
                                        New Quote
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button id="addToList" class="btn btn-info m-2" hidden>To Watch list</button>
                            <button id="removeFromList" class="btn btn-secondary m-2" hidden>Remove from List</button>
                            <button id="seenIt" class="btn btn-success m-2" hidden>Seen it!</button>
                            <button id="watching" class="btn btn-warning m-2" hidden>Watching</button>
                            <button id="unfinished" class="btn btn-danger m-2" hidden>Unfinished</button>
                            <button id="removeFromHistory" class="btn btn-secondary m-2" hidden>Remove from history</button>
                        </div>
                        <p id="problemDetailArticle"></p>
                    </div>
                </div>
            </div> <!-- #################################### -->


            <? include 'script.php' ?>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>