#!/bin/bash

echo "🚀 Iniciando Docker..."
docker-compose up --build -d

echo "⏳ Esperando a que los contenedores estén listos..."
sleep 5  # Espera 5 segundos para asegurarse de que todo esté arriba

echo "🔄 Ejecutando migraciones..."
docker exec -it php_app php cli-config.php orm:schema-tool:update --force

echo "✅ Listo! La API está corriendo en http://localhost:8020"
