-- Dropout Analysis System Database Schema

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS dropout_analysis;
USE dropout_analysis;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher', 'counselor', 'researcher') NOT NULL DEFAULT 'teacher',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Schools table
CREATE TABLE IF NOT EXISTS schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    district VARCHAR(100),
    state VARCHAR(100),
    contact_person VARCHAR(100),
    contact_email VARCHAR(100),
    contact_phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT,
    name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    date_of_birth DATE,
    grade_level INT,
    enrollment_date DATE,
    dropout_risk ENUM('low', 'medium', 'high') DEFAULT 'low',
    dropout_date DATE,
    dropout_reason TEXT,
    socioeconomic_status ENUM('low', 'medium', 'high'),
    parent_education_level VARCHAR(50),
    attendance_rate DECIMAL(5,2),
    academic_performance DECIMAL(5,2),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Risk factors table
CREATE TABLE IF NOT EXISTS risk_factors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category ENUM('academic', 'economic', 'social', 'family', 'school', 'other') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Student risk factors mapping
CREATE TABLE IF NOT EXISTS student_risk_factors (
    student_id INT,
    risk_factor_id INT,
    severity ENUM('low', 'medium', 'high') NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, risk_factor_id),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (risk_factor_id) REFERENCES risk_factors(id) ON DELETE CASCADE
);

-- Interventions table
CREATE TABLE IF NOT EXISTS interventions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('academic', 'counseling', 'financial', 'mentoring', 'other') NOT NULL,
    status ENUM('planned', 'active', 'completed', 'cancelled') DEFAULT 'planned',
    start_date DATE,
    end_date DATE,
    outcome TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Intervention progress tracking
CREATE TABLE IF NOT EXISTS intervention_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intervention_id INT,
    date DATE NOT NULL,
    status ENUM('in_progress', 'completed', 'cancelled') NOT NULL,
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (intervention_id) REFERENCES interventions(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- State data table for analysis
CREATE TABLE IF NOT EXISTS state_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state_name VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    primary_dropout_rate DECIMAL(5,2),
    upper_primary_dropout_rate DECIMAL(5,2),
    secondary_dropout_rate DECIMAL(5,2),
    higher_secondary_dropout_rate DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (state_name, year)
);

-- State risk factors
CREATE TABLE IF NOT EXISTS state_risk_factors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state_id INT,
    risk_factor_id INT,
    percentage DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES state_data(id) ON DELETE CASCADE,
    FOREIGN KEY (risk_factor_id) REFERENCES risk_factors(id) ON DELETE CASCADE
);

-- State intervention strategies
CREATE TABLE IF NOT EXISTS state_strategies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state_id INT,
    strategy_name VARCHAR(100) NOT NULL,
    description TEXT,
    effectiveness_rating INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES state_data(id) ON DELETE CASCADE
);

