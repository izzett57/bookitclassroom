-- DDL
-- Creation start
-- Initialize Database
CREATE DATABASE bookitclassroom;

-- Use Database
USE bookitclassroom;

-- Create USER Table
CREATE TABLE USER (
    ID int(20) NOT NULL AUTO_INCREMENT,
    FName varchar(200) NOT NULL,
    LName varchar(200) NOT NULL,
    Email varchar(200) NOT NULL UNIQUE,
    Password varchar(200) NOT NULL,
    Date timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    User_Type enum('MEMBER','ADMIN','CLUB_LEAD') NOT NULL,
    PRIMARY KEY(ID)
);

-- Create CLASSROOM Table
CREATE TABLE CLASSROOM (
    CName varchar(200) NOT NULL UNIQUE,
    Floor int(1),
    PRIMARY KEY(CName)
);

-- Create ENTRY Table
CREATE TABLE ENTRY (
    ID int(20) NOT NULL AUTO_INCREMENT,
    User_ID int(20),
    EName varchar(200) NOT NULL,
    Day enum('MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY') NOT NULL,
    Time_Start TIME NOT NULL,
    Time_End TIME NOT NULL,
    Assigned_Class varchar(200),
    FOREIGN KEY (User_ID) REFERENCES USER(ID),
    FOREIGN KEY (Assigned_Class) REFERENCES CLASSROOM(CName),
    PRIMARY KEY(ID)
);

-- Create BOOKING Table
CREATE TABLE BOOKING (
    ID int(20) NOT NULL AUTO_INCREMENT,
    Booking_Date DATE NOT NULL,
    Entry_ID int(20) NOT NULL,
    Classroom varchar(200) NOT NULL,
    FOREIGN KEY (Entry_ID) REFERENCES ENTRY(ID),
    FOREIGN KEY (Classroom) REFERENCES CLASSROOM(CName),
    PRIMARY KEY(ID)
);
-- Creation End

-- Example of Insert Statements
INSERT INTO USER (FName, LName, Email, Password) VALUES 
('$fname','$lname','$email', '$password');

INSERT INTO CLASSROOM (CName, Floor) VALUES 
('A1', 1);

INSERT INTO ENTRY (User_ID, EName, Day, Time_Start, Time_End) VALUES 
('$userid', '$ename', '$day', '$time_start', '$time_end');

INSERT INTO BOOKING (Booking_Date, Entry_ID, Classroom) VALUES 
('$bookingdate', '$entryid', '$classroom');


-- DML
-- UI
-- How to count the amount of floors
SELECT COUNT(DISTINCT Floor) AS No_Of_Floors
FROM CLASSROOM;

-- Booking
-- Booking an event
INSERT INTO BOOKING (Booking_Date, Entry_ID, Classroom) VALUES 
('$bookingdate', '$entryid', '$classroom');

UPDATE ENTRY -- Update ENTRY to show which classroom it is booked at
SET Assigned_Class = '$classroom'
WHERE ID = '$entryid';

-- User controls
-- Deleting an entry in ENTRY
DELETE FROM ENTRY
WHERE ID = '$entryid';

-- Admin controls
-- Updating a user type
UPDATE USER
SET User_Type = '$usertype'
WHERE USER.id = '$userid';

-- Deleting a booking
DELETE FROM BOOKING
WHERE ID = '$bookingid';