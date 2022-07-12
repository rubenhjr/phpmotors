<?php
    $classificationList = '<select name="classificationId" required>';
    $classificationList .= "<option value=''>Choose Car Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";
        if(isset($classificationId)){
            if($classification['classificationId'] == $classificationId){
                $classificationList .= ' selected ';
            }
        }
        $classificationList .= ">$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Add Vehicle | PHP Motors</title>
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
                <h1>Add Vehicle</h1><br>
                <?php
                    if (isset($message)) {
                    echo $message;
                }  
                ?>
                <form action="/phpmotors/vehicles/index.php" method="post">
                    <span>Select a Classification:</span>
                        <?php echo $classificationList;?>
                        <br> <br>
                    <label for="invMake">Make: </label>
                    <input type="text" name="invMake" id="invMake" maxlength="30" <?php if(isset($invMake)) {echo "value='$invMake'";}?> required> <br>
                    <label for="invModel">Model: </label>
                    <input type="text" name="invModel" id="invModel" maxlength='30' <?php if(isset($invModel)) { echo "value='$invModel'";} ?> required> <br>
                    <label for="invDescription">Description: </label>
                    <textarea name="invDescription" id="invDescription" cols="15" rows="5" <?php if(isset($invDescription)){ echo "value='$invDescription'";} ?>required></textarea><br>
                    <label for="invImage">Image: </label>
                    <input type="text" name="invImage" id="invImage" placeholder="../images/no-image.png" maxlength="50" <?php if(isset($invImage)){ echo "value='$invImage'";} ?> required><br>
                    <label for="invThumbnail">Image Thumbnail: </label>
                    <input type="text" name="invThumbnail" id="invThumbnail" placeholder="../images/no-image.png" maxlength="50" <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'";}?> required><br>
                    <label for="invPrice">Price: </label>
                    <input type="text" name="invPrice" id="invPrice" <?php if(isset($invPrice)) { echo "value='$invPrice'";} ?> required> <br>
                    <label for="invStock">Total in Stock: </label>
                    <input type="text" name="invStock" id="invStock" <?php if(isset($invStock)) { echo "value='$invStock'";} ?> required> <br>
                    <label for="invColor">Color: </label>
                    <input type="text" name="invColor" id="invColor" maxlength="20" <?php if(isset($invColor)) { echo "value='$invColor'";} ?> required> <br>

                    <input type="submit" name="action" value="Add Car">
                    <input type="hidden" name="action" value="addCar">
                    
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>