-- Insert sample data for users
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('John Doe', 'john@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher'),
('Jane Smith', 'jane@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'counselor'),
('Rahul Sharma', 'rahul@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher'),
('Priya Patel', 'priya@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'counselor'),
('Amit Kumar', 'amit@dropoutanalysis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'researcher');

-- Insert sample data for schools
INSERT INTO schools (name, address, district, state, contact_person, contact_email, contact_phone) VALUES
('Central High School', '123 Education St', 'Central District', 'Odisha', 'Principal Sharma', 'principal@centralhigh.edu', '9876543210'),
('Riverside Academy', '456 River Road', 'Riverside District', 'Bihar', 'Principal Kumar', 'principal@riverside.edu', '9876543211'),
('Sunrise Public School', '789 Sunrise Ave', 'Sunrise District', 'Assam', 'Principal Das', 'principal@sunrise.edu', '9876543212'),
('St. Mary School', '321 Church Road', 'Church District', 'Karnataka', 'Principal Thomas', 'principal@stmary.edu', '9876543213'),
('Government Model School', '654 Government Ave', 'Government District', 'Gujarat', 'Principal Singh', 'principal@govmodel.edu', '9876543214');

-- Insert sample data for risk factors
INSERT INTO risk_factors (name, description, category) VALUES
('Economic Constraints', 'Financial difficulties preventing continued education', 'economic'),
('Domestic Responsibilities', 'Family obligations taking precedence over education', 'family'),
('Lack of Interest', 'Student disengagement from academic activities', 'academic'),
('Distance to School', 'Geographic barriers to school attendance', 'school'),
('Safety Concerns', 'Security issues affecting school attendance', 'school'),
('Gender Inequality', 'Societal norms affecting educational access', 'social'),
('Child Marriage', 'Early marriage practices affecting education', 'social'),
('Infrastructure Deficiencies', 'Poor school facilities affecting learning', 'school'),
('Cultural Expectations', 'Traditional values conflicting with education', 'social'),
('Migration', 'Family relocation disrupting education', 'family');

-- Insert sample data for students (for John Doe - user_id 2)
INSERT INTO students (school_id, name, gender, date_of_birth, grade_level, enrollment_date, dropout_risk, socioeconomic_status, parent_education_level, attendance_rate, academic_performance, created_by) VALUES
(1, 'Aarav Kumar', 'male', '2008-05-15', 8, '2020-04-01', 'low', 'medium', 'High School', 95.5, 85.2, 2),
(1, 'Diya Patel', 'female', '2008-03-22', 8, '2020-04-01', 'medium', 'low', 'Middle School', 82.3, 75.8, 2),
(1, 'Arjun Singh', 'male', '2008-11-10', 8, '2020-04-01', 'high', 'low', 'Primary School', 65.7, 62.4, 2),
(2, 'Zara Khan', 'female', '2009-01-18', 7, '2021-04-01', 'low', 'high', 'College', 97.2, 90.5, 2),
(2, 'Vihaan Sharma', 'male', '2009-07-30', 7, '2021-04-01', 'medium', 'medium', 'High School', 88.6, 78.9, 2);

-- Insert sample data for students (for Jane Smith - user_id 3)
INSERT INTO students (school_id, name, gender, date_of_birth, grade_level, enrollment_date, dropout_risk, socioeconomic_status, parent_education_level, attendance_rate, academic_performance, created_by) VALUES
(3, 'Ananya Reddy', 'female', '2007-09-12', 9, '2019-04-01', 'low', 'high', 'College', 96.8, 88.7, 3),
(3, 'Kabir Verma', 'male', '2007-12-05', 9, '2019-04-01', 'high', 'low', 'Primary School', 70.2, 65.3, 3),
(3, 'Ishaan Gupta', 'male', '2008-02-28', 8, '2020-04-01', 'medium', 'medium', 'High School', 85.4, 77.6, 3),
(4, 'Myra Joshi', 'female', '2008-06-14', 8, '2020-04-01', 'low', 'high', 'College', 94.7, 86.9, 3),
(4, 'Rohan Malhotra', 'male', '2008-10-25', 8, '2020-04-01', 'high', 'low', 'Middle School', 68.9, 63.2, 3);

-- Insert sample data for interventions (for John Doe - user_id 2)
INSERT INTO interventions (student_id, name, description, type, status, start_date, end_date, created_by) VALUES
(1, 'Academic Tutoring', 'Weekly tutoring sessions to improve math and science grades', 'academic', 'active', '2023-09-01', '2023-12-31', 2),
(2, 'Parent Counseling', 'Regular meetings with parents to discuss academic progress', 'counseling', 'active', '2023-09-15', '2023-12-15', 2),
(3, 'Financial Aid', 'Providing school supplies and transportation assistance', 'financial', 'completed', '2023-08-01', '2023-08-31', 2),
(4, 'Peer Mentoring', 'Matching with a high-performing peer for academic support', 'mentoring', 'planned', '2023-10-01', '2023-12-31', 2),
(5, 'Attendance Improvement', 'Daily check-ins to improve attendance record', 'other', 'active', '2023-09-10', '2023-12-10', 2);

-- Insert sample data for interventions (for Jane Smith - user_id 3)
INSERT INTO interventions (student_id, name, description, type, status, start_date, end_date, created_by) VALUES
(6, 'Academic Support', 'Extra help with difficult subjects', 'academic', 'active', '2023-09-05', '2023-12-20', 3),
(7, 'Family Support', 'Working with family to create supportive environment', 'counseling', 'active', '2023-09-20', '2023-12-20', 3),
(8, 'Scholarship Application', 'Assistance with applying for educational scholarships', 'financial', 'completed', '2023-08-15', '2023-09-15', 3),
(9, 'Career Guidance', 'Exploring career options and educational pathways', 'mentoring', 'planned', '2023-10-10', '2023-12-10', 3),
(10, 'Behavioral Support', 'Addressing behavioral issues affecting academic performance', 'other', 'active', '2023-09-15', '2023-12-15', 3);

-- Insert sample data for state data
INSERT INTO state_data (state_name, year, primary_dropout_rate, upper_primary_dropout_rate, secondary_dropout_rate, higher_secondary_dropout_rate) VALUES
('Odisha', 2023, 0.0, 0.2, 27.3, 49.9),
('Bihar', 2023, 8.9, 25.0, 25.0, 40.3),
('Assam', 2023, 8.49, 10.33, 20.25, 32.39),
('Gujarat', 2023, 1.0, 4.5, 17.9, 82.91),
('Karnataka', 2023, 1.7, 2.7, 22.09, 30.5);

-- Insert sample data for state risk factors
INSERT INTO state_risk_factors (state_id, risk_factor_id, percentage) VALUES
(1, 1, 35.0), -- Odisha - Economic Constraints
(1, 2, 25.0), -- Odisha - Domestic Responsibilities
(1, 3, 20.0), -- Odisha - Lack of Interest
(1, 4, 15.0), -- Odisha - Distance to School
(1, 5, 5.0),  -- Odisha - Safety Concerns
(2, 1, 40.0), -- Bihar - Economic Constraints
(2, 6, 25.0), -- Bihar - Gender Inequality
(2, 7, 15.0), -- Bihar - Child Marriage
(2, 8, 15.0), -- Bihar - Infrastructure Deficiencies
(2, 9, 5.0);  -- Bihar - Cultural Expectations

-- Insert sample data for state strategies
INSERT INTO state_strategies (state_id, strategy_name, description, effectiveness_rating) VALUES
(1, 'Financial Assistance', 'Scholarships and aid programs for economically disadvantaged students', 8),
(1, 'Community Engagement', 'Programs to involve parents and community in education', 7),
(1, 'Curriculum Enhancement', 'Making education more relevant and engaging', 6),
(1, 'Infrastructure Development', 'Improving school facilities and accessibility', 8),
(1, 'Safety Measures', 'Implementing security protocols for student safety', 7),
(2, 'Financial Support', 'Direct financial assistance to families', 8),
(2, 'Community Awareness', 'Campaigns to change cultural attitudes toward education', 7),
(2, 'Infrastructure Enhancement', 'Building better school facilities', 8),
(2, 'Policy Interventions', 'Government policies to support education', 6),
(2, 'Vocational Training', 'Alternative education paths for older students', 7); 