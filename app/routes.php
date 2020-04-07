<?php

require 'routes/homepage.php';

// auth routes
require 'routes/auth/login.php';
require 'routes/auth/signup.php';
require 'routes/auth/registered.php';
require 'routes/auth/signin.php';
require 'routes/auth/logout.php';


require 'routes/youraccount.php';
require 'routes/personaldetails.php';
require 'routes/editusername.php';
require 'routes/editemail.php';
require 'routes/editpassword.php';

require 'routes/usernamechanged.php';
require 'routes/emailchanged.php';
require 'routes/passwordchanged.php';
require 'routes/addpersonalinfo.php';
require 'routes/addpersonalinfoform.php';
require 'routes/configureintelform.php';
require 'routes/configureamdform.php';

require 'routes/vieworder.php';
require 'routes/infoform.php';
require 'routes/checkout.php';
require 'routes/contact.php';

require 'routes/admins/admininterface.php';
require 'routes/admins/addadmin.php';
require 'routes/admins/addadminuser.php';
require 'routes/admins/viewusers.php';