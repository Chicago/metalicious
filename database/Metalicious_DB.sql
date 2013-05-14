/* CREATE DATABASE  IF NOT EXISTS `datadictionary` !40100 DEFAULT CHARACTER SET latin1 */;
USE `datadictionary`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: datadictionary.cityofchicago.org
-- ------------------------------------------------------
-- Server version	5.5.25a

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Tables`
--

DROP TABLE IF EXISTS `Tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tables` (
  `Table_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Table_Name` varchar(100) NOT NULL,
  `Table_Description` varchar(8000) NOT NULL,
  `Table_Comments` varchar(2000) NOT NULL,
  `Public` int(11) NOT NULL DEFAULT '1',
  `Creator` int(11) NOT NULL,
  `Views` int(11) NOT NULL DEFAULT '0',
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Last_Updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Table_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2582 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Databases_Tables`
--

DROP TABLE IF EXISTS `Databases_Tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Databases_Tables` (
  `Database_Table_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Database_ID` int(11) NOT NULL,
  `Table_ID` int(11) NOT NULL,
  PRIMARY KEY (`Database_Table_ID`),
  UNIQUE KEY `Unique_Databases_Tables__Database_ID_Table_ID` (`Database_ID`,`Table_ID`),
  KEY `FK_Databases_Tables__Database_ID` (`Database_ID`),
  KEY `FK_Databases_Tables__Table_ID` (`Table_ID`),
  CONSTRAINT `FK_Databases_Tables__Table_ID` FOREIGN KEY (`Table_ID`) REFERENCES `Tables` (`Table_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_Databases_Tables__Database_ID` FOREIGN KEY (`Database_ID`) REFERENCES `Databases` (`Database_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1482 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tables_Revisions`
--

DROP TABLE IF EXISTS `Tables_Revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tables_Revisions` (
  `Table_Revision_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Table_ID` int(11) DEFAULT NULL,
  `Table_Name` varchar(100) NOT NULL,
  `Table_Description` varchar(8000) NOT NULL,
  `Table_Comments` varchar(2000) NOT NULL,
  `Creator` int(11) NOT NULL,
  `Database_ID` int(11) DEFAULT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Table_Revision_ID`),
  KEY `FK_Tables_Revisions__Table_ID` (`Table_ID`),
  KEY `FK_Tables_Revisions__Database_ID` (`Database_ID`),
  CONSTRAINT `FK_Tables_Revisions__Database_ID` FOREIGN KEY (`Database_ID`) REFERENCES `Databases` (`Database_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_Tables_Revisions__Table_ID` FOREIGN KEY (`Table_ID`) REFERENCES `Tables` (`Table_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Variables_Revisions`
--

DROP TABLE IF EXISTS `Variables_Revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Variables_Revisions` (
  `Variable_Revision_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Variable_ID` int(11) DEFAULT NULL,
  `Variable_Name` varchar(100) NOT NULL,
  `Variable_Description` varchar(1000) NOT NULL,
  `Variable_Type_Format` varchar(100) NOT NULL,
  `Variable_Length` varchar(100) NOT NULL,
  `Variable_Values` varchar(3000) NOT NULL,
  `Variable_Example` varchar(1000) NOT NULL,
  `Variable_Comments` varchar(1000) NOT NULL,
  `Data_Portal` varchar(1) NOT NULL DEFAULT 'Y',
  `Table_ID` int(11) DEFAULT NULL,
  `Creator` int(11) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Variable_Revision_ID`),
  KEY `FK_Variables_Revisions__Variables_ID` (`Variable_ID`),
  KEY `FK_Variables_Revisions__Table_ID` (`Table_ID`),
  CONSTRAINT `FK_Variables_Revisions__Table_ID` FOREIGN KEY (`Table_ID`) REFERENCES `Tables` (`Table_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_Variables_Revisions__Variables_ID` FOREIGN KEY (`Variable_ID`) REFERENCES `Variables` (`Variable_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Databases_Revisions`
--

DROP TABLE IF EXISTS `Databases_Revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Databases_Revisions` (
  `Database_Revision_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Database_ID` int(11) DEFAULT NULL,
  `Database_Name` varchar(100) NOT NULL,
  `Description` varchar(8000) NOT NULL,
  `Business_Owner` varchar(100) NOT NULL,
  `Contact_Information` varchar(1000) NOT NULL,
  `Data_Period` varchar(1000) NOT NULL,
  `Software_Platform` varchar(1000) NOT NULL,
  `General_Accuracy` varchar(1000) NOT NULL,
  `Comments` varchar(1000) NOT NULL,
  `Public` int(11) NOT NULL DEFAULT '1',
  `Creator` int(11) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Database_Revision_ID`),
  KEY `FK_Databases_Revisions__Database_ID` (`Database_ID`),
  CONSTRAINT `FK_Databases_Revisions__Database_ID` FOREIGN KEY (`Database_ID`) REFERENCES `Databases` (`Database_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Databases`
--

DROP TABLE IF EXISTS `Databases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Databases` (
  `Database_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Database_Name` varchar(100) NOT NULL,
  `Description` varchar(8000) NOT NULL,
  `Business_Owner` varchar(100) NOT NULL,
  `Contact_Information` varchar(1000) NOT NULL,
  `Data_Period` varchar(1000) NOT NULL,
  `Software_Platform` varchar(1000) NOT NULL,
  `General_Accuracy` varchar(1000) NOT NULL,
  `Comments` varchar(1000) NOT NULL,
  `Public` int(11) NOT NULL DEFAULT '1',
  `Creator` int(11) NOT NULL,
  `Views` int(11) NOT NULL DEFAULT '0',
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Last_Updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Database_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tables_Variables`
--

DROP TABLE IF EXISTS `Tables_Variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tables_Variables` (
  `Table_Variable_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Table_ID` int(11) NOT NULL,
  `Variable_ID` int(11) NOT NULL,
  PRIMARY KEY (`Table_Variable_ID`),
  UNIQUE KEY `U_Tables_Variables__Table_ID__Variable_ID` (`Table_ID`,`Variable_ID`),
  KEY `FK_Tables_Variables__Table_ID` (`Table_ID`),
  KEY `FK_Tables_Variables__Variable_ID` (`Variable_ID`),
  CONSTRAINT `FK_Tables_Variables__Variable_ID` FOREIGN KEY (`Variable_ID`) REFERENCES `Variables` (`Variable_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_Tables_Variables__Table_ID` FOREIGN KEY (`Table_ID`) REFERENCES `Tables` (`Table_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20412 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Name` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `First_Name` varchar(50) NOT NULL DEFAULT '',
  `Last_Name` varchar(50) NOT NULL DEFAULT '',
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Keywords_Associations`
--

DROP TABLE IF EXISTS `Keywords_Associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Keywords_Associations` (
  `Keyword_Association_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Keyword_ID` int(11) NOT NULL,
  `Element_Type` varchar(45) NOT NULL,
  `Element_ID` int(11) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Keyword_Association_ID`),
  KEY `FK_Keywords_Associations__Keyword_ID` (`Keyword_ID`),
  CONSTRAINT `FK_Keywords_Associations__Keyword_ID` FOREIGN KEY (`Keyword_ID`) REFERENCES `Keywords` (`Keyword_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Temp_TABLE`
--

DROP TABLE IF EXISTS `Temp_TABLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Temp_TABLE` (
  `Table_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Data_Elements`
--

DROP TABLE IF EXISTS `Data_Elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Data_Elements` (
  `Element_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Element_Name` varchar(200) DEFAULT NULL,
  `Element_Parent_ID` int(11) DEFAULT NULL,
  `Element_Type` varchar(100) NOT NULL,
  `Element_Description` varchar(2000) NOT NULL,
  `Element_Creation_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Element_ID`),
  UNIQUE KEY `Element_Name_UNIQUE` (`Element_Name`),
  KEY `Element_Parent_ID` (`Element_ID`),
  KEY `FK_Element_Parent_ID` (`Element_Parent_ID`),
  CONSTRAINT `FK_Element_Parent_ID` FOREIGN KEY (`Element_Parent_ID`) REFERENCES `Data_Elements` (`Element_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Variables`
--

DROP TABLE IF EXISTS `Variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Variables` (
  `Variable_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Variable_Name` varchar(100) NOT NULL,
  `Variable_Description` varchar(1000) NOT NULL,
  `Variable_Type_Format` varchar(100) NOT NULL,
  `Variable_Length` varchar(100) NOT NULL,
  `Variable_Values` varchar(3000) NOT NULL,
  `Variable_Example` varchar(1000) NOT NULL,
  `Variable_Comments` varchar(1000) NOT NULL,
  `Data_Portal` varchar(1) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'Y',
  `Public` int(11) NOT NULL DEFAULT '1',
  `Creator` int(11) NOT NULL,
  `Views` int(11) NOT NULL DEFAULT '0',
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Last_Updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Variable_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20414 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Business_Functions`
--

DROP TABLE IF EXISTS `Business_Functions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Business_Functions` (
  `Business_Function_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Business_Function_Name` varchar(100) NOT NULL,
  `Business_Function_Description` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`Business_Function_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users_User_Types`
--

DROP TABLE IF EXISTS `Users_User_Types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users_User_Types` (
  `User_User_Type_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `User_Type_ID` int(11) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_User_Type_ID`),
  UNIQUE KEY `UNIQUE_Users_User_Types__User_ID_User_Type_ID` (`User_ID`,`User_Type_ID`),
  KEY `FK_User_ID` (`User_ID`),
  KEY `FK_User_Type_ID` (`User_Type_ID`),
  CONSTRAINT `FK_User_ID` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_User_Type_ID` FOREIGN KEY (`User_Type_ID`) REFERENCES `User_Types` (`User_Type_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `User_Types`
--

DROP TABLE IF EXISTS `User_Types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Types` (
  `User_Type_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Type_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`User_Type_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Keywords`
--

DROP TABLE IF EXISTS `Keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Keywords` (
  `Keyword_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Keyword` varchar(100) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Keyword_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Database_Business_Functions`
--

DROP TABLE IF EXISTS `Database_Business_Functions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Database_Business_Functions` (
  `Database_Business_Function_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Database_ID` int(11) NOT NULL,
  `Business_Function_ID` int(11) NOT NULL,
  `Date_Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Database_Business_Function_ID`),
  UNIQUE KEY `U_Database_Business_Functions__Database_ID__Business_Function_ID` (`Database_ID`,`Business_Function_ID`),
  KEY `FK_Database_Business_Functions__Database_ID` (`Database_ID`),
  KEY `FK_Database_Business_Functions__Business_Function_ID` (`Business_Function_ID`),
  CONSTRAINT `FK_Database_ID` FOREIGN KEY (`Database_ID`) REFERENCES `Databases` (`Database_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_Business_Function_ID` FOREIGN KEY (`Business_Function_ID`) REFERENCES `Business_Functions` (`Business_Function_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'datadictionary.cityofchicago.org'
--
/*!50003 DROP PROCEDURE IF EXISTS `0_Import_Database__Create_Database` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `0_Import_Database__Create_Database`(
IN
    _Database_Name VARCHAR(100),
    _Description VARCHAR(8000),
    _Business_Owner VARCHAR(100),
    _Contact_Information VARCHAR(1000),
    _Data_Period VARCHAR(1000),
    _Software_Platform VARCHAR(1000),
    _General_Accuracy VARCHAR(1000),
    _Comments VARCHAR(1000),
    _Creator INT(11)
)
BEGIN
IF (NOT EXISTS(SELECT Database_ID
            FROM
                `Databases`
            WHERE
                Database_Name = _Database_Name))
THEN
    -- insert newly imported DB
    INSERT INTO `Databases`
        (Database_Name, Description, Business_Owner, Contact_Information,
        Data_Period, Software_Platform, General_Accuracy, Comments, Creator)
    VALUES
        (_Database_Name, _Description, _Business_Owner, _Contact_Information,
        _Data_Period, _Software_Platform, _General_Accuracy, _Comments, _Creator);

    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        `Databases`
    WHERE
        Database_ID = LAST_INSERT_ID();
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `0_Import_Table__Create_Table` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `0_Import_Table__Create_Table`(
IN
    _Table_Name VARCHAR(100),
    _Table_Description VARCHAR(8000),
    _Table_Comments VARCHAR(2000),
    _Creator INT(11),
    _Database_Name VARCHAR(100)
)
BEGIN
IF (NOT EXISTS(SELECT Table_ID
            FROM
                Tables
            WHERE
                Table_Name = _Table_Name))
THEN
    -- insert newly imported Table
    INSERT INTO Tables
        (Table_Name, Table_Description,
        Table_Comments, Creator)
    VALUES
        (_Table_Name, _Table_Description,
        _Table_Comments, _Creator);
    
    -- store last_insert_id
    SET @LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- insert relationship
    INSERT INTO Databases_Tables
        (Database_ID, Table_ID)
    VALUES
        ((SELECT Database_ID
            FROM
                `Databases`
            WHERE
                Database_Name = _Database_Name), @LAST_INSERT_ID);
    
    -- get newly imported Table Record (if it exists)
    SELECT *
    FROM
        Tables
    WHERE
        Table_ID = @LAST_INSERT_ID;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `0_Import_Table__Table_Descriptions_OVERWRITE` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `0_Import_Table__Table_Descriptions_OVERWRITE`(
IN
    _Database_Name VARCHAR(100),
    _Table_Name VARCHAR(300),
    _Table_Description VARCHAR(8000),
    _Table_Comments VARCHAR(2000),
    _Creator INT
)
BEGIN
-- if corresponding table database relationship exists
IF (EXISTS(SELECT Tables.Table_ID
        FROM
            Tables, Databases_Tables, `Databases`
        WHERE
            `Databases`.Database_Name = _Database_Name AND
            Databases_Tables.Database_ID = `Databases`.Database_ID AND
            
            Tables.Table_ID = Databases_Tables.Table_ID AND
            Tables.Table_Name = _Table_Name))
THEN
    -- get corresponding table_id
    SET @Table_ID = (SELECT Tables.Table_ID
                    FROM
                        Tables, Databases_Tables, `Databases`
                    WHERE
                        `Databases`.Database_Name = _Database_Name AND
                        Databases_Tables.Database_ID = `Databases`.Database_ID AND
                        
                        Tables.Table_ID = Databases_Tables.Table_ID AND
                        Tables.Table_Name = _Table_Name);
    
    -- overwrite data
    UPDATE Tables
    SET
        Table_Name = _Table_Name,
        Table_Description = _Table_Description,
        Table_Comments = _Table_Comments
    WHERE
        Table_ID = @Table_ID;

    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        Tables
    WHERE
        Table_ID = (SELECT Tables.Table_ID
                    FROM
                        Tables, Databases_Tables, `Databases`
                    WHERE
                        `Databases`.Database_Name = _Database_Name AND
                        Databases_Tables.Database_ID = `Databases`.Database_ID AND
                        
                        Tables.Table_ID = Databases_Tables.Table_ID AND
                        Tables.Table_Name = _Table_Name);
    
ELSE
    -- insert newly imported Table
    INSERT INTO Tables
        (Table_Name, Table_Description, Table_Comments, Creator)
    VALUES
        (_Table_Name, _Table_Description, _Table_Comments, _Creator);
    
    -- store last_insert_id
    SET @LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- insert relationship
    INSERT INTO Databases_Tables
        (Database_ID, Table_ID)
    VALUES
        ((SELECT `Databases`.Database_ID
            FROM
                `Databases`
            WHERE
                `Databases`.Database_Name = _Database_Name), @LAST_INSERT_ID);
    
    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        Tables
    WHERE
        Table_ID = @LAST_INSERT_ID;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `0_Import_Table__Table_Descriptions_SKIP` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `0_Import_Table__Table_Descriptions_SKIP`(
IN
    _Database_Name VARCHAR(100),
    _Table_Name VARCHAR(300),
    _Table_Description VARCHAR(8000),
    _Table_Comments VARCHAR(2000),
    _Creator INT
)
BEGIN
-- if corresponding table database relationship doesn't exist
IF (NOT EXISTS(SELECT Tables.Table_ID
        FROM
            Tables, Databases_Tables, `Databases`
        WHERE
            `Databases`.Database_Name = _Database_Name AND
            Databases_Tables.Database_ID = `Databases`.Database_ID AND
            
            Tables.Table_ID = Databases_Tables.Table_ID AND
            Tables.Table_Name = _Table_Name))
THEN
    -- insert newly imported Table
    INSERT INTO Tables
        (Table_Name, Table_Description, Table_Comments, Creator)
    VALUES
        (_Table_Name, _Table_Description, _Table_Comments, _Creator);
    
    -- store last_insert_id
    SET @LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- insert relationship
    INSERT INTO Databases_Tables
        (Database_ID, Table_ID)
    VALUES
        ((SELECT `Databases`.Database_ID
            FROM
                `Databases`
            WHERE
                `Databases`.Database_Name = _Database_Name), @LAST_INSERT_ID);
    
    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        Tables
    WHERE
        Table_ID = @LAST_INSERT_ID;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `0_Import_Variable__Create_Variable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `0_Import_Variable__Create_Variable`(
IN
    _Variable_Name VARCHAR(100),
    _Variable_Type_Format VARCHAR(100),
    _Variable_Length VARCHAR(100),
    _Variable_Values VARCHAR(3000),
    _Variable_Example VARCHAR(1000),
    _Variable_Comments VARCHAR(1000),
    _Creator INT(11),
    _Table_Name VARCHAR(100)
)
BEGIN
IF (NOT EXISTS(SELECT Variable_ID
            FROM
                Variables
            WHERE
                Variable_Name = _Variable_Name))
THEN
    -- insert newly imported Variable
    INSERT INTO Variables
        (Variable_Name, Variable_Type_Format,
        Variable_Length, Variable_Values, Variable_Example,
        Variable_Comments, Creator)
    VALUES
        (_Variable_Name, _Variable_Type_Format,
        _Variable_Length, _Variable_Values, _Variable_Example,
        _Variable_Comments, _Creator);    
    
    -- store last_insert_id
    SET @LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- insert relationship
    INSERT INTO Tables_Variables
        (Table_ID, Variable_ID)
    VALUES
        ((SELECT Table_ID
            FROM
                Tables
            WHERE
                Table_Name = _Table_Name), @LAST_INSERT_ID);
    
    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        Variables
    WHERE
        Variable_ID = @LAST_INSERT_ID;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `1_Import_Variable__Create_Variable_OVERWRITE` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `1_Import_Variable__Create_Variable_OVERWRITE`(
IN
    _Database_Name VARCHAR(100),
    _Table_Name VARCHAR(100),
    _Variable_Name VARCHAR(100),
    _Variable_Type_Format VARCHAR(100),
    _Variable_Length VARCHAR(100),
    _Variable_Values VARCHAR(3000),
    _Variable_Description VARCHAR(1000),
    _Variable_Example VARCHAR(1000),
    _Variable_Comments VARCHAR(1000),
    _Creator INT(11)
)
BEGIN
-- if corresponding table database relationship exists
IF (EXISTS(SELECT Tables.Table_ID
        FROM
            Tables, Databases_Tables, `Databases`
        WHERE
            `Databases`.Database_Name = _Database_Name AND
            Databases_Tables.Database_ID = `Databases`.Database_ID AND
            
            Tables.Table_ID = Databases_Tables.Table_ID AND
            Tables.Table_Name = _Table_Name))
THEN
    -- if corresponding variable table relationship exists
    IF (NOT EXISTS(SELECT Variables.Variable_ID
                FROM
                    Variables, Tables_Variables, Tables
                WHERE
                    Tables.Table_Name = _Table_Name AND
                    Tables_Variables.Table_ID = Tables.Table_ID AND
                    
                    Variables.Variable_ID = Tables_Variables.Variable_ID AND
                    Variables.Variable_Name = _Variable_Name))
    THEN
        -- insert newly imported Variable
        INSERT INTO Variables
            (Variable_Name, Variable_Description, Variable_Type_Format,
            Variable_Length, Variable_Values, Variable_Example,
            Variable_Comments, Creator)
        VALUES
            (_Variable_Name, _Variable_Description, _Variable_Type_Format,
            _Variable_Length, _Variable_Values, _Variable_Example,
            _Variable_Comments, _Creator);    
        
        -- store last_insert_id
        SET @LAST_INSERT_ID = LAST_INSERT_ID();
        
        -- insert relationship
        INSERT INTO Tables_Variables
            (Table_ID, Variable_ID)
        VALUES
            ((SELECT Tables.Table_ID
                FROM
                    Tables, Databases_Tables, `Databases`
                WHERE
                    `Databases`.Database_Name = _Database_Name AND
                    Databases_Tables.Database_ID = `Databases`.Database_ID AND
                    
                    Tables.Table_ID = Databases_Tables.Table_ID AND
                    Tables.Table_Name = _Table_Name), @LAST_INSERT_ID);
        
        -- get newly imported Database Record (if it exists)
        SELECT *
        FROM
            Variables
        WHERE
            Variable_ID = @LAST_INSERT_ID;
    ELSE
        -- get corresponding table_id
        SET @Table_ID = (SELECT Tables.Table_ID
                        FROM
                            Tables, Databases_Tables, `Databases`
                        WHERE
                            `Databases`.Database_Name = _Database_Name AND
                            Databases_Tables.Database_ID = `Databases`.Database_ID AND
                            
                            Tables.Table_ID = Databases_Tables.Table_ID AND
                            Tables.Table_Name = _Table_Name);
            
        SET @Variable_ID = (SELECT Variables.Variable_ID
                            FROM
                                Variables, Tables_Variables, Tables
                            WHERE
                                Tables.Table_Name = _Table_Name AND
                                Tables_Variables.Table_ID = Tables.Table_ID AND
                                
                                Variables.Variable_ID = Tables_Variables.Variable_ID AND
                                Variables.Variable_Name = _Variable_Name AND
                                Tables.Table_ID = @Table_ID);
        
        -- overwrite newly imported Variable
        UPDATE Variables
        SET
            Variable_Name = _Variable_Name,
            Variable_Description = _Variable_Description,
            Variable_Type_Format = _Variable_Type_Format,
            Variable_Length = _Variable_Length,
            Variable_Values = _Variable_Values,
            Variable_Example = _Variable_Example,
            Variable_Comments = _Variable_Comments,
            Creator = _Creator
        WHERE
            Variable_ID = @Variable_ID;
        
        -- get newly imported Database Record (if it exists)
        SELECT *
        FROM
            Variables
        WHERE
            Variable_ID = @Variable_ID;
        
    END IF;
-- ELSE
--    SELECT CONCAT(_Variable_Name, " Variable Already Exists!") AS ERROR;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `1_Import_Variable__Create_Variable_SKIP` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `1_Import_Variable__Create_Variable_SKIP`(
IN
    _Database_Name VARCHAR(100),
    _Table_Name VARCHAR(100),
    _Variable_Name VARCHAR(100),
    _Variable_Type_Format VARCHAR(100),
    _Variable_Length VARCHAR(100),
    _Variable_Values VARCHAR(3000),
    _Variable_Description VARCHAR(1000),
    _Variable_Example VARCHAR(1000),
    _Variable_Comments VARCHAR(1000),
    _Creator INT(11)
)
BEGIN
-- if corresponding table database relationship exists
IF (EXISTS(SELECT Tables.Table_ID
        FROM
            Tables, Databases_Tables, `Databases`
        WHERE
            `Databases`.Database_Name = _Database_Name AND
            Databases_Tables.Database_ID = `Databases`.Database_ID AND
            
            Tables.Table_ID = Databases_Tables.Table_ID AND
            Tables.Table_Name = _Table_Name))
THEN
    -- if corresponding variable table relationship exists
    IF (NOT EXISTS(SELECT Variables.Variable_ID
                FROM
                    Variables, Tables_Variables, Tables
                WHERE
                    Tables.Table_Name = _Table_Name AND
                    Tables_Variables.Table_ID = Tables.Table_ID AND
                    
                    Variables.Variable_ID = Tables_Variables.Variable_ID AND
                    Variables.Variable_Name = _Variable_Name))
    THEN
        -- insert newly imported Variable
        INSERT INTO Variables
            (Variable_Name, Variable_Description, Variable_Type_Format,
            Variable_Length, Variable_Values, Variable_Example,
            Variable_Comments, Creator)
        VALUES
            (_Variable_Name, _Variable_Description, _Variable_Type_Format,
            _Variable_Length, _Variable_Values, _Variable_Example,
            _Variable_Comments, _Creator);    
        
        -- store last_insert_id
        SET @LAST_INSERT_ID = LAST_INSERT_ID();
        
        -- insert relationship
        INSERT INTO Tables_Variables
            (Table_ID, Variable_ID)
        VALUES
            ((SELECT Tables.Table_ID
                FROM
                    Tables, Databases_Tables, `Databases`
                WHERE
                    `Databases`.Database_Name = _Database_Name AND
                    Databases_Tables.Database_ID = `Databases`.Database_ID AND
                    
                    Tables.Table_ID = Databases_Tables.Table_ID AND
                    Tables.Table_Name = _Table_Name), @LAST_INSERT_ID);
        
        -- get newly imported Database Record (if it exists)
        SELECT *
        FROM
            Variables
        WHERE
            Variable_ID = @LAST_INSERT_ID;
        
    END IF;
-- ELSE
--    SELECT CONCAT(_Variable_Name, " Variable Already Exists!") AS ERROR;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ADMIN__Reload_Search_Tables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `ADMIN__Reload_Search_Tables`()
BEGIN

DROP TABLE Search_Databases;
DROP TABLE Search_Tables;
DROP TABLE Search_Variables;


CREATE TABLE Search_Databases LIKE `Databases`;
INSERT Search_Databases SELECT * FROM `Databases`;

CREATE TABLE Search_Tables LIKE Tables;
INSERT Search_Tables SELECT * FROM Tables;

CREATE TABLE Search_Variables LIKE Variables;
INSERT Search_Variables SELECT * FROM Variables;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Business_Function__Add_Business_Function` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Business_Function__Add_Business_Function`(
IN
    _Business_Function_Name VARCHAR(100),
    _Database_ID INT(11)
)
BEGIN
INSERT INTO Database_Business_Functions
    (Business_Function_ID, Database_ID)
VALUES
    ((SELECT Business_Function_ID
        FROM
            Business_Functions
        WHERE
            Business_Function_Name = _Business_Function_Name), _Database_ID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Business_Function__Get_All_Business_Functions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Business_Function__Get_All_Business_Functions`()
BEGIN
SELECT *
FROM
    Business_Functions
ORDER BY
    Business_Function_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Business_Function__Get_All_Business_Function_Databases` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Business_Function__Get_All_Business_Function_Databases`(
IN
    _Business_Function_ID INT
)
BEGIN
SELECT bf.*, d.*
FROM
    Business_Functions bf, `Databases` d, Database_Business_Functions dbf
WHERE
    bf.Business_Function_ID = _Business_Function_ID AND
    dbf.Business_Function_ID = bf.Business_Function_ID AND
    dbf.Database_ID = d.Database_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Business_Function__Get_Business_Function_Info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Business_Function__Get_Business_Function_Info`(
IN
    _Business_Function_ID INT
)
BEGIN
SELECT *
FROM
    Business_Functions
WHERE
    Business_Function_ID = _Business_Function_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Business_Function__Remove_Business_Function` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Business_Function__Remove_Business_Function`(
IN
    _Business_Function_ID INT(11),
    _Database_ID INT(11)
)
BEGIN
DELETE FROM Database_Business_Functions
WHERE
    Business_Function_ID = _Business_Function_ID AND
    Database_ID = _Database_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Activate_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Activate_Revision`(
IN
    _Database_Revision_ID INT(11)
)
BEGIN
IF (NOT EXISTS(SELECT Database_ID
            FROM
                Databases_Revisions
            WHERE
                Database_Revision_ID = _Database_Revision_ID AND
                Database_ID IS NULL))
THEN
    -- update record
    UPDATE `Databases`
        SET
            Database_Name = (SELECT Database_Name FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Description = (SELECT Description FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Business_Owner = (SELECT Business_Owner FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Contact_Information = (SELECT Contact_Information FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Data_Period = (SELECT Data_Period FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Software_Platform = (SELECT Software_Platform FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            General_Accuracy = (SELECT General_Accuracy FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Comments = (SELECT Comments FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1),
            Last_Updated = (SELECT Date_Created FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1)
        WHERE
            Database_ID = (SELECT Database_ID FROM Databases_Revisions WHERE Database_Revision_ID = _Database_Revision_ID LIMIT 0, 1);
ELSE
    -- insert record
    INSERT INTO `Databases`
        (Database_Name, Description, Business_Owner, Contact_Information,
        Data_Period, Software_Platform, General_Accuracy, Comments, Creator, Date_Created)
        SELECT
            Database_Name, Description, Business_Owner, Contact_Information,
            Data_Period, Software_Platform, General_Accuracy, Comments, Creator, Date_Created
        FROM
            Databases_Revisions
        WHERE
            Database_Revision_ID = _Database_Revision_ID;
    
    -- set the revision's Database_ID
    UPDATE Databases_Revisions
        SET
            Database_ID = LAST_INSERT_ID()
        WHERE
            Database_Revision_ID = _Database_Revision_ID;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Add_View` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Add_View`(
IN
    _Database_ID INT(11)
)
BEGIN
UPDATE `Databases`
SET
    Views = (Views + 1)
WHERE
    Database_ID = _Database_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Create_Database_Table_Relationship` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Create_Database_Table_Relationship`(
IN
    _Database_Name VARCHAR(100),
    _Table_ID INT(11)
)
BEGIN
IF (EXISTS(SELECT Database_ID
            FROM
                `Databases`
            WHERE
                Database_Name = _Database_Name))
THEN
    INSERT INTO Databases_Tables
        (Database_ID, Table_ID)
    VALUES
        ((SELECT Database_ID
            FROM
                `Databases`
            WHERE
                Database_Name = _Database_Name),
        _Table_ID);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Create_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Create_Revision`(
IN
    _Database_ID INT(11),
    _Database_Name VARCHAR(100),
    _Description VARCHAR(8000),
    _Business_Owner VARCHAR(100),
    _Contact_Information VARCHAR(1000),
    _Data_Period VARCHAR(1000),
    _Software_Platform VARCHAR(1000),
    _General_Accuracy VARCHAR(1000),
    _Comments VARCHAR(1000),
    _Creator INT(11)
)
BEGIN
INSERT INTO Databases_Revisions
    (Database_ID, Database_Name, Description, Business_Owner, Contact_Information,
    Data_Period, Software_Platform, General_Accuracy, Comments, Creator)
VALUES
    (_Database_ID, _Database_Name, _Description, _Business_Owner, _Contact_Information,
    _Data_Period, _Software_Platform, _General_Accuracy, _Comments, _Creator);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Delete_Database_Table_Relationship` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Delete_Database_Table_Relationship`(
IN
    _Database_Table_ID INT(11)
)
BEGIN
DELETE FROM Databases_Tables
WHERE
    Database_Table_ID = _Database_Table_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Delete_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Delete_Revision`(
IN
    _Database_Revision_ID INT(11)
)
BEGIN
DELETE FROM Databases_Revisions
WHERE
    Database_Revision_ID = _Database_Revision_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_All_Business_Functions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_All_Business_Functions`(
IN
    _Database_ID INT
)
BEGIN
SELECT bf.*
FROM
    Business_Functions bf, Database_Business_Functions dbf
WHERE
    dbf.Database_ID = _Database_ID AND
    dbf.Business_Function_ID = bf.Business_Function_ID
ORDER BY
    bf.Business_Function_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_All_Databases` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_All_Databases`()
BEGIN
SELECT *
FROM
    `Databases`
ORDER BY
    Database_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Business_Functions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Business_Functions`(
IN
    _Database_ID INT(11)
)
BEGIN
SELECT bf.*
FROM
    Business_Functions bf, Database_Business_Functions dbf
WHERE
    bf.Business_Function_ID = dbf.Business_Function_ID AND
    dbf.Database_ID = _Database_ID
ORDER BY
    bf.Business_Function_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Database_Info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Database_Info`(
IN
    _Database_ID INT
)
BEGIN
SELECT *
FROM
    `Databases`
WHERE
    Database_ID = _Database_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Database_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Database_Revisions`(
IN
    _Database_ID INT(11)
)
BEGIN
SELECT *
FROM
    Databases_Revisions
WHERE
    Database_ID = _Database_ID
ORDER BY
    Date_Created DESC;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Database_Tables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Database_Tables`(
IN
    _Database_ID INT
)
BEGIN
SELECT t.*
FROM
    Tables t, Databases_Tables dt
WHERE
    dt.Database_ID = _Database_ID AND
    dt.Table_ID = t.Table_ID
ORDER BY
    t.Table_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Keywords` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Keywords`(
IN
    _Database_ID INT(11)
)
BEGIN
SELECT Keywords.*
FROM
    Keywords, Keywords_Associations
WHERE
    Keywords.Keyword_ID = Keywords_Associations.Keyword_ID AND
    Keywords_Associations.Element_Type = 'database' AND
    Keywords_Associations.Element_ID = _Database_ID
ORDER BY
    Keywords.Keyword;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Get_Orphan_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Get_Orphan_Revisions`()
BEGIN
SELECT Users.*, Databases_Revisions.*
FROM
    Databases_Revisions, Users
WHERE
    Databases_Revisions.Database_ID IS NULL AND
    Users.User_ID = Databases_Revisions.Creator;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Database__Toggle_Public` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Database__Toggle_Public`(
IN
    _Database_ID INT(11),
    _Public INT(11)
)
BEGIN
UPDATE `Databases`
SET
    Public = _Public
WHERE
    Database_ID = _Database_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Keyword__Add_Keyword` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Keyword__Add_Keyword`(
IN
    _Keyword VARCHAR(100),
    _Element_Type VARCHAR(45),
    _Element_ID INT(11)
)
BEGIN
-- if keyword already exists
IF (EXISTS(SELECT Keyword
            FROM
                Keywords
            WHERE
                Keyword = _Keyword))
THEN
    -- add keyword to element
    INSERT INTO Keywords_Associations
        (Keyword_ID, Element_Type, Element_ID)
    VALUES
        ((SELECT Keyword_ID
            FROM
                Keywords
            WHERE
                Keyword = _Keyword),
        _Element_Type, _Element_ID);
ELSE
    -- add keyword
    INSERT INTO Keywords
        (Keyword)
    VALUES
        (_Keyword);
    
    -- add keyword to element
    INSERT INTO Keywords_Associations
        (Keyword_ID, Element_Type, Element_ID)
    VALUES
        (LAST_INSERT_ID(), _Element_Type, _Element_ID);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Keyword__Get_All_Keywords` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Keyword__Get_All_Keywords`()
BEGIN
SELECT *
FROM
    Keywords;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Keyword__Remove_Keyword` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Keyword__Remove_Keyword`(
IN
    _Keyword VARCHAR(100),
    _Element_Type VARCHAR(45),
    _Element_ID INT(11)
)
BEGIN
DELETE FROM Keywords_Associations
WHERE
    Keyword_ID = (SELECT Keyword_ID
                    FROM
                        Keywords
                    WHERE
                        Keyword = _Keyword)
    AND Element_Type = _Element_Type
    AND Element_ID = _Element_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Main_Most_Viewed` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Main_Most_Viewed`()
BEGIN
-- temporary table for elements
CREATE TEMPORARY TABLE Temp_Most_Viewed (
        Element_Type VARCHAR(50),
        Element_ID INT,
        Element_Name VARCHAR(1000),
        Element_Views INT);
        
-- get databases
INSERT INTO Temp_Most_Viewed (Element_Type, Element_ID, Element_Name, Element_Views)
(SELECT 'Database' AS Element_Type, Database_ID, Database_Name, Views
FROM
    `Databases`
ORDER BY
    Views DESC
LIMIT
    0,5);

-- get tables
INSERT INTO Temp_Most_Viewed (Element_Type, Element_ID, Element_Name, Element_Views)
(SELECT 'Table' AS Element_Type, Table_ID, Table_Name, Views
FROM
    Tables
ORDER BY
    Views DESC
LIMIT
    0,5);

-- get variables
INSERT INTO Temp_Most_Viewed (Element_Type, Element_ID, Element_Name, Element_Views)
(SELECT 'Variable' AS Element_Type, Variable_ID, Variable_Name, Views
FROM
    Variables
ORDER BY
    Views DESC
LIMIT
    0,5);

-- show report
SELECT *
FROM
    Temp_Most_Viewed
ORDER BY
    Element_Views DESC
LIMIT
    0,5;

-- drop temporary table
DROP TABLE Temp_Most_Viewed;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Main_Search` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Main_Search`(
IN
    _Search_Term VARCHAR(100)
)
BEGIN

-- temporary table for error reporting
CREATE TEMPORARY TABLE Temp_Search_Summary (
        Element_Type VARCHAR(50),
        Element_ID INT,
        Element_Name VARCHAR(1000));
        
-- get databases
INSERT INTO Temp_Search_Summary (Element_Type, Element_ID, Element_Name)
SELECT 'Database' AS Element_Type, Database_ID, Database_Name
FROM
    `Databases`
WHERE
    (Database_Name LIKE CONCAT('%', _Search_Term, '%') OR
    Description LIKE CONCAT('%', _Search_Term, '%') OR
    Business_Owner LIKE CONCAT('%', _Search_Term, '%') OR
    Contact_Information LIKE CONCAT('%', _Search_Term, '%') OR
    Data_Period LIKE CONCAT('%', _Search_Term, '%') OR
    Software_Platform LIKE CONCAT('%', _Search_Term, '%') OR
    General_Accuracy LIKE CONCAT('%', _Search_Term, '%') OR
    Comments LIKE CONCAT('%', _Search_Term, '%'))
    AND Public = 1;

-- get tables
INSERT INTO Temp_Search_Summary (Element_Type, Element_ID, Element_Name)
SELECT 'Table' AS Element_Type, Table_ID, Table_Name
FROM
    Tables
WHERE
    (Table_Name LIKE CONCAT('%', _Search_Term, '%') OR
    Table_Description LIKE CONCAT('%', _Search_Term, '%') OR
    Table_Comments LIKE CONCAT('%', _Search_Term, '%'))
    AND Public = 1;

-- get variables
INSERT INTO Temp_Search_Summary (Element_Type, Element_ID, Element_Name)
SELECT 'Variable' AS Element_Type, Variable_ID, Variable_Name
FROM
    Variables
WHERE
    (Variable_Name LIKE CONCAT('%', _Search_Term, '%') OR
    Variable_Description LIKE CONCAT('%', _Search_Term, '%'))
    AND Public = 1;

-- show report
SELECT *
FROM
    Temp_Search_Summary
ORDER BY
    Element_Name;

-- drop temporary table
DROP TABLE Temp_Search_Summary;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Activate_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Activate_Revision`(
IN
    _Table_Revision_ID INT(11)
)
BEGIN
IF (NOT EXISTS(SELECT Table_ID
            FROM
                Tables_Revisions
            WHERE
                Table_Revision_ID = _Table_Revision_ID AND
                Table_ID IS NULL))
THEN
    -- update record
    UPDATE `Tables`
        SET
            Table_Name = (SELECT Table_Name FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1),
            Table_Description = (SELECT Table_Description FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1),
            Table_Comments = (SELECT Table_Comments FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1),
            Creator = (SELECT Creator FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1),
            Last_Updated = (SELECT Date_Created FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1)
        WHERE
            Table_ID = (SELECT Table_ID FROM Tables_Revisions WHERE Table_Revision_ID = _Table_Revision_ID LIMIT 0, 1);
ELSE
    -- insert record
    INSERT INTO `Tables`
        (Table_Name, Table_Description, Table_Comments,
        Creator, Date_Created, Last_Updated)
        SELECT
            Table_Name, Table_Description, Table_Comments,
            Creator, Date_Created, Date_Created
        FROM
            Tables_Revisions
        WHERE
            Table_Revision_ID = _Table_Revision_ID;
    
    -- save last insert id
    SET @_LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- set the revision's Table_ID
    UPDATE Tables_Revisions
        SET
            Table_ID = @_LAST_INSERT_ID
        WHERE
            Table_Revision_ID = _Table_Revision_ID;
    
    -- if there is a Database_ID
    IF (EXISTS(SELECT Database_ID
                FROM
                    Tables_Revisions
                WHERE
                    Table_Revision_ID = _Table_Revision_ID AND
                    Database_ID IS NOT NULL))
    THEN
        -- insert into database table relationships
        INSERT INTO Databases_Tables
            (Database_ID, Table_ID)
        VALUES
            ((SELECT Database_ID
                FROM
                    Tables_Revisions
                WHERE
                    Table_Revision_ID = _Table_Revision_ID), @_LAST_INSERT_ID);
    END IF;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Add_View` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Add_View`(
IN
    _Table_ID INT(11)
)
BEGIN
UPDATE `Tables`
SET
    Views = (Views + 1)
WHERE
    Table_ID = _Table_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Create_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Create_Revision`(
IN
    _Table_ID INT(11),
    _Table_Name VARCHAR(100),
    _Table_Description VARCHAR(8000),
    _Table_Comments VARCHAR(2000),
    _Creator INT(11),
    _Database_ID INT(11)
)
BEGIN
INSERT INTO Tables_Revisions
    (Table_ID, Table_Name, Table_Description,
    Table_Comments, Creator, Database_ID)
VALUES
    (_Table_ID, _Table_Name, _Table_Description,
    _Table_Comments, _Creator, _Database_ID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Create_Table_VariableRelationship` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Create_Table_VariableRelationship`(
IN
    _Table_Name VARCHAR(100),
    _Variable_ID INT(11)
)
BEGIN
IF (EXISTS(SELECT Table_ID
            FROM
                Tables
            WHERE
                Table_Name = _Table_Name))
THEN
    INSERT INTO Tables_Variables
        (Table_ID, Variable_ID)
    VALUES
        ((SELECT Table_ID
            FROM
                Tables
            WHERE
                Table_Name = _Table_Name),
        _Variable_ID);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Delete_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Delete_Revision`(
IN
    _Table_Revision_ID INT(11)
)
BEGIN
DELETE FROM Tables_Revisions
WHERE
    Table_Revision_ID = _Table_Revision_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Delete_Table_Variable_Relationship` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Delete_Table_Variable_Relationship`(
IN
    _Table_Variable_ID INT(11)
)
BEGIN
DELETE FROM Tables_Variables
WHERE
    Table_Variable_ID = _Table_Variable_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_All_Tables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_All_Tables`()
BEGIN
SELECT *
FROM
    Tables;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Keywords` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Keywords`(
IN
    _Table_ID INT(11)
)
BEGIN
SELECT Keywords.*
FROM
    Keywords, Keywords_Associations
WHERE
    Keywords.Keyword_ID = Keywords_Associations.Keyword_ID AND
    Keywords_Associations.Element_Type = 'table' AND
    Keywords_Associations.Element_ID = _Table_ID
ORDER BY
    Keywords.Keyword;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Orphan_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Orphan_Revisions`()
BEGIN
SELECT Users.*, Tables_Revisions.*
FROM
    Tables_Revisions, Users
WHERE
    Table_ID IS NULL AND
    Users.User_ID = Tables_Revisions.Creator;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Parent_Databases` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Parent_Databases`(
IN
    _Table_ID INT(11)
)
BEGIN

SELECT `Databases`.*, Databases_Tables.Database_Table_ID
FROM
    `Databases`
LEFT JOIN
    Databases_Tables
ON
    `Databases`.Database_ID = Databases_Tables.Database_ID
WHERE
    Table_ID = _Table_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Table_Info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Table_Info`(
IN
    _Table_ID INT
)
BEGIN
SELECT *
FROM
    Tables
WHERE
    Table_ID = _Table_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Table_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Table_Revisions`(
IN
    _Table_ID INT(11)
)
BEGIN
SELECT *
FROM
    Tables_Revisions
WHERE
    Table_ID = _Table_ID
ORDER BY
    Date_Created DESC;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Get_Table_Variables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Get_Table_Variables`(
IN
    _Table_ID INT
)
BEGIN
SELECT v.*
FROM
    Variables v, Tables_Variables tv
WHERE
    tv.Table_ID = _Table_ID AND
    tv.Variable_ID = v.Variable_ID
ORDER BY
    v.Variable_Name;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Table__Toggle_Public` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Table__Toggle_Public`(
IN
    _Table_ID INT(11),
    _Public INT(11)
)
BEGIN
UPDATE Tables
SET
    Public = _Public
WHERE
    Table_ID = _Table_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Add_User_User_Type` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Add_User_User_Type`(
IN
    _User_ID INT(11),
    _User_Type_ID INT(11)
)
BEGIN
INSERT INTO Users_User_Types
    (User_ID, User_Type_ID)
VALUES
    (_User_ID, _User_Type_ID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Get_All_Users` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Get_All_Users`()
BEGIN
SELECT *
FROM
    Users;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Get_All_User_Types` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Get_All_User_Types`()
BEGIN
SELECT *
FROM
    User_Types;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Get_Users_User_Types` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Get_Users_User_Types`(
IN
    _User_ID INT
)
BEGIN
SELECT ut.*
FROM
    User_Types ut, Users_User_Types uut
WHERE
    uut.User_ID = _User_ID AND
    ut.User_Type_ID = uut.User_Type_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Get_User_Info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Get_User_Info`(
IN
    _User_ID INT
)
BEGIN
SELECT *
FROM
    Users
WHERE
    User_ID = _User_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Validate_Login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `User__Validate_Login`(
IN
    _User_Name VARCHAR(100),
    _Password VARCHAR(100)
)
BEGIN
SELECT *
FROM
    Users
WHERE
    User_Name = _User_Name AND
    Password = _Password;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Activate_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Activate_Revision`(
IN
    _Variable_Revision_ID INT(11)
)
BEGIN
IF (NOT EXISTS(SELECT Variable_ID
            FROM
                Variables_Revisions
            WHERE
                Variable_Revision_ID = _Variable_Revision_ID AND
                Variable_ID IS NULL))
THEN
    -- update record
    UPDATE `Variables`
        SET
            Variable_Name = (SELECT Variable_Name FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Description = (SELECT Variable_Description FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Type_Format = (SELECT Variable_Type_Format FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Length = (SELECT Variable_Length FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Values = (SELECT Variable_Values FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Example = (SELECT Variable_Example FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Variable_Comments = (SELECT Variable_Comments FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Data_Portal = (SELECT Data_Portal FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Creator = (SELECT Creator FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1),
            Last_Updated = (SELECT Date_Created FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1)
        WHERE
            Variable_ID = (SELECT Variable_ID FROM Variables_Revisions WHERE Variable_Revision_ID = _Variable_Revision_ID LIMIT 0, 1);
ELSE
    -- insert record
    INSERT INTO `Variables`
        (Variable_Name, Variable_Description, Variable_Type_Format,
        Variable_Length, Variable_Values, Variable_Example,
        Variable_Comments, Data_Portal, Creator, Date_Created, Last_Updated)
        SELECT
            Variable_Name, Variable_Description, Variable_Type_Format,
            Variable_Length, Variable_Values, Variable_Example,
            Variable_Comments, Data_Portal, Creator, Date_Created, Date_Created
        FROM
            Variables_Revisions
        WHERE
            Variable_Revision_ID = _Variable_Revision_ID;
    
    -- save last insert id
    SET @_LAST_INSERT_ID = LAST_INSERT_ID();
    
    -- set the revision's Table_ID
    UPDATE Variables_Revisions
        SET
            Variable_ID = @_LAST_INSERT_ID
        WHERE
            Variable_Revision_ID = _Variable_Revision_ID;
    
    -- if there is a Table_ID
    IF (EXISTS(SELECT Table_ID
                FROM
                    Variables_Revisions
                WHERE
                    Variable_Revision_ID = _Variable_Revision_ID AND
                    Table_ID IS NOT NULL))
    THEN
        -- insert into table variable relationships
        INSERT INTO Tables_Variables
            (Table_ID, Variable_ID)
        VALUES
            ((SELECT Table_ID
                FROM
                    Variables_Revisions
                WHERE
                    Variable_Revision_ID = _Variable_Revision_ID), @_LAST_INSERT_ID);
    END IF;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Add_View` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Add_View`(
IN
    _Variable_ID INT(11)
)
BEGIN
UPDATE `Variables`
SET
    Views = (Views + 1)
WHERE
    Variable_ID = _Variable_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Create_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Create_Revision`(
IN
    _Variable_ID INT(11),
    _Variable_Name VARCHAR(100),
    _Variable_Description VARCHAR(1000),
    _Variable_Type_Format VARCHAR(100),
    _Variable_Length VARCHAR(100),
    _Variable_Values VARCHAR(3000),
    _Variable_Example VARCHAR(1000),
    _Variable_Comments VARCHAR(1000),
    _Data_Portal VARCHAR(1),
    _Creator INT(11),
    _Table_ID INT(11)
)
BEGIN
INSERT INTO Variables_Revisions
    (Variable_ID, Variable_Name, Variable_Description,
    Variable_Type_Format, Variable_Length, Variable_Values,
    Variable_Example, Variable_Comments, Data_Portal,
    Creator, Table_ID)
VALUES
    (_Variable_ID, _Variable_Name, _Variable_Description,
    _Variable_Type_Format, _Variable_Length, _Variable_Values,
    _Variable_Example, _Variable_Comments, _Data_Portal,
    _Creator, _Table_ID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Delete_Revision` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Delete_Revision`(
IN
    _Variable_Revision_ID INT(11)
)
BEGIN
DELETE FROM Variables_Revisions
WHERE
    Variable_Revision_ID = _Variable_Revision_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_All_Variables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_All_Variables`()
BEGIN
SELECT *
FROM
    Variables;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_Keywords` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_Keywords`(
IN
    _Variable_ID INT(11)
)
BEGIN
SELECT Keywords.*
FROM
    Keywords, Keywords_Associations
WHERE
    Keywords.Keyword_ID = Keywords_Associations.Keyword_ID AND
    Keywords_Associations.Element_Type = 'variable' AND
    Keywords_Associations.Element_ID = _Variable_ID
ORDER BY
    Keywords.Keyword;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_Orphan_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_Orphan_Revisions`()
BEGIN
SELECT Users.*, Variables_Revisions.*
FROM
    Variables_Revisions, Users
WHERE
    Variable_ID IS NULL AND
    Users.User_ID = Variables_Revisions.Creator;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_Parent_Tables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_Parent_Tables`(
IN
    _Variable_ID INT(11)
)
BEGIN

SELECT Tables.*, Tables_Variables.Table_Variable_ID
FROM
    Tables
LEFT JOIN
    Tables_Variables
ON
    Tables.Table_ID = Tables_Variables.Table_ID
WHERE
    Variable_ID = _Variable_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_Variable_Info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_Variable_Info`(
IN
    _Variable_ID INT
)
BEGIN
SELECT *
FROM
    Variables
WHERE
    Variable_ID = _Variable_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Get_Variable_Revisions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Get_Variable_Revisions`(
IN
    _Variable_ID INT(11)
)
BEGIN
SELECT *
FROM
    Variables_Revisions
WHERE
    Variable_ID = _Variable_ID
ORDER BY
    Date_Created DESC;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Variable__Toggle_Public` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`citydata`@`hyperion.chapinhall.org`*/ /*!50003 PROCEDURE `Variable__Toggle_Public`(
IN
    _Variable_ID INT(11),
    _Public INT(11)
)
BEGIN
UPDATE Variables
SET
    Public = _Public
WHERE
    Variable_ID = _Variable_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-07 14:22:09
