-- Create users table
CREATE TABLE IF NOT EXISTS users (
     id SERIAL PRIMARY KEY,
     name VARCHAR(100),
    "group" VARCHAR(50)
    );

-- Insert sample users
INSERT INTO users (id, name, "group") VALUES
      (1, 'John', 'group1'),
      (2, 'Jack', 'group1'),
      (3, 'Paul', 'group1'),
      (4, 'Jack', 'group2'),
      (5, 'George', 'group2'),
      (6, 'Nick', 'group3'),
      (7, 'Jason', 'group3');

-- 2) Create the exams table
CREATE TABLE IF NOT EXISTS exams (
     id SERIAL PRIMARY KEY,
     date DATE NOT NULL,
     user_id INT NOT NULL,
     point INT NOT NULL,
     FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample exam records
INSERT INTO exams (id, date, user_id, point) VALUES
     (1, '2024-11-01', 1, 100),
     (2, '2024-11-04', 1, 70),
     (3, '2024-11-10', 2, 80),
     (4, '2024-11-15', 3, 40),
     (5, '2024-11-20', 4, 50),
     (6, '2024-11-30', 6, 60),
     (7, '2024-12-01', 5, 75),
     (8, '2024-12-05', 1, 80),
     (9, '2024-12-10', 2, 90),
     (10, '2024-12-12', 6, 75),
     (11, '2024-12-14', 4, 60),
     (12, '2024-12-16', 3, 85),
     (13, '2024-12-20', 7, 90),
     (14, '2024-12-24', 4, 95),
     (15, '2024-12-28', 3, 60),
     (16, '2024-12-30', 1, 40),
     (17, '2024-12-31', 2, 50),
     (18, '2025-01-04', 1, 60),
     (19, '2025-01-06', 3, 80),
     (20, '2025-01-08', 4, 75);