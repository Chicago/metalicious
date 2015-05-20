#!/usr/bin/python

# filedrop.py
import os
import wx
from DataModelerXmlReader import DataModelerXmlReader
#from DataModelerCsvReader import DataModelerCsvReader

class FileDrop(wx.FileDropTarget):
    '''
    Purpose: allow users to specify files for processing under the Oracle Data Modeler parser created by Chapin Hall for the Metalicious project.
    This class uses the wxPython libraries to create a GUI.  It's based on http://zetcode.com/wxpython/
    '''
    testmode = False
    error_message = ''	
    function_to_perform = ''
    output_folder = ''
	
    def __init__(self, window, function_to_perform=None, output_folder=None, testmode=False):
        self.testmode = testmode
        if(output_folder=='' or output_folder is None):
            output_folder = "metalicious_uploads_csv"
        if(function_to_perform is None):
            function_to_perform	= "export_dmd_to_csv"
        self.function_to_perform = function_to_perform
        wx.FileDropTarget.__init__(self)
        self.window = window

    def OnDropFiles(self, x, y, filenames):

        for file_or_folder_with_path in filenames:
            try:
                #file = open(file_or_folder_with_path, 'r')
                #text = file.read()
                #self.window.WriteText(text)
                #file.close()
                self.window.WriteText('\n \n' + 'File dropped: ' + file_or_folder_with_path)
                if(os.path.isfile(file_or_folder_with_path)):
                    #path = os.path.dirname(str(file_or_folder_with_path))
                    #head, tail = os.path.split(file_or_folder_with_path)
                    #filename = tail
                    pass
                elif(os.path.isdir(filename)):
                    #path = filename
                    #filename = ''
                    pass
                else:
                    self.error_message = "Parameter is not a file or directory name: '" + str(file_or_folder_with_path) + "'"
                    dlg = wx.MessageDialog(None, 'Error\n' + self.error_message)
                    dlg.ShowModal()
                if(self.error_message == ''):
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
                        xmlr = DataModelerXmlReader()
                        xmlr.testmode = self.testmode
                        xmlr.read_all_xml_files(file_or_folder_with_path)
                        '''************************************************************************'''
                    else:
                        self.error_message = "Invalid procedure: '" + function_to_perform + "'"
                        dlg = wx.MessageDialog(None, 'Error\n' + self.error_message)
                        dlg.ShowModal()

            except IOError, error:
                dlg = wx.MessageDialog(None, 'Error opening file\n' + str(error))
                dlg.ShowModal()
            except UnicodeDecodeError, error:
                dlg = wx.MessageDialog(None, 'Cannot open non ascii files\n' + str(error))
                dlg.ShowModal()

class DropFile(wx.Frame):
    def __init__(self, parent, id, title, function_to_perform=None, output_folder=None, testmode=False):
        if(output_folder=='' or output_folder is None):
            output_folder = "metalicious_uploads_csv"
        if(function_to_perform is None):
            function_to_perform	= "export_dmd_to_csv"
        wx.Frame.__init__(self, parent, id, title, size = (700, 400))
        self.text = wx.TextCtrl(self, -1, style = wx.TE_MULTILINE)
        dt = FileDrop(self.text, function_to_perform, output_folder, testmode)
        self.text.SetDropTarget(dt)
        self.Centre()
        self.Show(True)

if(__name__ == '__main__'):
    app = wx.App()
    function_to_perform = "export_dmd_to_csv"
    DropFile(None, -1, __file__ + " - " + function_to_perform, function_to_perform)
    app.MainLoop()