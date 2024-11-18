<div align="center">
  
  # Calificar Series
</div>

<div align="center">
  <img src="https://raw.githubusercontent.com/bnphony/ListaComentada/deployed/img/general.PNG" width="80%" alt="Configuration Panel">

  ![GitHub](https://img.shields.io/github/last-commit/bnphony/Calificar-Series)
  [![PHP](https://img.shields.io/badge/Code-PHP-4f5b93)](https://www.php.net/manual/es/intro-whatis.php)
  [![mysql](https://img.shields.io/badge/DB-mysql-3e6e93)](https://www.mysql.com/)
  [![Apache](https://img.shields.io/badge/WebServer-Apache-d64232)](https://httpd.apache.org/)  
  [![JavaScript](https://img.shields.io/badge/Code-JavaSript-orange)](https://developer.mozilla.org/es/docs/Web/JavaScript)
  [![JQuery](https://img.shields.io/badge/Code-JQuery-0769ad)](https://jquery.com/)  
  
  
 
</div>

## Indice
- [Convertir lista simple en TOP](#convertir-lista-simple-en-top)
  - [Descripción](#descripción)
     - [Tecnologías](#tecnologías)
  - [Dominio](#dominio)
     - [Configuración](#configuración)
     - [Lista Simple](#lista-simple)
     - [Lista Comentada](#lista-comentada)
  - [Funciones](#funciones)
     - [Sitio de la Aplicación Web](#sitio-de-la-aplicación-web)
  - [Autor](#autor)
     - [Contacto](#contacto)
  - [Licencia de Uso](#licencia-de-uso)
 
## Descripción
Sistema para la valoración de series o películas, permite categorizarlas y calificar cada uno de sus capítulos. Funciones Principales:
- Crear una cuenta de usuario, iniciar sesión y acceder al sistema, resetear la contraseña.
- CREATE, LIST, UPDATE, DELETE categorias.
- CREATE, LIST, UPDATE, DELETE series/películas.
- CREATE, LIST, UPDATE, DELETE capítulos de series.
- Descargar archivo JSON de los datos de una categoría.
- Subir  datos de series/películas en una categoría utilizando archivo JSON.
- Mostar un grafico de barras con el ranking de series/películos.
- Descargar el ranking de series/películas.

   
### Tecnologías

- Lenguaje del lado del servidor: [PHP](https://www.php.net/manual/es/intro-whatis.php) - Permite desarrollar aplicaciones web, se puede incrustar dentro de elementos HTML.
- Interacción con la Interfaz: [Java](https://www.java.com/es/) y [JQuery](https://jquery.com/) - Agregar comportamiento a los componentes de la UI.
- Cuadros de Confirmación: [jquery-confirm](https://craftpip.github.io/jquery-confirm/) - Cuadros de dialogos animados para confirmar procesos.
- Iconos: [Font Awesome](https://fontawesome.com/) - Mejorar la experiencia de usuario.
- Framework de Diseño: [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/) - Facilitar una interfaz agradable y responsiva.
- Visualización e interacción con gráficos: [D3js](https://d3js.org/) - Facilitar la creación de graficos interactivos utilizando elementos vectoriales.
  
## Dominio

Gestionar categorias, series/películas, episodios, generar graficos interactivos, reportes.
- Un usuario puede crearse una cuenta, iniciar sesión, restablecer su contraseña utilizando su email.
- Un usuario puede crear, actualizar, listar o eliminar categorías.
- Un usuario puede generar reportes de las valoraciones de series/peliculas por categoría.
- Una categoría tiene 0 o mas series/películas.
- Una serie tiene 0 o mas episodios.
- Un episodio tiene una imagen, descripción, valoración.

### Categoría

| Campo      | Tipo    | Descripción             |
|------------|---------|-------------------------|
| id         | UUID    | Identificador único     |
| nombre     | Varchar | Nombre de la Categoría  |
| fk_usuario | Usuario | Usuario de la Categoría |

### Serie

| Campo        | Tipo      | Descripción           |
|--------------|-----------|-----------------------|
| id           | UUID      | Identificar único     |
| nombre       | Varchar   | Nombre de la Serie    |
| logo         | Varchar   | Logo de la Serie      |
| fk_categoría | Categoría | Categoría de la Serie |

### Episodio

| Campo       | Tipo    | Descripción              |
|-------------|---------|--------------------------|
| id          | UUID    | Identificar único        |
| titulo      | Varchar | Título del Episodio      |
| imagen      | Varchar | Imagen del Episodio      |
| descripcion | Varchar | Descripción del Episodio |
| fk_serie    | Serie   | Serie del Episodio       |
| value       | Int     | Número del Episodo       |

### Usuario

| Campo            | Tipo     | Descripción                 |
|------------------|----------|-----------------------------|
| id               | UUID     | Identificador único         |
| Usuario          | Varchar  | Nombre del Usuario          |
| Password         | Varchar  | Contraseña del Usuario      |
| Estado           | Varchar  | Estado Actual del Usuario   |
| Token            | Varchar  | Token de Acceso del Usuario |
| Token_Expires_At | DateTime | Fecha de Límite del Token   |

### Usuario Token

| Campo     | Tipo     | Descripción       |
|-----------|----------|-------------------|
| TokenId   | UUID     | Identificar único |
| UsuarioId | Usuario  | Usuario del Token |
| Token     | Varchar  | Token del Usuario |
| Estado    | Varchar  | Estado del Token  |
| Fecha     | DateTime | Fecha del Token   |

## Funciones
<table>
  <tr>
    <td witdh="100%">
      <h3 align="center">Panel de Configuración</h3>
      <div align="center">
        <img src="https://raw.githubusercontent.com/bnphony/ListaComentada/deployed/img/configuration.PNG" width="80%" alt="Configuration Panel">
        <p>
          - Opciones de Configuración: Tipo de Bordes, Dimensiones de pantalla recomendados, Enumerar las líneas, Alinear el contenido.
        </p>
      </div>
    </td>
    
  </tr>
  
  <tr>
    <td witdh="100%">
      <h3 align="center">Lista Simple</h3>
      <div align="center">
        <img src="https://raw.githubusercontent.com/bnphony/ListaComentada/deployed/img/list_input.PNG" width="80%" alt="List Input">
        <p>
          - Se puede ingresar cualquier texto, pero cada línea se considera un elemento del ranking final.
        </p>
      </div>
    </td>
  </tr>

  
  <tr>
    <td witdh="100%">
      <h3 align="center">Lista Resultado</h3>
      <div align="center">
        <img src="https://raw.githubusercontent.com/bnphony/ListaComentada/deployed/img/list_output.PNG" width="80%" alt="List Output">
        <p>
          - Ranking Final con todas las configuraciones aplicadas.
        </p>
      </div>
    </td>
  </tr>
</table>

### Sitio de la Aplicación Web

[Link de la aplicación](https://bnphony.github.io/ListaComentada/)



## Autor
Codificado por [Bryan Jhoel Tarco Taipe](https://github.com/bnphony)

### Contacto
<a href="https://www.linkedin.com/in/bryan-tarco01" rel="noopener noreferrer" target="_blank">
  <img align="center" src="https://github.com/bnphony/Portafolio/blob/deployed/static/img/linkedin_icon.png" alt="LinkedIn" height="40" width="40" />
</a>
<a href="https://github.com/bnphony" rel="noopener noreferrer" target="blank">
  <img align="center" src="https://github.com/bnphony/Portafolio/blob/deployed/static/img/github_icon.png" alt="GitHub" height="40" width="40" />
</a>
<a href="mailto: bryan.tarco01@gmail.com" target="_blank">
  <img align="center" src="https://github.com/bnphony/Portafolio/blob/deployed/static/img/email_icon.png" alt="Email" height="40" width="40" />
</a>



## Licencia de Uso
Este repositorio y todo su contenido está licenciado bajo licencia **Creative Commons**. Por favor si compartes, usas o modificas este proyecto cita a su
autor, y usa las mismas condiciones para su uso docente, formativo o educativo y no comercial.
