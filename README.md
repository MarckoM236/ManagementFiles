# 📂 ManagementFiles

Sistema de gestión de archivos simple desarrollado en PHP con estructura MVC sin frameworks.

## ✅ Requisitos

- PHP >= 8.0
- Composer
- MySQL o MariaDB
- Un servidor web (como Apache o Nginx)

---

## 🛠️ Instalación

Sigue los pasos a continuación para instalar y ejecutar el sistema en tu entorno local.

1.  **Clonar el repositorio**
    Navega a tu directorio de proyectos y clona este repositorio.
    ```bash
    git clone https://github.com/tu-usuario/ManagementFiles.git
    cd ManagementFiles
    ```

2.  **Crear la base de datos**
    Accede a tu gestor de base de datos (MySQL/MariaDB) y crea una nueva base de datos.
    ```sql
    CREATE DATABASE management_files;
    ```

3.  **Importar la estructura de la base de datos**
    Importa el archivo `Database/DB_structure.sql` en la base de datos que acabas de crear. Esto creará todas las tablas necesarias para el sistema.

4.  **Cargar datos iniciales (Seeders)**
    Ejecuta el script `Database/seeders.sql` para insertar datos de prueba, incluyendo el usuario administrador por defecto.

5.  **Instalar dependencias PHP**
    Usa Composer para instalar todas las dependencias del proyecto.
    ```bash
    composer install
    ```

6.  **Configurar el archivo de entorno (`.env`)**
    Copia el archivo de ejemplo `.env.example` para crear tu propio archivo de configuración.
    ```bash
    cp .env.example .env
    ```
    Luego, abre el archivo `.env` y actualiza las credenciales de conexión a tu base de datos:
    ```env
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=management_files
    DB_USERNAME=tu_usuario_de_db
    DB_PASSWORD=tu_contraseña_de_db
    ```

7.  **Configurar el Virtual Host**
    Es crucial que tu servidor web apunte al directorio `Public/`, ya que es el único punto de entrada de la aplicación (`index.php`).

    **Ejemplo para Apache:**
    ```apache
    <VirtualHost *:80>
        ServerName managementfiles.local
        DocumentRoot "/ruta/completa/hacia/ManagementFiles/Public"

        <Directory "/ruta/completa/hacia/ManagementFiles/Public">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```
    No olvides añadir el dominio local a tu archivo `hosts` para que tu sistema pueda resolverlo.
    
    - **En Windows:** `C:\Windows\System32\drivers\etc\hosts`
    - **En macOS/Linux:** `/etc/hosts`

    Añade la siguiente línea:
    ```
    127.0.0.1   managementfiles.local
    ```

¡Listo! Ahora puedes acceder a `http://managementfiles.local` en tu navegador.

---

## 👤 Usuario Administrador

Puedes iniciar sesión con las siguientes credenciales por defecto:

-   **Correo:** `administrator@app.com`
-   **Contraseña:** `12345678`
