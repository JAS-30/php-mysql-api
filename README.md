# Building REST API with PHP and MySQL

### *Before starting make sure you have PHP installed and MySQL.

## Project description:
You are going to test the API's for a company that sells lab-grown meat internationally.<br>
If you look at the migration.sql file (that describes the database of the company) you will see that there are 2 tables:
- products : id,product_name,CO2_reduction ->to store the available products
- orders   : id,order_date,country,product,quantity ->to store the sales<br>
  You will be interacting with these tables with the following methods: GET, POST, PATCH, DELETE.

* Each order:
  - Can have: multiple clients
  - Cant'have: same clients(client A should only be present once), different products(order 1 can only sell product x to n-clients)

  ## STEP 1:
  Create database -> open the terminal and access your mysql account (type: "mysql -u root -p")<br>
                     Now type "SOURCE your/path/for/migration.sql;" . Your database is now ready.
  ## STEP 2:
  Clone the repository and in the .env file copy the content of .env.example and insert your data to access mysql.
  ## STEP 3:
  You can now test the API's.
  Go to the repository in the terminal and create a server by typing "PHP -S localhost:8000"
  I recommend using [POSTMAN](https://www.postman.com/downloads/)
  Go on postman and start testing.
  (remember to use POST resquests first to fill the database)

  ## AVAILABLE ROUTES:
  localhost:8000/
  - products (GET,POST)
  - products/:id (GET, PATCH, DELETE)
  - orders (GET,POST)
  - orders/:id (GET,DELETE)
  - orders/:id/:country (GET,PATCH,DELETE)
  - filter-range (GET) -> Sum of saved CO2 by time range
  - filter-country (GET) -> Sum of saved CO2 by time country
  - filter-product (GET) -> Sum of saved CO2 by time product
  
