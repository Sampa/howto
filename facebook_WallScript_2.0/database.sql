CREATE TABLE messages
(
msg_id INT PRIMARY KEY AUTO_INCREMENT,
message VARCHAR(200)
);


create table comments
(
com_id int primary key auto_increment,
 comment varchar(200), 
msg_id_fk int, 
foreign key (msg_id_fk) references messages(msg_id)
);