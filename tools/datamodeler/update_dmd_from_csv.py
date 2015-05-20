#!/usr/bin/python

# filedrop.py
import os  
import wx
from DropFile import DropFile
from DropFile import FileDrop
from DataModelerXmlReader import DataModelerXmlReader
#from DataModelerCsvReader import DataModelerCsvReader

testmode = False
input_folder = "metalicious_uploads_csv"
function_to_perform = "update_dmd_from_csv"
app = wx.App()
#DropFile(None, -1, __file__, function_to_perform)
DropFile(None, -1, "Drag and drop a DMD file into this window. CSV files will be loaded from \\" + input_folder, function_to_perform, input_folder, testmode)
app.MainLoop()
