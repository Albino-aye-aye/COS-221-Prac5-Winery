-- Create Winery table
CREATE TABLE COS221_Winery (
  WineryID INT PRIMARY KEY AUTO_INCREMENT,
  Country VARCHAR(255) NOT NULL,
  Region VARCHAR(255) NOT NULL,
  Name VARCHAR(255) NOT NULL
);

-- Create User table
CREATE TABLE COS221_User (
  UserID VARCHAR(255) PRIMARY KEY,
  Password VARCHAR(255) NOT NULL,
  Salt VARCHAR(255) NOT NULL,
  WineryID INT NULL,
  FOREIGN KEY (WineryID) REFERENCES COS221_Winery(WineryID) ON DELETE SET NULL
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

INSERT INTO COS221_Winery (Country, Region, Name)
VALUES ('Spain', 'Catalonia', 'L\'Arboc');

INSERT INTO COS221_Wines (Name, Vinification, Appellation, Vintage, Price, WineryID)
VALUES
    ('Cuvée Élégance', 'Sparkling Blend', 'Catalonia', '1919', 13.00, 1),
    ('Reserva de la Luna', 'Cabernet Sauvignon', 'Catalonia', '1999', 55.00, 1),
    ('Flor de Seda', 'Garnacha', 'Catalonia', '2001', 10.00, 1),
    ('Éxtasis Rojo', 'Red Blend', 'Catalonia', '2003', 15.00, 1),
    ('Crianza del Sol', 'Cabernet Sauvignon-Merlot', 'Catalonia', '2003', 15.00, 1),
    ('Perla Dorada', 'Chardonnay', 'Catalonia', '2006', 15.00, 1),
    ('Noche Esmeralda', 'Pinot Noir', 'Catalonia', '2007', 16.00, 1),
    ('Euforia de Girona', 'Grenache', 'Catalonia', '2007', 27.00, 1),
    ('Rioja Dorada', 'Tempranillo', 'Catalonia', '2008', 13.00, 1),
    ('Blanca del Mar', 'Garnacha Blanca', 'Catalonia', '2009', 15.00, 1);




INSERT INTO COS221_Winery (Country, Region, Name)
VALUES ('Italy', 'Tuscany', 'Guidi 1929');

INSERT INTO COS221_Wines (Name, Vinification, Appellation, Vintage, Price, WineryID)
VALUES
    ('Riserva d\'Oro', 'Vernaccia', 'Tuscany', '1929', 14.00, 2),
    ('Bianco di Sogni', 'White Blend', 'Tuscany', '1994', 140.00, 2),
    ('Cantico del Sole', 'Sangiovese', 'Tuscany', '1995', 56.00, 2),
    ('Segreto dell\'Amore', 'Cabernet Sauvignon', 'Tuscany', '1997', 27.00, 2),
    ('Incanto Bordeaux', 'Bordeaux-style', 'Tuscany', '1998', 40.00, 2),
    ('Danza dei Sensi', 'Syrah', 'Tuscany', '1998', 36.00, 2),
    ('Abbraccio di Prugnolo', 'Prugnolo Gentile', 'Tuscany', '2001', 75.00, 2),
    ('Serata di Toscana', 'Sangiovese Grosso', 'Tuscany', '2003', 120.00, 2),
    ('Meraviglia di Merlot', 'Merlot', 'Tuscany', '2003', 50.00, 2),
    ('Sinfonia di Cabernet', 'Cabernet Franc', 'Tuscany', '2004', 42.00, 2);



INSERT INTO COS221_Winery (Country, Region, Name)
VALUES ('Portugal', 'Colares', 'Adega Viuva Gomes');

INSERT INTO COS221_Wines (Name, Vinification, Appellation, Vintage, Price, WineryID)
VALUES
    ('Tesouro de Ramisco', 'Ramisco', 'Colares', '1934', 495.00, 3),
    ('Encanto de Moscatel', 'Moscatel', 'Colares', '1963', 400.00, 3),
    ('Brilho de Alvarinho', 'Alvarinho', 'Colares', '2001', 10.00, 3),
    ('Grande Reserva Português', 'Portuguese Red', 'Douro', '2001', 84.00, 3),
    ('Delícia de Trajadura', 'Trajadura', 'Vinho Verde', '2001', 7.00, 3),
    ('Suave de Bual', 'Bual', 'Madeira', '2003', 50.00, 3),
    ('Perfume Alentejano', 'Touriga Nacional', 'Alentejano', '2004', 19.00, 3),
    ('Harmonia de Bairrada', 'Cabernet Blend', 'Bairrada', '2004', 13.00, 3),
    ('Vinho do Sol', 'Trincadeira', 'Alentejano', '2005', 19.00, 3),
    ('Estrela da Estremadura', 'Alicante Bouschet', 'Estremadura', '2005', 16.00, 3);




INSERT INTO COS221_Winery (Country, Region, Name)
VALUES ('France', 'Languedoc-Roussillon', 'Gérard Bertrand');

INSERT INTO COS221_Wines (Name, Vinification, Appellation, Vintage, Price, WineryID)
VALUES
    ('Élégance Rouge', 'Red Blend', 'Languedoc-Roussillon', '1945', 350.00, 4),
    ('Essence de Grenache', 'Grenache', 'Languedoc-Roussillon', '2001', 26.00, 4),
    ('Harmonie de Syrah', 'Syrah', 'Languedoc-Roussillon', '2001', 8.00, 4),
    ('Mélange de Merlot', 'Merlot', 'Languedoc-Roussillon', '2001', 7.00, 4),
    ('Charme de Chardonnay', 'Chardonnay', 'Languedoc-Roussillon', '2002', 8.00, 4),
    ('Prestige de la Vallée', 'Rhône-style Red Blend', 'Languedoc-Roussillon', '2004', 13.00, 4),
    ('Cœur de Carignan', 'Carignan', 'Languedoc-Roussillon', '2005', 16.00, 4),
    ('Symphonie de Shiraz', 'Shiraz', 'Languedoc-Roussillon', '2005', 7.00, 4),
    ('Rosée Magique', 'Rosé', 'Languedoc-Roussillon', '2007', 10.00, 4),
    ('Harmonie de Merlot-Cabernet', 'Merlot-Cabernet Sauvignon', 'Languedoc-Roussillon', '2007', 13.00, 4);




INSERT INTO COS221_Winery (Country, Region, Name)
VALUES ('Hungary', 'Tokaji', 'Royal Tokaji');

INSERT INTO COS221_Wines (Name, Vinification, Appellation, Vintage, Price, WineryID)
VALUES
    ('Éclat Blanc', 'White Blend', 'Tokaji', '1996', 77.00, 5),
    ('Merveille de Muscat', 'Muscat', 'Tokaji', '2002', 20.00, 5),
    ('Or de Furmint', 'Furmint', 'Tokaji', '2003', 764.00, 5),
    ('Charme de Cabernet', 'Cabernet Blend', 'Tokaji', '2003', 78.00, 5),
    ('Symphony de Cabernet Franc', 'Cabernet Franc', 'Tokaji', '2003', 75.00, 5),
    ('Rubis de Kekfrankos', 'Kekfrankos', 'Tokaji', '2003', 28.00, 5),
    ('Étoile de Pinot Noir', 'Pinot Noir', 'Tokaji', '2008', 25.00, 5),
    ('Sérénité de Merlot', 'Merlot', 'Tokaji', '2008', 76.00, 5),
    ('Perle de Blauburger', 'Blauburger', 'Tokaji', '2008', 17.00, 5),
    ('Harmonie Bordeaux', 'Bordeaux-style', 'Tokaji', '2008', 37.00, 5);

-- Insert User 1
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('1', '$argon2id$v=19$m=65536,t=4,p=1$d1JUOE9Sc2RKUzZGd1Q5bQ$Q78xQJfIiYP1m3ZEDTILAQqtg8DOLy2sZZFGmUCfhcw', '591c2c8b5d76dc7f669b0706e1504a3f809d3d1472d6f9447ab1e9bf77b255f1', 1);

-- Insert User 2
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('2', '$argon2id$v=19$m=65536,t=4,p=1$aW9NYTNWQVIzby9iZmU3Tw$8IMOWjpNZfLSeMj9/nTrrw+tKPf1R2p+1McMW+rkEig', '9487ec18293ef84ad194cf0b5aba63857d2130274a0441ed8e83000812445203', 2);

-- Insert User 3
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('3', '$argon2id$v=19$m=65536,t=4,p=1$Lk9WcmFnNVUxR3VGUFNpeg$3gpo57k9BgXVwwQnUotffgbdf9TtNq4noordWA+qoDY', 'e633c3e68cb05eb5eb0ad6ad2ddaaf381d9d5d454dfa59a940c46c3b3b9624f0', 3);

-- Insert User 4
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('4', '$argon2id$v=19$m=65536,t=4,p=1$V1hLZ0hOd2ZTYllZYWt3TQ$AwioDFSu4tfZRBjDwpvtMQWWlqWSgp7HiLlj16J/BLc', '40f1aa32b0d0a5c35619da643ac392eb80782fd140d35cf930cadd9202678723', 4);

-- Insert User 5
INSERT INTO COS221_User (UserID, Password, Salt, WineryID)
VALUES ('5', '$argon2id$v=19$m=65536,t=4,p=1$d0VjZndVczlQL1o4M2lSdQ$fL1EZdgO4gLdT41V1frqwk7p4Z0HcT+f7nS9cWnNLiI', '09afbdda8df1fc9752b050fa5ae70f0b8976bb95f2d17bfdf305bbb16a197ea9', 5);

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
