# Financial Tracker

## Overview

Financial Tracker is a versatile application designed to help users manage their finances efficiently. It allows the creation of multiple wallets, tracking of expenses, setting savings goals for purchases, and monitoring financial activities through various charts and diagrams. Additionally, the app integrates with a currency converter API to facilitate transactions in different currencies.

## Features

- **Multiple Wallets**: Create and manage multiple wallets to organize your finances.
- **Expense Tracking**: Record and categorize your expenses to keep track of your spending habits.
- **Savings Goals**: Set and monitor goals for future purchases, ensuring you save up effectively.
- **Visualization**: Use charts and diagrams to get a visual representation of your financial activities and trends.
- **Currency Conversion**: Integrated currency converter API to handle transactions in various currencies seamlessly.

## Installation

To get started with Financial Tracker, follow these steps:

1. Clone the repository:
   ```sh
   git clone https://github.com/Yuwipiii/FinancialApplication.git
   ```
2. Navigate to the project directory:
   ```sh
   cd FinancialApplication
   ```
3. Install the required dependencies for Laravel:
   ```sh
   composer install
   ```
4. Install the required dependencies for Vue:
   ```sh
   npm install
   ```
5. Create a copy of the `.env` file:
   ```sh
   cp .env.example .env
   ```
6. Generate the application key:
   ```sh
   php artisan key:generate
   ```
7. Configure your database in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
8. Run the database migrations:
   ```sh
   php artisan migrate
   ```
9. Start the Laravel development server:
   ```sh
   php artisan serve
   ```
10. In a separate terminal, start the Vue development server:
    ```sh
    npm run dev
    ```

## Configuration

To use the currency converter feature, you'll need to configure the API key:

1. Sign up for an API key from a currency converter service (e.g., ExchangeRate-API, CurrencyLayer).
2. Add your API key to the `.env` file:
   ```env
   CURRENCY_API_KEY=your_api_key_here
   ```

## Usage

1. **Create Wallets**: Start by creating different wallets for various purposes (e.g., personal, business, savings).
2. **Add Expenses**: Log your expenses by selecting the appropriate wallet and category.
3. **Add Incomes**: Log your incomes by selecting the appropriate wallet and category.
4. **Set Goals**: Define your savings goals, specifying the target amount and deadline.
5. **Monitor Finances**: Use the built-in charts and diagrams to visualize your spending patterns, progress towards goals, and overall financial health.
6. **Currency Conversion**: Convert amounts between different currencies using the integrated currency converter.


## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

If you have any questions or feedback, please contact us at [support@financialtracker.com](mailto:support@financialtracker.com).

---

Enjoy tracking your finances with Financial Tracker! 🚀
