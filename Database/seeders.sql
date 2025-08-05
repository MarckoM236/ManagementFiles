/*Create roles*/
INSERT INTO management.roles
(id_rol, name) values (1,'user'),(2,'admin');

/*Create permissions*/
INSERT INTO management.permissions
(id_permission, `action`)
VALUES(1, 'user.query'),
(2,'user.profile'),
(3,'user.profile.update'),
(4,'user.create'),
(5,'user.update'),
(6,'user.delete'),
(7,'category.query'),
(8,'category.create'),
(9,'category.update'),
(10,'category.delete'),
(11,'document.query'),
(12,'document.create'),
(13,'document.update'),
(14,'document.delete');

/*create user admin*/
INSERT INTO management.users
(id_user, name, last_name, email, password)
VALUES(1, 'Administrator', 'Administrator', 'administrator@app.com', '12345678');

/*relation role - permissions*/
INSERT INTO management.roles_permissions
(id, id_role, id_permission)
VALUES(1, 1, 2),
(2,1,3),
(3,1,7),
(4,1,8),
(5,1,9),
(6,1,10),
(7,1,11),
(8,1,12),
(9,1,13),
(10,1,14),
(11, 2, 1),
(12, 2, 2),
(13, 2, 3),
(14, 2, 4),
(15, 2, 5),
(16, 2, 6),
(17, 2, 7),
(18, 2, 8),
(19, 2, 9),
(20, 2, 10),
(21, 2, 11),
(22, 2, 12),
(23, 2, 13),
(24, 2, 14);

/*relation role for user administrator*/
INSERT INTO management.roles_users
(id, id_role, id_user)
VALUES(1, 2, 1);