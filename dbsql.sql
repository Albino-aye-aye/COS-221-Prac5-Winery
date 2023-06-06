-- Create User table
CREATE TABLE COS221_User (
  UserID VARCHAR(255) PRIMARY KEY,
  Password VARCHAR(255) NOT NULL,
  Salt VARCHAR(255) NOT NULL,
  WineryID INT NULL,
  FOREIGN KEY (WineryID) REFERENCES COS221_Winery(WineryID) ON DELETE SET NULL
);

-- Create Winery table
CREATE TABLE COS221_Winery (
  WineryID INT PRIMARY KEY AUTO_INCREMENT,
  Country VARCHAR(255) NOT NULL,
  Region VARCHAR(255) NOT NULL,
  Name VARCHAR(255) NOT NULL
);

-- Create Wines table
CREATE TABLE COS221_Wines (
  WineID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  Vinification VARCHAR(255) NOT NULL,
  Appellation VARCHAR(255) NOT NULL,
  Vintage INT NOT NULL,
  Price DECIMAL(10,2) NOT NULL CHECK (Price >= 0),
  WineryID INT,
  FOREIGN KEY (WineryID) REFERENCES COS221_Winery(WineryID) ON DELETE CASCADE
);

-- Create Reviews table
CREATE TABLE COS221_Reviews (
  ReviewID INT PRIMARY KEY AUTO_INCREMENT,
  UserID VARCHAR(255),
  WineID INT,
  Points INT NOT NULL CHECK (Points >= 1 AND Points <= 100),
  ReviewText VARCHAR(1000),
  FOREIGN KEY (UserID) REFERENCES COS221_User(UserID) ON DELETE CASCADE,
  FOREIGN KEY (WineID) REFERENCES COS221_Wines(WineID) ON DELETE CASCADE
);

-- Insert into winery
INSERT INTO COS221_Winery (WineryID, Country, Region, Name)
VALUES (1, 'Spain', 'Catalonia', 'L''Arboc');

INSERT INTO COS221_Winery (WineryID, Country, Region, Name)
VALUES (2, 'Italy', 'Tuscany', 'Guidi 1929');

INSERT INTO COS221_Winery (WineryID, Country, Region, Name)
VALUES (3, 'Portugal', 'Colares', 'Adega Viuva Gomes');

INSERT INTO COS221_Winery (WineryID, Country, Region, Name)
VALUES (4, 'France', 'Languedoc-Roussillon', 'Gérard Bertrand');

INSERT INTO COS221_Winery (WineryID, Country, Region, Name)
VALUES (5, 'Hungary', 'Tokaji', 'Royal Tokaji');

-- Insert data into Wines table
INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('A',1, 'Sparkling Blend', 'Catalonia', 1919, 13.00, 1);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('B',2, 'Cabernet Sauvignon', 'Catalonia', 1999, 55.00, 1);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('C',3, 'Garnacha', 'Catalonia', 2001, 10.00, 1);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('D',4, 'Vernaccia', 'Tuscany', 1929, 14.00, 2);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('E',5, 'White Blend', 'Tuscany', 1994, 140.00, 2);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('F',6, 'Sangiovese', 'Tuscany', 1995, 56.00, 2);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('G',7, 'Ramisco', 'Colares', 1934, 495.00, 3);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('H',8, 'Moscatel', 'Colares', 1963, 400.00, 3);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('I',9, 'Alvarinho', 'Colares', 2001, 10.00, 3);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('J',10, 'Red Blend', 'Languedoc-Roussillon', 1945, 350.00, 4);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('K',11, 'Grenache', 'Languedoc-Roussillon', 2001, 26.00, 4);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('L',12, 'Syrah', 'Languedoc-Roussillon', 2001, 8.00, 4);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('M',13, 'White Blend', 'Tokaji', 1996, 77.00, 5);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('N',14, 'Muscat', 'Tokaji', 2002, 20.00, 5);

INSERT INTO COS221_Wines (Name, WineID, Vinification, Appellation, Vintage,Price, WineryID)
VALUES ('O',15, 'Furmint', 'Tokaji', 2003, 764.00, 5);

-- Insert into user
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('john.doe@example.com', 'password1', 'salt1', (SELECT WineryID FROM COS221_Winery WHERE WineryID = 1));

INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('jane.smith@gmail.com', 'password2', 'salt2', NULL);

INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('david.wilson@company.com', 'password3', 'salt3', (SELECT WineryID FROM COS221_Winery WHERE WineryID = 3));

INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('emily.jones123@yahoo.co.uk', 'password4', 'salt4', (SELECT WineryID FROM COS221_Winery WHERE WineryID = 4));

INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('michael.brown34@hotmail.com', 'password5', 'salt5', (SELECT WineryID FROM COS221_Winery WHERE WineryID = 5));

-- Create trigger to delete associated winery when a user is deleted (if WineryID is not null)
DELIMITER $$
CREATE TRIGGER delete_associated_winery_trigger
AFTER DELETE ON COS221_User
FOR EACH ROW
BEGIN
  IF OLD.WineryID IS NOT NULL THEN
    DELETE FROM COS221_Winery WHERE WineryID = OLD.WineryID;
  END IF;
END$$
DELIMITER ;

-- Create trigger to delete associated wines when a winery is deleted
DELIMITER $$
CREATE TRIGGER delete_associated_wines_trigger
AFTER DELETE ON COS221_Winery
FOR EACH ROW
BEGIN
  DELETE FROM COS221_Wines WHERE WineryID = OLD.WineryID;
END$$
DELIMITER ;
-- update the price of the wine as the average of points in reviews
DELIMITER $$
CREATE TRIGGER update_price_trigger AFTER INSERT ON COS221_Reviews
FOR EACH ROW
BEGIN
  UPDATE COS221_Wines
  SET Price = (
    SELECT AVG(Points)*2 FROM COS221_Reviews WHERE WineID = NEW.WineID
  )
  WHERE WineID = NEW.WineID;
END$$
DELIMITER ;

-- Create a separate trigger for UPDATE operation
DELIMITER $$
CREATE TRIGGER update_price_trigger_update AFTER UPDATE ON COS221_Reviews
FOR EACH ROW
BEGIN
  UPDATE COS221_Wines
  SET Price = (
    SELECT AVG(Points)*2 FROM COS221_Reviews WHERE WineID = NEW.WineID
  )
  WHERE WineID = NEW.WineID;
END$$
DELIMITER ;
