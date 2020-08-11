

/*------------BASE DE DATOS--------*/
drop database if exists tweb;
create database tweb;
use tweb;

/*-------Tablas------*/

drop table if exists galardonado;
create table galardonado (
idgal int not null,
nombre nvarchar (150),
primer_apellido nvarchar (150),
segundo_apellido nvarchar (150),
rfc nvarchar(14) not null,
edad int not null,
sexo int(1) default 0 not null,
correo nvarchar(120),
telefono nvarchar(15),
observaciones nvarchar(300),
discapacidad int(1) default 0 not null,
idescuela int not null,
idrec int not null,
primary key(idgal));


drop table if exists staff;
create table staff (
idstaff int not null,
usuario nvarchar(50) not null,
pasword varchar(32) not null,
nombre nvarchar (90) not null,
privilegio int(2) default 0 not null,
correo nvarchar(140) not null,
telefono nvarchar(15),
primary key(idstaff));


drop table if exists reconocimiento;
create table reconocimiento (
idrec int not null,
reconocimiento nvarchar (90) not null,
primary key(idrec));


drop table if exists escuela;
create table escuela (
idescuela int not null,
escuela nvarchar(150) not null,
primary key(idescuela));


drop table if exists asistencia;
create table asistencia (
idast int not null,
asistencia int(1) default 0 not null,
hora time default null,
idgal int not null,
idstaff int not null,
primary key(idast));

drop table if exists rel_asiento_galardonado;
create table rel_asiento_galardonado (
idrel int not null auto_increment,
idasiento int not null,
idgal int not null,
primary key (idrel));

drop table if exists validar_galardonado;
create table validar_galardonado (
token varchar(21) not null,
idgal int not null);

drop table if exists auditorio;
create table auditorio(
idauditorio int not null,
nombre nvarchar(100) not null,
primary key (idauditorio));

drop table if exists fila;
create table fila(
idfila int not null,
fila nvarchar(15) not null,
idauditorio int not null,
primary key (idfila));

drop table if exists asiento;
create table asiento(
idasiento int not null,
asiento int not null,
idfila int not null,
ocupado int(1) default 0 not null,
es_asiento int(1) default 1 not null,
primary key(idasiento));

alter table galardonado add foreign key (idescuela) references escuela(idescuela);
alter table galardonado add foreign key (idrec) references reconocimiento(idrec);
alter table asistencia add foreign key (idgal) references galardonado(idgal);
alter table asistencia add foreign key (idstaff) references staff(idstaff);
alter table fila add foreign key (idauditorio) references auditorio(idauditorio);
alter table asiento add foreign key (idfila) references fila(idfila);
alter table rel_asiento_galardonado add foreign key (idasiento) references asiento(idasiento);
alter table rel_asiento_galardonado add foreign key (idgal) references galardonado(idgal);
/*--------------------------FUNCTIONS------------------------------*/


drop function if exists f_Login; 
delimiter //
create function f_Login (p_usuario nvarchar(50), p_password varchar(32)) returns int(1)
begin
	declare confirm int(1);
	set confirm = (select count(*) from staff where usuario=p_usuario and pasword=p_password);
	return confirm;
end
//
delimiter ;


drop function if exists f_tipoUsuario; 
delimiter //
create function f_tipoUsuario (p_usuario nvarchar(50)) returns int(1)
begin
	declare tipo int(1);
	set tipo = (select privilegio from staff where usuario=p_usuario);
	return tipo;
end
//
delimiter ;


drop function if exists f_idEscuela; 
delimiter //
create function f_idEscuela (p_escuela nvarchar(150)) returns int
begin
	declare idexiste int;
	declare id_escuela int;
	set idexiste = (select idescuela from escuela where escuela=p_escuela);
	if idexiste is not null then
		return idexiste;
	else
		set id_escuela = (select max(idescuela) from escuela);
        if id_escuela is null then
			set id_escuela=0;
        end if;
		insert into escuela (idescuela,escuela)values((id_escuela+1),p_escuela);
		return (id_escuela+1);
	end if;
end
//
delimiter ;

