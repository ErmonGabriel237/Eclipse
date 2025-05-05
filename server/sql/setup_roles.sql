USE elearning;

-- Create roles table if it doesn't exist
CREATE TABLE IF NOT EXISTS roles (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    description varchar(255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id),
    UNIQUE KEY unique_role_name (name)
);

-- Insert default roles if they don't exist
INSERT IGNORE INTO roles (id, name, description) VALUES 
(1, 'student', 'Regular student user'),
(2, 'instructor', 'Course instructor'),
(3, 'admin', 'System administrator');