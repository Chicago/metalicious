'''docstring'''
import os, sys
import traceback
import datetime
import csv
#from datetime import date
#sys.path.append('c:\\greg\\code\\python')  		

class DataModelerXmlWriter(object):
    testmode = True
    initialized = False
    testmode = True
    error_message = ''
    logfile = ''
    logfile_handle = None
    logfile_is_open = False
    log_to_file = True
    log_to_db = False
    log_to_browser = False
    section_start = None
    section_end = None
    #current_xmlfile_path = ''
    #current_xmlfile_name = ''
    #parent_folder = ''	
    #csv_output_folder = ''
    #master_xmlparent = ''
    #master_xmlfile = ''
    #master_xmlfiles = []
    #columns = {}
    #col_tbl_db = {}
    #dblist = tbllist = collist = []
	
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

    def get_dmdtype_from_datatype(self, datatype):
        dmdtype = ''
        if(datatype.upper() == "DATE"):    
            datatype = "LOGDT007"
        elif(datatype.upper() == "INT" or datatype.upper() == "INTEGER"): 
            datatype = "LOGDT011"
        elif(datatype.upper() == "DATETIME"): 
            datatype = "LOGDT015"
        elif(datatype.upper() == "VARCHAR"): 
            datatype = "LOGDT024"
        elif(datatype.upper() == "CHAR"): 
            datatype = "LOGDT025"
        elif(datatype.upper() == "BIGINT"): 
            datatype = "LOGDT027"	
        elif(datatype.upper() == "BIT"): 
            datatype = "LOGDT034"
        return datatype

    def get_value_for_xml_tag(self, xml_line, tagtext):
        '''Remove tag text from a line of XML. Example: pass the line <sourceObjName>test1</sourceObjName> and this function returns "test1". 
		NOTE: tagtext is case-sensitive and must be specified exactly as it appears in the XML file. '''
        tagtext = tagtext.strip()
        value = str(xml_line).replace('<' + tagtext + '>', '')
        value = value.replace('</' + tagtext + '>', '')
        value = value.replace(chr(10), '').replace(chr(13), '').strip()
        return value

    def find_specified_section_in_xml(self, xml_file_with_path, object_type, object_name):
        '''Locate the specified section in the specified XML file '''
        section_start = section_end = 0
        if(self.initialized == False):
            self.initialize()
        object_type = object_type.strip().lower()
        object_name = object_name.strip().lower()
        if(object_type =='' or object_type is None):
            self.error_message = 'Object type may not be blank'
            self.logit(self.error_message, True)
            return []
        if(xml_file_with_path.lower()[-4:] != ".xml"):
            self.error_message = "Specified file is not an XML file: '" + xml_file_with_path + "'"
            self.logit(self.error_message, True)
            return []
        if os.path.isfile(xml_file_with_path):
            try: 
                print("Seeking " + object_type + ": '" + object_name + "'")
                with open(xml_file_with_path, "r") as xml:
                    line_num = 0
                    lines = xml.readlines()
                    for line in lines:
                        #print('----------------------------------------------------------------')
                        #print("(" + str(line_num) + ") " + str(line))
                        #XML file is divided into a TABLE section and a COLUMNS section.
                        if(line.lower().find('<table class=') > -1):
                            section = 'table' 
                        elif(line.lower().find('<columns itemclass=') > -1):
                            section = 'column'
                        #XML file is divided into a TABLE section and a COLUMNS section.
                        if( line.find('sourceObjName') > -1 and ((section=='table' and object_type=='table') or (section=='column' and object_type=='column')) ):
                            cur_obj_name = self.get_value_for_xml_tag(line, 'sourceObjName')
                            self.logit("\n" + "NEXT OBJECT (" + object_type + "): " + cur_obj_name)
                            if(cur_obj_name == object_name):
                                #Found the correct TABLE or COLUMN line.
                                print("\n" + "Found section for " + object_type + ": " + object_name)
                                section_start = line_num
                        elif( (object_type=='column' and line.find('</Column>') > -1) or (object_type=='table' and line.find('<columns itemClass=') > -1) ):
                            if(section_start is not None and section_start > 0):
                                print("\n" + "Exiting section for " + object_type + ": " + object_name)
                                section_end = line_num
                                break
                        #Increment the line counter:
                        line_num = line_num +1
                    xml.close()								
                    self.section_start = section_start
                    self.section_end = section_end
                    list = [section_start, section_end]
            except:
                exc_type, exc_value, exc_traceback = sys.exc_info()
                self.error_message = exc_value
                traceback.print_exception(exc_type, exc_value, exc_traceback, limit=4, file=sys.stdout)
                self.logit('\n' + 'Line: ', exc_traceback.tb_lineno)
                return False
            finally:
                pass
            return list

    def tag_exists_in_section(self, xml_file_with_path, tag):
        '''Sometimes we might want to add a value into the XML file, but no XML tag for that value exists in the TABLE or COLUMN section we are interested in updating.
		This is especially common for Comments -- most often, the person compiling the DMD file enters no comments, so no <comment> tag is created in the XML file. But we wish to add one later, so we must insert the tag and its value here.'''
        found = False
        if(self.initialized == False):
            self.initialize()
        if(xml_file_with_path.lower()[-4:] != ".xml"):
            self.error_message = "Specified file is not an XML file: '" + xml_file_with_path + "'"
            self.logit(self.error_message, True)
            return False
        if os.path.isfile(xml_file_with_path):
            try: 
                #Before running this function, a section in the XML file must be identified for a specified Table or Column. This should have been carried out by update_metadata_in_dmd() calling find_specified_section_in_xml().
                if( self.section_start is None or self.section_start==0 or self.section_end is None or self.section_end==0 ):
                    self.error_message = "Specified section not found for " + object_type + " '" + object_name + "' in file '" + xml_file_with_path + "'"
                    return None
                with open(xml_file_with_path, "r+") as xml:
                    line_num = 0
                    lines = xml.readlines()
                    for line in lines:
                        if(line_num >= self.section_start and line_num <= self.section_end):
                            print("(" + str(line_num) + ") " + str(line))
                            if(line.find(tag) > -1):
                                found = True
                                break
                        line_num = line_num +1
                    xml.close()
            except:
                exc_type, exc_value, exc_traceback = sys.exc_info()
                self.error_message = exc_value
                traceback.print_exception(exc_type, exc_value, exc_traceback, limit=4, file=sys.stdout)
                self.logit('\n' + 'Line: ', exc_traceback.tb_lineno)
                return False
            finally:
                pass
        return found

    def map_attrib_to_xml_tag(self, attrib_name):
        tag = ''
        if(attrib_name == 'columnwidth'):
            tag = 'dataTypeSize'
        elif(attrib_name == 'comment'):
            tag = 'comment'
        elif(attrib_name == 'datatype'):
            tag = 'logicalDatatype'
        
        return tag

    def overwrite_attribute_in_xml(self, xml_lines, attrib_name, attrib_value):
        success = True
        new_value = attributes[attrib_name]							#Get the raw value from the ATTRIBUTES dict, which will be used to overwrite the existing value in the XML file. 
        #Some attributes need special handling:
        if(attrib_name == 'datatype'):  							#Datatype needs to be translated from standard text ("Char") to DMD standard codes ("LOGDT025")
            new_value = self.get_dmdtype_from_datatype(new_value)
        tag_sought = self.map_attrib_to_xml_tag(attrib_name)
        print("\n" + "Seeking to overwrite value of attribute '" + attrib_name + "' (xml tag '" + tag_sought + "') with raw value '" + attrib_value + "' (method overwrite_attribute_in_xml())")
        if(tag_sought != ''):										#Loop thru the XML section seeking this XML tag.
            line_num = 0
            for line in xml_lines:
                if(line_num >= self.section_start and line_num <= self.section_end):
                    if(line.find('<' + tag_sought + '>') > -1):  					#Found the XML tag where we need to overwrite the existing value.
                        cur_value = self.get_value_for_xml_tag(line, tag_sought)   		#Get the VALUE between the tag and close-tag. Example: <comment>This is a comment</comment> would return "This is a comment"
                        print("\n" + "Overwriting attrib '" + attrib_name + "' value '" + cur_value + "' with '" + new_value + "'")
                        #For this line only, replace the existing string with the new string that was specified in the ATTRIBUTES dict for the specified attribute.
                        temp = xml_lines[line_num]
                        temp = temp.replace(cur_value, new_value)
                        xml_lines[line_num] = temp
                        break
                line_num = line_num +1            
        
        return xml_lines
    
    def update_metadata_in_dmd(self, xml_file_with_path, object_type, object_name, attributes):
        '''Oracle Model Builder DMD files can be updated to conform to metadata imported from CSV files or RDBMS.
		object_type can be 'table' or 'column'.  object_name is the table or column name. attributes is a dict of attributes such as datatype, columnwidth or comment.'''
        success = True
        if(self.initialized == False):
            self.initialize()
        object_type = object_type.strip().lower()
        object_name = object_name.strip().lower()		
        section_is_specified_target = False
        if(xml_file_with_path.lower()[-4:] != ".xml"):
            self.error_message = "Specified file is not an XML file: '" + xml_file_with_path + "'"
            self.logit(self.error_message, True)
            return False
        if os.path.isfile(xml_file_with_path):
            try: 
                #Function find_specified_section_in_xml() returns a list with starting and ending line numbers, but it also stores those line numbers as class properties.
                self.find_specified_section_in_xml(xml_file_with_path, object_type, object_name)
                if( self.section_start is None or self.section_start==0 or self.section_end is None or self.section_end==0 ):
                    self.error_message = "Specified section not found for " + object_type + " '" + object_name + "' in file '" + xml_file_with_path + "'"
                    return False
                with open(xml_file_with_path, "r+") as xml:
                    section = ''
                    line_num = 0
                    #Read the text into memory, then delete that text from the actual file (truncate).  Later we'll copy the modified text back into the file with file.writelines().
                    lines = xml.readlines()
                    xml.seek(0)
                    xml.truncate()
                    #For each attribute specified, iterate thru the XML section and if it is found, overwrite the old value with the value specified in attributes{} dict.
                    #num_attributes = len(attributes)
                    for attrib_name, attrib_value in attributes.items():
                        #********************************************************************************
                        lines = self.overwrite_attribute_in_xml(lines, attrib_name, attrib_value)
                        #********************************************************************************
                    '''for line in lines:
                        if(line_num >= self.section_start and line_num <= self.section_end):
                            print("(" + str(line_num) + ") " + str(line))
                            #If we are currently traversing the section for the specified Table or Column, then replace the DATATYPE, COLUMNWIDTH and/or COMMENT attributes as appropriate.
                            if(line.find('logicalDatatype') > -1):
                                if('datatype' in attributes):
                                    cur_datatype = self.get_value_for_xml_tag(line, 'logicalDatatype')
                                    new_datatype = attributes['datatype']
                                    new_datatype = self.get_dmdtype_from_datatype(new_datatype)
                                    temp = lines[line_num]
                                    temp = temp.replace(cur_datatype, new_datatype)
                                    lines[line_num] = temp
                            elif(line.find('dataTypeSize') > -1):
                                if('columnwidth' in attributes):
                                    cur_columnwidth = self.get_value_for_xml_tag(line, 'dataTypeSize')
                                    new_columnwidth = attributes['columnwidth']
                                    print("\n" + "Overwriting columnwidth '" + cur_columnwidth + "' with '" + new_columnwidth + "'")
                                    temp = lines[line_num]
                                    temp = temp.replace(cur_columnwidth, new_columnwidth)
                                    lines[line_num] = temp
                            elif(line.find('comment') > -1):
                                if('comment' in attributes):
                                    cur_comment = self.get_value_for_xml_tag(line, 'comment')
                                    new_comment = attributes['comment']
                                    print("\n" + "Overwriting comment '" + cur_comment + "' with '" + new_comment + "'")
                                    temp = lines[line_num]
                                    temp = temp.replace(cur_comment, new_comment)
                                    lines[line_num] = temp
                        
                        #Increment the line counter:
                        line_num = line_num +1
                    '''                    
                    #Overwrite the old file with updated metadata:
                    xml.writelines(lines)
                    xml.close()					
            except:
                exc_type, exc_value, exc_traceback = sys.exc_info()
                self.error_message = exc_value
                traceback.print_exception(exc_type, exc_value, exc_traceback, limit=4, file=sys.stdout)
                self.logit('\n' + 'Line: ', exc_traceback.tb_lineno)
                return False
            finally:
                pass
        else:
            self.error_message = "Specified DMD file does not exist: '" + xml_file_with_path + "'"
            self.logit(self.error_message, True)
            success = False
        
        return success

#------------------------------------------------------------------------------------
if(__name__ == '__main__'):
    print('About to create an instance of DataModelerXmlWriter class.')
    xmlw = DataModelerXmlWriter()
    attributes = {}
    #attributes = {'datatype': 'varchar', 'columnwidth': '765', 'comment': 'OVERWRITING the existing comment with this much better comment'}
    #xmlw.update_metadata_in_dmd('C:\\Greg\\ChapinHall\\DataModeler\\testdb\\rel\\BD830649-A98E4273A620\\table\\seg_0\\12C65BAE-1C35-2088-FD4D-2507DCA10C5E.xml', 'Column', 'test_char', attributes)
    attributes = {'datatype': 'varchar', 'columnwidth': '765', 'comment': 'OVERWRITING the existing comment for column TEST_INT with this brand new one'}
    xmlw.update_metadata_in_dmd('C:\\Greg\\ChapinHall\\DataModeler\\testdb\\rel\\BD830649-A98E4273A620\\table\\seg_0\\12C65BAE-1C35-2088-FD4D-2507DCA10C5E.xml', 'Column', 'test_int', attributes)
    
