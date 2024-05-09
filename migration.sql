CREATE DATABASE kreasDB;

CREATE TABLE kreasDB.products(
    id INT AUTO_INCREMENT KEY,
    product_name VARCHAR(35) NOT NULL,
    CO2_reduction INT NOT NULL 
);

CREATE TABLE kreasDB.orders(
    id_order INT NOT NULL,
    order_date DATE NOT NULL, 
    country VARCHAR(30) NOT NULL,
    product VARCHAR(35) NOT NULL,
    quantity INT NOT NULL
);