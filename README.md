# Scandiweb Product Management Backend

This is the backend part of the Scandiweb test task built using **PHP** and **MySQL**. It provides an API to manage products, allowing users to add, delete, and list products.

## Features

- RESTful API for managing products.
- Handles product creation, deletion, and listing.
- MySQL database to store product information.
- Simple routing and request handling using PHP.

## Technologies Used

- **PHP**: Server-side scripting language.
- **MySQL**: Relational database to store product data.
- **Apache**: Web server to serve PHP files.
- **XAMPP**: Development environment for PHP and MySQL.

## API Endpoints
The backend API provides the following endpoints:

- **base Url** => [http://scandiwebapi.mooo.com/api]

- GET /products: Retrieve the list of all products.
- POST /products: Add a new product by sending a JSON payload with product details.
- DELETE /products: Delete products according to list of product ids provied in the body.