drop function if exists f_idReconocimiento; 
delimiter //
create function f_idReconocimiento (p_recon nvarchar(90)) returns int
begin
	declare idexiste int;
	declare id_recon int;
	set idexiste = (select idrec from reconocimiento where reconocimiento=p_recon);
	if idexiste is not null then
		return idexiste;
	else
		set id_recon = (select max(idrec) from reconocimiento);
        if id_recon is null then
			set id_recon=0;
        end if;
		insert into reconocimiento (idrec,reconocimiento)values((id_recon+1),p_recon);
		return (id_recon+1);
	end if;
end
//
delimiter ;


drop function if exists f_idAuditorio; 
delimiter //
create function f_idAuditorio (p_auditorio nvarchar(100)) returns int
begin
	declare idexiste int;
	declare id_auditorio int;
	set idexiste = (select idauditorio from auditorio where nombre=p_auditorio);
	if idexiste is not null then
		return idexiste;
	else
		set id_auditorio = (select max(idauditorio) from auditorio);
        if id_auditorio is null then
			set id_auditorio=0;
        end if;
		insert into auditorio (idauditorio,nombre)values((id_auditorio+1),p_auditorio);
		return (id_auditorio+1);
	end if;
end
//
delimiter ;


drop function if exists f_anchoAuditorio; 
delimiter //
create function f_anchoAuditorio (p_auditorio nvarchar(100)) returns int
begin
	declare ancho int;
	declare ancho_auxiliar int;
	declare id_fila int;
	declare existe int;
	declare id_auditorio int;
	set id_auditorio = (select f_idAuditorio(p_auditorio));
	set id_fila=1;
	set ancho=(select count(*) from asiento where idfila=id_fila);
	set existe=(select count(*) from fila where idfila=id_fila);
	while existe >0 do
		set existe=(select count(*) from fila where idfila=id_fila);
		if existe >0 then
			set ancho_auxiliar=(select count(*) from asiento where idfila=id_fila);
			if ancho_auxiliar > ancho then
				set ancho=ancho_auxiliar;
			end if;
		end if;
		set id_fila=(id_fila+1);
	end while;
	return ancho;
end
//
delimiter ;


drop function if exists f_galardonadoValido;
delimiter //
create function f_galardonadoValido (p_rfc nvarchar(14)) returns int
begin
	declare id_gal int;
	declare validado int;
    set id_gal =(select idgal from galardonado where rfc=p_rfc);
	if id_gal is not null then
		set validado=(select count(*) from validar_galardonado where idgal=id_gal);
		if validado = 0 then
			/*------Si no hay un token es por que ya se validó-----*/
			set validado=1;
		else
			/*------Si hay un token es por que no se validó-----*/
			set validado=0;
		end if;
	end if;
	return validado;
end
//
delimiter ;


drop function if exists f_obtenerEdadRFC; 
delimiter //
create function f_obtenerEdadRFC (p_rfc nvarchar(14)) returns int
begin
	declare edad int;
    declare actual date;
    declare nacimiento date;
    declare fecha varchar(10);
    declare fecha_dia varchar(2);
    declare fecha_mes varchar(2);
    declare fecha_anio varchar(2);
    declare fecha_anioR varchar(4);
    declare anio int;
    set fecha_anio=(select SUBSTRING(p_rfc, 5, 2));
    set anio =(select CONVERT((fecha_anio),UNSIGNED INTEGER));
    if anio >= 0 and anio <= 05 then
		set fecha_anioR=(select CONCAT('20',fecha_anio));
	else
		set fecha_anioR=(select CONCAT('19',fecha_anio));
    end if;
    set fecha_mes=(select SUBSTRING(p_rfc, 7, 2));
    set fecha_dia=(select SUBSTRING(p_rfc, 9, 2));
    set fecha=(select CONCAT(fecha_anioR,'-'));
    set fecha=(select CONCAT(fecha,fecha_mes));
    set fecha=(select CONCAT(fecha,'-'));
    set fecha=(select CONCAT(fecha,fecha_dia));
    set nacimiento=(select str_to_date(fecha, '%Y-%m-%d'));
	set edad = (select YEAR(from_days(DATEDIFF(DATE(NOW()),
		str_to_date(nacimiento, '%Y-%m-%d')))));
	return edad;
end
//
delimiter ;


/*--------------------------PROCEDURES------------------------------*/


