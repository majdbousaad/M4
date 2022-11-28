Use emensawerbeseite;


create table ersteller
(
    id    int(8) auto_increment
        primary key,
    name  varchar(20)  not null,
    email varchar(200) null
);

create table wunschgericht
(
    id               bigint auto_increment
        primary key,
    name             varchar(20)                           not null,
    Beschreibung     varchar(400)                          null,
    erstellungsdatum timestamp default current_timestamp() not null on update current_timestamp(),
    ersteller_id     int(8)                                not null,
    constraint wunschgericht_ersteller_null_fk
        foreign key (ersteller_id) references ersteller (id)
);


