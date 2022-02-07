Autor: Néstor Sánchez
Última fecha de actualización: 07/02/2022 14:07:50

********************* MOTIVO DE LA APLICACION *******************************************************************************************************************************************
La presente aplicación se ha realizado con el motivo de una Actividad Entregable para la asignatura de Desarrollo de Aplicaciones Web
del modulo de Desarrollo de Aplicaciones Web Online Semipresencial, en 2º curso.

El profesor o cliente que ha pedido la aplicación es Fernando, actual profesor de la asignatura.

La aplicacion consiste en una web donde los usuarios de un juego pueden subir las estadisticas conseguidas en el mismo, la apliacion actua como mediadora entra la bbdd que almacena tanto
las estadisticas subidas como otros datos relacionados con el usuario del juego y las muestra de forma dinamica.

********************* ESTRUCTURA Y CONTENIDO DE LA ENTREGA ******************************************************************************************************************************
La estructura de directorios es la siguiente:

-Directorio Principal
        -config                 **Archivos de configuracion de la bbdd, enrutamiento y variables de sesión.
        -public => index.php    **Archivo público por el cual se accede y donde se inicia el servidor
        -src                    **carpeta que contiene la logica de la aplicacion asi como la interaccion con la BBDD.
            +Controllers
            +Core
            +Entity
            +Repository
        -templates              **Direcotorio que contiene todos los archivos (.html) corresponientes a la vista de la aplicación.
        -vendor                 **Carpeta con las librerias auxiliares para usar Composer, Twig y Doctrine (tambien parte del Framework Symphony).

********************* PUESTA EN FUNCIONAMIENTO *******************************************************************************************************************************************
La aplicacion necesita:
    - Recomendable el uso de XAMP que contenga las siguientes versiones:
        - BBDD mysql, aunque no es requisito imprescindible y se puede modificar en config/dbConfig.json.
        - Servidor Apache 2.4.52 (recomendado, no imprescindible, puede funcionar con otras versiones de apache)
        - PHP 8.0.14 (IMPRESCINDIBLE el uso de esta versión).
    - Instalacion de Composer.
    - El archivo de Composer.json debe de incluir estas versiones para los siguientes softwares:
        - Twig version ^3.3
        - Doctrine version ^2.11
        - Symphony/cache version ^6.0
        - Doctrine/annotations version ^1.13


    !!##  COMANDOS necesarios para la puesta en funcionamiento ##!!





********************* LINKS ***************************************************************************************************************************************************************
Link a video explicativo:

Link a proyecto:

********************* Observaciones *******************************************************************************************************************************************************

Cuando ha habido ausencia de requisitos o explicaciones especificas sobre el desarrollo de alguna parte de la aplicación, esta se ha realizado de la forma más lógica posible bajo el punto de vista del desarrollador
atendiendo siempre al motivo y objetivo de la presente aplicación.
