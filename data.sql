USE data_db;

-- query para los usuarios y perfiles

CREATE TABLE  t_Grupos(

id 		  		  int (255) auto_increment NOT NULL,
nombre 	   		varchar(150) NOT NULL,
descripcion 	text,
created_at  	datetime NOT NULL,
updated_at 		datetime NOT NULL,


CONSTRAINT pk_Grupos PRIMARY KEY (id)


)ENGINE=Innodb;


CREATE TABLE  t_perfiles(

id 		  		int (255) auto_increment NOT NULL,
Grupo_ID  int (255) NOT NULL,
nombre 	   		varchar(150) NOT NULL,
descripcion 	text,
created_at  	datetime NOT NULL,
updated_at 		datetime NOT NULL,


CONSTRAINT pk_perfiles PRIMARY KEY (id)
CONSTRAINT fk_Grupos FOREIGN KEY  (Grupo_ID) REFERENCES  t_Grupos(id)


)ENGINE=Innodb;


CREATE TABLE t_users(

User_ID 	 		  		varchar(50)  NOT NULL,
User_Name   		    varchar(50) NOT NULL,
User_Apellido 		  varchar(50) NOT NULL,
User_Contrasena 		varchar(255) NOT NULL,
Perfil_User  		    int(255) NOT NULL,
User_Email   		    varchar(255) NOT NULL,
User_Descripcion 	  text,
User_Ruta_Imagen    varchar(255) NOT NULL,
Remember_token	    varchar(255) NOT NULL,

Created_Date  	    datetime NOT NULL,
Updated_Date 		    datetime NOT NULL,

CONSTRAINT pk_users PRIMARY KEY (User_ID),
CONSTRAINT fk_Uperfil FOREIGN KEY  (Perfil_User) REFERENCES  t_perfiles(id)

)ENGINE=Innodb;


-- sql de los modulos

CREATE TABLE tipo_identificacion(

id 		  		    int (255) auto_increment NOT NULL,
nombre              varchar(50) NOT NULL,
descripcion         text,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_tIdentificacion PRIMARY KEY (id)

)ENGINE=Innodb;

CREATE TABLE t_proveedores(

Proveedor_Name 		  varchar(50) NOT NULL,
Tipo_Documento_Prov int (255)  NOT NULL,
No_Documento_Prov   varchar(100) NOT NULL,
Celular_Prov           varchar(20) NOT NULL,
Telefono_Prov           varchar(20),
Email_Prov               varchar(255) NOT NULL,
Ciudad                      varchar(100)NOT NULL,
Direccion_Prov           varchar(100)  NOT NULL,
User_ID           varchar(50) NOT NULL,,

Created_Date		datetime DEFAULT NULL,
Updated_Date  	datetime DEFAULT NULL,
Upload_Date   datetime DEFAULT NULL,

CONSTRAINT pk_proveedores PRIMARY KEY (No_Documento_Prov),
CONSTRAINT fk_user  FOREIGN KEY (User_ID ) REFERENCES t_users(User_ID),
CONSTRAINT fk_Tindentificacion FOREIGN KEY  (Tipo_Documento_Prov) REFERENCES t_tipo_identificacion(	ID_Ident )

)ENGINE=Innodb;


CREATE TABLE categoria(

id              int (255) auto_increment NOT NULL,
nombre          varchar(50) NOT NULL,
descripcion     text,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_categoria PRIMARY KEY (id)

)ENGINE=Innodb;



use data_db;
CREATE TABLE EstadoPrueba (
  Catalogo_Estado_Uni varchar(30) NOT NULL,
  Estado_Descripcion_Uni varchar(30) NOT NULL,
  User_ID int(11) NOT NULL,
  Created_Date datetime DEFAULT NULL,
  Updated_Date datetime DEFAULT NULL,
  Upload_Date datetime DEFAULT NULL,
    
  PRIMARY KEY (`Catalogo_Estado_Uni`)
) ENGINE=Innodb;


