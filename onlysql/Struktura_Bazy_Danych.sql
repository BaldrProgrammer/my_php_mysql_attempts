-- 1
create table reviews(
    reviewId integer primary key auto_increment,
    productCode varchar(15) not null,
    customerNumber integer not null,
    rating int check (rating >= 1 and rating <= 5),
    reviewText text,
    reviewDate date
);
