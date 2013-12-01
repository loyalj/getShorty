# getShorty

getShorty is a php based url shortener built for my own personal use. It is built using '[flight](http://flightphp.com/)' and mongoDB.  The shortener supports multiple domains with customization allowed at the domain level.  

Demo shortener can be found at: http://dblpl.us/

### API Access

Links can also be shortened programmatically by sending post commands to the getShorty app vis POST.  For Example:
```python
import urllib, urllib2, json
data = {'longURL':'http://www.yahoo.com','api':'1'}
data = urllib.urlencode(data)
resp = urllib2.urlopen('http://dblpl.us/', data)
resp = json.loads(resp.read())
print resp
```

### Installation
1. Start playing: http://www.youtube.com/watch?v=BI23T9hLInQ
2. Ensure MongoDB and PHP Mongo Extensions are installed.
3. Git clone repo to your local directory
4. Start shortening!
