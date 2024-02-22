# Hello
1. Run migrations
2. Run books seeder: php artisan db:seed --class=BookSeeder

# API
1. Books
- GET /books - List of books with pagination
- GET /books/search/{param} - List of books containing {param} in the name, author or client's first or last name
- GET /books/{id} - Book's details
- POST /books/rent - Rent a book. Params: client_id (required), book_id (required)
- GET /books/return/{id} - Return a book
2. Clients
- GET /clients - List of clients with pagination
- GET /clients/{id} - Client's details
- POST /clients - Create new client. Params: first_name (required), last_name (required)
- PUT /clients/{id} - Update client's data. Params: first_name (required), last_name (required)
- DELETE /clients/{id} - Delete client
