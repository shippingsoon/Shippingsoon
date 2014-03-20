
#!/usr/bin/env python
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

import Skype4Py
import config
import threading
from json import load
from urllib2 import urlopen
from random import randint
import sys
import pprint
from mpd import (MPDClient, CommandError)
from socket import error as SocketError
from threading import Timer

class Vada:
	chat = None
	skype = None
	client = None
	users = {}
	#Initializes Vada.
	def __init__(self):
		self.skype = Skype4Py.Skype()
		self.loadVada()
		self.displayInfo()
		#self.client = MPDClient()
		#self.scheduler = sched.scheduler(time.time, time.sleep)
		#if self.mpdConnect(self.client, config.CON_ID):
		#	print 'Connected to MPD server'
		#else:
		#	print 'Failed to connect to MPD server.'
		#	sys.exit(1)
	#Opens a Skype client and attempts to connect to it.
	def mpdConnect(self, client, con_id):
		try:
			client.connect(**con_id)
		except SocketError:
			return False
		return True
	def getMessage(self, message, status):
		if status == Skype4Py.cmsReceived:
			self.handleMessage(message)
	def loadVada(self):
		if not self.skype.Client.IsRunning:
			self.skype.Client.Start()
		self.skype.Attach()
		self.chat = self.getGroupChat()
		if not self.chat:
			exit('Could not find a group chat')
		self.skype.OnMessageStatus = self.getMessage
	#Displays Vada's information.
	def displayInfo(self):
		print 'Full Name: %s' % self.skype.CurrentUser.FullName
		print 'Status: %s' % self.skype.CurrentUser.OnlineStatus
	#Returns the most recent group chat.
	def getGroupChat(self):
		print "Searching for a group chat..."
		for chat in self.skype.RecentChats:
			if len(chat.Members) > 2:
				print "Found chat: %s" % chat.Name
				return chat
	#Returns a daily fortune.
	def getFortune(self, handle):
		if not handle in self.users:
			self.users[handle] = randint(0, (len(config.FORTUNES)-1))
		return config.FORTUNES[self.users[handle]]
	#Returns an FML.
	def getFML(self):
		return config.FML[randint(0, (len(config.FML)-1))]
	#Returns a quote.
	def getQuote(self):
		return config.QUOTE[randint(0, (len(config.QUOTE)-1))]
	def getWeather(self, city = 'savannah', state = 'ga'):
		data = urlopen('http://openweathermap.org/data/2.1/find/name?units=imperial&q=%s,%s' % (city, state))
		towns = load(data)
		if towns['count'] > 0:
			town = towns['list'][0]
			return u'The weather for %s, %s:\nTemperatue: %s\N{DEGREE SIGN}\nDetails: %s' % (city.title(), state.title(), town['main']['temp'], town['weather'][0]['description'])
		return "Couldn't determine the weather..."
	#Set a reminder.
	def reminder(self, name, message):
	    self.chat.SendMessage('%s, someone told me to remind you of this: %s' % (name, message))
	#Vada's logic.
	def handleMessage(self, message):
		arg = message.Body.split(' ');
		if arg[0] == '.fortune':
			self.chat.SendMessage("%s's fortune for today is: %s" % (message.FromDisplayName, self.getFortune(message.FromHandle)))
		elif arg[0] == '.fml':
			self.chat.SendMessage(self.getFML())
		elif arg[0] == '.quote':
			self.chat.SendMessage(self.getQuote())
		elif arg[0] == '.version' or arg[0] == '.v':
			self.chat.SendMessage('You are using: %s' % config.VERSION)
		elif arg[0] == '.copyright':
			self.chat.SendMessage(config.COPYRIGHT)
		elif arg[0] == '.weather' or arg[0] == '.w':
			self.chat.SendMessage(self.getWeather())
		elif arg[0] == '.current' or arg[0] == '.np':
			self.chat.SendMessage(self.client.currentsong())
		elif arg[0] == '.next':
			self.client.next()
		elif arg[0] == '.previous' or arg[0] == '.prev':
			self.client.previous()
		elif arg[0] == '.link':
			self.chat.SendMessage("http://10.5.59.5/vada/")
		elif arg[0] == '.remind' and len(arg) > 3:
			self.chat.SendMessage('okay, I will remind %s in %s minute%s' % (arg[1], arg[2], 's' if int(arg[2]) > 1 else ''))
			t = Timer((int(arg[2]) * 60), self.reminder, (arg[1], ' '.join(arg[3:])))
			t.start()
		else:
			print "Invalid arguments"
	#Main function.
	def main(self):
		print "Initiating Vada"
vada = Vada()
vada.main()
while True:
	time.sleep(1)

#Copyleft 2013 Anonymous - All Rights Reversed
