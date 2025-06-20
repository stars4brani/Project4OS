create database bookstore;
use bookstore;
CREATE TABLE Books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20)
);

CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    book_id INT,
    order_date DATE NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES Books(book_id) ON DELETE CASCADE
);

INSERT INTO Books (title, author, price, stock) VALUES
('1984', 'George Orwell', 9.99, 10),
('The Hobbit', 'J.R.R. Tolkien', 14.99, 5),
('Dune', 'Frank Herbert', 19.99, 8),
('To Kill a Mockingbird', 'Harper Lee', 12.50, 7),
('The Catcher in the Rye', 'J.D. Salinger', 11.99, 4),
('Pride and Prejudice', 'Jane Austen', 8.50, 6),
('The Great Gatsby', 'F. Scott Fitzgerald', 10.00, 9),
('Brave New World', 'Aldous Huxley', 13.75, 3);

INSERT INTO Orders (customer_id, book_id, order_date, quantity) VALUES
(6, 1, '2025-06-15', 1);