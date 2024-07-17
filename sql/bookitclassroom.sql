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
    User_Type enum('MEMBER','LECTURER','CLUB_LEAD','ADMIN') NOT NULL,
    Reset_Token varchar(200),
    Token_Expire DATETIME,
    ProfilePicture varchar(255) DEFAULT NULL,
    PRIMARY KEY(ID)
);

-- Create CLASSROOM Table
CREATE TABLE CLASSROOM (
    CName varchar(200) NOT NULL UNIQUE,
    Floor int(1) NOT NULL,
    PRIMARY KEY(CName)
);

-- Insert CLASSROOM Data
INSERT INTO CLASSROOM (CName, Floor) VALUES 
('1001', 1),
('1002', 1),
('1003', 1),
('1004', 1),
('1005', 1),
('1006', 1),
('1007', 1),
('1008', 1),
('1009', 1),
('1011', 1),
('1012', 1),
('1013', 1),
('1014', 1),
('1015', 1),
('1016', 1),
('1017', 1),
('1018', 1),
('1019', 1),
('1020', 1),
('2001', 2),
('2002', 2),
('2003', 2),
('2004', 2),
('2005', 2),
('2006', 2),
('2007', 2),
('2008', 2),
('2009', 2),
('2011', 2),
('2012', 2),
('2013', 2),
('2014', 2),
('2015', 2),
('2016', 2),
('2017', 2),
('2018', 2),
('2019', 2),
('2020', 2),
('3001', 3),
('3002', 3),
('3003', 3),
('3004', 3),
('3005', 3),
('3006', 3),
('3007', 3),
('3008', 3),
('3009', 3),
('3011', 3),
('3012', 3),
('3013', 3),
('3014', 3),
('3015', 3),
('3016', 3),
('3017', 3),
('3018', 3),
('3019', 3),
('3020', 3);

-- Create Semester table
CREATE TABLE SEMESTER (
    ID varchar(4) NOT NULL,
    Year int(4) NOT NULL,
    Sem int(1) NOT NULL,
    Start_Date DATE NOT NULL,
    End_Date DATE NOT NULL,
    PRIMARY KEY (ID, Year, Sem)
);

-- Create ENTRY Table
CREATE TABLE ENTRY (
    ID int(20) NOT NULL AUTO_INCREMENT,
    User_ID int(20) NOT NULL,
    EName varchar(200) NOT NULL,
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
    Type enum('SINGLE','SEMESTER') NOT NULL,
    Booking_Date DATE NOT NULL,
    Semester_ID varchar(4) NOT NULL,
    Entry_ID int(20) NOT NULL,
    Classroom varchar(200) NOT NULL,
    FOREIGN KEY (Entry_ID) REFERENCES ENTRY(ID),
    FOREIGN KEY (Classroom) REFERENCES CLASSROOM(CName),
    FOREIGN KEY (Semester_ID) REFERENCES SEMESTER(ID),
    PRIMARY KEY(ID)
);
