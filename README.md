README
======
Metalicious is an open-source, web-based data dictionary that is designed to capture and display metadata from databases, tables, and fields for platforms with one or more databases. Users may customize and deploy Metalicious as an internal or public data dictionary website.

This project is a generic release of the City of Chicago's [data dictionary](http://datadictionary.cityofchicago.org).

Installation
============
Copy the repository or download a compressed folder and unpack the directory to the folder you wish to host Metalicious.

Importing Database
------------------
Using the command line, run the following script:
```bash
mysql -u db-username -p -h yourlocaldatabase < database/Metalicious_DB.sql
```
Metalicious will create a new database called "datadictionary". Ensure no database with the same name exists as Metalicious will overwrite pre-existing data.


Creating Users
--------------
There is not a way to enter new users through the website in the current version. Adding new users will require access to the MySQL server and database. Use the following script to add new users:
```sql
INSERT INTO Users
	(User_Name, Password, First_Name, Last_Name)
VALUES
	('_username-to-be-added_', '_password_', '_user-first-name_', '_user-last-name_');
```
Where the \_underscored\_ arguments will be inserted into the user account.

Creating Business Functions
---------------------------
"Business Functions" is used to create categories to help users navigate to data dictionary entries. Currently, Metalicious does not support adding business functions through the website. Instead, new functions can be added through the following commands:
```sql
INSERT INTO Business_Functions
	(Business_Function_Name, Business_Function_Description)
VALUES
	('_business-function-to-be-added_', '_business-function-description_');
```
The \_underscored\_ entries may be modified to fit your needs.

Deploying Website
-----------------
Move the contents of /web to the directory you wish to deploy Metalicious.

After moving the contents, configure /include/dbconnopen.php to the appropriate MySQL database and login information:
```php
$cnnCDD = mysqli_connect("_yourlocaldatabase_", "_db-username_", "_db-password_")
```

The deployment of Metalicious assumes it will be installed in the root directory of the server (e.g., DOCUMENT_ROOT). To change this behavior, modify the file location.php 

Editing Contact Form
--------------------
Metalicious includes a contact form for users to contact a central location. You can edit the contact information in _ajax/contact_send.php_ 
```php
$to = "\"_email-name_\" <email-address@example.com>";
$subject = "Metalicious Data Dictionary: Online Comment / Question / Suggestion";
```

Adding Data
===========

Adding a new system or revising an existing system
-------------------
1.	Log into website
	Username: beginning of e+mail address (i.e. jsmith – do not include @gmail.com)
	Password: same as username
2.	Visit example.com/database_info.php, where example.com is the directory hosting Metalicious. Click "Create New DB"
	Note: If a database has been created, you may open an existing database to create a new database
3.	Enter all relevant information on the system 
4.	Select “Create New Database” once all information has been entered
	Note: This will create the database, but it will not yet appear on the website
5.	Activate the database 
	Click on your name at the top of the screen and select “Admin” from the drop down
	Click on the database and then select “Activate Revision”
	The system will now appear on the website.  Note: The database will need to be activated in order for it to be complete and appear in the website as well as for you to add the business function.
6.	Adding the Business Function
	Use the “Search” feature to open up the new database
	At the end of the database detail table, select the business function where this database belongs
	Follow step 7 to update the revision
7.	Making Revisions to a database
	Click “Change Info” at the end of the database detail 
+	Click “Save Revisions”
	Click “Database Revisions” and click “Load this revision” next to the appropriate dated revision.


Importing a table
-----------------



Importing a variable
---------------------
1.	Steps to take to get file ready for importing
+	Copy all relevant fields (system, table, column/field, type, length, value range, description, examples, comments) with no header row and paste into a separate excel file and save as CSV (comma delimited) file.
+	The System name in the file must match exactly how the system is named in the website.  For example, if the system is titled “Attendance System” in the website, the spreadsheet must have “Attendance System” listed under the system column.  
2.	Log into website
3.	Select “import” from the drop down list under your name 
4.	Select the “browse” button under the second option - Choose your Variables.csv file and then click on the submit button
5.	Add the appropriate variable CSV file
6.	Select “submit”



Requirements
============

Metalicious has not gone through broad deployment testing. Below are the specifications which this project was built. We appreciate feedback on other platforms which Metalicious does and does not operate.

System Requirements
-------------------
Severs hosting this project requires. This project was developed with the following specifications:
+ MySQL Community Server 5.5.25a
+ PHP 5.4.5

License & Support
-----------------

Metalicious is released under an MIT-style license. Portions of the design of the website uses [Font Awesome](http://fortawesome.github.com/Font-Awesome/) in the design, which is licensed under [CC BY 3.0](http://creativecommons.org/licenses/by/3.0/). Other licensed components of this project are compatible with an MIT license. The complete license is contained in the LICENSE file at the root of this distribution. By using this software in any fashion, you are agreeing to be bound by the terms of this license. You must not remove this notice, or any other, from this software.

The City of Chicago and its partners do not assume liability or support of Metalicious.

Acknowledgements
----------------

Metalicious was developed with support from the [MacArthur Foundation](http://www.macfound.org/) and [Chapin Hall at the University of Chicago](http://www.chapinhall.org/).
