<?php create database teamaces;
	create table users(
		id VARCHAR(30) NOT NULL PRIMARY KEY,
		first_name VARCHAR(50) NOT NULL,
		last_name VARCHAR(50) NOT NULL,
		email VARCHAR(150) NOT NULL,
		password VARCHAR(150) NOT NULL,
		address VARCHAR(225),
		user_type VARCHAR(10) NOT NULL,
		profile_status INT NOT NULL DEFAULT '1',
		date_reg VARCHAR(20) NOT NULL,
		extended_user_info VARCHAR (10)
	);
	create table user_info_extended(
		user_info_id VARCHAR(10) NOT NULL PRIMARY KEY, 
		user_id VARCHAR(30) NOT NULL,
		phone VARCHAR(10) NOT NULL, 
		gender VARCHAR(30) NOT NULL,
		date_of_birth VARCHAR(30) NOT NULL,
		nationality VARCHAR(30) NOT NULL,
		race VARCHAR(30) NOT NULL,
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE		
	);
	create table verify(
		veri_id VARCHAR(30) NOT NULL, 
		user_id VARCHAR(30) NOT NULL, 
		veri_link VARCHAR(50) NOT NULL,
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE	
	);
	create table highschool_education(
		edu_id INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		school_name VARCHAR(100) NOT NULL, 
		grade_passed VARCHAR(10) NOT NULL, 
		duration VARCHAR(70) NOT NULL, 
		PRIMARY KEY(edu_id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	create table tertiary_education(
		edu_id INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		qualification_name VARCHAR(100) NOT NULL, 
		tertiary_name VARCHAR(100) NOT NULL, 
		duration VARCHAR(70) NOT NULL, 
		PRIMARY KEY(edu_id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	create table job_experience(
		exp_id INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		job_title VARCHAR(100) NOT NULL, 
		organization_name VARCHAR(100) NOT NULL, 
		duration VARCHAR(50) NOT NULL, 
		PRIMARY KEY(exp_id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	create table about_myself(
		id INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		about VARCHAR(225) NOT NULL, 
		expertise VARCHAR(225) NOT NULL, 
		skills VARCHAR(225) NOT NULL, 
		PRIMARY KEY(id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	create table user_references(
		ref_id INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		ref_name VARCHAR(50) NOT NULL, 
		contact VARCHAR(15) NOT NULL, 
		organization VARCHAR(70) NOT NULL, 
		PRIMARY KEY(ref_id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	CREATE TABLE documents(
		doc_id   VARCHAR(10) NOT NULL PRIMARY KEY,
		doc_name VARCHAR(30) NOT NULL, 
		doc_loc VARCHAR(150) NOT NULL 
	);
	CREATE TABLE user_documents(
		user_id VARCHAR(30) NOT NULL, 
		doc_id  VARCHAR(10) NOT NULL, 
		PRIMARY KEY(user_id, doc_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,   
		FOREIGN KEY(doc_id) REFERENCES documents(doc_id) ON DELETE CASCADE   
	);
	CREATE TABLE find_employee(
		employer_id VARCHAR(30) NOT NULL, 
		employee_id VARCHAR(30) NOT NULL, 
		PRIMARY KEY(employer_id, employee_id), 
		FOREIGN KEY(employee_id) REFERENCES users(id) ON DELETE CASCADE,   
		FOREIGN KEY(employee_id) REFERENCES users(id) ON DELETE CASCADE   
	);

	CREATE TABLE profile_pictures(
		image_id  INT NOT NULL AUTO_INCREMENT,
		user_id VARCHAR(30) NOT NULL, 
		image VARCHAR(30) NOT NULL, 
		PRIMARY KEY(image_id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);

	create table company(
		id VARCHAR (20) NOT NULL,
		manager_id VARCHAR(30) NOT NULL, 
		company_name VARCHAR(50) NOT NULL, 
		company_phone VARCHAR(15) NOT NULL, 
		location VARCHAR(150) NOT NULL, 
		website VARCHAR(150) NOT NULL, 
		logo VARCHAR(150) NOT NULL, 
		PRIMARY KEY(id, manager_id), 
		FOREIGN KEY(manager_id) REFERENCES users(id) ON DELETE CASCADE   
	);

	CREATE TABLE job_categories(
		id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		category VARCHAR(50) NOT NULL
	);
	create table jobs(
		job_id VARCHAR(20) NOT NULL PRIMARY KEY,
		company_id VARCHAR(20),
		job_title VARCHAR(50) NOT NULL,
		remote_work INT NOT NULL,
		location VARCHAR(150) NOT NULL,
		job_type VARCHAR(10) NOT NULL,
		work_type VARCHAR(10) NOT NULL,
		salary_min VARCHAR(10),
		salary_max VARCHAR(10),
		closing_date VARCHAR(20),
		job_summary VARCHAR(225) NOT NULL,
		requirements VARCHAR(225),
		duties VARCHAR(225),
		job_ref VARCHAR(10) NOT NULL,
		job_status int NOT NULL DEFAULT 1,
		category int,
		date_posted VARCHAR(20) NOT NULL,
		FOREIGN KEY(company_id) REFERENCES company(id) ON DELETE SET NULL,   
		FOREIGN KEY(category) REFERENCES job_categories(id) ON DELETE SET NULL   
	);

	CREATE TABLE job_applications(
		user_id VARCHAR(30) NOT NULL, 
		job_id VARCHAR(30) NOT NULL, 
		date_applied VARCHAR(35) NOT NULL, 
		job_status INT NOT NULL default 2, 
		PRIMARY KEY(user_id, job_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,   
		FOREIGN KEY(job_id) REFERENCES jobs(job_id) ON DELETE CASCADE   
	);

	CREATE TABLE interview(
		interview_id VARCHAR(30) NOT NULL, 
		job_id VARCHAR(30) NOT NULL, 
		user_id VARCHAR(30) NOT NULL, 
		interview_date VARCHAR(35) NOT NULL, 
		interview_status INT NOT NULL default 1, 
		PRIMARY KEY(interview_id, job_id), 
		FOREIGN KEY(job_id) REFERENCES job_applications(job_id) ON DELETE CASCADE   
	)
	create table notifications(
		id VARCHAR (10) NOT NULL,
		user_id VARCHAR(30) NOT NULL, 
		n_message VARCHAR(200) NOT NULL, 
		n_action VARCHAR(100) NOT NULL, 
		n_status CHAR(1) NOT NULL DEFAULT 2, 
		n_date VARCHAR(50) NOT NULL, 
		PRIMARY KEY(id, user_id), 
		FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE   
	);
	create table subscribers(
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR (150),
		email VARCHAR (150) NOT NULL, 
		job_category INT,
		FOREIGN KEY(job_category) REFERENCES job_categories(id) ON DELETE SET NULL  
	);

	ALTER TABLE users ADD FOREIGN KEY (extended_user_info) REFERENCES user_info_extended (user_info_id) ON DELETE SET NULL;


	create table stats_jobs(
		stats_id VARCHAR(10) NOT NULL,
		job_id VARCHAR NOT NULL
		applications_approved
		applications_declined

	);
	create table stats_company(
		stats_id VARCHAR(10) NOT NULL,
		company_id VARCHAR NOT NULL,
		jobs_threshold int NOT NULL DEFAULT 20
		

	);

?>