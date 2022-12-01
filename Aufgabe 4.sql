
#1

ALTER TABLE gericht_hat_kategorie
    ADD CONSTRAINT UC_Gericht_Kategorie UNIQUE(gericht_id, kategorie_id);

#2
create index gericht_name_index
    on gericht (name);


#3
alter table gericht_hat_allergen
    drop foreign key gericht_fk;

alter table gericht_hat_allergen
    add constraint gericht_fk
        foreign key (gericht_id) references gericht (id)
            on delete cascade;

alter table gericht_hat_kategorie
    drop constraint gericht_id_fk;

alter table gericht_hat_kategorie
    add constraint gericht_id_fk
        foreign key(gericht_id)
            references gericht(id)
            on delete cascade ;


#4

alter table gericht_hat_kategorie
    drop constraint kategorie_id_fk;

alter table gericht_hat_kategorie
    add constraint kategorie_id_fk
        foreign key(kategorie_id)
            references kategorie(id)
            on delete restrict;

alter table kategorie
    drop constraint eltern_id_fk;

alter table kategorie
    add constraint eltern_id_fk
    foreign key (eltern_id)
    references kategorie(id)
    on delete restrict ;


#5
alter table gericht_hat_allergen
    drop foreign key allergen_fk;

alter table gericht_hat_allergen
    add constraint allergen_fk
        foreign key (code) references allergen (code)
            on update cascade;


#6
alter table gericht_hat_kategorie
    add constraint gericht_hat_kategorie_pk
        primary key (kategorie_id, gericht_id);

