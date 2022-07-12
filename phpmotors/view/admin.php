<?php
    if(!isset($_SESSION['loggedin']) && !$_SESSION['loggedin']){
        header('Location:/phpmotors/index.php');
    }
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Admin | PHP Motors</title>
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
            <h1>
            <?php
            if (isset($_SESSION['clientData'])) {
                echo $_SESSION['clientData']['clientFirstname'] . " " .$_SESSION['clientData']['clientLastname'];}
            ?>
            </h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }?>
            <p class="paragraph">You are logged in</p>

            <ul class="adminDetails">
                <li>First Name: 
                <?php
                if (isset($_SESSION['clientData'])) {
                    echo " " . $_SESSION['clientData']['clientFirstname'];}
                ?>
                </li>
                <li>Last Name:
                <?php
                if (isset($_SESSION['clientData'])) {
                    echo " " . $_SESSION['clientData']['clientLastname'];}
                ?>
                </li>
                <li>Email:
                <?php
                if (isset($_SESSION['clientData'])) {
                    echo " " . $_SESSION['clientData']['clientEmail'];}
                ?>
                </li>
            </ul>

            <h2>Account Management</h2>
            <p>Use this link to update your account information</p></p>
            <a href='/phpmotors/accounts/?action=client-update'>Update Account Information</a>

            <?php
                if (isset($_SESSION['clientData']) && $_SESSION['clientData']['clientLevel'] > 1) {
                    echo "<h2 class='margin_top'>Inventory Management</h2>";
                    echo "<p class='paragraph'>Use this link to manage the inventory</p>";
                    echo "<a href='/phpmotors/vehicles/'>Vehicle Management</a><br>";
                }

                echo "<h2>Manage your Reviews</h2>";
                if (isset($message2)){
                    echo $message2;
                }
                if (isset($displayClientReviews)){
                    echo $displayClientReviews;
                }
            ?>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>