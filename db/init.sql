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

create table tests (
  id int primary key auto_increment,
  name varchar(255) not null
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
        REFERENCES genders(id),
  CONSTRAINT UC_email UNIQUE (email)
);

create table rating_results (
  id int primary key auto_increment,
  `name` varchar(30) not null,
  description varchar(255) not null
);

create table user_ratings (
  id int primary key auto_increment,
  create_datetime datetime not null,
  user_id int not null,
  test_id int not null,
  game_play_data text not null,
  cached_rating decimal(10, 1),
  FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
  FOREIGN KEY (test_id)
        REFERENCES tests(id)
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

insert into tests(id, name) values
(1, 'Decision Making and Reaction Time'),
(2, 'Hand and Eye Coordination'),
(3, 'Balance Test'),
(4, 'Exhaled Breath Test')
;

insert into rating_results(id, name, description) values
(1, 'Extremely Impaired', 'Very poor cognitive impairment, Very low score results. Should not attend work and should not operate machinery.'),
(2, 'Impaired', 'Poor cognitive impairment, Decreased score results. Can attend work but not operate machinery.'),
(3, 'Slightly Impaired', 'Some cognitive impairment, Decreased score results. Can attend work and operate machinery.'),
(4, 'Not Impaired', 'No strong sign of cognitive impairment, Normal score results. Can attend work and operate machinery.'),
(5, 'Optimal', 'Better than normal cognitive function, Better than normal score results. Can attend work and operate machinery.')
;

insert into users(id, email, password_hash, gender_id, usage_reason_id) values
(1, 'josh.greig@gmail.com', '123', 2, 1)
;
