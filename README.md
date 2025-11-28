# 💍pinginikah. Simple Wedding Planner (Indonesian)

A personalized financial tracking application designed to help me (or any couples) plan wedding budget, track progress, and manage savings effectively.

> 🚧 **Status: Under Active Development**
> This project is currently in the early stages of development. Features are subject to change.

## 🌟 Core Features

-   **Real-time Gold Price Integration:**
    -   Connects to [MetalPriceAPI](https://metalpriceapi.com) to fetch live gold rates (XAU to IDR).
    -   **Smart Valuation Logic:** Gold items in your budget automatically adjust their estimated cost based on current market prices _until_ they are marked as purchased. Once bought, the price is locked to the historical cost.
-   **Couple Wallet Management:**
    -   Manage individual and shared savings.
    -   Link wallets to specific users (Groom/Bride).
    -   Track transaction history for every expense.
-   **Segmented Budgeting:**
    -   Break down the wedding into segments (e.g., _Akad_, _Resepsi_, _Seserahan_).
    -   Track progress bars per segment (Estimated vs. Realized).
-   **Daily API Safeguard:**
    -   Implements caching mechanisms to prevent API rate limit exhaustion (updates gold price only once per day via manual trigger).

## 🔄 Simple Flow

1.  **Setup Wallets:** Users input their funding sources (e.g., "John Doe BCA", "Tabungan Emas").
2.  **Define Project:** Create a Wedding Project and invite the partner.
3.  **Plan Items:**
    -   Input items into segments (e.g., "Penghulu", "Catering").
    -   For Gold items (Mahar or Wedding Rings), set the target weight (e.g., 10 grams). The app calculates the price automatically.
4.  **Tracking:**
    -   **Checklist:** When an item is bought/paid, mark it as "Done".
    -   **Deduction:** The app automatically deducts the amount from the selected Wallet and locks the item price.
    -   **Progress:** Watch the progress bars increase as you get closer to the big day!

## 💻 Tech Stack

-   **Framework:** Laravel 11
-   **Auth:** Laravel Breeze
-   **Styling:** Blade + Tailwind 3
-   **Database:** SQLite (Default)

## ⚙️ Installation & Requirements

### Requirements

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   [MetalPriceAPI](https://metalpriceapi.com) Key (Free Account is sufficient)

### Setup Guide

1.  **Clone the repository**

    ```bash
    git clone https://github.com/hasbinbl/wedding-prep-tracker.git
    cd pinginikah
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the example env file and configure it.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Open `.env` and set your API Key:

    ```env
    DB_CONNECTION=sqlite
    # ...
    METAL_PRICE_API_KEY=YOUR_API_KEY
    ```

4.  **Database Setup**
    Create the SQLite database file:

    ```bash
    touch database/database.sqlite
    ```

    Run migrations:

    ```bash
    php artisan migrate
    ```

5.  **Build Assets**

        ```bash
        npm run build
        ```

    **Run**

        ```bash
        npm run start
        ```

6.  **Access the App**
    Open `http://localhost:8000` in your browser.

---

**Note on Gold API:**
The free tier of MetalPriceAPI has a monthly request limit (maximum 100 request). The application is designed to only check the price for once a day to save your quota via the "Update Price" button on the dashboard.
