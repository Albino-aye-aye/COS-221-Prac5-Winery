
CREATE TABLE COS221_Winery (
  WineryID INT PRIMARY KEY,
  Country VARCHAR(255) NOT NULL,
  Region VARCHAR(255) NOT NULL,
  Name VARCHAR(255) NOT NULL
);

CREATE TABLE COS221_Wines (
  WineID INT PRIMARY KEY,
  Vinification VARCHAR(255) NOT NULL,
  Appellation VARCHAR(255) NOT NULL,
  Vintage INT NOT NULL,
  Points INT NOT NULL CHECK (Points >= 0),
  Price DECIMAL(10,2) NOT NULL CHECK (Price >= 0),
  WineryID INT,
  FOREIGN KEY (WineryID) REFERENCES COS221_Winery(WineryID)
);

CREATE TABLE COS221_User (
  UserID INT PRIMARY KEY,
  Password VARCHAR(255) NOT NULL,
  Salt VARCHAR(255) NOT NULL,
  Verified boolean 
);

CREATE TABLE COS221_Reviews (
  ReviewID INT PRIMARY KEY,
  UserID INT,
  WineID INT,
  Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
  ReviewText VARCHAR(1000),
  FOREIGN KEY (UserID) REFERENCES COS221_User(UserID),
  FOREIGN KEY (WineID) REFERENCES COS221_Wines(WineID)
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
INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (1, 'Sparkling Blend', 'Catalonia', 1919, 88, 13.00, 1);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (2, 'Cabernet Sauvignon', 'Catalonia', 1999, 86, 55.00, 1);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (3, 'Garnacha', 'Catalonia', 2001, 86, 10.00, 1);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (4, 'Vernaccia', 'Tuscany', 1929, 87, 14.00, 2);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (5, 'White Blend', 'Tuscany', 1994, 93, 140.00, 2);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (6, 'Sangiovese', 'Tuscany', 1995, 84, 56.00, 2);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (7, 'Ramisco', 'Colares', 1934, 93, 495.00, 3);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (8, 'Moscatel', 'Colares', 1963, 96, 400.00, 3);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (9, 'Alvarinho', 'Colares', 2001, 86, 10.00, 3);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (10, 'Red Blend', 'Languedoc-Roussillon', 1945, 95, 350.00, 4);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (11, 'Grenache', 'Languedoc-Roussillon', 2001, 89, 26.00, 4);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (12, 'Syrah', 'Languedoc-Roussillon', 2001, 82, 8.00, 4);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (13, 'White Blend', 'Tokaji', 1996, 91, 77.00, 5);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (14, 'Muscat', 'Tokaji', 2002, 87, 20.00, 5);

INSERT INTO COS221_Wines (WineID, Vinification, Appellation, Vintage, Points, Price, WineryID)
VALUES (15, 'Furmint', 'Tokaji', 2003, 94, 764.00, 5);

-- Insert into user 
INSERT INTO COS221_User (UserID, Password, Salt, Verified)
VALUES (1, 'password1', 'salt1', (SELECT Name FROM COS221_Winery WHERE WineryID = 1));

INSERT INTO COS221_User (UserID, Password, Salt, Verified)
VALUES (2, 'password2', 'salt2', NULL);

INSERT INTO COS221_User (UserID, Password, Salt, Verified)
VALUES (3, 'password3', 'salt3', (SELECT Name FROM COS221_Winery WHERE WineryID = 3));
