# PHP Login Register System

This system is being sold on [Codester](https://www.codester.com/items/38000/phploginregistersystem). 

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Admin Dashboard](#admin-dashboard)
- [License](#license)
- [Author](#author)

## Introduction

This is a PHP-based Login Register System that offers secure user authentication and an Admin Dashboard for user management. It is built using the PDO (PHP Data Objects) and follows Object-Oriented Programming (OOP) principles. Below are the system's key features and instructions on how to set it up and use it.

## Features

- **Ajax Login**: Seamless login functionality without page refresh.
- **Secure Login & Register**: Implements strong security practices to safeguard user data.
- **Change Password Function**: Allows users to update their passwords securely.
- **Change Email Function**: Enables users to modify their registered email addresses.
- **Password Reset**: Provides a password reset mechanism for users who forget their passwords.
- **Send Email Confirmation**: Sends confirmation emails for user registration and email updates.
- **Two Factor Authentication**: Enhances security with two-factor authentication.
- **Hashed Passwords**: Stores passwords securely using salted and hashed values.

### User Management

- **Profile Edit**: Allows users to edit their profiles.
- **Online/Offline Status**: Displays user online or offline status.
- **Messaging System**: Provides a messaging system for users to communicate.

### Admin Dashboard

- **Total Users**: Displays the total number of registered users.
- **Recent Sign-Ups**: Lists recently registered users.
- **Active Users**: Shows users currently online.
- **View User**: Allows administrators to view a specific user's details.
- **All Users**: Lists all registered users.
- **Single User Update**: Enables administrators to update user information.
- **Delete User**: Allows administrators to delete user accounts.
- **Add User**: Provides administrators the ability to create new user accounts.

## Requirements

To use this system, you will need the following:

- A web server with PHP support
- A MySQL database
- Basic knowledge of web development and server administration

## Installation

1. Clone or download this repository to your web server or local development environment.
2. Create a MySQL database and import the included SQL file to set up the required database tables.
3. Configure the database connection in `config.php` with your database credentials.
4. Set up your email configuration in `config.php` for email confirmation and password reset functionalities.

## Configuration

In the `config.php` file, you need to configure the following:

- Database connection details (host, username, password, database name).
- Email configuration for sending confirmation and reset emails.
- Base URL for your system (usually the domain where it's hosted).

## Usage

1. Access the system through your web browser, typically via `http://yourdomain.com/login.php`.
2. Register as a new user or log in if you already have an account.
3. Explore the system's features, including profile editing, messaging, and more.

## Admin Dashboard

1. Log in as an administrator to access the Admin Dashboard.
2. From the Admin Dashboard, you can manage users, view statistics, and perform administrative tasks.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Author

This system was created by [bitress](https://github.com/bitress). For questions or support, you can contact me at [byteress@gmail.com].

---

Enjoy using the PHP Login Register System! If you have any questions, suggestions, or issues, feel free to reach out.