drop procedure if exists sp_altaStaff;
delimiter //
create procedure sp_altaStaff (in p_usuario nvarchar(90), in p_pasword varchar(32),
in p_nombre nvarchar(90),in p_privilegio int(2), in p_correo nvarchar(140),
in p_telefono nvarchar(15))
begin
	declare id_staff int;
    set id_staff=(select idstaff from staff where usuario=p_usuario);
    if id_staff is null then
		set id_staff=(select max(idstaff) from staff);
        if id_staff is null then
			set id_staff=0;
		end if;
        insert into staff(idstaff,usuario,pasword,nombre,privilegio,correo,telefono)
        values((id_staff+1),p_usuario,p_pasword,p_nombre,p_privilegio,p_correo,p_telefono);
    else
		select 'El usuario del Staff ya existe' as 'msg';
    end if;
end
//
delimiter ;


drop procedure if exists sp_editarStaff;
delimiter //
create procedure sp_editarStaff (in p_usuario nvarchar(90), in p_pasword varchar(32),
in p_nombre nvarchar(90), in p_correo nvarchar(140),in p_telefono nvarchar(15))
begin
	declare id_staff int;
    set id_staff=(select idstaff from staff where usuario=p_usuario);
    if id_staff is not null then
		update staff set pasword=p_pasword, nombre=p_nombre,
        correo=p_correo, telefono=p_telefono where idstaff=id_staff;
	end if;
end
//
delimiter ;


drop procedure if exists sp_borrarStaff;
delimiter //
create procedure sp_borrarStaff (in p_usuario nvarchar(90))
begin
	declare id_staff int;
    set id_staff=(select idstaff from staff where usuario=p_usuario);
    delete from staff where idstaff=id_staff;
    delete from asistencia where idstaff=id_staff;
end
//
delimiter ;


drop procedure if exists sp_altaGalardonado;
delimiter //
create procedure sp_altaGalardonado (in p_rfc nvarchar(14), in p_nombre nvarchar(150),
in p_primer_apellido nvarchar(150), in p_segundo_apellido nvarchar(150), in p_sexo int(1),
in p_observaciones nvarchar(300), in p_correo nvarchar(120), in p_escuela nvarchar(150),
in p_telefono nvarchar(15),in p_reconocimiento nvarchar(90), in p_discapacidad int(1))
begin
	declare id_gal int;
    declare id_escuela int;
    declare id_rec int;
    declare v_edad int;
	declare v_sexo int(1);
	declare v_discapacidad int(1);
    declare existe int;
    set id_gal =(select idgal from galardonado where rfc=p_rfc);
    if id_gal is null then
		set id_gal=(select max(idgal) from galardonado);
        if id_gal is null then
			set id_gal=0;
        end if;
		set id_rec=(select f_idReconocimiento(p_reconocimiento));
        set id_escuela=(select f_idEscuela(p_escuela));
        set v_edad=(select f_obtenerEdadRFC(p_rfc));
		if p_sexo = 0 then
			set v_sexo=0;
		else
			set v_sexo=1;
		end if;
		if p_discapacidad = 0 then
			set v_discapacidad=0;
		else
			set v_discapacidad=1;
		end if;
        insert into galardonado(idgal,nombre,rfc,primer_apellido,segundo_apellido,
		sexo,correo,telefono,edad,discapacidad,observaciones,idescuela,idrec)
        values((id_gal+1),p_nombre,p_rfc,p_primer_apellido,p_segundo_apellido,v_sexo,
		p_correo,p_telefono,v_edad,v_discapacidad,p_observaciones,id_escuela,id_rec);
		insert into asistencia(idast,asistencia,hora,idgal,idstaff)
		values((id_gal+1),0,TIME(NOW()),(id_gal+1),1);
	end if;
end
//
delimiter ;


