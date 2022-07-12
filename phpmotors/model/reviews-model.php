<?php
// insert a review
function insertReview($reviewText, $invId, $clientId) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews(reviewText, invId, clientId) VALUES (:reviewText, :invId, :clientId)';
    $stmt = $db->prepare($sql);
    // Store review in database
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
//Gets reviews from specific inventory item
function getReviewsFromInvId($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, clients.clientFirstname, clients.clientLastname FROM reviews JOIN clients ON reviews.clientId = clients.clientId WHERE reviews.invId = :invId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $revInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $revInfo;
}
//Gets reviews by a specific client
function getReviewsFromClientId($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewDate, reviewId, inventory.invMake, inventory.invModel FROM reviews JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $revInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $revInfo;
}
function getRevItemInfo($reviewId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, inventory.invMake, inventory.invModel FROM reviews JOIN inventory ON inventory.invId = reviews.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $revInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $revInfo;
}
//Update review info
function updateReview($reviewId, $reviewText){
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewDate = CURRENT_TIMESTAMP, reviewText = :reviewText WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
//Delete review
function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

?>