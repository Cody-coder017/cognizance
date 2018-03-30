create table usage_frequencies (
  id int primary key auto_increment,
  name varchar(100) not null
);

create table usage_reasons (
  id int primary key auto_increment,
  name varchar(100) not null
);

create table genders (
  id int primary key auto_increment,
  name varchar(30) not null
);

create table `users` (
  id int primary key auto_increment,
  email varchar(50) not null,
  password_hash varchar(50) not null,
  birth_date date,
  gender_id int,
  usage_frequency_id int,
  usage_reason_id int,
  FOREIGN KEY (usage_frequency_id)
        REFERENCES usage_frequencies(id),
  FOREIGN KEY (usage_reason_id)
        REFERENCES usage_reasons(id),
  FOREIGN KEY (gender_id)
        REFERENCES genders(id)
);

create table user_ratings (
  id int primary key auto_increment,
  user_id int not null,
  rating_1 decimal(10, 2),
  rating_2 decimal(10, 2),
  rating_3 decimal(10, 2),
  rating_4 decimal(10, 2),
  FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

insert into usage_frequencies(id, name) values
(1, 'Every day'),
(2, '3-4 times a week'),
(3, 'Once a week'),
(4, 'Once a month'),
(5, 'A few times a year'),
(6, 'Never')
;

insert into usage_reasons(id, name) values 
(1, 'Cancer'),
(2, 'Other disease'),
(3, 'Pain Management'),
(4, 'Other')
;

insert into genders(id, name) values
(1, 'Female'),
(2, 'Male'),
(3, 'Other')
;

insert into users(id, email, password_hash, gender_id, usage_reason_id) values
(1, 'josh.greig@gmail.com', '123', 2, 1)
;
