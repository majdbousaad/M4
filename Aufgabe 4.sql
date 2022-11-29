
#1

ALTER TABLE gericht_hat_kategorie
    ADD CONSTRAINT UC_Gericht_Kategorie UNIQUE(gericht_id, kategorie_id);

#2
create index gericht_name_index
    on gericht (name);

#3
alter table gericht_hat_allergen
    drop foreign key gericht_hat_allergen_allergen_code_fk;

alter table gericht_hat_allergen
    add constraint gericht_hat_allergen_allergen_code_fk
        foreign key (code) references allergen (code)
            on delete cascade;

alter table gericht_hat_allergen
    drop foreign key gericht_hat_allergen_gericht_id_fk;

alter table gericht_hat_allergen
    add constraint gericht_hat_allergen_gericht_id_fk
        foreign key (gericht_id) references gericht (id)
            on delete cascade;


#4




#5
alter table gericht_hat_allergen
    drop constraint gericht_hat_allergen_allergen_code_fk;

alter table gericht_hat_allergen
    add constraint gericht_hat_allergen_allergen_code_fk
    foreign key (code)
    references allergen(code)
    on update cascade;


#6
alter table gericht_hat_kategorie
    add constraint gericht_hat_kategorie_pk
        primary key (kategorie_id, gericht_id);

