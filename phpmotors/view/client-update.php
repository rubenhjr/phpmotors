<?php
if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] && (isset($_SESSION['clientData']))){
        header('Location: /phpmotors/index.php');
    }
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    $clientLastname = $_SESSION['clientData']['clientLastname'];
    $clientEmail = $_SESSION['clientData']['clientEmail'];
    $clientId= $_SESSION['clientData']['clientId'];
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Client Update | PHP Motors</title>
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
                <h1>Manage Account</h1>
                <h2>Update Account</h2>
                <?php
                    if (isset($message)){
                        echo $message;
                    }
                ?>

                <form action="/phpmotors/accounts/" method="post">
                    <label for="clientFirstname">First Name: </label> <br>
                    <input type="text" name="clientFirstname" id="clientFirstname" 
                    <?php if(isset($clientInfo['clientFirstname'])){ echo "value='$clientInfo[clientFirstname]'"; } elseif(isset($clientFirstname)){ echo "value='$clientFirstname'";}?> required><br>

                    <label for="clientLastname">Last Name: </label> <br>
                    <input type="text" name="clientLastname" id="clientLastname"
                    <?php if(isset($clientInfo['clientLastname'])){ echo "value='$clientInfo[clientLastname]'"; } elseif(isset($clientLastname)){ echo "value='$clientLastname'";}?> required><br>

                    <label for="clientEmail">Email Address: </label><br>
                    <input type="email" name="clientEmail" id="clientEmail" placeholder="Enter a valid email address" 
                    <?php if(isset($clientInfo['clientEmail'])){ echo "value='$clientInfo[clientEmail]'"; } elseif(isset($clientEmail)){ echo "value='$clientEmail'";}?> required><br><br>

                    <input type="submit" name="submit" value="Update Info">
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="
                        <?php echo $clientInfo['clientId'];?>">
                </form>
                <h2>Update Password</h2>
                <?php if(isset($message2)){ 
                    echo $message2;}
                    ?>
                <form action="/phpmotors/accounts/index.php" method="post">
                    <p>Password must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <p>*Note: Your original password will be to change.</p>
                    <label for="updatedPassword">Password: </label>
                    <input name="clientPassword" id="updatedPassword" type="password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <input type="submit" name="action" id="updatePass" class="button" value="Update Password">
                    <input type="hidden" name="action" value="updatePassword
                    <?php if(isset(($clientId))){
                        echo $clientId;}?>">                    
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>