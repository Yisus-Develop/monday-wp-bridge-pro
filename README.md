# EWEB - Monday.com Integration 🚀

A professional WordPress plugin that seamlessly integrates Contact Form 7 submissions with Monday.com boards, featuring intelligent lead scoring, automatic classification, and a powerful admin dashboard.

> **Current Deployment:** This plugin is actively used in production for **Mars Challenge** lead management. The first public release will include Mars Challenge-specific configurations as the reference implementation.

## ✨ Key Features

- **🎯 Intelligent Lead Scoring**: Automatic 0-36 point scoring based on profile, country, institution size, and business context
- **🌍 Language Detection**: Auto-detects lead language (Spanish, Portuguese, English) based on country
- **📊 Admin Dashboard**: Monitor all submissions, view JSON payloads, and re-send failed leads
- **🔄 GitHub Auto-Updater**: Receive plugin updates directly from GitHub
- **🛡️ Secure Settings**: API credentials stored safely in WordPress database (never in code)
- **🔍 Smart Routing**: Automatically routes "Zers" (young leads) to dedicated status for custom workflows
- **📝 Full Logging**: Optional debug mode with automatic log rotation

## 🎬 Quick Start

### Installation

1. Download the plugin folder
2. Upload to `/wp-content/plugins/monday-webhook-trigger/`
3. Activate the plugin through WordPress admin
4. Go to **Monday Leads → Settings** and enter your Monday.com credentials

### Configuration

Navigate to **Monday Leads → ⚙️ Configuración** and provide:

- **API Token**: Your Monday.com API token
- **Board ID**: The ID of your Monday.com board
- **Debug Mode**: Enable/disable detailed logging

## 🏗️ Architecture

```
monday-webhook-trigger/
├── monday-webhook-trigger.php    # Main plugin file (70 lines, clean!)
└── includes/
    ├── class-eweb-github-updater.php  # Auto-updater engine
    ├── class-monday-handler.php       # Core lead processing logic
    ├── admin-dashboard.php            # Admin UI & monitoring
    ├── db-setup.php                   # Database schema
    ├── MondayAPI.php                  # Monday.com GraphQL wrapper
    ├── LeadScoring.php                # Scoring & classification engine
    ├── NewColumnIds.php               # Column ID mappings
    ├── StatusConstants.php            # Status label definitions
    └── language-config.json           # Country-to-language mapping
```

## 📋 Requirements

- **PHP**: 8.1 or higher
- **WordPress**: 5.8+
- **Contact Form 7**: Latest version
- **Monday.com Account**: With API access

## 🔧 How It Works

1. **Capture**: Hooks into Contact Form 7's `wpcf7_mail_sent` action
2. **Process**: Sanitizes data, calculates lead score, detects language/role
3. **Create**: Always creates a new item in Monday.com (deduplication disabled by user request)
4. **Update**: Populates all Monday.com columns with enriched data
5. **Log**: Saves submission to local WordPress database for monitoring

## 🎯 Lead Scoring Breakdown

| Factor | Points |
|--------|--------|
| **Profile Type** | 0-12 pts |
| **Country Priority** | 0-8 pts |
| **Institution Size** | 0-8 pts |
| **Business Context** | 0-8 pts |

**Classifications:**

- 🔥 **HOT** (24-36 pts): High-priority leads
- 🌡️ **WARM** (12-23 pts): Medium-priority leads
- ❄️ **COLD** (0-11 pts): Low-priority leads

## 🛠️ Development

### Local Setup

```bash
# Clone the repository
git clone https://github.com/Yisus-Develop/monday-lead-integration.git

# Navigate to your WordPress plugins directory
cd /path/to/wordpress/wp-content/plugins/

# Create symlink (or copy files)
ln -s /path/to/monday-lead-integration monday-webhook-trigger
```

### Debugging

Enable **Debug Mode** in Settings to generate detailed logs at:

```
wp-content/plugins/monday-webhook-trigger/webhook_debug.log
```

Logs auto-rotate at 5MB.

## 📦 Deployment

### Via GitHub Auto-Updater

1. Create a new release in GitHub with a version tag (e.g., `v2.1.0`)
2. WordPress will automatically detect the update
3. Users can update with one click from the Plugins page

### Manual Deployment

Upload these files to your production server:

- `monday-webhook-trigger.php`
- `includes/` (entire directory)

## 🔐 Security

- ✅ API credentials stored in WordPress database (not in files)
- ✅ All inputs sanitized before processing
- ✅ Nonce verification on all admin actions
- ✅ No credentials committed to Git

## 📊 Monitoring

Access the admin dashboard at **WordPress Admin → Monday Leads**

Features:

- View all submissions with status codes
- Search by email or source
- Re-send failed submissions
- View full JSON payloads
- Bulk delete old records
- Send test leads

## 🤝 Contributing

This is a private project for Mars Challenge. For feature requests or bug reports, contact the development team.

## 📜 License

Proprietary - Mars Challenge © 2026

## 👨‍💻 Author

**Yisus Develop**  
Mars Challenge Development Team

---

**Need help?** Check the [Wiki](../../wiki) or contact support.
