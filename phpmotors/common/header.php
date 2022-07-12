<div class="logo">
    <img src="/phpmotors/images/site/logo.png" alt="PHP Motors">
</div>
    <?php 
        // if (isset($_SESSION['clientData'])) {
            // echo "<a>Welcome ". $_SESSION['clientData']['clientFirstname']."</a>";
            // }
            
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_SESSION['clientData'])){
            echo "<div id='flex-span'><a href='/phpmotors/accounts/'> " . $_SESSION['clientData']['clientFirstname'] . "</a>  |  <a href='/phpmotors/accounts/?action=Logout'>Logout</a></div>";
        }
        else{
            echo "<a class='account' href='/phpmotors/accounts/?action=login-page'>My Account</a>";
        }
    ?>
    <!-- <h1><a class="account" href="/phpmotors/accounts/index.php?action=login">My Account</a></h1> -->
    