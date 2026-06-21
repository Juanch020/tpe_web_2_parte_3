# TPE WEB 2 - Parte 3

## API REST - Sistema de Gestión de Equipos y Jugadores

### Alumno

* Juan Ignacio Arballo
* DNI: 46825856
* Email: [jiarballo6@gmail.com](mailto:jiarballo6@gmail.com)

# Descripción

Esta entrega consiste en la implementación de una API REST para el sistema de gestión de equipos y jugadores desarrollado en las entregas anteriores.

La API permite consultar, agregar, modificar y eliminar información relacionada con:

* Jugadores
* Equipos
* Posiciones

Además, incorpora funcionalidades adicionales:

* Autenticación mediante JWT
* Filtrado de resultados
* Ordenamiento ascendente y descendente
* Paginación
* Protección de rutas mediante token

# Tecnologías utilizadas

* PHP
* MySQL
* Apache (XAMPP)
* JWT (JSON Web Token)
* Postman para pruebas de la API

# Cambios realizados respecto a la Parte 2

Para esta entrega desarrolle una API REST independiente del frontend MVC realizado anteriormente.

Se agregaron:

* Controladores específicos para la API.
* Modelos reutilizados para el acceso a datos.
* Sistema de autenticación JWT.
* Middleware para validación de tokens.
* Sistema de filtrado de jugadores.
* Sistema de ordenamiento dinámico.
* Sistema de paginación.
* Respuestas JSON con códigos HTTP apropiados.
* Archivo `.htaccess` para garantizar el correcto funcionamiento de las peticiones realizadas desde Postman.

# Instalación

1. Clonar el repositorio.

2. Importar la base de datos:

```sql
equipo_de_futbol.sql
```

3. Configurar credenciales de acceso en:

```php
config.php
```

4. Iniciar Apache y MySQL desde XAMPP.

5. Acceder a la API mediante:

```text
http://localhost/tpe_parte_3_2026/api_router.php
```

# Autenticación JWT

## Login

### Endpoint

```http
POST /api_router.php?resource=auth/login
```

### Body

```json
{
    "username": "webadmin",
    "password": "admin"
}
```

### Respuesta

```json
{
    "message": "Login exitoso",
    "token": "JWT_GENERADO"
}
```

## Uso del token

Las rutas protegidas requieren el header:

```http
Authorization: Bearer TOKEN
```

# Endpoints públicos

## Jugadores

### Obtener todos los jugadores

```http
GET /api_router.php?resource=jugadores
```

### Obtener jugador por ID

```http
GET /api_router.php?resource=jugadores/1
```

## Equipos

### Obtener todos los equipos

```http
GET /api_router.php?resource=equipos
```

### Obtener equipo por ID

```http
GET /api_router.php?resource=equipos/1
```

## Posiciones

### Obtener todas las posiciones

```http
GET /api_router.php?resource=posiciones
```

### Obtener posición por ID

```http
GET /api_router.php?resource=posiciones/1
```

# Filtrado

Disponible para jugadores.

### Ejemplo

```http
GET /api_router.php?resource=jugadores&filterField=id_equipo&filterValue=1
```

### Campos permitidos

* nombre
* precio
* id_equipo
* id_posicion

# Ordenamiento

Disponible para jugadores.

### Ascendente

```http
GET /api_router.php?resource=jugadores&sort=precio&order=ASC
```

### Descendente

```http
GET /api_router.php?resource=jugadores&sort=id&order=DESC
```

### Campos permitidos

* id
* nombre
* precio
* id_equipo
* id_posicion

# Paginación

Disponible para jugadores.

### Página 1

```http
GET /api_router.php?resource=jugadores&page=1&limit=3
```

### Página 2

```http
GET /api_router.php?resource=jugadores&page=2&limit=3
```

### Parámetros

* page → número de página
* limit → cantidad de elementos por página

# Endpoints protegidos

## Jugadores

### Crear jugador

```http
POST /api_router.php?resource=jugadores
```

```json
{
    "nombre":"messi",
    "precio":5000000,
    "id_equipo":2,
    "id_posicion":4
}
```

### Modificar jugador

```http
PUT /api_router.php?resource=jugadores/4
```

```json
{
    "nombre":"leonel messi",
    "precio":9000000,
    "id_equipo":2,
    "id_posicion":4,
    "foto": null
}
```

### Eliminar jugador

```http
DELETE /api_router.php?resource=jugadores/4
```

## Equipos

### Crear equipo

```http
POST /api_router.php?resource=equipos
```

```json
{
    "nombre":"Boca Juniors",
    "descripcion":"Equipo de prueba",
    "fecha_creacion":"1905-04-03",
    "foto": null
}
```

### Modificar equipo

```http
PUT /api_router.php?resource=equipos/1
```

```json
{
    "nombre":"Boca Juniors",
    "descripcion":"Equipo actualizado",
    "fecha_creacion":"1905-04-03",
    "foto": null
}
```

### Eliminar equipo

```http
DELETE /api_router.php?resource=equipos/1
```

## Posiciones

### Crear posición

```http
POST /api_router.php?resource=posiciones
```

```json
{
    "nombre":"Arquero reserva"
}
```

### Modificar posición

```http
PUT /api_router.php?resource=posiciones/1
```

```json
{
    "nombre":"Arquero Elite"
}
```

### Eliminar posición

```http
DELETE /api_router.php?resource=posiciones/1
```

# Códigos de respuesta

Códigos:
- 200: Operación exitosa
- 201: Recurso creado correctamente
- 204: Recurso eliminado correctamente
- 400: Solicitud inválida
- 401: No autorizado
- 404: Recurso no encontrado

# Consideraciones

* No se puede eliminar equipos con jugadores asociados.
* No se pude eliminar posiciones con jugadores asociados.
* Las operaciones POST, PUT y DELETE requieren autenticación JWT.
