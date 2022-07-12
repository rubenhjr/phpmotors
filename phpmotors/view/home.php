<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
        <link rel="stylesheet" href="/phpmotors/css/phpmotors_style.css">
        <title>Home | PHP Motors</title>
    </head>
    
    <body>
        <div class="wrapper">
            <header>
                <?php require $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/header.php' ?>
            </header>
            <nav>
            <?php
                    // require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'
                    echo $navList; 
            ?>
            </nav>
            <main>
                <h1>Welcome to Php Motors!</h1>
                <div class="cont_picture">
                    <div class="description"> 
                                <h2 id="homeH2">DMC Delorean</h2>
                                <p>3 Cup holders<br>
                                Superman doors<br>
                                Fuzzy dice!</p>
                    </div>
                    <div id="container">
                        <img class="delor_img" src="/phpmotors/images/vehicles/delorean.jpg" alt="delorean">
                        <img src="/phpmotors/images/site/own_today.png" id="own" alt="button to buy car">
                    </div>
                </div>
                <div id="flex">
                    <div class="column_review">
                            <h3>DMC Delorean Reviews</h3>
                            <ul>
                                <li>"So fast it's almost like traveling in time." (4/5)</li>
                                <li>"Coolest ride on the road." (4/5)</li>
                                <li>"I'm feeling Marty McFly!" (5/5)</li>
                                <li>"The most futuristic ride of our day." (4.5/5)</li>
                                <li>"80's living and love it!" (5/5)</li>
                            </ul>
                    </div>
                    <div class="grid">
                        <div class="column_upgrades">
                            <h3>Delorean Upgrades</h3>
                            <div class="first_section">
                                <div class="upgrades">
                                    <img class="img_upgrades" src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux Capacitor">
                                    <a href="#">Flux Capacitor</a>
                                </div> <br>
                                <div class="upgrades">
                                    <img class="img_upgrades" src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers">
                                    <a href="#">Bumper Stickers</a>
                                </div> <br>
                            </div>
                            <div class="second_section">
                                <div class="upgrades">
                                    <img class="img_upgrades" src="/phpmotors/images/upgrades/flame.jpg" alt="Flame Decals">
                                    <a href="#">Flame Decals</a>
                                </div> <br>
                                <div class="upgrades">
                                    <img class="img_upgrades" src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub Caps">
                                    <a href="#">Hub Caps</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>