create database pet_hero;
use pet_hero;

create table pet_multimedia(
    file_id bigint auto_increment,
    file_path text not null,
    pet_id bigint not null,
    description varchar(150) not null,

    constraint pk_pet_multimedia primary key (file_id),
    constraint fk_pet_id foreign key (pet_id) references pets (pet_id) on delete cascade

);

create table owners(
    owner_id bigint auto_increment,
    name varchar(150) not null ,
    last_name varchar(150) not null,
    adress varchar(150) not null,
    dni bigint not null,
    phone varchar(50) not null,
    email varchar(150) not null,
    password varchar(150) not null,
    birth_date date not null,
    active boolean not null default 1,

    constraint pk_owners primary key (owner_id),
    constraint unq_dni unique (dni),
    constraint unq_email unique (email),
    constraint chk_birth_date check ( birth_date<=now() )
);

create table available_dates(
    date_id bigint not null,
    date date not null,
    guardian_id bigint not null,

    constraint pk_available_dates primary key (date_id),
    constraint chk_future_date check (date>=now()),
    constraint fk_guardian_id foreign key (guardian_id) references guardians (guardian_id)
);



create table guardians(
    guardian_id bigint auto_increment,
    name varchar(150) not null ,
    last_name varchar(150) not null,
    adress varchar(150) not null,
    cuil bigint not null,
    phone varchar(50) not null,
    email varchar(150) not null,
    password varchar(250) not null,
    birth_date date not null,
    reputation float not null,
    preferred_size varchar(150),
    active boolean not null default 1,
    price float ,

    constraint pk_owners primary key (guardian_id),
    constraint unq_ unique (cuil),
    constraint unq_email unique (email),
    constraint chk_birth_date check ( birth_date<=now() ),
    constraint chk_price check (price>=0)
);


create table pets(
    pet_id bigint auto_increment,
    name varchar(150) not null,
    pet_type varchar(150) not null,
    pet_size varchar(150) not null,
    pet_breed varchar(150) not null default 'Unknown',
    observations text default ' ',
    owner_id bigint not null,
    active boolean not null default 1,

    constraint pk_pet primary key (pet_id),
    constraint fk_owner_id foreign key (owner_id) references owners(owner_id) on delete cascade

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
    constraint fk_guardian foreign key (guardian_id) references guardians (guardian_id)

);



create table reservations_x_pets(
    reservartion_x_pets_id bigint not null auto_increment,
    reservation_id bigint not null,
    pet_id bigint not null,

    constraint pk_reservations_x_pets primary key (reservartion_x_pets_id),
    constraint fk_reservation_id foreign key (reservation_id) references reservations(reservation_id),
    constraint fk_pet_id foreign key (pet_id) references pets(pet_id)

);




create table payments(
    payment_id bigint not null,
    amount float not null,
    date date not null,
    reservation_id bigint not null,
    owner_id bigint not null,
    guardian_id bigint not null,
    active boolean not null  default 1,
    method varchar(150) not null,
    payment_number int not null,
    constraint pk_payment primary key (payment_id),
    constraint fk_guardian_id foreign key (guardian_id) references guardians(guardian_id),
    constraint fk_owner_id foreign key (owner_id) references owners(owner_id),
    constraint fk_reservation_id foreign key (reservation_id) references reservations (reservation_id),
    constraint chk_negative_amount check ( amount>=0 )
);