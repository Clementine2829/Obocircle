<?php create database new_accommodations;
	create table accommodations(
		id VARCHAR(40) NOT NULL PRIMARY KEY,
		name VARCHAR(65) NOT NULL,
		manager VARCHAR(45) NOT NULL,
		display VARCHAR(1) NOT NULL DEFAULT 0,
		nsfas BOOLEAN NOT NULL DEFAULT 0, 
		about TEXT NOT NULL,
		date_posted VARCHAR(20) NOT NULL
	);
    create table rooms(
		room_id VARCHAR(35) NOT NULL,
		accommo_id VARCHAR (40) UNIQUE NOT NULL,
		single_sharing BOOLEAN NOT NULL DEFAULT 0, 
		double_sharing BOOLEAN NOT NULL DEFAULT 0, 
		multi_sharing BOOLEAN NOT NULL DEFAULT 0, 
        PRIMARY KEY (room_id, accommo_id),
		FOREIGN KEY (accommo_id) REFERENCES accommodations(id) ON DELETE CASCADE  
	);
	CREATE TABLE single_s ( 
		single_id VARCHAR (20) NOT NULL,
		room_id VARCHAR (35) UNIQUE NOT NULL,
		cash VARCHAR (10) NOT NULL,
		bursary VARCHAR (10) NOT NULL,
        PRIMARY KEY (single_id, room_id),
		FOREIGN KEY (room_id) REFERENCES rooms (room_id) ON DELETE CASCADE
	);

	CREATE TABLE double_s ( 
		double_id VARCHAR (20) NOT NULL,
		room_id VARCHAR (35) UNIQUE NOT NULL,
		cash VARCHAR (10) NOT NULL,
		bursary VARCHAR (10) NOT NULL,
        PRIMARY KEY (double_id, room_id),
		FOREIGN KEY (room_id) REFERENCES rooms (room_id) ON DELETE CASCADE
	);
	CREATE TABLE multi_s ( 
		multi_id VARCHAR (20) NOT NULL,
		room_id VARCHAR (35) UNIQUE NOT NULL,
		cash VARCHAR (10) NOT NULL,
		bursary VARCHAR (10) NOT NULL,
        PRIMARY KEY (multi_id, room_id),
		FOREIGN KEY (room_id) REFERENCES rooms (room_id) ON DELETE CASCADE
	);

    CREATE TABLE address ( 
		address_id VARCHAR (30) NOT NULL,
		accommo_id VARCHAR (40) UNIQUE NOT NULL,
		main_address VARCHAR (150) NOT NULL,
		contact CHAR (10),
        PRIMARY KEY (address_id, accommo_id),
		FOREIGN KEY (accommo_id) REFERENCES accommodations (id) ON DELETE CASCADE
	);
    CREATE TABLE websites ( 
		website_id VARCHAR (10) NOT NULL,
		accommo_id VARCHAR (40) UNIQUE NOT NULL,
		website VARCHAR (100) NOT NULL,
		PRIMARY KEY (website_id, accommo_id),
		FOREIGN KEY (accommo_id) REFERENCES accommodations (id) ON DELETE CASCADE
	);
    CREATE TABLE images ( 
		image_id VARCHAR (15) NOT NULL PRIMARY KEY,
		image VARCHAR (30) UNIQUE NOT NULL
	);
    CREATE TABLE accommodation_images (
    	accommo_id VARCHAR (40) NOT NULL,
		image_id VARCHAR (15) NOT NULL,
		PRIMARY KEY (accommo_id, image_id),
		FOREIGN KEY (accommo_id) REFERENCES accommodations (id) ON DELETE CASCADE,
		FOREIGN KEY (image_id) REFERENCES images (image_id) ON DELETE CASCADE
	);
    
	CREATE TABLE features ( 
		f_id VARCHAR (30) PRIMARY KEY NOT NULL,
		accommo_id VARCHAR (40) UNIQUE NOT NULL,
		f1 varchar(1), 
		f2 varchar(1), 
		f3 varchar(1), 
		f4 varchar(1), 
		f5 varchar(1), 
		f6 varchar(1), 
		f7 varchar(1), 
		f8 varchar(1), 
		f9 varchar(1), 
		f10 varchar(1), 
		f11 varchar(1), 
		f12 varchar(1), 
		f13 varchar(1), 
		f14 varchar(1), 
		f15 varchar(1), 
		f16 varchar(1), 
		f17 varchar(1), 
		f18 varchar(1), 
		f19 varchar(1), 
		f20 varchar(1), 
		f21 varchar(1), 
		f22 varchar(1), 
		f23 varchar(1), 
		f24 varchar(1), 
		f25 varchar(1), 
		f26 varchar(1), 
		f27 varchar(1), 
		f28 varchar(1), 
		f29 varchar(1), 
		f30 varchar(1), 
		FOREIGN KEY (accommo_id) REFERENCES accommodations (id) ON DELETE CASCADE
	);
************************************************************************************************
    create database obo_users;
    create table users(
        id varchar (45) not null primary key, 
        first_name varchar(30) not null,
        last_name varchar(30) not null,
        gender char(1) not null, 
        date_of_birth char(10) not null, 
        phone char(10) not null, 
        email varchar (50) not null unique,
        password varchar (100) not null, 
        ref_code char (6) unique not null, 
        reg_date varchar (20) not null
    );
    create table users_extended(
        user_ex_id varchar (20) not null, 
        user_id varchar (45) not null, 
        address varchar (200) not null, 
        profile_status boolean not null default 0,
        user_type varchar (15) not null default 'general_user',
		primary key (user_ex_id, user_id),
		foreign key (user_id) references users (id) ON DELETE CASCADE
    );
    create table general_users(
        general_id varchar (10) not null, 
        user_id varchar (20) not null,
        uploads int default 0,
		primary key (general_id, user_id),
		foreign key (user_id) references users_extended (user_ex_id) ON DELETE CASCADE
    );
    create table premium_users (
        premium_id varchar (10) not null, 
        user_id varchar (20) not null,
        uploads int default 0,
		primary key (premium_id, user_id),
		foreign key (user_id) references users_extended (user_ex_id) ON DELETE CASCADE
    );
    create table subscribers(
        id int not null AUTO_INCREMENT primary key, 
        email varchar (60) not null unique, 
        sub_date timestamp
    );        
    
    create table activate_account(
        activate_id varchar(30) not null primary key,
        user_id varchar(45) not null,
        expire_date varchar(10) not null,
        veri_link char(6) not null,   
        foreign key (user_id) references users(id) on delete cascade
    );

    create table display_picture(
        dp_id varchar(10) not null,
        user_id varchar(45) not null,
        image varchar (20) not null,
        primary key(dp_id, user_id),
        foreign key (user_id) references users(id) on delete cascade
    );
    create table reset_pass(
        reset_id varchar(35) not null,
        user_id varchar(45) not null,
        reset_link char (6) not null,
        primary key(reset_id, user_id),
        foreign key (user_id) references users(id) on delete cascade
    );
    
    create table refs (
        ref_code char (6) not null, 
        email varchar (60) not null
    );

    create table notifications(
        notification_id varchar(10) not null,
        user_id varchar(45) not null,
        n_message varchar (200) not null,
        n_action varchar (200) not null,
        n_status char (1) not null default "0",
        n_date varchar (15) not null, 
        primary key (notification_id, user_id), 
        foreign key (user_id) references users (id) on delete cascade
    )

?>