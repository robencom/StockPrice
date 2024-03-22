# Stock Price Aggregator

A Laravel-based application that aggregates real-time stock price data.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- Docker
- Docker-compose
- Git

### Installing

A step by step series of instructions that tell you how to get a development environment running.

1. Clone the repository:
   git clone https://github.com/robencom/StockPrice.git

2. Navigate to the project directory:
   cd StockPrice

3. Build and run the Docker containers:
   docker-compose up --build


The app will be available at http://localhost:8000

## Running the tests

This application uses PHPUnit for unit and feature tests. To run the tests, execute the following command from the root of the project:

```
php artisan test
```

## Design Decisions
The application's database schema is designed for efficient storage and retrieval of stock price data. Key optimizations include:

- **Indexing**: Indexes on `symbol` in the `stocks` table and `stock_id` in the `stock_prices` table ensure fast queries, especially beneficial for large datasets.

- **Partitioning**: For handling extensive historical stock price data, partitioning the `stock_prices` table can improve performance and management.

- **Caching**: Frequently accessed data, such as the latest stock prices, is cached to reduce database load and mitigate rate limit issues from the 3rd party API.

### Caching Strategy

To optimize the application's performance, caching is utilized for storing the latest stock price data. This reduces the need for frequent database queries and API calls, ensuring quick access to the most recent data.

### API Integration

Real-time stock price data is fetched from the Alpha Vantage API, with robust error handling and rate limit management to ensure reliable data retrieval.

## API Documentation

This project uses L5 Swagger to generate interactive API documentation.

## Generating the Documentation

To generate the API documentation, run:

```
php artisan l5-swagger:generate
```

## Viewing the Documentation
Once generated, the API documentation can be accessed at:
```
http://localhost:8000/api/documentation
```

## Deployment

This application follows standard Laravel deployment practices. For detailed instructions on deploying Laravel applications, refer to the official [Laravel deployment documentation](https://laravel.com/docs/deployment).

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [Docker](https://www.docker.com/) - Containerization

## Authors

* Ruben Bourtoutian

## License

This project is licensed under the MIT License
