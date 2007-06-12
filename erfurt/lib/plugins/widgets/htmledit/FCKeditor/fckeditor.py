"""
FCKeditor - The text editor for internet
Copyright (C) 2003-2005 Frederico Caldeira Knabben

Licensed under the terms of the GNU Lesser General Public License:
		http://www.opensource.org/licenses/lgpl-license.php

For further information visit:
		http://www.fckeditor.net/

"Support Open Source software. What about a donation today?"

File Name: fckeditor.py
	This is the integration file for Python.

File Authors:
		Andrew Liu (andrew@liuholdings.com)
"""

import cgi
import os
import string

def escape(text, replace=string.replace):
    """Converts the special characters '<', '>', and '&'.

    RFC 1866 specifies that these characters be represented
    in HTML as &lt; &gt; and &amp; respectively. In Python
    1.5 we use the new string.replace() function for speed.
    """
    text = replace(text, '&', '&amp;') # must be done 1st
    text = replace(text, '<', '&lt;')
    text = replace(text, '>', '&gt;')
    text = replace(text, '"', '&quot;')
    text = replace(text, "'", '&#39;')
    return text

# The FCKeditor class
class FCKeditor(object):
	def __init__(self, instanceName):
		self.InstanceName = instanceName
		self.BasePath = '/FCKeditor/'
		self.Width = '100%'
		self.Height = '200'
		self.ToolbarSet = 'Default'
		self.Value = '';

		self.Config = {}

	def Create(self):
		return self.CreateHtml()

	def CreateHtml(self):
		HtmlValue = escape(self.Value)
		Html = "<div>"

		if (self.IsCompatible()):
			File = "fckeditor.html"
			Link = "%seditor/%s?InstanceName=%s" % (
					self.BasePath,
					File,
					self.InstanceName
					)
			if (self.ToolbarSet is not None):
				Link += "&amp;ToolBar=%s" % self.ToolbarSet

			# Render the linked hidden field
			Html += "<input type=\"hidden\" id=\"%s\" name=\"%s\" value=\"%s\" style=\"display:none\" />" % (
					self.InstanceName,
					self.InstanceName,
					HtmlValue
					)

			# Render the configurations hidden field
			Html += "<input type=\"hidden\" id=\"%s___Config\" value=\"%s\" style=\"display:none\" />" % (
					self.InstanceName,
					self.GetConfigFieldString()
					)

			# Render the editor iframe
			Html += "<iframe id=\"%s\__Frame\" src=\"%s\" width=\"%s\" height=\"%s\" frameborder=\"no\" scrolling=\"no\"></iframe>" % (
					self.InstanceName,
					Link,
					self.Width,
					self.Height
					)
		else:
			if (self.Width.find("%%") < 0):
				WidthCSS = "%spx" % self.Width
			else:
				WidthCSS = self.Width
			if (self.Height.find("%%") < 0):
				HeightCSS = "%spx" % self.Height
			else:
				HeightCSS = self.Height

			Html += "<textarea name=\"%s\" rows=\"4\" cols=\"40\" style=\"width: %s; height: %s;\" wrap=\"virtual\">%s</textarea>" % (
					self.InstanceName,
					WidthCSS,
					HeightCSS,
					HtmlValue
					)
		Html += "</div>"
		return Html
	
	def IsCompatible(self):
		if (os.environ.has_key("HTTP_USER_AGENT")):
			sAgent = os.environ.get("HTTP_USER_AGENT", "")
		else:
			sAgent = ""
		if (sAgent.find("MSIE") >= 0) and (sAgent.find("mac") < 0) and (sAgent.find("Opera") < 0):
			i = sAgent.find("MSIE")
			iVersion = float(sAgent[i+5:i+5+3])
			if (iVersion >= 5.5):
				return True
			return False
		elif (sAgent.find("Gecko/") >= 0):
			i = sAgent.find("Gecko/")
			iVersion = int(sAgent[i+6:i+6+8])
			if (iVersion >= 20030210):
				return True
			return False
		else:
			return False

	def GetConfigFieldString(self):
		sParams = ""
		bFirst = True
		for sKey in self.Config.keys():
			sValue = self.Config[sKey]
			if (not bFirst):
				sParams += "&amp;"
			else:
				bFirst = False
			if (sValue):
				k = escape(sKey)
				v = escape(sValue)
				if (sValue == "true"):
					sParams += "%s=true" % k
				elif (sValue == "false"):
					sParams += "%s=false" % k
				else:
					sParams += "%s=%s" % (k, v)
		return sParams
					
