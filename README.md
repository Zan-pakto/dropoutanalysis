# Student Dropout Analysis System

A comprehensive web application for analyzing and addressing student dropout rates across different states in India. This system helps educators, administrators, and policymakers identify at-risk students and implement effective interventions.

## Features

- **State-wise Analysis**: View detailed dropout statistics for different states
- **Interactive Maps**: Visual representation of dropout rates across states
- **Student Tracking**: Monitor individual student dropout risk
- **Intervention Management**: Create and track interventions for at-risk students
- **User Authentication**: Secure login system with role-based access
- **Profile Management**: Edit user profiles and manage account settings

## Technology Stack

- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Data Visualization**: Chart.js
- **Authentication**: Session-based authentication

## Installation

1. Clone the repository to your local machine:
   ```
   git clone https://github.com/yourusername/dropout-analysis.git
   ```

2. Set up a local web server (XAMPP, WAMP, or similar)

3. Import the database schema:
   - Create a database named `dropout_analysis`
   - Import the SQL file from the `database` directory

4. Configure the database connection:
   - Open `includes/db.php`
   - Update the database credentials if needed

5. Access the application through your web browser:
   ```
   http://localhost/dropout-analysis
   ```

## Project Structure

```
dropout-analysis/
├── css/                  # Stylesheets
├── data/                 # JSON data files
│   └── dropout_data.json # State and student data
├── img/                  # Images and state maps
├── includes/             # PHP includes
│   ├── auth_check.php    # Authentication verification
│   ├── auth_modal.php    # Login/signup modal
│   ├── db.php            # Database connection
│   ├── footer.php        # Footer template
│   └── header.php        # Header template
├── js/                   # JavaScript files
├── analysis.php          # State analysis page
├── edit_profile.php      # Profile editing page
├── index.php             # Homepage
├── interventions.php     # Interventions management
├── profile.php           # User profile page
├── signin.php            # Login page
└── signup.php            # Registration page
```

## Data Structure

The application uses a JSON file (`data/dropout_data.json`) to store:

- State-wise dropout statistics
- Primary causes of dropout
- Intervention strategies
- Education level data
- Gender disparity information
- Student records
- Intervention tracking
- User accounts

## Usage

1. **User Registration/Login**:
   - New users can register through the signup page
   - Existing users can log in through the signin page

2. **State Analysis**:
   - View overall dropout statistics
   - Click on state cards to see detailed information
   - Analyze causes and potential interventions

3. **Student Management**:
   - Add and track students
   - Assess dropout risk
   - Create and monitor interventions

4. **Profile Management**:
   - Edit personal information
   - Change password
   - View activity history

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Data sources: [List your data sources]
- Icons: Font Awesome
- Maps: [Source of state maps] 