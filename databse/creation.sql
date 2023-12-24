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

ALTER TABLE car
ADD FOREIGN KEY (office_num) REFERENCES office(office_id) ON UPDATE CASCADE;

ALTER TABLE office
ADD FOREIGN KEY (mgr_id) REFERENCES staff(staff_id) ON UPDATE CASCADE;

ALTER TABLE reservation
ADD FOREIGN KEY (car_id) REFERENCES car(car_id) ON UPDATE CASCADE,
ADD FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON UPDATE CASCADE,
ADD FOREIGN KEY (return_office) REFERENCES office(office_id) ON UPDATE CASCADE;
