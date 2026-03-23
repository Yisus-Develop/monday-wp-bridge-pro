<?php
/**
 * config-sample.php - Configuration Example for Monday.com Integration
 * COPY THIS FILE TO config.php AND FILL IN YOUR REAL CREDENTIALS.
 * 
 * Part of the EWEB/Vault Factory suite
 * Developed by Yisus Develop
 */

// Credenciales de Monday.com (Get your token at: https://monday.com/developers/v2)
define('MONDAY_API_TOKEN', 'YOUR_MONDAY_API_TOKEN_HERE');

// ID of the Monday.com board to interact with
define('MONDAY_BOARD_ID', 'YOUR_BOARD_ID_HERE');

// Optional: Webhook URL for debugging (Set to false for production)
define('WEBHOOK_DEBUG', false);

// Secret for secure communication between WP and the Handler
// Used to verify that the request comes from an authorized source
define('MONDAY_INTEGRATION_SECRET', 'GENERATE_A_RANDOM_SECRET_HERE');