CREATE TABLE materiaPrueba(

Codigo_ID           int (255) auto_increment NOT NULL,
Material_Name       varchar(30) NOT NULL,
Cantidad_Material   int (255) NOT NULL,
Marca               varchar(200) NOT NULL,
Medida              varchar(50) NOT NULL,
Precio_Compra       float,
Categoria           varchar(30) NOT NULL,
No_Documento_Prov1   int (255) NOT NULL,
User_ID             text,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_matria PRIMARY KEY (Codigo_ID),
CONSTRAINT fk_medida    FOREIGN KEY  (Medida) REFERENCES medida(id)

)ENGINE=Innodb;












CREATE TABLE estado_op_venta(

    id                  int(255) auto_increment NOT NULL,
    nombre              varchar(255) NOT NULL,
    descripcion         text,
    created_at		    datetime DEFAULT NULL,
    updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_estado_op_venta PRIMARY KEY (id)

)ENGINE=Innodb;




CREATE TABLE estado_tarea(

    id                  int(255) auto_increment NOT NULL,
    nombre              varchar(255) NOT NULL,
    descripcion         text,
    created_at		    datetime DEFAULT NULL,
    updated_at  	    datetime DEFAULT NULL,

    CONSTRAINT pk_estado_tarea PRIMARY KEY (id)


)ENGINE=Innodb;




-- cotizaciones

CREATE TABLE estado_cotizacion(

  id        int (255) AUTO_INCREMENT NOT NULL,
  nombre        varchar (255) NOT NULL,
  descripcion   text,
  created_at      datetime DEFAULT NULL,
  updated_at       datetime DEFAULT NULL,

  CONSTRAINT pk_estado_cotizacion PRIMARY KEY (id)

)ENGINE=INNODB;


CREATE TABLE t_cotizaciones(

    Cotizacion_id 				       varchar(255) NOT NULL,
    Cliente_ID		    	         int(11) NOT NULL,
    Op_Venta_ID			    	       varchar(255) NOT NULL,
    Unidad 		                   varchar(255),
    Valor_Total_Unidad           float,


    Porcentaje_Valor_Descuento   float,
    Valor_Descuento              float,
    Valor_Unidad_Final           float,
    Valor_Congelacion 	         float,
    Fecha_Congelacion		         date,
    Valor_Cuota_Separacion       float,
    Fecha_Cuota_Separacion       date,
    Cuota_Inicial                float,
    Valor_Cuota_Inicial_20       float,
    Numero_Cuotas_20             int(11),
    Tipo_Cuotas_20               varchar(20),
    Valor_Cuota_20               float,
    Valor_Cuota_70               float,
    Estado_Cotizacion            varchar(30),
    User_ID                       int(255),
    created_at                datetime DEFAULT NULL,
    updated_at                datetime DEFAULT NULL,

    CONSTRAINT	pk_cotizacion PRIMARY KEY (Cotizacion_id),
    CONSTRAINT	fk_cliente_id FOREIGN KEY (Cliente_ID) REFERENCES t_clientes(Cliente_ID),
    CONSTRAINT fk_in_inmueble FOREIGN KEY (Unidad) REFERENCES  t_unidades(id_unidad),
    CONSTRAINT	fk_id_op_venta FOREIGN KEY (Op_Venta_ID) REFERENCES t_oportunidad_venta(Op_Venta_ID)

    CONSTRAINT  fk_user_id  FOREIGN KEY (User_ID) REFERENCES  t_users(User_ID),


  )ENGINE=INNODB;



CREATE TABLE fecha_pagos_cotizaciones(

  id                int(255)  AUTO_INCREMENT NOT NULL,
  id_cotizacion     int(255) NOT NULL,
  fecha_pagos       datetime NOT NULL,¨
  valor_pago        int(255) NOT NULL,

  id_user		    int(255) NOT NULL,
  created_at       datetime DEFAULT NULL,
  updated_at       datetime DEFAULT NULL,

  CONSTRAINT pk_fecha_pagos  PRIMARY KEY (id),
  CONSTRAINT fk_cotizaciones FOREIGN KEY (id_cotizacion) REFERENCES cotizaciones(id),

  CONSTRAINT id_user_fk FOREIGN KEY (id_user) REFERENCES users(id)

)ENGINE=INNODB;