drop procedure if exists sp_editarGalardonado;
delimiter //
create procedure sp_editarGalardonado (in p_rfc nvarchar(14), in p_nombre nvarchar(150),
in p_primer_apellido nvarchar(150), in p_segundo_apellido nvarchar(150), in p_sexo int(1),
in p_correo nvarchar(120), in p_telefono nvarchar(15), in p_observaciones nvarchar(300),
in p_discapacidad int(1),in p_escuela nvarchar(150),in p_reconocimiento nvarchar(90))
begin
	declare id_gal int;
	declare id_escuela int;
	declare id_recon int;
	declare v_sexo int(1);
	declare v_discapacidad int(1);
    set id_gal =(select idgal from galardonado where rfc=p_rfc);
    if id_gal is not null then
		if p_sexo = 0 then
			set v_sexo=0;
		else
			set v_sexo=1;
		end if;
		if p_discapacidad = 0 then
			set v_discapacidad=0;
		else
			set v_discapacidad=1;
		end if;
		set id_escuela=(select f_idEscuela(p_escuela));
		set id_recon=(select f_idReconocimiento(p_reconocimiento));
		update galardonado set nombre=p_nombre, primer_apellido=p_primer_apellido,
		segundo_apellido=p_segundo_apellido,telefono=p_telefono, correo=p_correo,
        sexo=v_sexo, discapacidad=v_discapacidad, idescuela=id_escuela, idrec=id_recon,
        observaciones=p_observaciones where idgal=id_gal;
    end if;
end
//
delimiter ;


drop procedure if exists sp_borrarGalardonado;
delimiter //
create procedure sp_borrarGalardonado (in p_rfc nvarchar(14))
begin
	declare id_gal int;
	declare id_asiento int;
    set id_gal=(select idgal from galardonado where rfc=p_rfc);
    set id_asiento=(select idasiento from rel_asiento_galardonado where idgal=id_gal);
    update asiento set ocupado=0 where idasiento=id_asiento;
    delete from rel_asiento_galardonado where idgal=id_gal;
	delete from asistencia where idgal=id_gal;
    delete from galardonado where idgal=id_gal;
end
//
delimiter ;


drop procedure if exists sp_borrarGalardonadoPorId;
delimiter //
create procedure sp_borrarGalardonadoPorId (in id_gal int)
begin
	declare id_asiento int;
    set id_asiento=(select idasiento from rel_asiento_galardonado where idgal=id_gal);
    update asiento set ocupado=0 where idasiento=id_asiento;
    delete from rel_asiento_galardonado where idgal=id_gal;
	delete from asistencia where idgal=id_gal;
    delete from galardonado where idgal=id_gal;
end
//
delimiter ;


drop procedure if exists sp_borrarEscuela;
delimiter //
create procedure sp_borrarEscuela (in p_escuela nvarchar(150))
begin
	declare id_escuela int;
	declare id_gal int;
    set id_escuela=(select f_idEscuela(p_escuela));
	set id_gal=(select max(idgal) from galardonado where idescuela=id_escuela);
	while id_gal is not null do
		set id_gal=(select max(idgal) from galardonado where idescuela=id_escuela);
		call sp_borrarGalardonadoPorId(id_gal);
	end while;
	delete from escuela where idescuela=id_escuela;
end
//
delimiter ;


drop procedure if exists sp_borrarReconocimiento;
delimiter //
create procedure sp_borrarReconocimiento (in p_reconocimiento nvarchar(90))
begin
	declare id_recon int;
	declare id_gal int;
    set id_recon=(select f_idReconocimiento(p_reconocimiento));
	set id_gal=(select max(idgal) from galardonado where idrec=id_recon);
	while id_gal is not null do
		set id_gal=(select max(idgal) from galardonado where idrec=id_recon);
		call sp_borrarGalardonadoPorId(id_gal);
	end while;
	delete from reconocimiento where idrec=id_recon;
end
//
delimiter ;



drop procedure if exists sp_guardarTokenGalardonado;
delimiter //
create procedure sp_guardarTokenGalardonado (in p_rfc nvarchar(14),in p_tk varchar(21))
begin
	declare id_gal int;
	declare existe int(1);
    set id_gal =(select idgal from galardonado where rfc=p_rfc);
    if id_gal is not null then
		set existe=(select count(*) from validar_galardonado where token=p_tk);
		if existe = 0 then
			insert into validar_galardonado(token,idgal)values(p_tk,id_gal);
		end if;
    end if;
end
//
delimiter ;


drop procedure if exists sp_pasarAsistencia;
delimiter //
create procedure sp_pasarAsistencia (in p_usuario nvarchar(50), in p_tk varchar(21))
begin
	declare id_staff int;
	declare id_gal int;
    declare id_ast int;
    set id_staff =(select idstaff from staff where usuario=p_usuario);
    if id_staff is not null then
		set id_gal =(select idgal from validar_galardonado where token=p_tk);
		if id_gal is not null then
			set id_ast=(select asistencia from asistencia where idgal=id_gal);
            if id_ast=0 then
				set id_ast=id_gal;
				update asistencia set asistencia=1, hora=TIME(NOW()),
                idstaff=id_staff where idast=id_ast;
				delete from validar_galardonado where token=p_tk;
            end if;
		end if;
    end if;
