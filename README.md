# personnelManagement

## Description

  This is my second PHP project created for study purposes. It was used raw CSS and PHP in this project and displayed data was created using `MySQL workbench`.Assigned and completed tasks:
  * Create DB schema with tables and data in it with relations (in this case: 1:M relation);
  * Display DB schema tables data with their relations into browser using PHP;
  * Create Delete and Update functionality: Delete and Update in browser should work in DB tables too;
  * Create Creation functionality: It is needed to be able to create new employee and new project in browser tables, and theese data should be set in DB schema too;
  * It is needed to be able to assign an employee to a project and this assigment sets in DB schema too;
  * Use 'prepared statements' into code;

## Instalation
  To launch this project you will need `Git Bash` or `VSCode`, `MySQL Workbench` and `Xampp` apps.
  * To clone this project: Navigate to **htdocs** folder and with your `Git Bash` or via `VSCode` terminal type `git clone https://github.com/alinapak/personnelManagement.git` ;
  * Open `Xampp` and make sure that **Apache** and **MySQL** servers are on;
  * Open `MySQL workbench` and connect at any your connection (connection should support creating database and reading, creating, updating and deleting tables);
  * In your chosen connection Create DATABASE named **personnel_projects** or copy this command: `CREATE DATABASE personnel_projects;`
  * Click on **Server** and choose **Data Import**, as you can see in the image:
  image.png
  * Click **Import from Self-Contained File** and find **dump.sql** file, which should be in **htdocs** folder, where you cloned this project:
  image.png
  * Select **Default Target Schema** and choose your created schema named **personnel_projects**:
  image.png
  * Leave defaulted settings (**Dump Structure and Data**) and select **Start Import**:
  image.png
  * Refresh your DataBase:
  image.png
  * Now you should see all created tables and their data:
  image.png
  * After all these steps, open your browser and in searcbar type `localhost/personnelManagement`.

## Usage
  After typing in your browser search bar `localhost/personnelManagement`, you will see `personnel` table, and you also be able to navigate between `personnel` and `projects` tables via navbar. While navigating, you can:
  * Delete employees;
  * Create new employees;
  * Delete projects;
  * Create new projects;
  * Update projects;
  * Update employees and by updating them assign an existing project to them.

## Author
  This project was created by me [Alina Pakamorytė](https://www.linkedin.com/in/alina-pakamoryt%C4%97-73a66377/)
