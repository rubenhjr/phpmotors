<?php
if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
        header('Location: /phpmotors/index.php');
}
$clientId = $_SESSION['clientData']['clientId'];
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Review Update | PHP Motors</title>
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
                    <?php if (isset($revInfo['invMake']) && isset($revInfo['invModel'])){
                        echo "$revInfo[invMake] $revInfo[invModel] Review";
                    }
                    ?>
                </h1> <br>

                <?php if(isset($_SESSION['message2'])){
                    echo $_SESSION['message2'];
                    unset($_SESSION['message2']);
                    }  
                ?>

                <p>Reviewed on <?php if(isset($reviewDate)){echo $reviewDate;} elseif(isset($revInfo['reviewDate'])){echo date('d F,Y', strtotime($revInfo['reviewDate']));}?></p>
                <form action="/phpmotors/reviews/index.php" method="post">
                    <fieldset id='update_field'>
                        <label for="revText">Review Text</label><br>
                        <textarea name="reviewText" id="revText" cols="20" rows="5" required><?php if(isset($reviewText)){echo $reviewText;} elseif(isset($revInfo['reviewText'])){echo $revInfo['reviewText']; }?></textarea>
                        <input type="submit" name="action" id="updateRevBtn" class="button" value="Update Review">
                        <input type="hidden" name="action" value="updateReview">
                        <input type="hidden" name="reviewId" value="<?php if(isset($revInfo['reviewId'])){echo $revInfo['reviewId'];} elseif(isset($reviewId)){echo $reviewId;}?>">
                    </fieldset>
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>