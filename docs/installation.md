# Installation

Copy the repository or download a compressed folder and unpack the directory to the folder you wish to host Metalicious.

## Importing Database

Using the command line, run the following script:
```bash
mysql -u db-username -p -h yourlocaldatabase < database/Metalicious_DB.sql
```
Metalicious will create a new database called "datadictionary". Ensure no database with the same name exists as Metalicious will overwrite pre-existing data.


## Creating Users

There is not a way to enter new users through the website in the current version. Adding new users will require access to the MySQL server and database. Use the following script to add new users:
```sql
INSERT INTO Users
	(User_Name, Password, First_Name, Last_Name)
VALUES
	('_username-to-be-added_', '_password_', '_user-first-name_', '_user-last-name_');
```
Where the \_underscored\_ arguments will be inserted into the user account.

## Creating Business Functions

"Business Functions" is used to create categories to help users navigate to data dictionary entries. Currently, Metalicious does not support adding business functions through the website. Instead, new functions can be added through the following commands:
```sql
INSERT INTO Business_Functions
	(Business_Function_Name, Business_Function_Description)
VALUES
	('_business-function-to-be-added_', '_business-function-description_');
```
The \_underscored\_ entries may be modified to fit your needs.

## Deploying Website

Move the contents of /web to the directory you wish to deploy Metalicious.

After moving the contents, configure /include/dbconnopen.php to the appropriate MySQL database and login information:
```php
$cnnCDD = mysqli_connect("_yourlocaldatabase_", "_db-username_", "_db-password_")
```

The deployment of Metalicious assumes it will be installed in the root directory of the server (e.g., DOCUMENT_ROOT). To change this behavior, modify the file location.php 

## Editing Contact Form

Metalicious includes a contact form for users to contact a central location. You can edit the contact information in _ajax/contact_send.php_ 
```php
$to = "\"_email-name_\" <email-address@example.com>";
$subject = "Metalicious Data Dictionary: Online Comment / Question / Suggestion";
```