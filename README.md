# M&G Store — tienda en línea lista para usar

Tienda virtual en PHP (MVC propio) con panel de administración, catálogo con **variantes** (color, talla, medidas…),
carrito, pedidos, clientes, contactos, suscriptores, páginas editables y un módulo de **Configuración** donde se cambia
todo (nombre, contacto, correo, PayPal, moneda…) **sin editar archivos**.

🔗 **Demo en vivo:** https://mgstore.tecnosistemahn.com

Incluye un catálogo de ejemplo (5 productos por categoría con sus fotos) y pedidos/clientes **ficticios** para que veas cómo funciona.

## Requisitos
- PHP 8.3 o superior (probado en 8.3; compatible con 8.4) con las extensiones `pdo_mysql`, `mbstring`, `openssl`, `gd`, `fileinfo`
- MySQL 5.7+ / MariaDB 10.4+ (probado en MariaDB 10.11)
- Apache con `mod_rewrite` y `AllowOverride All` (en WAMP/XAMPP/cPanel ya viene así)

## Instalación (5 pasos)
1. Copia esta carpeta al servidor (por ejemplo `C:\wamp64\www\mgstore` o la carpeta de tu dominio).
2. Crea una base de datos vacía (utf8mb4) e impórtala con `database/tienda_catalogo.sql`.
3. Copia `Config/Config.example.php` como `Config/Config.php` y edita **solo** lo técnico:
   `BASE_URL` (la dirección de tu sitio, sin `/` al final), `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`
   y **`KEY`** (una frase larga y secreta; no la cambies después de instalar).
4. Abre tu sitio en el navegador. Para entrar al panel: `TU-SITIO/login`
   - Usuario: `admin@local.test`
   - Contraseña: `admin123`  → **cámbiala en el primer ingreso** (y el correo, en Usuarios).
5. En el panel entra a **Configuración** y escribe el nombre de tu tienda, teléfonos, WhatsApp, redes, correo y PayPal. Pulsa «Guardar».

## Qué cambiar para que sea tuyo
- **Configuración** (panel): datos de la tienda, contacto, redes, moneda, costo de envío, servidor de correo (con botón de prueba), PayPal (empieza en modo *sandbox*) y qué categorías salen en la portada.
- **Páginas** (panel): textos de «Nosotros», «Preguntas frecuentes», «Términos», «Sucursales», con tu información.
- **Categorías y Productos** (panel): borra los de ejemplo y sube los tuyos. En cada producto puedes crear **variantes** (talla, color…) con su propio stock y precio.
- **Pedidos, clientes, mensajes y suscriptores de ejemplo**: bórralos desde el panel antes de abrir al público.

## Seguridad (ya incluida)
Consultas preparadas contra inyección SQL, contraseñas con bcrypt y límite de intentos de login, protección CSRF, salida escapada contra XSS, subida de imágenes validada, cabeceras de seguridad y HTTPS forzado (excepto en `localhost`). Las contraseñas de correo y PayPal se guardan cifradas y no se muestran en el panel.
Recomendado: usa HTTPS, cambia la contraseña del administrador y mantén PHP actualizado.

## Estructura
`Controllers/ Models/ Views/` (MVC) · `Libraries/Core/` (núcleo) · `Assets/` (CSS, JS, imágenes) · `Config/` · `database/` (SQL y migraciones)

## Licencia
MIT — úsalo, modifícalo y véndelo libremente. Ver `LICENSE`.


## Créditos
Plantilla de la tienda basada en un diseño de Colorlib (ver pie de página). Hecho por **Inversiones N&G / TecnoSistemaHN**.
