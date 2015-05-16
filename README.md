# Brewer
A “databaseless” extranet for mock-ups.

###Overview###
This online tool is made for showcasing designs for review. It loads folder of images and allows them to be displayed all together as a list, or one at a time as a slideshow.

###Setup###
To install, add the files to a root folder. Be sure to include the ".htaccess" file. This file will control the url routing. Add designs to it within the following directory structure under “archive”: 2015/client-name/project/round. There is an example included to get you started. **Note** : Brewer shortens the name of the four digit year folder to two digits when displayed in the url.


###Configuration###

**Watermarking** : 
There is a watermark image included by default. Replace "watermark.png" located in the "archive" folder to personalize it. To enable watermarking, pass the url variable "?wm=1".

You can place a different watermark.png file in every folder to override the watermark image of it's parent folder.

*Example:*
your.wbesite.com/15/some-company/some-project/round-01/showcase?wm=1


**Background Color** :
You can override Brewer’s default background color by passing in the url variable ?bg=[some color]. When using a hex color ommit the “#” symbol.

*Example:*
your.wbesite.com/15/some-company/some-project/round-01/showcase?bg=0000


**Custom Company Name display** :
The company name that displays in the header is derived from the name of it's corresponding folder. To override this pass the url varianle ?cn=[some company name].

*Example:*
your.wbesite.com/15/some-company/some-project/round-01/showcase?cn=company%20title


**Using multiple url variables** :
If your not familiar with url variables, they are parameter names and data you can pass to a website by appending them to the end of the url. The first one is set by a preceding “?”. Additional variables can be passed with the use of an “&”.

*Example:*
your.wbesite.com/15/some-company/some-project/round-01/showcase?cn=company%20title&bg=ccc&wm=1
