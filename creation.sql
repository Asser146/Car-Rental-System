CREATE DATABASE `car rental company`;
use `car rental company`;

create table staff_user(
staff_id int not null AUTO_INCREMENT,
fname varchar(225) not null,
Lname varchar(225) not null,
email varchar(225) not null,
password varchar(225) not null,
PRIMARY KEY (staff_id)
);

create table client(
client_id int not null AUTO_INCREMENT,
fname varchar(225) not null,
Lname varchar(225) not null,
email varchar(225) not null,
password varchar(225) not null,
PRIMARY KEY (client_id)
);
