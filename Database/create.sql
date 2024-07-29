-- Crear la tabla users
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Crear la tabla categorias
CREATE TABLE categories (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

-- Crear la tabla documents
CREATE TABLE documents (
    id_document INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_category INT,
    descripcion TEXT,
    url VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_category) REFERENCES categories(id_category)
);

-- Crear la tabla roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Crear la tabla permissions
CREATE TABLE permissions (
    id_permission INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255) NOT NULL
);

-- Crear la tabla roles_permissions con id como clave primaria
CREATE TABLE roles_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT,
    id_permission INT,
    FOREIGN KEY (id_role) REFERENCES roles(id_rol),
    FOREIGN KEY (id_permission) REFERENCES permissions(id_permission)
);
