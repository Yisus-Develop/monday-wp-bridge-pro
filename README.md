# Monday.com Bridge & Lead Scoring Engine

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-8892bf.svg)](https://www.php.net/)
[![Integration](https://img.shields.io/badge/Integration-Monday.com-orange.svg)](https://monday.com/)

Advanced bridge for bidirectional communication between WordPress and **Monday.com**, featuring an automated **Lead Scoring** engine and secure webhook handling.

## 🚀 Key Features

- **Automated Lead Scoring:** Logic to qualify prospects based on status, activity, and custom criteria.
- **Webhook Processing:** Securely handles incoming data from Monday.com boards.
- **Monday API Wrapper:** Optimized communication with the Monday.com V2 API.
- **Secure Communication:** Uses custom secrets to verify authorized requests.
- **Flexible Configuration:** Customizable column mappings and status constants.

## 🛠️ Components

- **`LeadScoring.php`**: The heart of the scoring algorithm.
- **`MondayAPI.php`**: Specialized class for API interaction.
- **`webhook-handler.php`**: Entry point for asynchronous updates.
- **`StatusConstants.php`**: Centralized management of workflow states.

## ⚙️ Configuration

1. Copy `config-sample.php` to `config.php`.
2. Enter your **Monday API Token** and **Board ID**.
3. Define a secure **Integration Secret**.
4. Configure your column IDs in `NewColumnIds.php`.

## 🔒 Security Notice

**NEVER** commit your `config.php` or any file containing real API tokens to version control. Use environment variables or local configuration files.

---
Developed by **Yisus Develop**
[enlaweb.co](https://enlaweb.co/)
