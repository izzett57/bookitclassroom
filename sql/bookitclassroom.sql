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
    Reset_Token varchar(200),
    Token_Expire DATETIME,
    PRIMARY KEY(ID)
);

-- Create CLASSROOM Table
CREATE TABLE CLASSROOM (
    CName varchar(200) NOT NULL UNIQUE,
    Floor int(1) NOT NULL,
    PRIMARY KEY(CName)
);

-- Create ENTRY Table
CREATE TABLE ENTRY (
    ID int(20) NOT NULL AUTO_INCREMENT,
    User_ID int(20) NOT NULL,
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
