# 🎟️ E-ticket 2024

**E-ticket 2024** es una aplicación web desarrollada como proyecto final para la materia **Desarrollo de Software**. Su objetivo es facilitar la gestión y emisión de entradas electrónicas para eventos, proporcionando una solución moderna y eficiente tanto para organizadores como para asistentes.

---

## 🚀 Características Principales

- 📄 Generación y gestión de tickets electrónicos.
- 🧑‍💼 Panel de administración para organizadores de eventos.
- 👥 Gestión de usuarios y autenticación segura.
- 📊 Visualización de estadísticas de eventos.
- 📧 Notificaciones por correo electrónico para confirmaciones y recordatorios.

---

## 🛠️ Tecnologías Utilizadas

- **PHP** con el framework **Laravel 11**.
- **Blade** para la creación de vistas dinámicas.
- **Bootstrap** para estilos rápidos y responsivos.
- **JavaScript** para interactividad en el frontend.
- **MySQL** como sistema de gestión de bases de datos.

---
## 📁 **Estructura del Proyecto**

    E-ticket2024/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── lang/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── tests/
    ├── .env.example
    ├── artisan
    ├── composer.json
    ├── package.json
    └── README.md

---
🤝 Colaboradores
Este proyecto fue realizado en colaboración con:

Cristian Buenanote

Franco Garcia

Natanael Campos

Santiago Casado

---

## ⚙️ Instalación y Configuración

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/zeppelino/E-ticket2024.git
   cd E-ticket2024
2. **Instalar dependencias de PHP y JS**
    ```bash
    composer install && npm install

3. **Copiar archivo de entorno y generar clave**
    
    ```bash
    cp .env.example .env && php artisan key:generate
    
4. **Ejecutar migraciones**
   
    ```bash
    php artisan migrate

5. **Compilar assets en modo desarrollo**

    ```bash
    npm run dev

6 **Iniciar servidor de desarrollo**
php artisan serve
