# Gmail SMTP Setup Guide

## Step 1: Enable 2-Factor Authentication

1. Go to your **Google Account** settings
2. Click on **Security** in the left sidebar
3. Under "Signing in to Google", click **2-Step Verification**
4. Follow the setup process to enable 2FA

## Step 2: Create App Password

1. In Google Account settings, go to **Security**
2. Under "Signing in to Google", click **App passwords**
3. Select **Mail** as the app
4. Select **Other** as the device
5. Enter "Saloon Senulya" as the name
6. Click **Generate**
7. **Copy the 16-character password** (you'll need this)

## Step 3: Configure Gmail SMTP

### Option A: Update gmail_smtp.php
```php
$gmail_config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_username' => 'your-actual-gmail@gmail.com',
    'smtp_password' => 'your-16-character-app-password',
    'from_email' => 'your-actual-gmail@gmail.com',
    'from_name' => 'Saloon Senulya',
    'smtp_secure' => 'tls'
];
```

### Option B: Use XAMPP Mercury Mail Server
1. Start **Mercury Mail Server** in XAMPP Control Panel
2. Configure Mercury Mail Server settings
3. Use local SMTP settings

## Step 4: Test Email Sending

1. Open `http://localhost/SE09/Saloon/otp_test_page.html`
2. Enter your Gmail address
3. Click "Send OTP"
4. Check your Gmail inbox (and spam folder)

## Troubleshooting

### Email not sending:
- ✅ Check if 2FA is enabled
- ✅ Verify App Password is correct
- ✅ Check if Gmail SMTP is accessible
- ✅ Ensure PHP mail() function works

### OTP not received:
- ✅ Check spam/junk folder
- ✅ Verify email address is correct
- ✅ Check `otp_log.txt` for errors
- ✅ Try different Gmail account

### Common Issues:
- **"Mail sent: NO"** - SMTP configuration issue
- **"Invalid credentials"** - Wrong App Password
- **"Connection timeout"** - Firewall blocking SMTP

## Production Setup

For production use:
1. Use a professional email service (SendGrid, Mailgun)
2. Set up proper SPF/DKIM records
3. Monitor email delivery rates
4. Remove test OTP display from alerts

## Security Notes

- Never use your regular Gmail password
- Always use App Passwords for SMTP
- Keep App Passwords secure
- Regularly rotate App Passwords
