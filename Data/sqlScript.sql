create database pet_hero;
use pet_hero;

CREATE TABLE pet_sizes(
    pet_size_id int auto_increment,
    name varChar(50) not null,
    CONSTRAINT pk_pet_size_id PRIMARY KEY (pet_size_id)
);

CREATE TABLE users(
    user_id bigint auto_increment,
    name varChar(150) NOT NULL,
    last_name varChar(150) NOT NULL,
    adress varChar(150) NOT NULL,
    phone varChar(50) NOT NULL,
    email varChar(150) NOT NULL,
    password varChar(150) NOT NULL,
    birth_date date NOT NULL,
    active boolean not null default 1,
    CONSTRAINT pk_user_id PRIMARY KEY (user_id),
    CONSTRAINT unq_email UNIQUE (email)
);

create table owners(
    user_id bigint NOT NULL,
    dni varChar(150) not null,

    constraint pk_owner_user_id primary key (user_id),
    constraint fk_owner_user_id foreign key (user_id) references users(user_id) ON DELETE CASCADE,

    constraint unq_dni unique (dni)
    /*constraint chk_birth_date check ( birth_date<=now() )*/
);

create table guardians(
    user_id bigint NOT NULL,
    cuil varChar(150) not null,
    reputation float not null default 3,
    preferred_size_dog int,
    preferred_size_cat int,
    price float,

    constraint pk_guardian_user_id primary key (user_id),
    CONSTRAINT fk_guardian_user_id foreign KEY (user_id) references users(user_id) ON DELETE CASCADE,

    CONSTRAINT fk_preferred_size_dog FOREIGN KEY (preferred_size_dog) REFERENCES pet_sizes(pet_size_id) ON DELETE SET NULL,
    CONSTRAINT fk_preferred_size_cat FOREIGN KEY (preferred_size_cat) REFERENCES pet_sizes(pet_size_id) ON DELETE SET NULL,
    constraint unq_cuil unique (cuil),
    /*constraint chk_birth_date check ( birth_date<=now() ),*/
    constraint chk_price check (price>=0)
);

create table available_dates(
	guardian_id bigint not null,
    date date not null,
    
    constraint pk_available_dates primary key (guardian_id, date),
    /*constraint chk_future_date check (date>=now()),*/
    constraint fk_guardian_id foreign key (guardian_id) references guardians (user_id) ON DELETE CASCADE
);

create table pets(
    pet_id bigint auto_increment,
    name varchar(150) not null,
    pet_type varchar(150) not null,
    pet_size int,
    pet_breed varchar(150) not null default 'Unknown',
    observations varchar(250) default '',
    owner_id bigint not null,
    vaccination_plan varchar(250),
    pet_img varchar(250),
    pet_video varchar(250),
    active boolean not null default 1,

    constraint pk_pet primary key (pet_id),
    CONSTRAINT fk_pet_size FOREIGN key (pet_size) REFERENCES pet_sizes(pet_size_id) ON DELETE SET NULL,
    constraint fk_owner_id foreign key (owner_id) references owners(user_id) on delete cascade
);

create table pet_multimedia(
    file_id bigint auto_increment,
    file_path text not null,
    pet_id bigint not null,
    description varchar(150) not null,

    constraint pk_pet_multimedia primary key (file_id),
    constraint fk_pet_id foreign key (pet_id) references pets (pet_id) on delete cascade

);

create table reservations(
    reservation_id bigint not null auto_increment,
    price bigint not null,

    guardian_id bigint not null,
    owner_id bigint not null,
    active boolean not null default 1,
    state varchar(50) not null,

    constraint pk_reservations primary key (reservation_id),
    constraint fk_guardian foreign key (guardian_id) references guardians (user_id) ON DELETE CASCADE,
    constraint fk_owner foreign key (owner_id) references owners (user_id) ON DELETE CASCADE

);



create table reservations_x_pets(
    reservation_x_pets_id bigint not null auto_increment,
    reservation_id bigint not null,
    pet_id bigint not null,

    constraint pk_reservations_x_pets primary key (reservation_x_pets_id),
    constraint fk_reservation_id foreign key (reservation_id) references reservations(reservation_id),
    constraint fk_pet foreign key (pet_id) references pets(pet_id)

);

create table reservations_x_dates(
    date date not null,
    reservation_id bigint not null,

    constraint pk_available_dates_reservation primary key (date, reservation_id),
    constraint fk_id_reservation foreign key (reservation_id) references reservations (reservation_id) ON DELETE CASCADE
);

