<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title><?php echo $invInfo["invMake"] . " " . $invInfo["invModel"]; ?> | PHP Motors</title>
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
                <?php echo "<h1>$invInfo[invMake] $invInfo[invModel]</h1><br>";
                if(isset($message)){
                    echo $message; }
        
                if(isset($thumbnailDisplay) && isset($vehicleDisplay)){
                    echo "<div id=two-cols>";
                    }

                if(isset($thumbnailDisplay)){
                    echo $thumbnailDisplay;
                }

                if(isset($vehicleDisplay)){
                    echo $vehicleDisplay;
                    }

                if(isset($thumbnailDisplay)){
                    echo "</div>";
                    }

                echo "<h2>Customer Reviews</h2> <br>";
                echo "<h2>Review the $invInfo[invMake] $invInfo[invModel]</h2>";
                if(!isset ($_SESSION['loggedin'])){
                    echo "<p>To add a review, please <a href='/phpmotors/accounts/?action=login-page'>sign in</a> first!</p>";
                } else{
                    $screenName = substr($_SESSION['clientData']['clientFirstname'], 0,1) . $_SESSION['clientData']['clientLastname'];
                    $clientId = $_SESSION['clientData']['clientId'];

                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }

                    echo "<form action='/phpmotors/reviews/index.php' method='post'>
                    <fieldset id='review-fieldset'>
                        <label for='scrName'>Screen Name:</label>
                        <input name='screenName' id='scrName' type='text' readonly='readonly' value='$screenName'><br>
                        <label for='rev'>Review:</label>
                        <textarea name='reviewText' id='rev' rows='5' require></textarea>
                        <input type='submit' name='submit' id='reviewbtn' class='button' value='Submit Review'> <br>
                        <input type='hidden' name='action' value='addReview'>
                        <input type='hidden' name='invId' value='$invId'>
                        <input type='hidden' name='clientId' value='$clientId'>
                    </fieldset>
                    </form>";
                }

                if(isset($message2)){
                    echo $message2;
                }

                // Display the reviews
                if(isset($reviewsDisplay)){
                    echo $reviewsDisplay;
                }

                ?>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>