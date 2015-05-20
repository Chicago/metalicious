#!/usr/bin/env python
import sys
import os
import datetime
import traceback
from tkinter import *
import tkinter.filedialog 
from tkinter.messagebox import showerror
from DataModelerXmlReader import DataModelerXmlReader

class DmdChoose(Frame):
    '''
    Purpose: allow users to specify files for processing under the Oracle Data Modeler parser created by Chapin Hall for the Metalicious project.
    This class uses the TkInter libraries to create a GUI. 
    '''
    parent_window = None
    testmode = None
    error_message = ''	
    output_folder = ''
    label_object = None
    textbox = None
    label_object2 = None
    textbox2 = None
    msgbox = None
    file_types = [('DMD files', '*.dmd'), ('All files', '*')]
    file_name_with_path = None
    function_to_perform = "export_dmd_to_csv"
    framestack_counter = None
    logfile = ''
    logfile_handle = None
    logfile_is_open = False
    log_to_file = True
    log_to_db = False
    log_to_browser = False

    def __init__(self, parent_window, function_to_perform="export_dmd_to_csv", output_folder="metalicious_uploads_csv", testmode=True):
        Frame.__init__(self, parent_window)
        self.parent_window = parent_window	
        self.testmode = testmode
        self.output_folder = output_folder
        self.function_to_perform = function_to_perform
		
        #This FRAME object will be placed into the parent window, directly below any previous frames. The grid() ROW designators refer to the parent window's Grid and determine which order the Frames will be displayed in.
        stackslot = self.get_framestack_counter("init")
        self.grid(column=0, row=stackslot, sticky=W)                    #position the Frame within the Parent Window
        self.config(width=400, background='#ffffff', borderwidth=2, padx=3, pady=3)   #height=self.frame_height, 
        self.columnconfigure(0, weight=1, pad=3)
        self.rowconfigure(0, pad=3)

        #Message box:
        self.msgbox = Entry(self)
        self.msgbox.grid(row=0, column=0, columnspan=2, sticky=W) 
        self.msgbox.config(relief="ridge", font=("Arial", 10, "bold italic"), background="#FFFFF9", 
                    fg="#000000fff", readonlybackground="#ffffff000", borderwidth=1, 
                    width=110, justify="left")     #, state="normal"
		
        #Label for the filepath textbox:
        self.label_object = Label(self, text='File selected:')
        self.label_object.grid(row=1, column=0, sticky=W) 
        self.label_object.config(font=("Arial", 10, "bold italic"), borderwidth=1, width=30, anchor=E, justify="left", background="ivory")
        #Textbox:
        self.textbox = Entry(self)
        self.textbox.grid(row=1, column=1, sticky=W) 
        self.textbox.config(relief="ridge", font=("Arial", 10, "bold italic"), background="#FFFFF9", 
                    fg="#000000fff", readonlybackground="#ffffff000", borderwidth=1, 
                    width=80, justify="left" )    #, state="readonly"
        self.textbox.focus_set()
		
        #Label for the CSV textbox:
        self.label_object2 = Label(self, text='Output location:')
        self.label_object2.grid(row=2, column=0, sticky=W) 
        self.label_object2.config(font=("Arial", 10, "bold italic"), borderwidth=1, width=30, anchor=E, justify="left", background="ivory")
        #Textbox2:
        self.textbox2 = Entry(self)
        self.textbox2.grid(row=2, column=1, sticky=W) 
        self.textbox2.config(relief="ridge", font=("Arial", 10, "bold italic"), background="#FFFFF9", 
                    fg="#000000fff", readonlybackground="#ffffff000", borderwidth=1, 
                    width=80, justify="left")    #, state="readonly" 
        #Logging
        now = datetime.datetime.now()
        stamp = str(now.year) + str(now.month) + str(now.day) + str(now.hour) + str(now.minute) + str(now.second)
        self.logfile = 'C:\Temp\PythonLogFile_' + stamp + '.txt'
        self.initialized = True
		
        #PROMPT THE USER TO SELECT A FILE:		
        self.locate_file()		

    def get_framestack_counter(self, who_called=''):
        if(self.framestack_counter == None):
            self.framestack_counter = 0
        else:
            self.framestack_counter += 1
        print("\n" + "framestack_counter: " + str(self.framestack_counter) + "  " + who_called )
        return self.framestack_counter
	
    def locate_file(self):
        self.file_name_with_path = tkinter.filedialog.askopenfilename(parent=self.parent_window, filetypes=self.file_types, title='Choose a file')
        if self.file_name_with_path != '' and self.file_name_with_path is not None:
            print("\n" + "In locate_file, file_name_with_path = '" + self.file_name_with_path + "'")
            self.handle_file(self.file_name_with_path)
        return self.file_name_with_path
		
    def handle_file(self, file_or_folder_with_path):
        #for file_or_folder_with_path in filenames:
        try:
            #file = open(file_or_folder_with_path, 'r')
            #text = file.read()
            #self.window.WriteText(text)
            #file.close()
            print('\n \n' + 'File dropped: ' + file_or_folder_with_path)
            #print("\n Test error trap... \n")
            #x= getIt(z)
            if(os.path.isfile(file_or_folder_with_path)):
                #path = os.path.dirname(str(file_or_folder_with_path))
                #head, tail = os.path.split(file_or_folder_with_path)
                #filename = tail
                pass
            elif(os.path.isdir(file_or_folder_with_path)):
                #path = filename
                #filename = ''
                pass
            else:
                self.error_message = "Parameter is not a file or directory name: '" + str(file_or_folder_with_path) + "'"
                self.display_error('Error opening file\n' + self.error_message)
					
            if(self.error_message == ''):
                head, tail = os.path.split(file_or_folder_with_path)
                if(self.function_to_perform.lower() == "read_csv_files"):
                    '''************************************************************************'''
                    '''Call DataModelerCsvReader with the dropped file(s) or folder '''
                    #cr = DataModelerCsvReader()
                    #cr.read_csv_files(file_or_folder_with_path)
                    pass
                    '''************************************************************************'''
                elif(self.function_to_perform.lower() == "export_dmd_to_csv"):
                    '''************************************************************************'''
                    '''Call   with the dropped file(s) or folder '''
                    self.textbox.insert(END, file_or_folder_with_path)
                    self.textbox.grid()
                    xmlr = DataModelerXmlReader()
                    xmlr.testmode = self.testmode
                    output_folder = xmlr.read_all_xml_files(file_or_folder_with_path)
                    self.textbox2.insert(END, os.path.join(head, output_folder) )
                    self.textbox2.focus_set()
                    '''************************************************************************'''
                else:
                    self.error_message = "Invalid procedure: '" + function_to_perform + "'"
                    self.display_error('Error\n' + self.error_message)

        except:
            exc_type, exc_value, exc_traceback = sys.exc_info()
            self.error_message = str(exc_value)
            traceback.print_exception(exc_type, exc_value, exc_traceback, limit=4, file=sys.stdout)
            self.logit('\n' + 'Line: ', exc_traceback.tb_lineno)
            self.display_error('Error opening file\n' + str(self.error_message))
            return False
        finally:
            pass

    def display_error(self, error_msg):
        self.msgbox.insert(END, "ERROR: " + error_msg)
	
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

	
#******************************************************************************************		
def main():
    root = Tk()
    root.geometry("700x400+100+100")
    master = DmdChoose(root)
    root.mainloop()

if __name__ == '__main__':
    main() 