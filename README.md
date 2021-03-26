eatStatic
==========

* Note - This is no longer under development and has been unmaintained for years, it was a great learning excercise, but don't use it :) * 

eatStatic is am open-source text file driven blog engine which was originally put together to allow me to maintain a travel blog with limited internet connectivity - blog posts were written as simple text files in textmate/ emacs and uploaded to the server when a connection was available.

There is also a simple thumbnail gallery system to allow thumbnail galleries to appear in a post, and an image cache system to allow resized versions of uploaded images to be displayed (and cached).

A system of "blocks" is used to display blocks of content (once again coming from a text file) in any template.

The app also stores objects (such as archive lists) in JSON files - the json file storage idea was put together for another project - I didn't want to go down the mysql 
route and it just seemed like a blindingly simple idea to save php object instances to the filesystem
using json_encode. This works really well, but probably won't scale very well, so i'm now looking at 
providing switchable mongodb support for larger/ higher traffic applications.


Future of eatStatic
-------------------

I no longer use or maintain this, it was fun for a few years, and a great learning excercise!

License
-------

Open Source MIT (see MIT-license.txt)
