<?php
// Vehicle Controller
// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
//Get the functions library
require_once '../library/functions.php';
//Get the uploads-model library
require_once '../model/uploads-model.php';
// Get review model
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

switch ($action) {
    case 'addClass':
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'classificationName');
        // Check for missing data
        if(empty($classificationName)){
            $message = '<p id="error_message">Please provide the information for the empty field.</p>';
            include '../view/add-classification.php';
            exit;
        }
        // Send the date to the model
        $newClassification = addClassification($classificationName);
        // Check and report the result
        if($newClassification === 1){
            header("Location: /phpmotors/vehicles/index.php");
            exit;
        } else {
            $message = "<p id='error_message'>Sorry $classificationName was not able to be added at this time. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }
        break;
    case 'addCar':
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT));
        $invStock = trim(filter_input(INPUT_POST, 'invStock',FILTER_SANITIZE_NUMBER_INT ));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)){
            $message ="<p id='error_message'>Please provide the information for the empty field.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        // Send the data to the model
        $newVehicle = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        // Check and report the result
        if($newVehicle === 1){
            $message = "<p>The $invMake, $invModel was added successfully!</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p id ='error-message'>Sorry, but the vehicle registration failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;
    case 'classification-page':
        include "../view/add-classification.php";
        break;
    case 'vehicle-page':
        include "../view/add-vehicle.php";
        break;
        /* * ********************************** 
        * Get vehicles by classificationId 
        * Used for starting Update & Delete process 
        * ********************************** */ 
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;
    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
        $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock',FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message ="<p id='error_message'>Please provide the information for the empty field.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {
            $message = "<p>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else{
            $message = "<p id ='error-message'>Error. The new vehicle was not added.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
        $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p>Congratulations, the $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else{
            $message = "<p id ='error-message'>Error. The new vehicle was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
    break;
    case 'classification':
            $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vehicles = getVehiclesByClassification($classificationName);
            if(!count($vehicles)){
                $message = "<p id='error_message'>Sorry, no $classificationName vehicles could be found.</p>";
            } else {
                $vehicleDisplay = buildVehicleDisplay($vehicles);
            }
            // echo $vehicleDisplay;
            // exit;
            include '../view/classification.php';
    break;
    case 'vehicle':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invInfo = getInvItemInfo($invId);
        $carThumbnails = getThumbnail($invId);
        
        if(!count($invInfo)){
            $message = "<p id='error_message'>Sorry, no vehicle information could be found.</p>";
        } else{
            $vehicleDisplay = buildVehicleInfo($invInfo);
            $thumbnailDisplay = buildThumbnailDisplay($carThumbnails);
        }

        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $revInfo = getReviewsFromInvId($invId);

        if(!count($revInfo)){
            $message2 = "<p>Be the first to write a review!</p>";
        } else {
            $reviewsDisplay = buildReviewsInfo($revInfo);
        }

        include '../view/vehicle-detail.php';

    break;
    default:
        $classificationList = buildClassificationList($classifications);
        include "../view/vehicle-man.php";
    break;
}

