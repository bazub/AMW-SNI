AMW-SNI
=======

Social Network Integration - for www.announcemewhen.com
---------------------

Includes login/register with Facebook, G+ and Twitter
By following the register process, we will ask Google/Facebook for your email address and store it in our databases, for twitter you will be asked to provide your email in another page, if you didn't already provide it through another service.

Includes local deauthentication for Facebook, G+ and Twitter. 
Local deauthentication will revoke access from your Facebook and G+ account, for Twitter you have to do it manually.

Includes deauthentication from facebook.com
The other services don't provide it, so it is advised to revoke access directly from http://announcemewhen.com/login.php

Since the scripts handle the tokens obtaining process, you can build any other social integration features (likes/share/posts/etc) on top of this with minimal to no editing of the current scripts.


This is free software; you can redistribute it and/or modify it under
    the terms of the GNU General Public License (version 2) as published by the
    Free Software Foundation. It is distributed in the hope that it will be useful, but
    WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
    or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
    more details.
