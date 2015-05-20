'''docstring'''
import os, sys
import traceback
import datetime
import csv
#from datetime import date
#sys.path.append('c:\\greg\\code\\python')  		

class DataModelerXmlReader(object):
    initialized = False
    testmode = True
    error_message = ''
    logfile = ''
    logfile_handle = None
    logfile_is_open = False
    log_to_file = True
    log_to_db = False
    log_to_browser = False
    current_xmlfile_path = ''
    current_xmlfile_name = ''
    parent_folder = ''	
    csv_output_folder = ''
    master_xmlparent = ''
    master_xmlfile = ''
    master_xmlfiles = []
    tables = {}
    columns = {}
    #col_tbl_db = {}
    dblist = tbllist = collist = []
	
    #def __init__(self):
    #    super().__init__()
    def initialize(self):
        now = datetime.datetime.now()
        stamp = str(now.year) + str(now.month) + str(now.day) + str(now.hour) + str(now.minute) + str(now.second)
        self.logfile = 'C:\Temp\PythonLogFile_' + stamp + '.txt'
        self.initialized = True
    
    def open_logfile(self):
        self.logfile_handle = open(self.logfile, 'a')

    def close_logfile(self):
        self.logfile_handle.close()
		
    def logit(self, text, to_console=False, to_logfile=False, to_db=False, to_browser=False):
        '''docstring '''
        #Always log to console if TestMode is True, or if an error has occurred:
        if(self.testmode):
            to_console = True
        if(self.error_message != ''):
            to_console = True
        if(self.log_to_file):
            to_logfile = True
        if(self.log_to_db):
            to_db = True
        if(self.log_to_browser):
            to_browser = True
        #*********************
        if(to_console):
           	print(text)
        if(to_logfile):
            if(text != '' and text is not None):
                if(self.logfile_is_open == False):
                    self.open_logfile()
                    self.logfile_is_open = True
                    self.logfile_handle.write(text)

    def find_first_matching_child_folder(self, parent_name_with_path, child_name):
        '''Seek a child folder under a specified parent folder or its subfolders. Return the first matching child folder encountered. Thanks to Jerub at http://stackoverflow.com/questions/120656/directory-listing-in-python'''
        child_name = child_name.lower()
        for dirname, dirnames, filenames in os.walk(parent_name_with_path):
            # print path to all subdirectories
            for subdirname in dirnames:
                subdir_with_path = os.path.join(dirname, subdirname)
                self.logit("\n" + "DIR: " + dirname)
                self.logit("SUB: " + subdirname)
                if(subdirname.lower() == child_name):
                    return subdir_with_path
        return None
    
    def find_all_matching_child_folders(self, parent_name_with_path, child_name):
        '''Seek a child folder under a specified parent folder or its subfolders. Return a list of all matching folders found.  Thanks to Jerub at http://stackoverflow.com/questions/120656/directory-listing-in-python'''
        child_name = child_name.lower()
        matchlist = []
        for dirname, dirnames, filenames in os.walk(parent_name_with_path):
            for subdirname in dirnames:
                subdir_with_path = os.path.join(dirname, subdirname)
                self.logit("\n" + "DIR: " + dirname)
                self.logit("SUB: " + subdirname)
                if(subdirname.lower() == child_name):
                    matchlist.append(subdir_with_path)
        return matchlist

    def _identify_master_xml_files(self, parent_folder):
        '''Traverse the descendants of the specified parent folder, to locate the "/rel/ folder where DataModeler XML files are stored.'''
        matchlist = self.find_all_matching_child_folders(parent_folder, 'seg_0')
        self.logit("\n \n \n")
        self.logit(matchlist)
        if(len(matchlist) > 0):
            for folder in matchlist:
                folder_path_as_list = str(folder).lower().split(os.sep)
                if(self.testmode):
                    self.logit("\n \n \n" + "^^^^^^^^^^^^^^^^^^^^^^")
                    self.logit(folder_path_as_list)
                    self.logit('table? ' + str('table' in folder_path_as_list))
                    self.logit('phys? ' + str('phys' in folder_path_as_list))
                    self.logit('seg_0? ' + str('seg_0' in folder_path_as_list))
                #if(('table' in folder_path_as_list) and ('seg_0' in folder_path_as_list) and not ('phys' in folder_path_as_list)):
                if( ('seg_0' in folder_path_as_list) and not ('phys' in folder_path_as_list) ):
                    self.logit("\n" + "You found it: '" + str(folder) + "'")
                    self.master_xmlparent = str(folder)
        self.logit("\n" + "PARENT FOLDER rel OF DataModeler XML FILES: '" + self.master_xmlparent + "'" + "\n")
        '''Once the /seg_0/ folder is located, traverse the FILES under the /rel/ folder and its subfolders, to find DataModeler XML files.'''
        digits = '0123456789'
        for dirname, dirnames, filenames in os.walk(self.master_xmlparent):
            xmlfiles = []
            for filename in filenames:
                '''Master XML file will have a filename of digits and hyphens.  Example: 27A9EE0B-3C17-955B-B560-992EAC724718.xml'''
                #GMS January 2014 - some XML files start with Letters and appear to be valid table descriptions.  Why was the limitation placed here to only read XML files starting with DIGITS?
                #if(str(filename)[0] in digits and str(filename.lower()).endswith('xml')):
                if(str(filename.lower()).endswith('xml')):
                    xmlfile = os.path.join(dirname, filename)
                    xmlfiles.append(xmlfile)
                    self.logit("\n" + "XML FILE: '" + xmlfile + "'")
            #'''TESTING: Assume that the first matching XML file found in the relevant folder is the correct file in which detailed information is stored'''
            #self.master_xmlfile = xmlfiles[0]
            #self.logit("\n" + "MASTER XML FILE: '" + self.master_xmlfile + "'")
            #return self.master_xmlfile
            return xmlfiles

    def get_value_for_xml_tag(self, xml_line, tagtext):
        '''Remove tag text from a line of XML. Example: pass the line <sourceObjName>test1</sourceObjName> and this function returns "test1". 
		NOTE: tagtext is case-sensitive and must be specified exactly as it appears in the XML file. '''
        tagtext = tagtext.strip()
        value = str(xml_line).replace('<' + tagtext + '>', '')
        value = value.replace('</' + tagtext + '>', '')
        value = value.replace(chr(10), '').replace(chr(13), '').strip()
        return value

    def get_datatype_from_dmdtype(self, dmdtype):
        datatype = ''
        if(dmdtype.upper() == "LOGDT007"):    #Date
            datatype = "Date"
        elif(dmdtype.upper() == "LOGDT011"):  #Int
            datatype = "Int"
        elif(dmdtype.upper() == "LOGDT015"):  #Datetime
            datatype = "Timestamp"
        elif(dmdtype.upper() == "LOGDT019"):  #Decimal??
            datatype = "Decimal"
        elif(dmdtype.upper() == "LOGDT024"):  #varchar
            datatype = "Char"
        elif(dmdtype.upper() == "LOGDT025"):  #char
            datatype = "Char"
        elif(dmdtype.upper() == "LOGDT027"):  #bigint
            datatype = "Int"	
        elif(dmdtype.upper() == "LOGDT034"):  #Bit
            datatype = "Boolean"
        return datatype

    def _define_csv_ouputfolder(self, parent_folder=None, output_folder=None):
        if(parent_folder=='' or parent_folder is None):
            parent_folder = self.parent_folder
        if(output_folder=='' or output_folder is None):
            output_folder = self.csv_output_folder
        if(output_folder=='' or output_folder is None):
            output_folder = "metalicious_uploads_csv"
        #If the output_folder is a sub-folder without a full path, create it UNDER THE PARENT FOLDER. 
        head, tail = os.path.split(output_folder)
        if(head == ''):
            self.csv_output_folder = os.path.join(parent_folder, output_folder)
        else:
            self.csv_output_folder = output_folder
        if not os.path.exists(self.csv_output_folder):
            os.makedirs(self.csv_output_folder)
        self.logit("New CSV files will be saved to folder: " + self.csv_output_folder)
        return self.csv_output_folder

    def write_tableinfo_to_csv(self, tablename='', dbname='', output_folder=None):
        '''This function is typically called by function read_xml_file(). It writes the current self.tables information to a CSV file that can be uploaded to the Metalicious website.
        Table-level information that has been saved by function read_xml_file can be exported to a CSV file for upload into Metalicious.
        CSV columns: (1) Database name (2) Table name (3) Table description'''
        print("\nTop of write_tableinfo_to_csv(), table parm is '%s'" % (tablename))
        csvfile = 'Tbl_'
        #G.Sanders 9/2014 DO NOT include DB name in export CSV until we have a way of identifying the user-friendly DB name
        # if dbname:
        #    csvfile = csvfile + dbname.strip() + '__'
        if tablename:
            csvfile = csvfile + tablename.strip() + '_'  
        csvfile = csvfile + self.current_xmlfile_name.lower().replace('.xml', '.csv')
        self._define_csv_ouputfolder()		            #Define the path where CSV files will be stored, and create that folder if it does not exist.
        csvfile_with_path = os.path.join(self.csv_output_folder, csvfile)
        self.logit("\n" + "CSV file location: " + self.csv_output_folder, True)
        self.logit("New TABLE CSV file: " + csvfile, True)
        if sys.version_info >= (3,0,0):                 #FOR PYTHON3
            csvfile = open(csvfile_with_path, 'w', newline='')
        else:
            csvfile = open(csvfile_with_path, 'wb')
        with csvfile:
            csvwriter = csv.writer(csvfile, delimiter=',', quotechar='"', quoting=csv.QUOTE_ALL)    #, quoting=csv.QUOTE_MINIMAL
            hold_tbl = ""
            for key, value in self.tables.items():
                #If the current row matches the specified tablename (or if no tablename was specified), write the LIST associated with this Table/Column combination to the CSV file.
                #KEYS for the self.columns DICT are a concatenation of DB and Table, delimited by tilde ~
                #EACH VALUE in the self.tables dict is a list showing this table's database and description.
                #print("Next TABLE in self.tables: %s" % (value))
                tilde = key.find('~')
                if(tilde > -1):
                    #self.logit("In write_tableinfo(), String '" + key + "' delimited at tilde " + str(tilde) + "... '" + key[:tilde] + "' and '" + key[tilde+1:] + "'")
                    if not dbname or (dbname and key[:tilde].lower() == dbname.lower()):            #If no DB name was found, or the DB name found MATCHES the specified DbName parameter.
                        current_tbl = str(value[1])               #TableName is the 2nd value in the values list
                        if current_tbl.strip().lower() == tablename.strip().lower() and current_tbl != hold_tbl:                  #In the TABLES csv file, we write out each data table ONLY ONCE (which means this CSV normally has only ONE ROW).
                            self.logit("\nIn write_tableinfo(), writing row for Table '%s'" % (current_tbl) )
                            #This is where the CSV row is written to the file:
                            csvwriter.writerow(["(db here)", value[1], value[2], value[0] ])        #Key for this dict is a concatenation of DB + '~' + TABLE. key[:tilde] is the DB and key[tilde+1:] is the TABLE
                            hold_tbl = value[1]
            csvfile.close()
            return 1


    def write_columninfo_to_csv(self, tablename='', dbname='', output_folder=None):
        '''This function is typically called by function read_xml_file(). 
        Column-level information that has been saved by function read_xml_file can be exported to a CSV file for upload into Metalicious.
        CSV columns: (1) Table name (2)Database name (aka "system") (3) Column name (4) Data type (5) Column width (6) Codebook for this column (7) Caption for this column. '''
        print("\nTop of write_columninfo_to_csv(), table parm is '%s'" % (tablename))
        csvfile = 'VarUpld_'
        #G.Sanders 9/2014 DO NOT include DB name in export CSV until we have a way of identifying the user-friendly DB name
        #if(dbname !='' and dbname is not None):
        #    csvfile = csvfile + dbname.strip() + '__'
        if(tablename !='' and tablename is not None):
            csvfile = csvfile + tablename.strip() + '_'  
        csvfile = csvfile + self.current_xmlfile_name.lower().replace('.xml', '.csv')
        self._define_csv_ouputfolder()		#Define the path where CSV files will be stored, and create that folder if it does not exist.
        csvfile_with_path = os.path.join(self.csv_output_folder, csvfile)
        self.logit("CSV file location: " + self.csv_output_folder, True)
        self.logit("New CSV file: " + csvfile, True)
        if sys.version_info >= (3,0,0):         #FOR PYTHON3
            csvfile = open(csvfile_with_path, 'w', newline='')
        else:
            csvfile = open(csvfile_with_path, 'wb')
        with csvfile:
            csvwriter = csv.writer(csvfile, delimiter=',', quotechar='"', quoting=csv.QUOTE_ALL)    #, quoting=csv.QUOTE_MINIMAL
            for key, value in self.columns.items() :
                #If the current row matches the specified tablename (or if no tablename was specified), write the LIST associated with this Table/Column combination to the CSV file.
                #KEYS for the self.columns DICT are a concatenation of Table and Column, delimited by tilde ~				
                #VALUES for the self.columns dict are lists showing this column's database, table, column-name, alias, datatype, width, codebook and description.
                tilde_pos = key.find('~')
                if(tablename and tilde_pos > -1):
                    current_tbl = key[:tilde_pos]
                    #self.logit("In write_columninfo(), seeking table '%s', found current_tbl '%s'. String '%s' delimited at tilde %s... '%s' and '%s'"  % (tablename, current_tbl, key, tilde_pos, key[:tilde_pos], key[tilde_pos+1:]), True)
                    if current_tbl.strip().lower() == tablename.strip().lower():
                        self.logit("In write_columninfo(), writing row for Table '%s' and value '%s %s'" % (current_tbl,  value[1], value[2]), True )
                        #This is where the CSV row is written to the file:
                        csvwriter.writerow([ "(db here)", value[1], value[2], value[3], value[4], value[5], value[6], value[0] ])      #Key for this dict is a concatenation of TABLE + '~' + COLUMN. key[:tilde_pos] is the TABLE and key[tilde_pos+1:] is the COLUMN
                    else:
                        pass  #print("Too bad, '%s' does not equal '%s'" % (tablename, current_tbl))
            csvfile.close()				
            return 1


    def read_xml_file(self, xmlfile_with_path, write_to_csv=True):
        self.logit("\n" + "*****************************************READING NEXT XML FILE***************************")
        self.logit(xmlfile_with_path)
        self.logit("************************************************************************************************")
        head, tail = os.path.split(xmlfile_with_path)
        self.current_xmlfile_path = head
        self.current_xmlfile_name = tail
        datatype = columnwidth = comment = coldescrip = codebook = section = holddb = holdtable = columnname = tbldescrip = ''
        temp_col_list = []
        temp_tbl_list = []
        with open(xmlfile_with_path, "r") as f:
            count_col = 0
            content = f.readlines()          #Load the contents of the XML file into a list
            ln = 0
            for line in content:
                #self.logit(line)
                #self.logit("\nRow %s) Current section: '%s'" % (ln, section), True)
                self.logit("Row %s)" % (ln), True)
                parentobj = childobj = ''
                '''XML file is divided into a TABLE section and a COLUMNS section.
                In Table section, Table is the child and DB is the parent. In Columns section, Column is the child and Table is the Parent.'''
                if(line.lower().find('<table') > -1):
                    print("Found the TABLE SECTION")
                    section = 'table' 
                    parent_type = 'Database'
                    child_type = 'Table'
                elif(line.lower().find('<columns') > -1):
                    section = 'column'
                    parent_type = 'Table'
                    child_type = 'Column'
                elif(line.lower().find('<fonts') > -1):
                    section = 'font'
                elif(line.lower().find('<indexes') > -1):
                    section = 'index'
                #print("%s)Current section: '%s'" % (ln, section))

                if(line.lower().find('<table') > -1):
                    if(line.find(' name="') > -1):
                        childobj = str(line[line.find(' name="'):]).replace(' name="', '').replace('">', '').replace(chr(9),'').replace(chr(10),'').replace(chr(13),'')
                        print("\nIn TableSection, ChildObj is '%s' with type '%s'" % (childobj, child_type))
                elif(line.find('schemaObject') > -1):
                    parentobj = self.get_value_for_xml_tag(line, 'schemaObject')
                elif(line.find('sourceObjSchema') > -1):                   #sourceObjSchema tag value is the Table Name if this is a Columns section
                    parentobj = self.get_value_for_xml_tag(line, 'sourceObjSchema')
                    #self.logit("\n" + "NEXT PARENT MATCH (" + parent_type + "): " + parentobj)
                elif(line.find('sourceObjName') > -1):                   #sourceObjName is the Column Name
                    childobj = self.get_value_for_xml_tag(line, 'sourceObjName')
                    #self.logit("NEXT CHILD MATCH (" + child_type + "): " + childobj)
                elif(line.find('logicalDatatype') > -1):                 #logicalDatatype is the data type, which is in a DM-specific format
                    datatype = self.get_value_for_xml_tag(line, 'logicalDatatype')
                    datatype = self.get_datatype_from_dmdtype(datatype)
                elif(line.find('dataTypeSize') > -1):                    #dataTypeSize is the byte width for this data column
                    columnwidth = self.get_value_for_xml_tag(line, 'dataTypeSize')
                elif(line.find('comment') > -1):                         #Comment tag is important because we read it, and sometimes write it.
                    comment = self.get_value_for_xml_tag(line, 'comment')
                    if(section == 'table'):
                        tbldescrip = comment
                    elif(section == 'column'):
                        #Column comment should be divided into two sections, if the user included both DESCRIPTION and CODEBOOK narrative in this space.
                        codebook_pos = comment.upper().find('CODEBOOK')
                        if codebook_pos:
                            print("Codebook keyword found at position: %s" % (codebook_pos) )
                            coldescrip = comment[:codebook_pos]
                            codebook = comment.replace(coldescrip, '')
                            codebook = codebook[10:].strip()                  #Remove the word "Codebook"
                        else:
                            codebook = ''
                            coldescrip = comment
                    print("Comment: '" + comment + "' ...  Descrip: '" + coldescrip + "' .... Codebook: '" + codebook + "'")

                #If a parent or child object has been located, store the value
                if(parentobj or childobj):                    #Either a Parent or a Child object (or both) found
                    print("Parentobj: '%s', ChildObj: '%s', Section: '%s'" % (parentobj, childobj, section))
                    '''Table section has only table-level attributes (including its parent database) '''
                    if(section == 'table'):                   #Currently reading lines within the <Table tag, before we encounter the <columns> collection
                        if(parentobj):
                            holddb = parentobj
                            print("HoldDB: '%s'" % (holddb))
                        if(childobj):
                            holdtable = childobj
                            print("HoldTable: '%s'" % (holdtable))
                    elif(section == 'column'):
                        '''Column section has column-level attributes '''  
                        if(parentobj):
                            holdtable = parentobj
                            print("HoldTable-- '%s'" % (holdtable))
                        if(childobj):
							#Store information about this table-column combination in a dict:
                            #self.col_tbl_db['db_' + holddb + '___tbl_' + holdtable + '___col_' + str(count_col)] = childobj
                            columnname = childobj            #Text found in the "sourceObjName" element
                            #self.col_tbl_db[holdtable + '~' + columnname] = holddb
                            count_col = count_col + 1
                #End of metadata about this COLUMN
                #***********************************************************************************************************
                #Write the TABLE metadata into self.tables
                if(line.lower().find('<columns') > -1):           #String "<columns" is found in this line, signifying the END of the table description section. Write the current TABLE information to a list now.
                    temp_tbl_list.append(holddb.upper())       	  #0 - database (actual name, not the user-friendly Metalicious DB name)
                    temp_tbl_list.append(str(holdtable).upper() ) #1 - table
                    temp_tbl_list.append(str(tbldescrip))         #2 - table description
                    #Store the temp_tbl_list[] variables to a dictionary-type class property called self.tables
                    self.tables[holddb + '~' + holdtable] = temp_tbl_list         #db + '~' + table is the key, while the entire 'temp_tbl_list' attribute list is the 'value' of the dict item.
                    #blank out the placeholder variables, or their values will carry over into the next TABLE section
                    tbldescrip = ''
                    temp_tbl_list = []
                #***********************************************************************************************************
                #Write the COLUMN metadata into self.columns
                if(line.find('</Column>') > -1):                  #String "</Column>" is found in this line, signifying the END of a column description section.
                    temp_col_list.append(holddb.upper())          #0 - database (actual name, not the user-friendly Metalicious DB name)
                    temp_col_list.append(str(holdtable).upper() ) #1 - table
                    temp_col_list.append(columnname)              #2 - column
                    temp_col_list.append(datatype)   	          #3 - datatype
                    columnwidth = columnwidth.upper().replace("BYTES", "").replace("BYTE", "").strip()
                    temp_col_list.append(columnwidth)  	          #4 - column-width
                    temp_col_list.append(codebook)   	          #5 - codebook (valid values and their code definitions)
                    temp_col_list.append(coldescrip)  		          #6 - description of this column ("variable")
                    #Store the temp_col_list[] variables to a dictionary-type class property called self.columns, which stores ALL columns found.
                    self.columns[holdtable + '~' + columnname] = temp_col_list         #table + '~' + column is the key, while the entire 'temp_col_list' attribute list is the 'value' of the dict item.
                    #IMPORTANT: blank out the placeholder variables, or their values will carry over into the next COLUMN section (and they won't be overwritten if the next column section lacks tags for some of the attributes!)
                    columnname = datatype = columnwidth = comment = coldescrip = codebook = ''
                    temp_col_list = []

                if(line.lower().find('</columns>') > -1):        #End of the relevant sections in this XML file
                    self.debug_display_table_list()
                    self.debug_display_column_list
                ln += 1

        #Write the information from this XML file to CSV files (one file for Table-level info, one file for Column-level info):
        if write_to_csv:
            self.write_tableinfo_to_csv(holdtable, holddb)
            self.write_columninfo_to_csv(holdtable, holddb)

            return 1

    def read_all_xml_files(self, parent_folder, output_folder=None):
        '''Detailed information about the items exported from an Oracle Data Modeler DMD project can be found in an XML file buried deep in the folders beneath the .DMD file.
        First locate the relevant XML files, then parse the elements of those files and store the information contained therein to a CSV file.'''
        if(self.initialized == False):
            self.initialize()
        if(output_folder=='' or output_folder is None):
            output_folder = "metalicious_uploads_csv"
        '''It is possible a FILE rather than a FOLDER was dropped here.'''
        head, tail = os.path.split(parent_folder)
        pos = tail.rfind('.')
        if(pos+5 > len(tail)):		#period near end indicates this is probably a filename
            parent_folder = head    #parent_folder is the parent of the specified file.
        self.logit("Parent folder: '" + parent_folder + "'", True)
        if(parent_folder != '' and parent_folder is not None): 
            parent_folder = str(parent_folder)
            '''Copy the parent_folder local variable to a class property '''
            self.parent_folder = parent_folder
            '''Do not go through the process of identifying the master XML file for this DMD file every time a new item is submitted for processing! This XML file should provide detailed information for ALL items contained in the current Data Modeler DMD model. '''
            if(self.master_xmlfile is None or len(self.master_xmlfiles) == 0):
                self.master_xmlfiles = self._identify_master_xml_files(parent_folder)
                if(self.master_xmlfiles is None or len(self.master_xmlfiles) == 0):
                    self.error_message = 'Master XML details file was not found'
                    self.logit(self.error_message)
                    return None
            
        else:
            self.error_message = 'Parent Folder cannot be blank'
            self.logit(self.error_message)
            return None
        #***************************************************************************************************************
        '''Assuming the master XML files have been located, read through them to locate db-schema name, table name, etc. 
		It appears that one master XML file is generated for EACH TABLE. So we can assume that only one database and one table are described by each XML.'''
        self.logit("\n" + "Number of XML files found: " + str(len(self.master_xmlfiles)), True)
        for xmlfile in self.master_xmlfiles:
            self.logit("Next XML: " + xmlfile)		
            '''The read_xml_file() function extracts column names along with their table and database containers. '''
            self.read_xml_file(xmlfile)
        #***************************************************************************************************************
        #self.columns stores the column-level metadata for ALL XML files within the folder being searched.
        self.logit("\n \n" + "---------ALL COLUMNS FOUND (keys are a concatenation of Table and Column; values are attributes of the COLUMN. Items appear in no particular order because this is a DICTIONARY.)----------------------------------")
        for key, value in self.columns.items():		  #FOR PYTHON3
            self.logit(value)

        # *******************************************************************************************
        #If specified, write metadata for the TABLE, and the COLUMNS in this TABLE, to a CSV file.
        self.debug_display_table_list()
        self.debug_display_column_list()
        #if(write_to_csv):
            #self.write_tableinfo_to_csv(holdtable, holddb)
            #self.write_columninfo_to_csv(holdtable, holddb)

        #self.logit('\n' + 'Find database_business_functions~business_function_id: ' + self.col_tbl_db['database_business_functions~business_function_id'])
        #If log file was opened, close it before exiting.			
        if(self.logfile_is_open):
            self.close_logfile()

        return output_folder

    def update_metadata_in_dmd(self, dmd_file_with_path, object_type, object_name, attributes):
        '''Oracle Model Builder DMD files can be updated to conform to metadata imported from CSV files or RDBMS.
		object_type can be 'table' or 'column'.  object_name is the table or column name. attributes is a dict of attributes such as datatype, columnwidth or comment.'''
        success = True
        if(self.initialized == False):
            self.initialize()
        object_type = object_type.strip().lower()
        object_name = object_name.strip().lower()		
        section_is_specified_target = False
        if(dmd_file_with_path.lower()[-4:] != ".dmd"):
            self.error_message = "Specified file is not a DMD file: '" + dmd_file_with_path + "'"
            self.logit(self.error_message, True)
            return False
        if os.path.isfile(dmd_file_with_path):
            try: 
                with open(xmlfile_with_path, "r+") as dmd:
                    content = dmd.readlines()
                    line_num = 0
                    for line in content:
                        self.logit(line)
                        section = ''
                        #XML file is deivided into a TABLE section and a COLUMNS section.
                        if(line.lower().find('<table class=') > -1):
                            section = 'table' 
                        elif(line.lower().find('<columns itemclass=') > -1):
                            section = 'column'
                        if( line.find('sourceObjName') > -1 and ((section=='table' and object_type=='table') or (section=='column' and object_type=='column')) ):
                            cur_obj_name = str(line).replace('<sourceObjName>', '')
                            cur_obj_name = cur_obj_name.replace('</sourceObjName>', '')
                            cur_obj_name = cur_obj_name.replace(chr(10), '').replace(chr(13), '').strip().lower()
                            self.logit("\n" + "NEXT OBJECT (" + object_type + "): " + cur_obj_name)
                            if(cur_obj_name == object_name):
                                #Found the correct TABLE or COLUMN line.
                                section_is_specified_target = True
								
                        '''If we are currently traversing the section for the specified Table or Column, then replace the DATATYPE, COLUMNWIDTH and/or COMMENT attributes as appropriate.'''
                        if(line.find('logicalDatatype') > -1 and section_is_specified_target):
                            if('datatype' in attributes):
                                cur_datatype = str(line).replace('<logicalDatatype>', '')
                                cur_datatype = datatype.replace('</logicalDatatype>', '')
                                cur_datatype = datatype.replace(chr(10), '').replace(chr(13), '').strip().lower()
                                new_datatype = attributes['datatype']
                                new_datatype = self.get_dmdtype_from_datatype(cur_datatype)
                                temp = lines[line_num]
                                temp = temp.replace(cur_datatype, new_datatype)
                                lines[line_num] = temp
                                #dmd.writelines(lines)
                        elif(line.find('dataTypeSize') > -1 and section_is_specified_target):
                            if('columnwidth' in attributes):
                                cur_columnwidth = str(line).replace('<dataTypeSize>', '')
                                cur_columnwidth = cur_columnwidth.replace('</dataTypeSize>', '')
                                cur_columnwidth = cur_columnwidth.replace(chr(10), '').replace(chr(13), '').strip().lower()
                                new_columnwidth = attributes['columnwidth']
                                temp = lines[line_num]
                                temp = temp.replace(cur_columnwidth, new_columnwidth)
                                lines[line_num] = temp
                        elif(line.find('comment') > -1):
                            if('comment' in attributes):
                                cur_comment = str(line).replace('<comment>', '')
                                cur_comment = cur_comment.replace('</comment>', '')
                                cur_comment = cur_comment.replace(chr(10), '').replace(chr(13), '').strip()
                                new_comment = attributes['comment']
                                temp = lines[line_num]
                                temp = temp.replace(cur_comment, new_comment)
                                lines[line_num] = temp
                        elif( (line.find('</Column>') > -1 and object_type=='column') or (line.find('<columns itemClass=') > -1 and object_type=='table') ):
                            section_is_specified_target = False		#The specified Table or Column section has been exited.
						
                        line_num = line_num +1
                        
            except:
                exc_type, exc_value, exc_traceback = sys.exc_info()
                self.error_message = exc_value
                traceback.print_exception(exc_type, exc_value, exc_traceback, limit=4, file=sys.stdout)
                self.logit('\n' + 'Line: ', exc_traceback.tb_lineno)
                return False
            finally:
                pass
        else:
            self.error_message = "Specified DMD file does not exist: '" + dmd_file_with_path + "'"
            self.logit(self.error_message, True)
            success = False
        
        return success

    def debug_display_table_list(self):
        self.logit("\nTABLES LIST", True)
        for key, value in self.tables.items() :
            self.logit("Key: %s, Value: %s" % (key, value), True)

    def debug_display_column_list(self):
        self.logit("\nCOLUMNS LIST", True)
        for key, value in self.columns.items() :
            self.logit("Key: %s, Value: %s" % (key, value), True)


#------------------------------------------------------------------------------------
if(__name__ == '__main__'):
    print('About to create an instance of DataModelerXmlReader class.')
    xmlr = DataModelerXmlReader()
    #xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\DataModeler\\metalicious\\Metalicious_Modelled')
    #xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\DataModeler\\testdb')
    #xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\DataModeler\\MetaDash')
    #xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\Metalicious\\DMDs_Sept2014\\DoIT\\CDPH online ordering')
    #xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\Metalicious\\DMDs_Sept2014\\DoIT\\CDPH Voucher Processing\\vouchers.dmd')
    xmlr.read_all_xml_files('C:\\Greg\\ChapinHall\\Metalicious\\DMDs_Sept2014\\DoIT\\Event Management\Event_management.dmd')
