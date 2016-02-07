<?php 

// HOME
require ROOT_PATH . '/src/Pages/Home/Home.php';

// CONTACT US
require ROOT_PATH . '/src/Pages/ContactUs/ContactUs.php';

// ARTICLE PAGE
require ROOT_PATH . '/src/Pages/Article/Page/ArticlePage.php';

// SIGN
require ROOT_PATH . '/src/Pages/Sign/Signin/Signin.php';
require ROOT_PATH . '/src/Pages/Sign/Signout/Signout.php';
require ROOT_PATH . '/src/Pages/Sign/Signup/Signup.php';

// ARTICLE
require ROOT_PATH . '/src/Pages/Article/Delete/ArticleDelete.php';
require ROOT_PATH . '/src/Pages/Article/Edit/ArticleEdit.php';
require ROOT_PATH . '/src/Pages/Article/New/ArticleNew.php';
require ROOT_PATH . '/src/Pages/Article/Show/ArticleShow.php';

// USER
require ROOT_PATH . '/src/Pages/User/Delete/UserDelete.php';
require ROOT_PATH . '/src/Pages/User/Deactivate/UserDeactivate.php';
require ROOT_PATH . '/src/Pages/User/Edit/UserEdit.php';
require ROOT_PATH . '/src/Pages/User/Profile/UserProfile.php';
require ROOT_PATH . '/src/Pages/User/Show/UserShow.php';

// DASHBOARD
require ROOT_PATH . '/src/Pages/Dashboard/Admin/DashboardAdmin.php';
require ROOT_PATH . '/src/Pages/Dashboard/Author/DashboardAuthor.php';

// EMAIL
require ROOT_PATH . '/src/Pages/EmailChange/EmailChange.php';

// PASSWORD
require ROOT_PATH . '/src/Pages/Password/Change/PasswordChange.php';
require ROOT_PATH . '/src/Pages/Password/Forgot/PasswordForgot.php';
require ROOT_PATH . '/src/Pages/Password/Reset/PasswordReset.php';

// NOTICE
require ROOT_PATH . '/src/Pages/Notice/Notice.php';

// ARTICLE VIEW 
// (place it in the last line of code) / (simpan di baris terakhir) 
require ROOT_PATH . '/src/Pages/Article/View/ArticleView.php';