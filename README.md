# personnelManagement

## Description
This is my second PHP project created for study purposes. 

## Instalation
To launch this project you need to have VSCode, MySQL and Xampp apps.
It is needed to create table in MySQL to launch this project. Follow these steps to do that:
* Open your MySQL;
* Create database named personnelman. Just copy this command and paste it in MySQL tab:
  * `CREATE DATABASE personel_projects;`
* Create personnel table (copy and paste this command):
  * `CREATE TABLE personnel (
id INT AUTO_INCREMENT PRIMARY KEY,
fname VARCHAR(30),
lname VARCHAR(30),
project_id int
);`
* Create PROJECTS table  (copy and paste this command):
  * `CREATE TABLE projects (
id INT AUTO_INCREMENT PRIMARY KEY,
project_name VARCHAR(30)
);`
* Adding references one to many :
  * `ALTER TABLE personnel
ADD CONSTRAINT FOREIGN KEY
    fk_project_id (Project_id)
    REFERENCES Projects(id)
    ON DELETE SET NULL
    ON UPDATE SET NULL;`
