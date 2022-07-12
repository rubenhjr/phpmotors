<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Register | PHP Motors</title>
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
                <h1>Register New User</h1>
                <?php
                    if (isset($message)) {
                    echo $message;
                }  
                ?>
                <form action="/phpmotors/accounts/index.php" method="post">
                    

                    <label for="clientFirstname">First Name: </label> <br>
                    <input type="text" name="clientFirstname" id="clientFirstname" <?php if (isset($clientFirstname)) { echo"value=$clientFirstname";}?> required><br>

                    <label for="clientLastname">Last Name: </label> <br>
                    <input type="text" name="clientLastname" id="clientLastname" <?php if(isset($clientLastname)) { echo "value=$clientLastname";}?> required><br>

                    <label for="clientEmail">Email Address: </label><br>
                    <input type="email" name="clientEmail" id="clientEmail" placeholder="Enter a valid email address" <?php if(isset($clientEmail)) { echo "value=$clientEmail";}?>required><br><br>

                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br> 
                    <label for="clientPassword">Password: </label><br>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>

                    <input type="submit" value="Register">
                    <input type="hidden" name="action" value="register">
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>