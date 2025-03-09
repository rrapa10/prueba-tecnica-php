# 🛠️ Prueba Técnica PHP con Makefile 🚀

Este proyecto es una prueba técnica en PHP siguiendo principios de **DDD (Domain-Driven Design)** y utilizando **Doctrine** para la gestión de base de datos.

## 📌 Tecnologías Utilizadas

- **PHP 8.2** 🐘
- **Doctrine ORM** 🔍
- **MySQL 8** 🌅
- **Slim Framework** 🌐
- **Docker y Docker Compose** 🐳
- **PHPUnit para pruebas automatizadas** ✅

---

## **📌 Requisitos Previos**

Antes de ejecutar el proyecto, asegúrate de tener instalado:

- [Docker](https://docs.docker.com/get-docker/) 🐳
- [Docker Compose](https://docs.docker.com/compose/install/) 📞
- [Git](https://git-scm.com/downloads) 🔗
- **Make**: Si estás en Windows, instala [Chocolatey](https://chocolatey.org/install) y luego ejecuta:
  ```powershell
  choco install make
  ```

---

## **📌 Instalación y Ejecución con Makefile 🚀**

### **🔹 Paso 1: Clonar el repositorio**

```bash
git clone https://github.com/rrapa10/prueba-tecnica-php.git
cd prueba-tecnica-php
```

### **🔹 Paso 2: Instalar dependencias con Composer**

Antes de ejecutar la aplicación, es necesario instalar las dependencias de PHP dentro del contenedor:
```bash
make install
```
📌 **Este comando ejecutará `composer install` dentro del contenedor `php_app` para instalar todas las librerías necesarias y generar la carpeta `vendor/`.**

⚠️ **Si `make install` no funciona, intenta ejecutar manualmente:**
```bash
docker exec -it php_app composer install
```

### **🔹 Paso 3: Iniciar el entorno con Docker y Makefile**

```bash
make start
```
📌 **Esto iniciará Docker, esperará que los contenedores se inicien y aplicará las migraciones de la base de datos automáticamente.**

### **🔹 Paso 4: Crear las tablas en la base de datos (Migraciones)**

```bash
make migrate
```
📌 **Este comando ejecutará las migraciones de Doctrine y creará las tablas necesarias en la base de datos.**

---

## **📌 Acceder a la Aplicación**

La API estará disponible en:

```plaintext
http://localhost:8020
```

Puedes acceder a **phpMyAdmin** para gestionar la base de datos:

```plaintext
http://localhost:8080
```
- **Usuario:** `user`
- **Contraseña:** `password`

---

## **📌 Pruebas Automatizadas**

Para ejecutar las pruebas con PHPUnit, usa:

```bash
make test
```

---

## **📌 Detener los Contenedores**

Si deseas detener el entorno de Docker, usa:

```bash
make stop
```

---

## **📌 Comandos de Makefile**

| **Comando**    | **Descripción**                                      |
| -------------- | ---------------------------------------------------- |
| `make install` | Instala las dependencias con Composer.               |
| `make start`   | Levanta los contenedores con Docker.                 |
| `make stop`    | Detiene todos los contenedores.                      |
| `make restart` | Reinicia los contenedores.                           |
| `make logs`    | Muestra los logs de los contenedores en tiempo real. |
| `make migrate` | Aplica las migraciones en la base de datos.          |
| `make test`    | Ejecuta las pruebas con PHPUnit.                     |

---

## **📌 Endpoints Disponibles**

| **Método** | **Endpoint**  | **Descripción**             |
| ---------- | ------------- | --------------------------- |
| **POST**   | `/register`   | Registra un nuevo usuario.  |
| **GET**    | `/users`      | Obtiene todos los usuarios. |
| **GET**    | `/users/{id}` | Obtiene un usuario por ID.  |
| **PUT**    | `/users/{id}` | Actualiza un usuario.       |
| **DELETE** | `/users/{id}` | Elimina un usuario.         |

---

## **📌 Contacto**

Si tienes dudas, contáctame en [GitHub](https://github.com/rrapa10).

👉 **¡Listo! Con este README, tu proyecto estará completamente documentado. 🚀**

