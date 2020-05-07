<?php

require 'routes/pagesview/homepage.php';

// auth routes
require 'routes/auth/login.php';
require 'routes/auth/signup.php';
require 'routes/auth/registered.php';
require 'routes/auth/signin.php';
require 'routes/auth/logout.php';

// user routes
require 'routes/user/youraccount.php';
require 'routes/user/personaldetails.php';
require 'routes/user/editusername.php';
require 'routes/user/editemail.php';
require 'routes/user/editpassword.php';
require 'routes/user/usernamechanged.php';
require 'routes/user/emailchanged.php';
require 'routes/user/passwordchanged.php';
require 'routes/user/addpersonalinfoform.php';
require 'routes/user/yourorder.php';
require 'routes/user/contact.php';
require 'routes/user/contactform.php';
require 'routes/user/viewmessages.php';
require 'routes/user/checkout.php';


// webpage routes
require 'routes/pagesview/configureintelform.php';
require 'routes/pagesview/configureamdform.php';
require 'routes/pagesview/vieworder.php';
require 'routes/pagesview/shoppingcart.php';
require 'routes/pagesview/processconfiguration.php';

// admin routes
require 'routes/admins/admininterface.php';
require 'routes/admins/addadmin.php';
require 'routes/admins/addadminuser.php';
require 'routes/admins/viewusers.php';
require 'routes/admins/viewuseroptions.php';
require 'routes/admins/deleteuser.php';
require 'routes/admins/addproductsform.php';
require 'routes/admins/addproducts.php';
require 'routes/admins/assignbuilds.php';
require 'routes/admins/assignmentform.php';
require 'routes/admins/orders.php';
require 'routes/admins/orderoption.php';
require 'routes/admins/viewallmessages.php';
require 'routes/admins/productslist.php';
require 'routes/admins/productaction.php';
require 'routes/admins/updateitem.php';

// webpage products route
require 'routes/pagesview/desktops.php';
require 'routes/pagesview/laptops.php';
require 'routes/pagesview/monitor.php';
require 'routes/pagesview/peripherals.php';