-- Bases de datos actualizadas


CREATE TABLE nivel_estudios(

  id                  int(255)  AUTO_INCREMENT NOT NULL,
  descripcion         text,
  created_at    datetime DEFAULT NULL,
  updated_at    datetime DEFAULT NULL,

  CONSTRAINT pk_nivel_estudios   PRIMARY KEY (id)


)ENGINE=INNODB;

CREATE TABLE clientes(

id                  int(255) auto_increment NOT NULL,
nombre              varchar(255) NOT NULL,
tipo_iden           int(255) NOT NULL,
num_identificacion  varchar(255) NOT NULL,
fecha_nacimiento    datetime DEFAULT NULL,
id_n_estudio   int(255) NOT NULL,
profesion           varchar(255) NOT NULL,
contacto1           varchar(50) NOT NULL,
contacto2           varchar(50) NOT NULL ,
email               varchar(255) NOT NULL,
descripcion         text,
id_user             int(255) NOT NULL,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_cliente PRIMARY KEY (id),

CONSTRAINT fk_tipo FOREIGN KEY  (tipo_iden) REFERENCES tipo_identificacion(id),
CONSTRAINT create_fk FOREIGN KEY  (id_user ) REFERENCES users(id),
CONSTRAINT fk_nivel_estudios FOREIGN KEY (id_n_estudio) REFERENCES  nivel_estudios(id)


)ENGINE=Innodb;


CREATE TABLE oportunidad_venta(

id                  int(255) auto_increment NOT NULL,
cliente_id          int(255) NOT NULL,

inmueble_id             int(255) NOT NULL,
id_user             int(255) NOT NULL,
cantidad            int(255) NOT NULL,
valor_compra        double(20,3) NOT NULL,
fecha_cierre        datetime NOT NULL,
estado_id           int(255) NOT NULL,
descripcion         text,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_oportunidad_venta PRIMARY KEY (id),


CONSTRAINT user_create_fk    FOREIGN KEY  (id_user)     REFERENCES users(id),
CONSTRAINT fk_cliente   FOREIGN KEY  (cliente_id)   REFERENCES clientes(id),
CONSTRAINT fk_inmueble    FOREIGN KEY  (inmueble_id )     REFERENCES inmueble(id),
CONSTRAINT fk_estado_op   FOREIGN KEY  (estado_id)    REFERENCES estado_op_venta(id),


)ENGINE=Innodb;








CREATE TABLE tareas(

id                  int(255) auto_increment NOT NULL,
oportunidad_venta   int(255),
tarea               text NOT NULL,
fecha_recordatorio  datetime NOT NULL,
id_user             int(255) NOT NULL,
id_estado           int(255) NOT NULL,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,
CONSTRAINT pk_tarea PRIMARY KEY (id),

CONSTRAINT fk_op_venta     FOREIGN KEY  (oportunidad_venta ) REFERENCES oportunidad_venta(id),
CONSTRAINT fk_usuario_id     FOREIGN KEY  (id_user ) REFERENCES users(id),
CONSTRAINT fk_estado_tarea     FOREIGN KEY  (id_estado  ) REFERENCES estado_tarea(id),
)ENGINE=Innodb;





-------------------------Nuevos cambios en la base de datos----------------

-- cambios en la tabla obras-> cambio de nombre a inmueble
-- Nuevas tablas proyectos
-- tabla estado_proyecto
-- tabla tipo_inmueble
-- tabla inmueble
-- tabla torre




-- Base de datos de proyectos y obras

CREATE TABLE estado_proyecto(

  id                    int(255) AUTO_INCREMENT NOT NULL,
  nombre                varchar(255) NOT NULL,
  descripcion           text,

  created_at          datetime DEFAULT NULL,
  updated_at          datetime DEFAULT NULL,

  CONSTRAINT pk_estado_proyecto PRIMARY KEY (id)

)ENGINE=INNODB;


