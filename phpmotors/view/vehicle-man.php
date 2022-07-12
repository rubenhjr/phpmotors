<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
    }
    if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    }
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Vehicle Management | PHP Motors</title>
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
                <h1>Vehicle Management</h1><br>
                <ul>
                    <li><a href="../vehicles/index.php?action=classification-page">Add Classifications</a></li>
                    <li><a href="../vehicles/index.php?action=vehicle-page">Add Vehicle</a></li>
                </ul>
                <div class="invTable">
                    <?php
                        if (isset($message)) { 
                            echo $message; 
                        } 
                        if (isset($classificationList)) { 
                            echo '<h2 class="h2Class">Vehicles By Classification</h2>'; 
                            echo '<p>Choose a classification to see those vehicles</p>'; 
                            echo $classificationList; 
                        }
                    ?>
                    <noscript>
                        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
                    </noscript>
                    <table id="inventoryDisplay"></table>
                </div>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
        <script src="../js/inventory.js"></script>
    </body>
</html>
<?php unset($_SESSION['message']); ?>