<?php
// reviews controller
// Create or access a Session
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
//Get the functions library
require_once '../library/functions.php';
//Get the reviews model
require_once '../model/reviews-model.php';

// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = createNavList($classifications);

// This is the main controller
$action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action) {
        case 'addReview':
            // Filter and store the data
            $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

            // check for missing data
            if(empty($reviewText) || empty($invId) || empty($clientId)){
                $message = "<p id='error_message'>Please provide the information for the empty field.</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/?action=vehicle&invId=' . $invId);
                exit;
            }

            $reviewOutcome = insertReview($reviewText, $invId, $clientId);

            // Check and report the result
            if($reviewOutcome){
                $message = "Thank you for submitting the review!";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/?action=vehicle&invId=' . $invId);
                exit;
            } else{
                $message = "<p id='error_message'>Sorry but the review was not submitted. Please try again.</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/?action=vehicle&invId=' . $invId);
                exit;
            }
            break;

        case 'mod':
            $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
            $revInfo = getRevItemInfo($reviewId);
            $reviewDate = date('d F,Y', strtotime($revInfo['reviewDate']));
            $reviewText = $revInfo['reviewText'];
            $invMake = $revInfo['invMake'];
            $invModel = $revInfo['invModel'];

            // //check to see if $invInfo has any data. If not, we will set an error message
            // if(count($revInfo)<1){
            //     $message = '<p>Sorry, no review information could be found.</p>';
            // }
            include '../view/review-update.php';
            exit;
        case 'del':
            $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
            $revInfo = getRevItemInfo($reviewId);
            $reviewDate = $revInfo['reviewDate'];
            $reviewText = $revInfo['reviewText'];
            $invMake = $revInfo['invMake'];
            $invModel = $revInfo['invModel'];

            // check to see if $invInfo has any data
            if(count($revInfo)<1){
                $message = "<p id='error_message'>Sorry, no review information was found.</p>";
            }
            include '../view/review-delete.php';
            exit;

        case 'updateReview':
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
            $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (empty($reviewId) || empty($reviewText)) {
                $message = "<p class='red'>Please make sure not to leave the review form blank.</p>";
                $_SESSION['message2'] = $message;
                header('location: /phpmotors/reviews/?action=mod&reviewId='.$reviewId);
                exit;
            }
            $updateResult = updateReview($reviewId, $reviewText);

            if ($updateResult) {
                $message = "<p class='notify'>The review was updated successfully.</p>";
                $_SESSION['message2'] = $message;
                header('location: /phpmotors/reviews/?action=mod&reviewId='.$reviewId);
                exit;
            }
            else {
                $message = "<p class='red'>Error. The new review was not updated.</p>";
                include '../view/review-update.php';
                exit;
            }
            break; 
        case 'deleteReview':
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
            $deleteResult = deleteReview($reviewId);

            if ($deleteResult) {
                $message = "<p>The review was successfully deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/accounts/');
                exit;
            } else{
                $message = "<p id='error_message'>Error, the new review was not updated.</p>";
                $_SESSION['message'] = $message;
                include '../view/review-delete.php';
                exit;
            }
            break;
        default:
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
                include '../view/admin.php';
                exit;
            } else{
                header('location: /phpmotors/index.php');
            }
            break;
    }

?>