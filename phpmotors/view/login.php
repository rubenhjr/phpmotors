<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/phpmotors/css/phpmotors_style.css">
        <title>Login | PHP Motors</title>
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
                <h1>Login</h1>

                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>

                <form id="registrationForm" method="post" action="/phpmotors/accounts/" id="logForm">
                    <label for="clientEmail"> Email Address:</label> <br>
                    <input type="text" name="clientEmail" id="clientEmail" placeholder="Email Address" required <?php if(isset($clientEmail)) { echo "value=$clientEmail";}?>><br>

                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                    <label for="clientPassword">Password: </label><br>
                    <input type="password" name="clientPassword" id="clientPassword" placeholder="Password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>

                    <input type="submit" value="Login"> <br>
                    <input type="hidden" name="action" value="Login">
                    <span id="registerNew">No account? <a href='../accounts/index.php?action=register-page'>Sign-up</a></span>
                </form>
            </main>
            <footer>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php' ?>
            </footer>
        </div>  <!--wrapper ends-->
    </body>
</html>