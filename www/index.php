<?php

require("depend/curl.php");
$trendingQuery = 'f game.id,game.name,url,game.genres.name,game.first_release_date,game.summary,game.platforms.slug; where id >= 1 & game.category = 0 & game.first_release_date > 1672527600 & game.first_release_date < 1688162399 & game.platforms.slug = "win" & game.follows >= 1 & game.hypes >= 1 & game.cover.url ~ *"//images.igdb.com"*; l 500;';
$topQuery = 'f game.name,url,game.genres.name,game.first_release_date,game.summary,game.platforms.slug,game.platforms.name, game.follows;
where game.platforms.slug = "win" & game.follows > 100 & game.cover.url ~ *"//images.igdb.com"*; l 500;';

$url = "https://api.igdb.com/v4/covers";
$CurledTrending = getData($url, $trendingQuery);
$CurledTop = getData($url, $topQuery);

$top_games = json_decode($CurledTop);
$trending_games = json_decode($CurledTrending);


/*
if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}*/

//echo $response;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Game2Racker</title>
</head>

<body>
    <?php include("depend/navbar.php")?>
    <div class="trending">
        <h1 class="wrapper-name"> New Releases</h1>
        <div id="wrapper" class="wrapper container card-content">

            <?php
            foreach ($trending_games as $game) {
                $name = $game->game->name;
                echo "<div class=\"card\">
                        <div class=\"card-header\">
                            <a href=\"game.php?gameid=". $game->id."\"class=\"IdProperty\" title = \"$name\"></a>
                            <h3 class=\"name\">" . $game->game->name . "</h3>
                        </div>
                        <div class=\"card-body\">
                            <img loading=\"lazy\" src=\"https://" . str_replace("t_thumb", "t_cover_big", $game->url) . "\">
                        </div>
                    </div>";
            }
            ?>
        </div>
    </div>


    <div class="AlltimeTop">
        <h1 class="wrapper-name">All time Top games</h1>
        <div id="wrapper2" class="wrapper container card-content">
            <?php
            foreach ($top_games as $game) {
                $name = $game->game->name;
                echo "<div class=\"card\" >
                        <div class=\"card-header\">
                            <a href=\"game.php?gameid=" . $game->id ."\"class=\"IdProperty\" title = \"$name\"></a>
                            <h3 class=\"name\">" . $game->game->name . "</h3>
                        </div>
                        <div class=\"card-body\">
                            <img loading=\"lazy\" src=\"https://" . str_replace("t_thumb", "t_cover_big", $game->url) . "\">
                        </div>
                    </div>";                   
            }

            ?>
        </div>
    </div>

    
    <?php require("depend/footer.php"); ?>

    <script src="js/vanilla.kinetic.js"></script>
    <script type="text/javascript" charset="utf-8">
        const mediaQuery = window.matchMedia('(min-width: 800px)')
        if (mediaQuery.matches) {
            var $id = function(id) {
            return document.getElementById(id);
        };
            
        var $click = function(elem, fn) {
            return elem.addEventListener('click', function(e) {
                fn.apply(elem, [e]);
            }, false);
        };

        let rapper = document.getElementsByClassName("wrapper");
        for (let i = 0; i < rapper.length; i++) {
            new VanillaKinetic(rapper[i]);
            
        }
        }
        

        // new VanillaKinetic(document.getElementById('wrapper'), {
        //     filterTarget: function(target, e) {
        //         if (!/down|start/.test(e.type)) {
        //             return !(/area|a|input/i.test(target.tagName));
        //         }
        //     }
        // });
    </script>
    

</body>

</html>