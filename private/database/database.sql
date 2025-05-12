CREATE DATABASE events_planning;
GRANT USAGE ON *.* TO 'Thuvauser'@'localhost' IDENTIFIED BY 'ThuvaPassword';
GRANT ALL PRIVILEGES ON events_planning.* TO 'Thuvauser'@'localhost';
FLUSH PRIVILEGES;
USE events_planning;

CREATE TABLE IF NOT EXISTS `USER` ( 
  Email_Address VARCHAR(320) NOT NULL,
  First_Name VARCHAR(30) NOT NULL, 
  Last_Name VARCHAR (30) NOT NULL, 
  Password VARCHAR(30) NOT NULL, 
  CONSTRAINT UserPK PRIMARY KEY (`Email_Address`)
);

CREATE TABLE IF NOT EXISTS `EVENT_TYPE` (
  Event_Type_Id INT AUTO_INCREMENT,
  Type VARCHAR(50) NOT NULL,
  CONSTRAINT Event_Type_IdPK PRIMARY KEY (`Event_Type_Id`)
);

CREATE TABLE IF NOT EXISTS `EVENT` (
    Event_Id INT AUTO_INCREMENT,
    Event_Name VARCHAR(100) NOT NULL,
    Event_Description TEXT NOT NULL,
    Event_Type_Id INT NOT NULL,
    Start_Date DATETIME NOT NULL,
    End_Date DATETIME NOT NULL,
    Visibility ENUM('Public','Private') NOT NULL,
    Address VARCHAR(255) NOT NULL,
    City VARCHAR(100) NOT NULL,
    Province VARCHAR(100) NOT NULL,
    Postal_Code VARCHAR(20) NOT NULL,
    CONSTRAINT EventPK PRIMARY KEY (`Event_ID`),
    CONSTRAINT Event_Event_IdFK FOREIGN KEY (`Event_Type_Id`) 
      REFERENCES `event_type`(`Event_Type_Id`) 
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS `USER_EVENT` (
    User_Event_Id INT AUTO_INCREMENT,
    Event_Id INT NOT NULL,
    Email_Address VARCHAR(320) NOT NULL,
    Relationship ENUM('Owner','Participant'),
    CONSTRAINT User_EventPK PRIMARY KEY (`User_Event_Id`),
    CONSTRAINT User_Event_EventFK FOREIGN KEY (`Event_ID`) 
      REFERENCES `EVENT`(`Event_Id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE,
    CONSTRAINT User_Event_UserFK FOREIGN KEY (`Email_Address`) 
      REFERENCES `USER`(`Email_Address`) 
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

INSERT INTO EVENT_TYPE values 
  (1, 'Sports'),
  (2, 'Conference'),
  (3, 'Concert/Festival'),
  (4, 'Celebration/Party');

-- Insert dummy values
INSERT INTO USER values
  ('tan00132@algonquinlive.com', 'Simon', 'Tan', 'password'),
  ('ragu0011@algonquinlive.com', 'Thuvarahan', 'Ragunathan', '12345678'),
  ('julie123@algonquinlive.com', 'Julie', 'Nguyen', 'nguyenpassword'),
  ('felix123@algonquinlive.com', 'Felix', 'Lu', 'lupassword');

INSERT INTO EVENT(Event_Name, Event_Description, Event_Type_Id, Start_Date, End_Date, Visibility,
                    Address, City, Province, Postal_Code) values 
    ("Thuva's Birthday Bash", "It's gonna be exciting. Please come.", 4, "2025-04-20 12:00:00", "2025-04-25 12:00:00",
    'Public', '123 Any Street', 'Ottawa', 'ON', 'K1F5D2'),
    ("Julie's Animation Conference", "Bring your own tablet.", 2, "2025-04-15 8:00:00", "2025-04-20 18:00:00",
    'Public', '854 Animation Avenue', 'Ottawa', 'ON', 'K1L9D2'),
    ("Felix's Piano Recital", "Bring your own tissues. You're gonna cry.", 3, "2025-04-16 16:00:00", "2025-04-17 21:00:00",
    'Public', '1 Elgin Street', 'Ottawa', 'ON', 'K1N8X5'),
    ("Private basketball game", "5-man teams, full-court", 1, "2025-04-11 12:00:00", "2025-04-12 15:00:00",
    'Private', '42 Dean Drive', 'Ottawa', 'ON', 'K1R3E7');
  
INSERT INTO USER_EVENT(Event_Id, Email_Address, Relationship) values
  (1, 'ragu0011@algonquinlive.com', 'Owner'),
  (1, 'tan00132@algonquinlive.com', 'Participant'),
  (1, 'felix123@algonquinlive.com', 'Participant'),
  (2, 'julie123@algonquinlive.com', 'Owner'),
  (3, 'felix123@algonquinlive.com', 'Owner'),
  (4, 'tan00132@algonquinlive.com', 'Owner');
