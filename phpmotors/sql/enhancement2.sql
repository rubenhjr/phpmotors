-- 1
INSERT INTO clients (clientFirstName, clientLastName, clientEmail, clientPassword, comment) VALUES ('Tony', 'Stark', 'tony@starkent', 'Iam1ronM@n', 'I am the real Ironman');

--2
UPDATE clients 
SET clientLevel = '3' 
WHERE cllientFirstName = 'Tony' AND cllientLastName = 'Stark';

--3
UPDATE inventory set invDescription = REPLACE(invDescription, 'small interiors', 'spacious interior') WHERE invId = '12'; 

--4
SELECT inventory.invModel,carclassification.classificationName
FROM inventory
INNER JOIN carclassification ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationName = 'SUV';

--5
DELETE FROM inventory WHERE invModel = 'Wrangler';

--6
UPDATE inventory
SET invImage = CONCAT("/phpmotors", invImage), invThumbnail = CONCAT("/phpmotors", invThumbnail);

