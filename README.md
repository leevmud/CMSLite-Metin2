# CMSLite - Metin2
Developed by [Levmud](https://www.levmud.com/)!

Discord: Hazel#4067

## About
Made with [Slim Framework v2](https://www.slimframework.com/docs/v2/), and [RainTPL 3](https://github.com/feulf/raintpl3), this CMS brings to you a new level of application allowing you to create, and manage all your pages in a easy way.

# Features
## User features
* Register
* Login
* Player and Guild ranking
* Downloads
* Change Email
* Change Password
* Warehouse Password
* Character Password
* Unbugg Character
* Recover Account Password

## Admin features
* Add post
* Edit post
* Delete post
* Ban user permanent
* Ban user for days
* Unbann user
* Add user coins
* Remove user coins

## Extra features
* Enable/Disable Lycan in Top Class Ranking(Disabled by default)
* Enable and set max accounts per email(Disabled by default)
* Enable/Disable register
* Block user login on site if banned
* Send emails with SMTP(PHPMailer)
* and more...

# Web Server Requirements
* Apache server with `rewrite_module` ON. (or [nginx](https://www.slimframework.com/docs/v2/routing/rewrite.html#nginx))
* PHP Version: `7.0.0+`

PHP Modules:
* session
* json
* pdo
* pdo_mysql
* filter
* sockets - optional

## Installation
Localhost:
1. Open `/vendor/init.php` and set your DB user, host and password.
2. Run the `query.sql` file in your `account` database to add 2 new columns(web_admin and register_ip) in account table and to create a new table called cmsnews.

Live:
1. The same steps above.
2. Enable SSL in your Host.
3. Get your [Google reCaptcha](https://www.google.com/recaptcha/admin/create) keys.
4. Set your [Google reCaptcha](https://www.google.com/recaptcha/admin/create) keys in `/vendor/init.php`.
5. Set 'ENABLE_CAPTCHA' to true.
6. Remove '//' in 'index.php' line 2(session_set_cookie_params)
7. (Apache Only) Remove '#' in .htaccess to redirect your site to SSL/TSL.

All extra configurations are in `init.php`

**To change server responses edit the Lang file inside the Lang folder.**

**Templates changes can be made in /Templates/Default/**

If you have any doubt or need any kind of assistance you can contact me on Discord.