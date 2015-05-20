#!/usr/bin/python

# filedrop.py
import os  
import wx
from DropFile import DropFile
from DropFile import FileDrop
from DataModelerXmlReader import DataModelerXmlReader
#from DataModelerCsvReader import DataModelerCsvReader

testmode = False
output_folder = "metalicious_uploads_csv"
function_to_perform = "export_dmd_to_csv"
app = wx.App()
#DropFile(None, -1, __file__, function_to_perform)
DropFile(None, -1, "Drag and drop a DMD file into this window. CSV files will be saved to \\" + output_folder, function_to_perform, output_folder, testmode)
app.MainLoop()
