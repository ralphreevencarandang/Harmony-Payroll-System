# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)


- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
"# decentralized-app" 
"# Harmony-Payroll-System"

  THIS PAYROLL AND TIMEKEEPING SYSTEM USED ARDUINO UNO AND RFID FOR RECORDING THE EMPLOYEE ATTENDANCE.
  IF YOU WANT THE CODES AND WIRINGS FOR ADUINO JUST CONTACT ME.

 THIS SYSTEM AUTOMATICALLY CALCULATE THE PAYROLL OF EMPLOYEE BASED ON THE EMPLOYEE ATTENDANCE. 
 SYSTEM FEATURES:
1. HOLIDAYS CALCULATIONS
2. RESTDAY CALCULATIONS
3. LATES CALCULATIONS
4. OVERTIME CALCULATIONS
5. UNDERTIME CALCULATIONS
6. LEAVE CALCULATIONS
7. GENERATES DETAILED PAYROLL
8. DOWNLAOD/FILTER ATTENDANCE IN DIFFERENT FILE FORMATS
9. ARCHIVE
10. ACTIVITY LOG
11. ACCOUNT SETTINGS
12. DYNAMIC DROPDOWNS (POSITION, DEPARTMENT, ADDRESS)
13. MANAGE EMPLOYEES
14. DYNAMIC ASSIGNING PAYHEADS. 

  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/10f3f61ebc014f50ce6fd1076b7cb1f9a8ae579b/public/images/Dashboard.png)
  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/d423ff24799e6518b601d4de35f1aa1fb1f491a1/public/images/Attendance.png)
  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/d423ff24799e6518b601d4de35f1aa1fb1f491a1/public/images/Archive.png)
  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/d423ff24799e6518b601d4de35f1aa1fb1f491a1/public/images/Holiday.png)
  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/d423ff24799e6518b601d4de35f1aa1fb1f491a1/public/images/Department.png)
  ![image](https://github.com/ralphreevencarandang/Harmony-Payroll-System/blob/d423ff24799e6518b601d4de35f1aa1fb1f491a1/public/images/Position.png)
