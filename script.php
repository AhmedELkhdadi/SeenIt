<script>
    //////////////////////////////////4 SEARCH RESLUTS/////////////////////////////////
    $("#closeDetail").click(function() {
        $("#articleDetails").prop('hidden', true);
        $("#watchHistoryContainer").prop('hidden', false);
    })
    $("#closeMoreResults").click(function() {
        $("#articleDetails").prop('hidden', true);
        $("#watchHistoryContainer").prop('hidden', false);
        $("#moreResults").prop('hidden', true);
    })

    var typingTimer; //timer identifier
    var doneTypingInterval = 750; //time in ms (1 seconds)
    var searched = "";
    var articles;
    var i, j, k;
    var inDataBase = "no";
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
            http.open("GET", "secondary/fetchresult.php?initSearch=" + searched, true);
            http.send();

        } else { //clear sreach results when user input is ""
            clearSearch();
            $("#result").prop('style', "left:-3000px");
        }
    }
    ////////////// show 13 first results ////////////////

    function printAllResults(value) {
        let url = "articleDetail('" + value['link'] + "')";
        $("#allresults").append("<div onclick=" + url + " class='d-flex justify-content-start border border-secondary rounded m-2 oneMoreResult'><div class='m-2'><img src=" + value[" imgSrc"] + "/></div><p class='m-2 pt-2'>" + value["title"] + "</p></div>");

    }
    ////////////////////////////////////////////////////
    function showMoreResults() {
        $("#spinContAllResults").prop('hidden', false);
        $("#result").prop('style', "left:-3000px");
        $("#moreResults").prop("hidden", false);
        $("#articleDetails").prop('hidden', true);
        $("#watchHistoryContainer").prop('hidden', true);
        var http = new XMLHttpRequest();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                articles = JSON.parse(this.responseText); // I get 15 first results, I show 4 results
                $("#spinContAllResults").prop('hidden', true);
                $("#allresults").prop('hidden', false);
                $("#allresults").html("");
                articles.forEach(printAllResults);
            }
        }
        http.open("GET", "secondary/fetchresult.php?moreSearch=" + searched, true);
        http.send();
    }
    ////////////////////////Get Info on article///////////////////////////////
    function printMoment(value) {
        let des = value['description'];
        let delFuncName = "deleteMoment('" + value['moment_id'] + "','" + value['moment_img'] + "')";
        let enlargeFun = "enlargeMoment('" + value['moment_img'] + "')";
        $("#moments").append("<div class='card momentCards border border-secondary' id='moment_" + value[' moment_id'] +
            "' ><img class='card-img-top' style='width:100%;hieght:100;' onclick=" + enlargeFun + " src='Moments/" +
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
        $("#moreDetails").prop("hidden", true);
        $("#spinCont").prop('hidden', false);
        $("#watchHistoryContainer").prop('hidden', true);
        $("#result").prop('style', "left:-3000px");
        $("#moreResults").prop('hidden', true);
        $("#seenDetail").prop('hidden', true);
        $("#confThought").prop('hidden', true);
        var detailReq = new XMLHttpRequest();
        detailReq.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // console.log(this.responseText);
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
                    inDataBase = info['status'];
                    $("#addToList").prop('hidden', true);
                    $("#removeFromList").prop('hidden', true);
                    // $("#momentForm").prop('hidden', true); // in case moment form was open in another article
                    $("#moments").html("");
                    // $("#quoteForm").prop('hidden', true); // in case quote form was open in another article
                    $("#quotes").html("");
                    if (info['status'] == "seenIt") {
                        $("#statusHead").html("Completed");
                        $("#statusHead").css("color", "#47b100");
                        $("#watching").prop('hidden', false);
                        $("#unfinished").prop('hidden', false);
                        $("#seenIt").prop('hidden', true);
                    } else if (info['status'] == "watching") {
                        $("#statusHead").html("Watching");
                        $("#statusHead").css("color", "#fdd700");
                        $("#seenIt").prop('hidden', false);
                        $("#watching").prop('hidden', true);
                        $("#unfinished").prop('hidden', false);
                    } else if (info['status'] == "unfinished") {
                        $("#statusHead").html("Unfinished");
                        $("#statusHead").css("color", "#d61a1a");
                        $("#seenIt").prop('hidden', false);
                        $("#watching").prop('hidden', false);
                        $("#unfinished").prop('hidden', true);
                    }

                    $("#removeFromHistory").prop('hidden', false);
                    $("#seenDetail").prop('hidden', false);
                    $(".hiddenWatchedId").val(info['id_watched']);
                    $("#watchDate").html("<span class='smallHeaders'>Watch date:</span> " + info["watchDate"]);
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
                    // console.log(info['moments']);
                    if (info['moments'].length > 0)
                        info['moments'].forEach(printMoment);

                    if (info['quotes'].length > 0)
                        info['quotes'].forEach(printQuote);

                } else {
                    inDataBase = "no";
                    $("#seenIt").prop('hidden', false);
                    $("#watching").prop('hidden', false);
                    $("#unfinished").prop('hidden', false);
                    $("#removeFromHistory").prop('hidden', true);
                }
            }
        }
        detailReq.open("GET", "secondary/fetchresult.php?articleLink=" + articleLink, true);
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
                    $("#toWatchList").prepend("<div class='card my-1 rounded watchlistItem' id='list" + addToList + "' onclick=" + url +
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
                    {
                        document.getElementById("list" + link).remove();
                        $.post(
                            "libraryTreatement.php", {
                                watchListAfterRemoval: watchListLoaded,
                            },
                            function(data) {
                                //console.log(data);
                                let listArticles = JSON.parse(data);
                                listArticles.forEach(printWatchList);
                                watchListLoaded += 1;
                                if (watchListLoaded >= TowatchListRowsNum) {
                                    $("#loadMoreWatchList").prop('hidden', true);
                                }
                            },
                            'text'
                        )
                    }
                }
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
    } ?>

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
    function addHistoryFunc(articleStatus) {
        if (inDataBase == "no") {
            let addToHistory = $("#hiddenLink").html();
            let title = $("#articleDetails h2").html();
            let posterLink = $("#articleDetails img").attr("src");
            let today = new Date();
            let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            $.post(
                "libraryTreatement.php", {
                    addToHistory: addToHistory,
                    title: title,
                    posterLink: posterLink,
                    currentDate: date,
                    status: articleStatus,
                },
                function(data) {
                    if (data != "A problem occured") {
                        inDataBase = articleStatus;
                        // console.log(data);
                        let info = JSON.parse(data);
                        $("#removeFromList").prop('hidden', true);
                        $("#addToList").prop('hidden', true);
                        $("#removeFromHistory").prop('hidden', false);
                        if (articleStatus == "seenIt") {
                            $("#statusHead").html("Completed");
                            $("#statusHead").css("color", "#47b100");
                            $("#watching").prop('hidden', false);
                            $("#unfinished").prop('hidden', false);
                            $("#seenIt").prop('hidden', true);
                        } else if (articleStatus == "watching") {
                            $("#statusHead").html("Watching");
                            $("#statusHead").css("color", "#fdd700");
                            $("#watching").prop('hidden', true);
                            $("#unfinished").prop('hidden', false);
                        } else if (articleStatus == "unfinished") {
                            $("#statusHead").html("Unfinished");
                            $("#statusHead").css("color", "#d61a1a");
                            $("#seenIt").prop('hidden', false);
                            $("#watching").prop('hidden', false);
                            $("#unfinished").prop('hidden', true);
                        }
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
                        $("#watchHistory").prepend("<div class='card m-1 flex-sm-grow-1 flex-xl-grow-0 rounded watchHistoryItem " + articleStatus + "Item  ' id='hist" + addToHistory + "' onclick=" + url +
                            "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + posterLink +
                            "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + title + "</h6></div></div></div></div>");

                        if (document.getElementById("list" + addToHistory) != null)
                            document.getElementById("list" + addToHistory).remove(); //TODO: load 1 to wacth article after every delete 

                    } else
                        $("#problemDetailArticle").html(data);
                },
                'text'
            );
        } else {
            let addToHistory = $("#hiddenLink").html();
            $.post(
                "libraryTreatement.php", {
                    changeStatus: addToHistory,
                    status: articleStatus,
                },
                function(data) {
                    if (articleStatus == "seenIt") {
                        $("#statusHead").html("Completed");
                        $("#statusHead").css("color", "#47b100");
                    } else if (articleStatus == "watching") {
                        $("#statusHead").html("Watching");
                        $("#statusHead").css("color", "#fdd700");
                    } else if (articleStatus == "unfinished") {
                        $("#statusHead").html("Unfinished");
                        $("#statusHead").css("color", "#d61a1a");
                    }
                    if (document.getElementById("hist" + addToHistory) != null) // in the case where the article is not loaded in the List
                    {
                        document.getElementById("hist" + addToHistory).classList.add(articleStatus + "Item");
                        document.getElementById("hist" + addToHistory).classList.remove(inDataBase + "Item");

                    }
                    $("#" + articleStatus).prop('hidden', true);
                    $("#" + inDataBase).prop('hidden', false);
                    inDataBase = articleStatus;
                    //TODO: change color in watch history 

                }
            )
        }
    }
    $("#seenIt").click(function() {
        addHistoryFunc("seenIt");
    });
    $("#watching").click(function() {
        addHistoryFunc("watching");
    });
    $("#unfinished").click(function() {
        addHistoryFunc("unfinished");
    });

    // $("#watching").click(function() {
    //     addHistoryFunc(2);
    // });
    // $("#unfinished").click(function() {
    //     addHistoryFunc(3);
    // });

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
                    inDataBase = "no";
                    $("#seenIt").prop('hidden', false);
                    $("#watching").prop('hidden', false);
                    $("#unfinished").prop('hidden', false);
                    $("#seenDetail").prop('hidden', true);
                    $("#addToList").prop('hidden', false);
                    $("#removeFromHistory").prop('hidden', true);

                    if (document.getElementById("hist" + link) != null) // in the case where the article is not loaded in the List
                    {
                        document.getElementById("hist" + link).remove();
                        $.post(
                            "libraryTreatement.php", {
                                loadAfterRemoval: historyLoaded,
                            },
                            function(data) {
                                // console.log(data);
                                let histArticles = JSON.parse(data);
                                histArticles.forEach(printHistory);
                                historyLoaded += 1; // in the back-end we load 1
                                // console.log(historyRowsNum);
                                // console.log(historyLoaded);
                                if (historyLoaded >= historyRowsNum) {
                                    $("#loadMoreHistory").prop("hidden", true);
                                }
                            },
                            'text'
                        )
                        if (historyLoaded >= historyRowsNum) {
                            $("#loadMoreHistory").prop("hidden", true);
                        }
                    }
                }
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
        let enlargeFun = "enlargeMoment('" + value['moment_img'] + "')";
        $("#moments").append("<div class='card momentCards border border-secondary'  id='moment_" + value['moment_id'] + "'><img class='card-img-top' style='width:100%;                             hieght:100;' onclick=" + enlargeFun + " src='Moments/" +
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
        $("#momProb").html("Uploading Moment... (May take some time)");
        $("#addMoment").prop("disabled", true);
        if ($("#momImg")[0].files.length == 0) {
            $("#momProb").html("No moment Added");
            $("#addMoment").prop("disabled", false);
        } else {
            $.post({
                url: "libraryTreatement.php",
                data: new FormData(this), //  this sends all form informations 
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    let response = JSON.parse(data);
                    if (response['status'] == 0) {
                        $("#momProb").html(response['message']);
                    } else {
                        let des = $("#momDes").val();
                        // $("#momentForm").prop('hidden', true);
                        printAddedMoment(response, des);
                        $("#momProb").html("");
                        $("#addMoment").prop("disabled", false);
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
    //////////////////////// enlarge Moment //////////////////////////
    function enlargeMoment(src, des) {
        $("#fullScreenMoment img").attr("src", "Moments/" + src);
        $("#fullScreenMoment").prop('hidden', false);
    }
    //////////////////////// hide enlarge ////////////////////////////
    $(document).mouseup(function(e) {
        var container = $("#enlargedImg");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && !$("#search").is(e.target)) {
            $("#fullScreenMoment").prop('hidden', true);
        }
    });
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
            $("#watchHistory").append("<div class='card m-1 flex-sm-grow-1 flex-xl-grow-0 rounded watchHistoryItem " + value['status'] + "Item' id='hist" + value["link"] + "' onclick=" + url +
                "><div class='row no-gutters h-100'><div class='col-md-3 col-2 h-100'><img class='h-100 w-100 rounded-left' src='" + value["imgSrc"] +
                "'/></div><div class='col-md-9 col-10'><div class='card-body h-100'><h6 class='card-title'>" + value["title"] + "</h6></div></div></div></div>");
    }

    <?php
    $sqlRows = "SELECT COUNT(*) AS count FROM watchedarticle";
    $hisRows = mysqli_fetch_assoc(mysqli_query($conn, $sqlRows))['count'];

    $sqlHistory = "SELECT code,imgUrl,title,status from watchedarticle WHERE login = '$login' ORDER BY id_w DESC LIMIT 0,24";
    $resultHis = mysqli_query($conn, $sqlHistory);
    $responseHis = [];
    while ($row = mysqli_fetch_assoc($resultHis)) {
        $responseHis[] = array("link" => $row['code'], "title" => $row['title'], "imgSrc" => $row['imgUrl'], "status" => $row['status']);
    }

    ?>

    var historyLoaded = 0;
    var historyRowsNum = <?php echo $hisRows; ?>;
    var histArticles = <?php echo json_encode($responseHis); ?>; // this is json parsed automaticaly
    histArticles.forEach(printHistory);
    historyLoaded += 24;
    if ((historyLoaded > historyRowsNum) || (historyLoaded == historyRowsNum)) {
        $("#loadMoreHistory").prop("hidden", true);

    }
    // console.log(historyRowsNum);
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