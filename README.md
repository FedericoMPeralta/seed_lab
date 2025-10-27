# SEED LAB - INASE

**Sistema de Gestión de Muestras de Semillas**

Seed Lab es una aplicación desarrollada en **CakePHP** para la gestión y análisis de muestras de semillas utilizada por **INASE**. Permite registrar muestras, cargar resultados de análisis y generar reportes detallados de manera cómoda y eficiente.

---

## Instalación en Linux

**Nota:** Este proceso de instalación está optimizado para sistemas basados en **Debian/Ubuntu** (Ubuntu, Linux Mint, Pop!_OS, etc.). Para otras distribuciones instala manualmente PHP 8.3, MySQL, y Composer.

### Paso 1: Obtener el código


Podés obtener el proyecto de dos formas:


#### Opción 1: Clonar el repositorio

Clona el proyecto usando **HTTPS** o **SSH**:

```bash
# HTTPS
git clone https://github.com/FedericoMPeralta/seed_lab.git

# SSH (si tenés configurada tu clave)
git clone git@github.com:FedericoMPeralta/seed_lab.git
```

Luego, ingresa al directorio del proyecto:

```bash
cd seed_lab
```

#### Opción 2: Descargar release

1. En Releases entrá en la release Seed_lab_beta o entrá al link: (https://github.com/FedericoMPeralta/seed_lab/releases/tag/0.1.0)
2. Descargá el archivo zip o tar.gz.
3. Descomprimilo en tu carpeta de trabajo.
4. Ingresá al directorio descomprimido:

```bash
cd seed_lab-0.1.0
```

### Paso 2: Instalar dependencias

Ejecuta el script de instalación que configura automáticamente el entorno:
```bash
./scripts/install_dependencies.sh
```

Este script instalará:

- PHP 8.3
- Composer
- MySQL
- Dependencias de CakePHP (ubicadas en `vendor/`)

### Paso 3: Crear la base de datos

Configura la base de datos inicial con el usuario `seed_dev` y los permisos necesarios:
```bash
./scripts/set_up_db.sh
```

---

## Desarrollo y Testing

### Ejecutar tests

Para correr todos los tests automáticos (controladores, modelos y vistas):
```bash
vendor/bin/phpunit
```

El entorno de tests utiliza la base de datos `seed_lab_db_test`, configurada en `config/app_local.php`.

### Iniciar el servidor local

Para levantar la aplicación:
```bash
bin/cake server
```

La aplicación estará disponible en: **[http://localhost:8765/](http://localhost:8765/)**

Para detener el servidor, presiona `Ctrl + C`.

---

## Interfaz de Usuario

### Página principal

Desde la página principal se puede acceder a:

- Gestión de Muestras
- Reportes
- Cargar nueva muestra
- Cargar nuevo resultado

### Gestión de Muestras

Permite visualizar y administrar las muestras registradas. Cada entrada muestra:

- Código de muestra
- Precinto
- Cantidad de resultados asociados

Al acceder al detalle de una muestra específica se puede:

- Editar o eliminar la muestra
- Agregar nuevos resultados para esa muestra
- Editar o eliminar resultados asociados a la muestra

### Reporte de Análisis de Muestras

Se puede visualizar todos los reportes con opciones para filtrar y ordenar:

**Filtros disponibles:**

- Por especie
- Por fecha de recepción de muestra
- Por fecha del resultado del reporte

**Ordenamiento:** Los datos del reporte pueden ordenarse según sus diferentes valores, haciendo click en los nombres de las columnas.

**Modos de visualización:**

- **Modo Resumen:** Muestra únicamente el resultado más reciente por cada muestra.
- **Modo Detallado:** Muestra todos los reportes registrados.