end
//
delimiter ;


drop procedure if exists sp_pasarAsistenciaRFC;
delimiter //
create procedure sp_pasarAsistenciaRFC (in p_usuario nvarchar(50),in p_rfc nvarchar(14))
begin
	declare id_staff int;
	declare id_gal int;
    declare id_ast int;
    set id_staff =(select idstaff from staff where usuario=p_usuario);
    if id_staff is not null then
		set id_gal=(select idgal from galardonado where rfc=p_rfc);
		set id_ast=id_gal;
		update asistencia set asistencia=1, hora=TIME(NOW()),
		idstaff=id_staff where idast=id_ast;
		delete from validar_galardonado where idgal=id_gal;
    end if;
end
//
delimiter ;


drop procedure if exists sp_crearAsiento;
delimiter //
create procedure sp_crearAsiento (in p_auditorio nvarchar(100),
in p_fila nvarchar(15), in p_asiento int, in p_state int(1))
begin
	declare id_auditorio int;
	declare id_fila int;
    declare id_asiento int;
	declare state_asiento int(1);
    if p_state = 0 then
		set state_asiento=0;
	else
		set state_asiento=1;
	end if;
    set id_auditorio=(select f_idAuditorio(p_auditorio));
    set id_fila=(select idfila from fila where idauditorio=id_auditorio and fila=p_fila);
    if id_fila is null then
		set id_fila=(select max(idfila) from fila);
        if id_fila is null then
			set id_fila=0;
        end if;
        set id_fila=(id_fila+1);
        insert into fila (idfila,fila,idauditorio) values(id_fila,p_fila,id_auditorio);
    end if;
    set id_asiento=(select idasiento from asiento where idfila=id_fila and asiento=p_asiento);
    if id_asiento is null then
		set id_asiento =(select max(idasiento) from asiento);
        if id_asiento is null then
			set id_asiento=0;
		end if;
		insert into asiento(idasiento,asiento,idfila,es_asiento)
        values((id_asiento+1),p_asiento,id_fila,state_asiento);
    end if;
end
//
delimiter ;


drop procedure if exists sp_ocuparAsiento;
delimiter //
create procedure sp_ocuparAsiento (in p_rfc nvarchar(14),in p_auditorio nvarchar(100),
in p_fila nvarchar(15), in p_asiento int)
begin
	declare id_gal int;
	declare id_auditorio int;
	declare id_fila int;
    declare id_asiento int;
    declare unAsiento int(1);
    declare existe int(1);
    set id_gal =(select idgal from galardonado where rfc=p_rfc);
    if id_gal is not null then
		set id_auditorio =(select idauditorio from auditorio where nombre=p_auditorio);
		if id_auditorio is not null then
			set id_fila=(select idfila from fila where idauditorio=id_auditorio and fila=p_fila);
            if id_fila is not null then
				set id_asiento=(select idasiento from asiento where idasiento=p_asiento);
                if id_asiento is not null then
					set unAsiento=(select es_asiento from asiento where idasiento=p_asiento);
					if unAsiento=1 then
						set existe=(select count(*) from rel_asiento_galardonado where idasiento=p_asiento);
						if existe=0 then
							set existe=(select count(*) from rel_asiento_galardonado where idgal=id_gal);
							if existe=0 then
								insert into rel_asiento_galardonado (idasiento,idgal) values(id_asiento,id_gal);
                                update asiento set ocupado=1 where idasiento=id_asiento and idfila=id_fila;
							end if;
						end if;
					end if;
                end if;
            end if;
		end if;
    end if;
end
//
delimiter ;


drop procedure if exists sp_crearAuditorio;
delimiter //
create procedure sp_crearAuditorio (in p_auditorio nvarchar(100), in p_filas int, in p_asientos int)
begin
	declare i int;
	declare j int;
	call sp_borrarAuditorio(p_auditorio);
	set i=1;
	while i<p_filas do
		set j=1;
		while j<p_asientos do
			call sp_crearAsiento(p_auditorio,i,j,1);
			set j=(j+1);
		end while;
		set i=(i+1);
	end while;