create table payments(
    payment_id bigint auto_increment,
    amount float not null,
    date date not null,
    reservation_id bigint not null,
    owner_id bigint not null,
    guardian_id bigint not null,
    active boolean not null  default 1,
    method varchar(150) not null,
    payment_number int not null,
    constraint pk_payments primary key (payment_id),
    constraint fk_payment_guardian foreign key (guardian_id) references users(user_id),
    constraint fk_payment_owner foreign key (owner_id) references users(user_id),
    constraint fk_payment_reservation foreign key (reservation_id) references reservations (reservation_id),
    constraint chk_negative_amount check ( amount>=0 )
);


INSERT INTO users (name, last_name, adress, phone, email, password, birth_date) VALUES ("Santiago", "Yanosky", "costa 12222", "02235887965", "santi@gmail.com", "elmascapito", '2002-11-13');
INSERT INTO users (name, last_name, adress, phone, email, password, birth_date) VALUES ("Agus", "Kumar", "basural 5555", "02235 1256987", "agus@gmail.com", "elmascapoto", '1999-11-12');

INSERT INTO pet_sizes(name) VALUES ("big");
INSERT INTO pet_sizes(name) VALUES ("medium");
INSERT INTO pet_sizes(name) VALUES ("small");

INSERT INTO guardians (user_id, cuil, reputation, preferred_size_dog, preferred_size_cat, price) VALUES (1, "5555555", 3.2, 1, 2, 5000);
INSERT INTO owners (user_id, dni) VALUES (2, 52555633);

CREATE PROCEDURE insertPet(IN p_name varchar(150), IN p_pet_type varchar(150), IN p_pet_size int, IN p_pet_breed varchar(150), IN p_observations varchar(250), IN p_owner_id bigint, IN p_vaccination_plan varchar(250), IN p_pet_img varchar(250), IN p_pet_video varchar(250))
BEGIN

    INSERT INTO pets (name, pet_type, pet_size, pet_breed, observations, owner_id, vaccination_plan, pet_img, pet_video) VALUES (p_name, p_pet_type, p_pet_size, p_pet_breed, p_observations, p_owner_id, p_vaccination_plan, p_pet_img, p_pet_video);

    SELECT last_insert_id() as id_pet;

END;

CREATE PROCEDURE create_Reservation(IN p_price bigint, IN p_guardian_id bigint, IN p_owner_id bigint)
BEGIN
    
    INSERT INTO reservations (price, guardian_id, owner_id, state) VALUES (p_price, p_guardian_id, p_owner_id, 'Pending');

    SELECT last_insert_id() as id_reservation;

END;

/* ------------------------------------------------ PAYMENTS ------------------------------------------ *

/* Insertar un payment */

INSERT INTO payments (amount, date, reservation_id, owner_id, guardian_id, payment_number) VALUES (10, now(), 36, 2, 1, 1023456);

/* Tipos de pagos */

/* Card | Cash | ? */ 

/* Obtener payment por id */

SELECT p.amount as 'amount', p.date as 'date', p.payment_number as 'payment_number', CONCAT(uo.name, " ", uo.last_name) as 'owner_name', CONCAT(ug.name, " ", ug.last_name) as 'guardian_name', r.price as 'price'

FROM payments p 
INNER JOIN users uo ON uo.user_id = p.owner_id
INNER JOIN users ug ON ug.user_id = p.guardian_id
INNER JOIN reservations r ON r.reservation_id = p.reservation_id
WHERE p.payment_id = 2;

/* Falta fecha de vencimiento!!  NO VA*/
/* Falta numero de tarjeta!! */
/* Falta tipo de tarjeta? */


/* Obtener payment(s) por reserva */

/*
amount
date
payment_number
owner_name
guardian_name
price
*/

SELECT p.amount as 'amount', p.date as 'date', p.payment_number as 'payment_number', CONCAT(uo.name, " ", uo.last_name) as 'owner_name', CONCAT(ug.name, " ", ug.last_name) as 'guardian_name', r.price as 'price'

FROM payments p 
INNER JOIN users uo ON uo.user_id = p.owner_id
INNER JOIN users ug ON ug.user_id = p.guardian_id
INNER JOIN reservations r ON r.reservation_id = p.reservation_id
WHERE r.reservation_id = 36;


/* Obtener todos lo Payments */

SELECT p.amount as 'amount', p.date as 'date', p.payment_number as 'payment_number', CONCAT(uo.name, " ", uo.last_name) as 'owner_name', CONCAT(ug.name, " ", ug.last_name) as 'guardian_name', r.price as 'price'
FROM payments p 
INNER JOIN users uo ON uo.user_id = p.owner_id
INNER JOIN users ug ON ug.user_id = p.guardian_id
INNER JOIN reservations r ON r.reservation_id = p.reservation_id;

/* Desactivar un payment */

UPDATE payments SET active=false WHERE payment_id=2;

SELECT * FROM pet_sizes;

