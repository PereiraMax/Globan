create database Globan;
use Globan;
create table Cliente(
 id int not null AUTO_INCREMENT,
 nombre varchar(60),
 telefono varchar(20),
 CONSTRAINT pkCliente primary key(id)   
)engine=innodb;
create table Producto(
id int not null AUTO_INCREMENT,
nombre varchar(60),
valor double not null,
constraint pkProducto primary key(id)    
)engine=innodb;
create table Venta(
id int not null AUTO_INCREMENT,
idCliente int not null,
idProducto int not null,
cantidad int not null,
constraint pk_idVenta primary key(id),
constraint fk_Venta1 FOREIGN key(idCliente) references Cliente(id),  
constraint fk_Venta2 foreign key(idProducto)references Producto(id)    
)engine=innodb;


