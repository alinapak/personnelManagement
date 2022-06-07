# personnelManagement

## Description
This is my second PHP project created for study purposes. 

## Instalation
To launch this project you need to have VSCode, MySQL and Xampp apps.
It is needed to create table in MySQL to launch this project. Follow these steps to do that:
* Open your MySQL;
* Create database named personnelman. Just copy this command and paste it in MySQL tab:
  * `CREATE DATABASE Test;`
* Create personnel table (copy and paste this command):
  * `CREATE TABLE personnel (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
fname VARCHAR(30),
lname VARCHAR(30),
machine_id int
);`
* Create machines table  (copy and paste this command):
  * `CREATE TABLE machines (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
machine_name VARCHAR(5)
);`
