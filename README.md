# MNC Project

Welcome to the MNC Project! This is a Laravel 11-based backend project designed to manage various aspects of the ROSN system.

## Table of Contents

-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Features](#features)
-   [Contributing](#contributing)
-   [License](#license)

## Requirements

Before you begin, ensure you have met the following requirements:

-   PHP >= 8.0
-   Composer
-   Laravel 11
-   MySQL or any other supported database
-   Redis (optional, for caching)
-   Node.js and npm (for front-end dependencies)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/yourusername/ROSN.git
    cd MNC
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Set up your environment file:**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

5. **Configure your environment file (.env):**

    - Set your database credentials
    - Configure Redis if used

6. **Run migrations and seeders:**

    ```bash
    php artisan migrate --seed
    ```

## Configuration

-   **Database:** Make sure to update your `.env` file with the correct database configuration.
-   **Caching:** If using Redis, configure the Redis settings in your `.env` file.
-   **Mail:** Set up your mail configuration in the `.env` file if email notifications are required.

## Usage

To run the application locally, use the following command:

```bash
php artisan serve
```
