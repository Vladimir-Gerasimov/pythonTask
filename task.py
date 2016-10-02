# -*- coding: utf-8 -*-

from __future__ import print_function
import re
import sys
import os.path
import io
import urllib.request
import urllib.parse
import json
import matplotlib.pyplot as plt
from matplotlib import rc
import math

class Graph :
	__data = None
	__map = [ 0, 0 ]
		
	__color = ['r', 'g', 'b', 'c', 'm', 'y', 'k']
	__currentColor = 0
	
	__syns = dict()
	
	def __init__( self, data ) :
		self.__data = data
		font = {
			'family': 'Arial',
			'weight': 'normal',
			'size': 10
		}
		rc( 'font',**font )
		n = 0
		for w in self.__data :
			if 'word' in w.keys() :
				n += 1

		self.__x = math.ceil( math.sqrt( n ) )
			
	def nextColor( self ) :
		if self.__currentColor == len( self.__color ) - 1 :
			self.__currentColor = 0
		else :
			self.__currentColor += 1
		return self.__color[ self.__currentColor ]
			
	def plot( self ) :
		frame1 = plt.gca()
		frame1.axes.get_xaxis().set_visible(False)
		frame1.axes.get_yaxis().set_visible(False)
		
		k = 0
		currY = 0
		for w in self.__data :
			if 'word' in w.keys() :
				word = w[ 'word' ]
				inf = w[ 'infin' ]
				syn = w[ 'syn' ]
				label = word
				if word != inf :
					label = word + " (" + inf + ")" 
					
				i = 1
				n = len( syn )
				rad = 2 * math.pi / n
				
				clr = self.nextColor()
				
				row = math.floor( k / self.__x )
				col = k % self.__x
				
				size = n * 1.5 + 1
				
				cx = size * 1.1
				cy = ( size + self.__map[1] ) * 0.8
				
				if cy > currY :
					currY = cy
				
				if row > 0 :
					cy += self.__map[1]
					
				if col > 0 :
					cx += self.__map[0]
								
				if col == self.__x - 1 :
					self.__map[0] = 0
					self.__map[1] = currY
				else :
					self.__map[0] += size
				
				for s in syn :
				
					x = i * math.sin( ( i - 1 ) * rad )
					y = i * math.cos( ( i - 1 ) * rad )
	
					if s in self.__syns.keys() :
						for c in self.__syns[ s ] :
							plt.plot( [ cx + x, c[0] ], [-cy + y, c[1]], color='silver' )
						self.__syns[ s ].append([cx + x, -cy + y])
					else :
						self.__syns[ s ] = [[cx + x, -cy + y]]
	
					plt.plot( [ cx, cx + x ], [ -cy, -cy + y ], clr + 'o-' )
					plt.text( cx, -cy, label ) 
					plt.text( cx + x, -cy + y, s ) 
					i += 1
				k += 1	
		
		plt.show()
	
class Book :
	__txt = ""
	__words = dict()
	__skip = [ u'и', u'ну', u'', u'бы', u'а', u'с', u'—', u'в', u'на', u'под', u'над', u'не', u'но', u'что', u'где', u'как', u'о', u'из', u'к', u'же', u'то', u'за', u'я', u'он', u'она', u'оно', u'они', u'ему', u'мне', u'нам', u'им', u'ты', u'вы', u'это', u'все', u'всё', u'ее', u'его', u'их', u'когда', u'от', u'у', u'нас', u'так', u'по' ]
	__syn = []
	
	def __init__( self, text ) :
		if isinstance( text, str ) :
			self.__txt = text
		else:
			raise TypeError( "Book text is not a valid string!" )

	def getSynonyms( self, words ) :
		syn = []
		for w in words :
			url = "https://dictionary.yandex.net/api/v1/dicservice.json/lookup"
			values = 	{ 	'key': 'dict.1.1.20160930T124003Z.804f49c0182af619.d7c9fe661db759e02e69147a0491fd96e417e3e1',
							'lang': 'ru-ru',
							'text': w,
							'flags': '4'
						}
			data = urllib.parse.urlencode( values )
			req = urllib.request.Request( url + "?" + data )
			with urllib.request.urlopen( req ) as response:
				page = json.loads( response.read().decode( 'utf-8' ) )
				dic = dict()
				infin = ""
				for d in page[ 'def' ] :
					if 'tr' in d.keys() :
						dic[ 'word' ] = w
						dic[ 'infin' ] = d[ 'text' ]
						dic[ 'syn' ] = []
						tr = d[ 'tr' ]
						for item in tr :
							dic[ 'syn'].append( item[ 'text' ] )
				syn.append( dic )
		return syn
			
	def cleanText( self ) :
		regex = re.compile( "[\-,\.!\?\(\)0-9\\\/\"\«\»\:…—;\[\]]+" )
		self.__txt = re.sub( regex, " ", self.__txt )
		
	def genWords( self ) :
		for word in self.__txt.split() :
			word = word.lower()
			if word in self.__skip :
				continue
			if not word in self.__words.keys() :
				self.__words[ word ] = 0
			self.__words[ word ] += 1
	
	def getTop( self, num ) :
		top_n = [0 for i in range( num )]
		top_w = ["" for i in range( num )]
		
		for word in self.__words.keys() :
			n = self.__words[ word ]
			if n >= top_n[ 0 ] :
				top_n[ 0 ] = n
				top_w[ 0 ] = word
				for i in range( num - 1 ) :
					for j in range( i + 1, num ) :
						if top_n[ i ] > top_n[ j ] :
							b = top_n[ j ]
							top_n[ j ] = top_n[ i ]
							top_n[ i ] = b
							b = top_w[ j ]
							top_w[ j ] = top_w[ i ]
							top_w[ i ] = b
		top = [( top_w[i], top_n[i] ) for i in range( num )]
		return top
	
	def extractWords( self, n ) :
		self.cleanText()
		self.genWords()
		return self.getTop( n )
	

	
def getText( p ) :
	text = ""
	with io.open(p, encoding='cp437') as file:
		text = file.read()

	return text.encode( 'cp437' ).decode( 'utf-8' )
	

def main( args ) :
	p = sys.argv[ 1 ]
	n = 10
	if len( sys.argv ) > 2 :
		n = int( sys.argv[ 2 ] )
	
	print( "Reading book..." )
	bk = Book( getText( p ) )
	
	print( "Extracting top " + str( n ) + " words..." )
	words = bk.extractWords( n )
	lst = sorted( words, key=lambda tup: tup[1], reverse=True )
	i = 1
	for item in lst :
		print( "   " + str( i ) + ": " + item[0] + "(" + str( item[1] ) + ")" )
		i += 1
	
	nums = input( "Please choose words (numbers separated by comma): " )
	nums = str( nums ).split( "," )
	words = [ lst[ int( i ) - 1 ][ 0 ] for i in nums ]
	
	print( "Retrieving synonyms from Yandex..." )
	syn = bk.getSynonyms( words )
	
	print( "Generating graph..." )
	gr = Graph( syn )
	gr.plot()
	print( "Done" )
	
	
if __name__ == "__main__":
	if len( sys.argv ) > 1 :
		main( sys.argv )
	else :
		print( "Not enough args" )
		exit( 1 )