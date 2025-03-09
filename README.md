# 🛠️ Prueba Técnica PHP 🚀

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
- **Windows:** Se recomienda usar [Git Bash](https://git-scm.com/downloads) o [WSL](https://learn.microsoft.com/en-us/windows/wsl/install).  

---

## **📌 Instalación y Ejecución 🚀**  

### **🔹 Paso 1: Clonar el repositorio**  
```bash
git clone https://github.com/TU-USUARIO/prueba-tecnica-php.git
cd prueba-tecnica-php
```

### **🔹 Paso 2: Dar permisos al script (Solo en Linux/macOS)**  
Si usas **Linux o macOS**, ejecuta este comando para dar permisos de ejecución:  
```bash
chmod +x start.sh
```

### **🔹 Paso 3: Iniciar el entorno con Docker**  
Ejecuta el siguiente comando según tu sistema operativo:  

🔹 **En Linux/macOS:**  
```bash
./start.sh
```

🔹 **En Windows (Git Bash o WSL):**  
```bash
bash start.sh
```

📌 **Esto iniciará Docker, esperará que los contenedores se inicien y aplicará las migraciones de la base de datos automáticamente.**  

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
Para ejecutar las pruebas con PHPUnit, usa este comando:  
```bash
docker exec -it php_app vendor/bin/phpunit
```

---

## **📌 Detener los Contenedores**  
Si deseas detener el entorno de Docker, usa:  

🔹 **En Linux/macOS:**  
```bash
./stop.sh
```

🔹 **En Windows (Git Bash o WSL):**  
```bash
bash stop.sh
```

---

## **📌 Comandos Ú tiles**  

| **Comando**                 | **Descripción** |
|-----------------------------|----------------|
| `./start.sh` (o `bash start.sh`) | Levanta los contenedores con Docker. |
| `./stop.sh` (o `bash stop.sh`)   | Detiene todos los contenedores. |
| `docker-compose logs -f`    | Muestra los logs en tiempo real. |
| `docker exec -it php_app vendor/bin/phpunit` | Ejecuta las pruebas con PHPUnit. |
| `docker exec -it php_app php vendor/bin/doctrine orm:schema-tool:update --force` | Aplica migraciones de Doctrine. |

---

## **📌 Endpoints Disponibles**  

| **Método** | **Endpoint**         | **Descripción**                |
|------------|----------------------|--------------------------------|
| **POST**   | `/register`          | Registra un nuevo usuario.     |
| **GET**    | `/users`             | Obtiene todos los usuarios.    |
| **GET**    | `/users/{id}`        | Obtiene un usuario por ID.     |
| **PUT**    | `/users/{id}`        | Actualiza un usuario.          |
| **DELETE** | `/users/{id}`        | Elimina un usuario.            |

---

## **📌 Contacto**  
Si tienes dudas, contáctame en [GitHub](https://github.com/TU-USUARIO).  

👉 **¡Listo! Con este README, tu proyecto estará completamente documentado. 🚀**  

