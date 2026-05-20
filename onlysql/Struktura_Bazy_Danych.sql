-- 1
create table reviews(
    reviewId integer primary key auto_increment,
    productCode varchar(15) not null,
    customerNumber integer not null,
    rating int check (rating >= 1 and rating <= 5),
    reviewText text,
    reviewDate date
);

-- 2
insert into customers(customerNumber, customerName, contactLastName, contactFirstName, phone, addressLine1, city, country)
values (465464564,
        'Sklep Modele',
        'Anna',
        'Nowak',
        '500-100-200',
        '',
        'Warszawa',
        'Polska');

-- 3
alter table reviews
add constraint fk_customerNumbers
foreign key (customerNumber) references customers(customerNumber);

-- 4
alter table customers
add column lastLogin datetime;

-- 5
update customers
set phone = '333-444-555'
where customerNumber = 103;

-- 6
delete from customers
where country = 'Poland';
