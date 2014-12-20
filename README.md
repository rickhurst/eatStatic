eatStatic
==========

update December 2014 - [Status of eatStatic December 2014](http://eatstatic.olivewoodstudio.com/2014/12/19/eatstatic-status/)

eatStatic is am open-source text file driven blog engine which was originally put together to allow me to maintain a travel blog with limited internet connectivity - blog posts were written as simple text files in textmate/ emacs and uploaded to the server when a connection was available.

There is also a simple thumbnail gallery system to allow thumbnail galleries to appear in a post, and an image cache system to allow resized versions of uploaded images to be displayed (and cached).

A system of "blocks" is used to display blocks of content (once again coming from a text file) in any template.

The app also stores objects (such as archive lists) in JSON files - the json file storage idea was put together for another project - I didn't want to go down the mysql 
route and it just seemed like a blindingly simple idea to save php object instances to the filesystem
using json_encode. This works really well, but probably won't scale very well, so i'm now looking at 
providing switchable mongodb support for larger/ higher traffic applications.

The master branch powers the demo (and future documentation site) here:-

http://eatstatic.olivewoodstudio.com/

The demo site acts a development blog, so if you are interested in updates, add http://eatstatic.olivewoodstudio.com/feed to your RSS reader.

A slightly older version also powers my personal blog (with 600+ posts) here:-

http://www.rickhurst.co.uk

The "latest" version powers [my Travel/ VW T25 camper blog](http://ontheroad.rickhurst.co.uk). This branch is used for testing new features which can be cherry picked/ merged back into master.

The above blog has the data folder located in my Dropbox, so new posts are automatically synced to the live site.

Future of eatStatic
-------------------

I intend to maintain and develop this with a strong emphasis on the blogging capabilities - i.e. making it easy and convenient to blog and upload/ maintain photo galleries. I may add some basic page and menu creation and management, but don't intend to make it into a full featured CMS, in fact it has been designed with the idea that you can drop an eatStatic blog (or several subject specific blogs) into another PHP website being managed by another CMS. However, never say never! 

Some other features I would like to add in the nearish future:-

* markdown support <- DONE
* blog post and block editing (via web admin) <- POST EDITING DONE
* image uploading and gallery management via web <- PARTLY DONE
* prev' and 'next' on posts <- DONE
* keyword search
* category RSS feeds <- DONE

License
-------

Open Source MIT (see MIT-license.txt)