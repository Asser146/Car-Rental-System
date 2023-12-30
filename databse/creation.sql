CREATE DATABASE `car rental company`;
USE `car rental company`;
CREATE TABLE car (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    company VARCHAR(255),
    model VARCHAR(255),
    year_made INT,
    image_path VARCHAR(255),
    car_status VARCHAR(255),
    price_per_day INT,
    office_num INT NOT NULL
);

CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    Fname VARCHAR(255),
    Lname VARCHAR(255),
    office_num VARCHAR(255),
    email VARCHAR(255),
    pass VARCHAR(255)
);

CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    Fname VARCHAR(255),
    Lname VARCHAR(255),
    email VARCHAR(255),
    pass VARCHAR(255)
);

CREATE TABLE office (
    office_id INT AUTO_INCREMENT PRIMARY KEY,
    Location VARCHAR(255),
    mgr_id INT,
    FOREIGN KEY (mgr_id) REFERENCES staff(staff_id)
);

CREATE TABLE reservation (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    customer_id INT NOT NULL,
    start_date DATE,
    return_date DATE,
    return_office INT
);
CREATE TABLE payment (
    reservation_id INT,
    start_date DATE,
    return_date DATE,
    total_payment int,  -- Adjust the precision and scale based on your currency and requirements
    PRIMARY KEY(reservation_id,start_date,return_date),
    FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id)
);

ALTER TABLE car
ADD FOREIGN KEY (office_num) REFERENCES office(office_id) ON UPDATE CASCADE;

ALTER TABLE office
ADD FOREIGN KEY (mgr_id) REFERENCES staff(staff_id) ON UPDATE CASCADE;

ALTER TABLE reservation
ADD FOREIGN KEY (car_id) REFERENCES car(car_id) ON UPDATE CASCADE,
ADD FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON UPDATE CASCADE,
ADD FOREIGN KEY (return_office) REFERENCES office(office_id) ON UPDATE CASCADE;

DELIMITER //
CREATE TRIGGER after_reservation_insert
AFTER INSERT ON reservation
FOR EACH ROW
BEGIN
    DECLARE total_payment INT;

    -- Fetch the price_per_day from the related car
    SELECT car.price_per_day INTO total_payment
    FROM car
    WHERE car.car_id = NEW.car_id;

    -- Calculate total_payment based on your logic
    -- For example, you can use DATEDIFF to calculate the duration of the reservation
    SET total_payment = DATEDIFF(NEW.return_date, NEW.start_date) * total_payment;

    -- Insert into the payment table
    INSERT INTO payment (reservation_id, start_date, return_date, total_payment)
    VALUES (NEW.reservation_id, NEW.start_date, NEW.return_date, total_payment);
END;
//
DELIMITER ;

