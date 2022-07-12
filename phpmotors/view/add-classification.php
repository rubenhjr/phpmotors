<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>New Classification | PHP Motors</title>
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
                <h1>Add Car Classification</h1>
                <?php
                if (isset($message)) {
                echo $message;
                }
                ?>
                <form action="/phpmotors/vehicles/index.php" method="post">
                    <span>Please enter no more than 30 characters.</span> <br><br>
                    <label for="className">Classification Name:</label> <br>
                    <input type="text" name="classificationName" id="className" required maxlength="30"> <br>
                    <input type="submit" name="action" value="Add Classification">
                    <input type="hidden" name="action" value="addClass"> <br>
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>
