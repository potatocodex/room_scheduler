# Room Scheduler

A modern, responsive web-based room scheduling system with real-time display capabilities and admin management interface.

## Features

### Live Display (Viewer)

- Real-time schedule display with auto-refresh every 30 seconds
- Beautiful gradient UI with smooth animations and transitions
- Responsive design that works on all devices (desktop, tablet, mobile)
- Navigation controls to browse different dates (Previous/Today/Next)
- Live event indicators showing currently active events
- Authentication system with secure login for viewers
- Auto-logout after 60 minutes of inactivity

### Admin Panel

- Complete schedule management with add, edit, and delete functionality
- Multi-user authentication with different access levels
- Real-time data synchronization with the live display
- Quick templates for common meeting types
- Bulk actions and day clearing options
- Data export functionality (JSON format)
- Statistics dashboard showing event counts and usage metrics
- Server status monitoring with connection indicators

### Backend API

- RESTful PHP API with JSON file-based storage
- CORS support for cross-origin requests
- Error handling and validation
- Automatic data backup and persistence
- Scalable architecture ready for database integration

## Quick Start

### Prerequisites

- Web server with PHP 7.4+ support (Apache, Nginx, etc.)
- Modern web browser (Chrome, Firefox, Safari, Edge)

### Installation

1. Clone or download the repository:

```bash
git clone https://github.com/yourusername/lskk-room-scheduler.git
cd lskk-room-scheduler
```

2. Upload files to your web server:

```
your-domain.com/
├── api.php
├── index.html          # Live Display (Viewer)
├── admin.html          # Admin Panel
└── schedule_data.json  # Data storage (auto-created)
```

3. Configure the API URL in both HTML files:

```javascript
// In index.html and admin.html, update this line:
const API_URL = 'https://your-domain.com/api.php';
```

4. Set proper permissions (if using Linux/Unix):

```bash
chmod 644 *.html *.php
chmod 666 schedule_data.json  # Make writable for PHP
```

## Default Login Credentials

### Viewer Access (index.html)

- Username: `viewer` | Password: `view2025`
- Username: `guest` | Password: `guest2025`
- Username: `user` | Password: `user2025`

### Admin Access (admin.html)

- Username: `admin` | Password: `admin2025`
- Username: `manager` | Password: `schedule2025`
- Username: `staff` | Password: `events2025`

**Important:** Change these default credentials in production!

## Usage

### For Viewers

1. Open `index.html` in your browser
2. Login with viewer credentials
3. Browse schedules using navigation buttons
4. View real-time updates automatically

### For Administrators

1. Open `admin.html` in your browser
2. Login with admin credentials
3. Add, edit, or delete events
4. Use quick templates for faster scheduling
5. Export data for backup purposes

## Configuration

### Customizing Credentials

Edit the credentials in the JavaScript section of each file:

For Viewer (index.html):

```javascript
const VIEWER_CREDENTIALS = {
    'your_username': 'your_password',
    'another_user': 'another_password'
};
```

For Admin (admin.html):

```javascript
const AUTH_CREDENTIALS = {
    'admin_user': 'admin_password',
    'manager_user': 'manager_password'
};
```

### Customizing Auto-refresh Interval

```javascript
// Change refresh interval (default: 30 seconds)
setInterval(refreshData, 30000); // 30000ms = 30 seconds
```

### Customizing Session Timeout

```javascript
// Viewer timeout (default: 60 minutes)
inactivityTimer = setTimeout(logout, 60 * 60 * 1000);

// Admin timeout (default: 30 minutes)
inactivityTimer = setTimeout(logout, 30 * 60 * 1000);
```

## File Structure

```
lskk-room-scheduler/
├── api.php              # Backend API (REST endpoints)
├── index.html           # Live Display/Viewer interface
├── admin.html           # Administrative interface
├── schedule_data.json   # Data storage (JSON format)
├── README.md           # This documentation
└── screenshots/        # Interface screenshots (optional)
```

## API Endpoints

| Method | Endpoint                 | Description                  |
| ------ | ------------------------ | ---------------------------- |
| GET    | /api.php                 | Get all schedule data        |
| GET    | /api.php?date=YYYY-MM-DD | Get events for specific date |
| POST   | /api.php                 | Add/update events for a date |
| DELETE | /api.php?date=YYYY-MM-DD | Delete all events for a date |

### API Request Examples

Get all data:

```javascript
fetch('https://your-domain.com/api.php')
```

Get specific date:

```javascript
fetch('https://your-domain.com/api.php?date=2025-01-15')
```

Add events:

```javascript
fetch('https://your-domain.com/api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        date: '2025-01-15',
        events: [
            {
                timeStart: '09:00',
                timeStop: '11:00',
                title: 'Meeting Room A',
                description: 'Project discussion meeting'
            }
        ]
    })
})
```

## Customization

### Changing Colors and Themes

The interface uses CSS custom properties for easy theming:

```css
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --accent-color: #667eea;
    --text-color: #333;
    --background-light: rgba(255, 255, 255, 0.95);
}
```

### Adding Custom Event Templates

In admin.html, modify the templates object:

```javascript
const templates = {
    meeting: { 
        title: 'Conference Room', 
        description: 'Regular team meeting',
        timeStart: '09:00', 
        timeStop: '10:00' 
    },
    seminar: { 
        title: 'Seminar Hall', 
        description: 'Academic seminar',
        timeStart: '14:00', 
        timeStop: '16:00' 
    }
};
```

## Troubleshooting

### Common Issues

**1. API not working / CORS errors:**

- Ensure api.php is accessible via HTTP
- Check that CORS headers are properly set
- Verify PHP version compatibility

**2. Data not saving:**

- Check file permissions on schedule_data.json
- Ensure web server can write to the directory
- Verify PHP error logs

**3. Login not working:**

- Check JavaScript console for errors
- Verify credentials in the code
- Clear browser cache and session storage

**4. Display not updating:**

- Check API URL configuration
- Verify internet connection
- Check browser developer tools for errors

### Debug Mode

Add this to your JavaScript console to test the API:

```javascript
// Test API connection
testAPI();

// Check current authentication
console.log('Auth status:', sessionStorage.getItem('viewerAuth'));

// View current schedule data
console.log('Schedule data:', scheduleData);
```

## Security Considerations

- Change default passwords before deployment
- Use HTTPS in production environments
- Implement rate limiting on the API endpoints
- Validate and sanitize all user inputs
- Regular backups of schedule data
- Monitor access logs for suspicious activity

## Contributing

1. Fork the repository
2. Create a feature branch (git checkout -b feature/amazing-feature)
3. Commit your changes (git commit -m 'Add amazing feature')
4. Push to the branch (git push origin feature/amazing-feature)
5. Open a Pull Request

## License

This project is licensed under the MIT License.

## Author

**PotatoCodex** - Initial work

## Acknowledgments

- LSKK (Laboratorium Sistem Kendali dan Kecerdasan Buatan)
- Modern CSS techniques for beautiful UI
- RESTful API design principles
- Responsive web design best practices

## Support

If you have any questions or need support:

1. Check the troubleshooting section above
2. Open an issue on GitHub
3. Contact the development team

---

Made with love by PotatoCodex © 2025