end
//
delimiter ;


drop procedure if exists sp_borrarAuditorio;
delimiter //
create procedure sp_borrarAuditorio (in p_auditorio nvarchar(100))
begin
	declare id_auditorio int;
	declare id_fila int;
	declare id_asiento int;
	set id_auditorio =(select idauditorio from auditorio where nombre=p_auditorio);
    set id_fila=(select max(idfila) from fila where idauditorio=id_auditorio);
    while id_fila is not null do
		set id_asiento=(select max(idasiento) from asiento where idfila=id_fila);
		while id_asiento is not null do
			delete from rel_asiento_galardonado where idasiento=id_asiento;
			delete from asiento where idasiento=id_asiento;
			set id_asiento=(select max(idasiento) from asiento where idfila=id_fila);
		end while;
        delete from fila where idfila=id_fila;
		set id_fila=(select max(idfila) from fila where idauditorio=id_auditorio);
    end while;
    delete from auditorio where idauditorio=id_auditorio;
end
//
delimiter ;


/*--------------------------VISTAS-------------------------*/

drop view if exists vw_Auditorio;
create view vw_Auditorio as select G.rfc, G.nombre,
G.primer_apellido, G.segundo_apellido, G.discapacidad,
G.observaciones,E.escuela, Rc.reconocimiento, A.idasiento,
A.asiento, A.es_asiento, A.ocupado, A.idfila
from rel_asiento_galardonado as R inner join galardonado as G
inner join reconocimiento as Rc inner join escuela as E
inner join asiento as A where R.idasiento=A.idasiento
and R.idgal=G.idgal and G.idrec = Rc.idrec and G.idescuela=E.idescuela;

drop view if exists vw_Galardonado;
create view vw_Galardonado as select G.idgal, G.nombre, G.rfc, G.primer_apellido,
G.segundo_apellido, G.discapacidad, G.observaciones,E.escuela, Rc.reconocimiento
from galardonado as G inner join reconocimiento as Rc
inner join escuela as E
where G.idrec = Rc.idrec and G.idescuela=E.idescuela;

drop view if exists vw_Reconocimientos;
create view vw_Reconocimientos as select Rc.reconocimiento,
G.nombre, G.rfc, G.observaciones, E.escuela
from galardonado as G inner join reconocimiento as Rc
inner join escuela as E
where G.idrec = Rc.idrec and G.idescuela=E.idescuela;

drop view if exists vw_Asistencia;
create view vw_Asistencia as select G.idgal, G.rfc, G.nombre as 'nombre',
G.primer_apellido, G.segundo_apellido, G.observaciones,
G.discapacidad, A.asistencia, A.hora, S.usuario,
S.nombre as 'staff', E.escuela, R.reconocimiento
from asistencia as A inner join galardonado as G
inner join staff as S inner join reconocimiento as R 
inner join escuela as E where A.idgal=G.idgal
and G.idescuela=E.idescuela and G.idrec=R.idrec and A.idstaff=S.idstaff;

drop view if exists vw_PDF;
create view vw_PDF as select G.nombre, V.token
from validar_galardonado as V
inner join galardonado as G where V.idgal=G.idgal;


/*--------------------------PRUEBAS------------------------------*/

call sp_altaStaff('admin','d8578edf8458ce06fbc5bb76a58c5ca4','Administrador Supremo',0,
'emanuelbarrera98@gmail.com','5540891179');

call sp_crearAuditorio('auditorio',17,50);
/*
call sp_crearAsiento('auditorio','A',2,1);
call sp_crearAsiento('auditorio','A',3,1);
call sp_ocuparAsiento('BAEE980918P68','auditorio','A',1);
call sp_ocuparAsiento('RFCFOO','auditorio','A',3);
call sp_borrarAuditorio('auditorio');

*/

/*select (@cnt := @cnt + 1) as rowNumber,
t.* from (select idgal from galardonado 
where discapacidad = 0 order by sexo)
t cross join (select @cnt := 0) as dummy;*/

use tweb;
use tweb;
use tweb;
use tweb;
use tweb;
use tweb;
use tweb;
use tweb;












