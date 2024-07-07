-- DDL
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

-- Create TIMETABLE Table
CREATE TABLE TIMETABLE (
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
    Timetable_ID int(20) NOT NULL,
    Classroom varchar(200) NOT NULL,
    FOREIGN KEY (Timetable_ID) REFERENCES TIMETABLE(ID),
    FOREIGN KEY (Classroom) REFERENCES CLASSROOM(CName),
    PRIMARY KEY(ID)
);

-- Example of Insert Statements
INSERT INTO USER (FName, LName, Email, Password) VALUES 
('$fname','$lname','$email', '$password');

INSERT INTO CLASSROOM (CName, Floor) VALUES 
('A1', 1);

INSERT INTO TIMETABLE (User_ID, EName, Day, Time_Start, Time_End) VALUES 
('$userid', '$ename', '$day', '$time_start', '$time_end');

INSERT INTO BOOKING (Booking_Date, Timetable_ID, Classroom) VALUES 
('$bookingdate', '$timetableid', '$classroom');


-- DML
-- How to count the amount of floors
SELECT COUNT(DISTINCT Floor) AS No_Of_Floors
FROM CLASSROOM;

-- In the event of an event is booked
INSERT INTO BOOKING (Booking_Date, Timetable_ID, Classroom) VALUES 
('$bookingdate', '$timetableid', '$classroom');

UPDATE TIMETABLE -- Update timetable to show which classroom it is booked at
SET Assigned_Class = '$classroom'
WHERE TIMETABLE.id = '$timetableid';