CREATE TABLE proyectos(

  id                  int(255) AUTO_INCREMENT NOT NULL,
  nombre              varchar(150) NOT NULL,
  id_user             int(255) NOT NULL,
  id_estado           int(255) NOT NULL,
  fecha_inicio        datetime NOT NULL,
  fecha_finalizacion  datetime NOT NULL,

  direccion           text,
  descripcion         text,
  created_at          datetime DEFAULT NULL,
  updated_at          datetime DEFAULT NULL,

  CONSTRAINT pk_proyectos PRIMARY KEY (id),
  CONSTRAINT fk_user_create FOREIGN KEY (id_user) REFERENCES  users(id),
  CONSTRAINT fk_estado_proyecto FOREIGN KEY (id_estado)   REFERENCES estado_proyecto(id)


)ENGINE=INNODB;


CREATE TABLE torre(

  id                 int (255) AUTO_INCREMENT NOT NULL,
  nombre             varchar(50) NOT NULL,
  cant_pisos         int(255) NOT NULL,
  id_proyecto        int (255)  NOT NULL,

  id_user            int(255) NOT NULL,

  descripcion        text,
  created_at         datetime DEFAULT NULL,
  updated_at         datetime DEFAULT NULL,

  CONSTRAINT  pk_torre PRIMARY KEY (id),
  CONSTRAINT  fk_proyecto FOREIGN KEY (id_proyecto) REFERENCES proyectos(id),
  CONSTRAINT fk_user_create FOREIGN KEY (id_user) REFERENCES  users(id),

)ENGINE=INNODB;


CREATE TABLE tipo_inmueble(

id            int (255) AUTO_INCREMENT NOT NULL,
nombre        varchar(50) NOT NULL,
descripcion   text,
User_ID                   int(11),

created_at    datetime DEFAULT NULL,
updated_at    datetime DEFAULT NULL,
CONSTRAINT fk_create_user    FOREIGN KEY (id_user) REFERENCES t_users(User_ID)

CONSTRAINT pk_tipo_obra  PRIMARY KEY (id)


)ENGINE=INNODB;




CREATE TABLE t_unidades(

id_unidad                 varchar(255) NOT NULL,
Torre_Name                varchar(50)  NOT NULL,
Proyecto_ID               varchar(10)  NOT NULL,
Unidad                    varchar(18)  NOT NULL,
Nomenclatura_Unidad       varchar(10)  NOT NULL,
Area_Habitable_M2         float        NOT NULL,
Area_Extension_M2         float        NOT NULL,
Tipo_Extension            varchar(15)  NOT NULL,
Area_Total_M2             float        NOT NULL,
No_Parqueaderos           int(50)      NOT NULL,
Parque_Descr              varchar(24),
Bodega_Deposito_M2        float,
Tipo_Inmueble             varchar(30)  NOT NULL,
Estado_Unidad             varchar(30)  NOT NULL,
Valor_Parqueadero         float,
Valor_Deposito            float,
Valor_Total_Unidad        float,
User_ID                   int(11),

created_at    datetime DEFAULT NULL,
updated_at    datetime DEFAULT NULL,
Upload_Date   datetime DEFAULT NULL,

CONSTRAINT pk_obras   PRIMARY KEY (id_unidad,Unidad),
CONSTRAINT fk_proyecto FOREIGN KEY (Proyecto_ID) REFERENCES t_proyecto(Proyecto_ID),
CONSTRAINT fk_torre FOREIGN KEY (id_torre) REFERENCES t_torre(id),
CONSTRAINT fk_tipo_inmueble FOREIGN KEY (Tipo_Inmueble) REFERENCES  t_tipo_inmueble(id),
CONSTRAINT fk_create    FOREIGN KEY (id_user) REFERENCES t_users(User_ID)

)ENGINE=INNODB;












TODO: -- faltaaaa!!!!

CREATE TABLE estado_inmueble()ENGINE=INNODB;
