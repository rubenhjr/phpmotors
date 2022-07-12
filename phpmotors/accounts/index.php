<?php
// Accounts Controller
// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
//Get the reviews model
require_once '../model/reviews-model.php';

// Get the array of classifications
$classifications = getClassifications();
// var_dump($classifications);
// 	exit;

// Build a navigation bar using the $classifications array
$navList = createNavList($classifications);

// This is the main controller
$action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

switch ($action){
    case 'register':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail',FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if($existingEmail){
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
            $message = "<p id = 'error_message'> Please provide the information for the empty field.</p>";
            include '../view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
        // Check and report the result
        if($regOutcome === 1){
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            // include '../view/login.php';
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p id='error-message'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }

    break;
    case 'register-page':
        include "../view/registration.php";
    break;
    case 'login-page':
        include "../view/login.php";
        
    break;
    case 'Login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
        include '../view/login.php';
        exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if(!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        if(isset($_SESSION['message'])){
            unset($_SESSION['message']);
        }
        $clientId = $_SESSION['clientData']['clientId'];
        $clientReviews = getReviewsFromClientId($clientId);

        if(!count($clientReviews)){
            $message2 = '<p class="red">No reviews have been added yet.</p>';
        }else{
            $displayClientReviews = buildReviewDisplay($clientReviews);
        }
        // Send them to the admin view
        include '../view/admin.php';
        exit;
    break;
    case 'Logout':
        session_unset();
        session_destroy();
        include '../index.php';
        exit;
    break;
    case 'updateAccount':
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        // $clientInfo = getClient($_SESSION['clientData']['clientEmail']);
        //Validate email
        $checkEmail = checkEmail($clientEmail);
        $existingEmail = checkExistingEmail($clientEmail);
          // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
            $message = '<p class="error_message">Please do not submit a blank form field.</p>';
            include '../view/client-update.php';
            exit;
        }
        // // Check for existing email address in the table
        if($existingEmail && $clientEmail != $_SESSION['clientData']['clientEmail']){
            $message = '<p class="error_message">Sorry, that email address already exists.</p>';
            include '../view/client-update.php';
            exit;
            }
        // Send the data to the model
        $updateResult = updateAccount($clientFirstname,$clientLastname,$clientEmail, $clientId);
        // Check and report the result
        if($updateResult){
            $message = "<p class='notify'>$clientFirstname, your account has successfully been updated.</p>";
            //update client info based on ID
            $clientData = updateClient($clientId);
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p class='error_message'>Sorry $clientFirstname, we could not update your information. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }
    break;
    case 'updatePassword';
        //filter and store the data
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        //Validate password
        $checkPassword = checkPassword($clientPassword);
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        $clientData = updateClient($clientId);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // check for missing data
        if(empty($clientPassword)){
            $message2 = '<p>Please enter a password.</p>';
            include '../view/client-update.php';
            exit;
        }
        // if password matches the old password
        if($hashCheck){ 
            $message2 = '<p>Please make sure the new password is not the same as the current one.</p>';
            include '../view/client-update.php';
            exit;
        }
        // has the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // send the data to the model
        $updatePasswordOutcome = updatePassword($hashedPassword, $clientId);
        // check and report the result
        array_pop($clientData);
        if($updatePasswordOutcome){
            $clientFirstname = $_SESSION['clientData']['clientFirstname'];
            $message = "<p>$clientFirstname, your password has successfully been updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $message2 = "<p>Sorry $clientFirstname, your password was not updated successfully.</p>";
            include '../view/client-update.php';
            exit;
        }
    break;
    case 'client-update';
        include '../view/client-update.php';
    break;
    default:
    if(isset($_SESSION['message'])){
        unset($_SESSION['message']);
    }
    $clientId = $_SESSION['clientData']['clientId'];
    $clientReviews = getReviewsFromClientId($clientId);


    if(!count($clientReviews)){
        $message2 = '<p class="red">No reviews have been added yet.</p>';
    }
    else{
        $displayClientReviews = buildReviewDisplay($clientReviews);
    }
    include "../view/admin.php";
    break;
}