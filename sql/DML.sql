-- Example of Insert Statements
INSERT INTO USER (FName, LName, Email, Password) VALUES 
('$fname','$lname','$email', '$password');

INSERT INTO CLASSROOM (CName, Floor) VALUES 
('A1', 1);

INSERT INTO ENTRY (User_ID, EName, Day, Time_Start, Time_End) VALUES 
('$userid', '$ename', '$day', '$time_start', '$time_end');

INSERT INTO BOOKING (Booking_Date, Entry_ID, Classroom) VALUES 
('$bookingdate', '$entryid', '$classroom');


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
