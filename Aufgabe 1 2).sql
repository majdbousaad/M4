create table wunschgericht
(
    id               bigint auto_increment
        primary key,
    name             varchar(20)                           not null,
    Beschreibung     varchar(400)                          null,
    erstellungsdatum timestamp default current_timestamp() not null on update current_timestamp(),
    ersteller_name   varchar(20)                           not null,
    ersteller_email  varchar(300)                          null
);

