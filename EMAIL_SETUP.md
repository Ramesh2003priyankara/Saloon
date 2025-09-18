# Email Setup Guide for OTP System

## Option 1: Gmail SMTP (Recommended)

### Step 1: Enable 2-Factor Authentication
1. Go to your Google Account settings
2. Enable 2-Factor Authentication
3. Go to "App passwords" section
4. Generate an "App password" for "Mail"

### Step 2: Update email_config.php
```php
$email_config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_username' => 'your-actual-gmail@gmail.com',
    'smtp_password' => 'your-16-character-app-password',
    'from_email' => 'your-actual-gmail@gmail.com',
    'from_name' => 'Saloon Senulya',
    'smtp_secure' => 'tls'
];
```

## Option 2: Local Mail Server

### For XAMPP Users:
1. Install Mercury Mail Server (comes with XAMPP)
2. Configure Mercury Mail Server
3. Update email_config.php:
```php
$local_email_config = [
    'use_local' => true,
    'from_email' => 'noreply@saloonsenulya.com',
    'from_name' => 'Saloon Senulya'
];
```

## Option 3: Other Email Services

### Outlook/Hotmail:
```php
$email_config = [
    'smtp_host' => 'smtp-mail.outlook.com',
    'smtp_port' => 587,
    'smtp_username' => 'your-email@outlook.com',
    'smtp_password' => 'your-password',
    'from_email' => 'your-email@outlook.com',
    'from_name' => 'Saloon Senulya',
    'smtp_secure' => 'tls'
];
```

## Testing Email Functionality

1. **Check otp_log.txt** - Contains all OTP attempts and email status
2. **Test with your own Gmail** - Enter your Gmail address and check inbox
3. **Check spam folder** - OTP emails might go to spam initially

## Troubleshooting

### Email not sending:
- Check if PHP mail() function is enabled
- Verify SMTP credentials
- Check firewall settings
- Ensure 2FA is enabled for Gmail

### OTP not received:
- Check spam/junk folder
- Verify email address is correct
- Check otp_log.txt for errors
- Try different email service

## Production Setup

For production, you should:
1. Remove test OTP display from alerts
2. Use a professional email service (SendGrid, Mailgun, etc.)
3. Set up proper SPF/DKIM records
4. Monitor email delivery rates
