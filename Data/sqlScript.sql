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
    CONSTRAINT unq_email UNIQUE (user_id)
);

create table owners(
    user_id bigint NOT NULL,
    dni bigint not null,

    constraint pk_owner_user_id primary key (user_id),
    constraint fk_owner_user_id foreign key (user_id) references users(user_id) ON DELETE CASCADE,

    constraint unq_dni unique (dni)
    /*constraint chk_birth_date check ( birth_date<=now() )*/
);

create table guardians(
    user_id bigint NOT NULL,
    cuil bigint not null,
    reputation float not null,
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
    date_id bigint not null,
    date date not null,
    guardian_id bigint not null,

    constraint pk_available_dates primary key (date_id),
    /*constraint chk_future_date check (date>=now()),*/
    constraint fk_guardian_id foreign key (guardian_id) references guardians (user_id) ON DELETE CASCADE
);


create table pets(
    pet_id bigint auto_increment,
    name varchar(150) not null,
    pet_type varchar(150) not null,
    pet_size int,
    pet_breed varchar(150) not null default 'Unknown',
    observations text default ' ',
    owner_id bigint not null,
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
    start_date date not null,
    finish_date date not null,

    guardian_id bigint not null,
    active boolean not null default 1,
    state varchar(50) not null,

    constraint pk_reservations primary key (reservation_id),
    constraint fk_guardian foreign key (guardian_id) references guardians (user_id) ON DELETE CASCADE

);



create table reservations_x_pets(
    reservation_x_pets_id bigint not null auto_increment,
    reservation_id bigint not null,
    pet_id bigint not null,

    constraint pk_reservations_x_pets primary key (reservation_x_pets_id),
    constraint fk_reservation_id foreign key (reservation_id) references reservations(reservation_id),
    constraint fk_pet foreign key (pet_id) references pets(pet_id)

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