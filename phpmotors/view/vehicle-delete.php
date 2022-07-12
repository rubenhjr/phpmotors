<?php
    if($_SESSION['clientData']['clientLevel'] < 2){
        header('location: /phpmotors/');
        exit;
    }
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title> <?php if(isset($invInfo['invMake'])){ echo "Delete $invInfo[invMake] $invInfo[invModel]";}?> | PHP Motors</title>
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
                <?php if(isset($invInfo['invMake'])){ echo "Delete $invInfo[invMake] $invInfo[invModel]";}
                    ?>
            </h1><br>
                <?php
                    if (isset($message)) {
                    echo $message;
                }  
                ?>
                <h2 style="color:red";>Confirm vehicle deletion. The delete is permanent.</h2>
                <form action="/phpmotors/vehicles/index.php" method="post">

                    <label for="invMake">Make: </label>
                    <input type="text" readonly name="invMake" id="invMake" <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'";}?>> <br>
                    <label for="invModel">Model: </label>
                    <input type="text" readonly name="invModel" id="invModel"<?php if(isset($invInfo['invModel'])) { echo "value='$invInfo[invModel]'";} ?>> <br>
                    <label for="invDescription">Description: </label>
                    <textarea name="invDescription" readonly id="invDescription" <?php if(isset($invInfo['invDescription'])){ echo $invInfo['invDescription'];}?>></textarea><br>

                    <input type="submit" name="submit" value="Delete Vehicle">
                    <input type="hidden" name="action" value="deleteVehicle">
                    <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];}?>">
                    
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>