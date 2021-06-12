# 'X' Log in / Sign up system

This is a program in which you can create your own account and then log into it, just like you would do it for your favorite websites

## Instructions on how to run this project on your computer

1. Install XAAMP

2. Open XAAMP and start both Apache and MySQL

3. Open localhost/phpmyadmin/ in a browser

4. Create a DataBase called "x"

5. Create a table called "users" with the following parameters
  - ID (INT, must be primary key and have auto-increment)
  - name (VARCHAR, 100 characters)
  - email (VARCHAR, 100 characters)
  - password (VARCHAR, 50 characters) 

6. Open localhost/X/ in a browser 

7. Sign up 
  - for Name only letters, whitespaces, and single quotes are allowed
  - E-mail must contain "@" and "."
  - Password must contain at least one uppercase, one lowercase, and a number

8. Log in

9. Log out if you wish

The program executes an input-validation algorithm, that in order
to prevent code injections, it also executes password encryption 
