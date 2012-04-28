eatStatic
==========

eatStatic is a text file driven blog which was originally put together to allow me to
maintain a travel blog with limited internet connectivity - blog posts were written in textmate/ emacs 
and uploaded to the server when a connection was available.

The app also stores objects (such as archive lists) in JSON files - the json file storage idea was put together for another project - I didn't want to go down the mysql 
route and it just seemed like a blindingly simple idea to save php object instances to the filesystem
using json_encode. This works really well, but probably won't scale very well, so i'm now looking at 
providing switchable mongodb support for larger/ higher traffic applications.

The master branch powers the demo (and future documentation site) here:-

http://eatstatic.olivewoodstudio.com/