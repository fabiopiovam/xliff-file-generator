xliff-file-generator
====================

Generador de archivo de internacionalización (i18n) en formato [XLIFF (XML Localisation Interchange File Format)](http://en.wikipedia.org/wiki/XLIFF).

Este proyecto fue creado a partir de la necesidad de hacer la internacionalización del sitio [laborautonomo.org](http://laborautonomo.org) (desarrollado con PHP Silex micro-framework y Twig template language), que ahora tiene su contenido en Portugués, Inglés y Español.

### Requerimientos

PHP 5.3 >=

Instalación y Uso
-----------------

1. Ejecutar `git clone https://github.com/laborautonomo/xliff-file-generator.git`

2. Agregar permisos para escrita (777) en el directorio "generated" 

3. Cambiar el archivo de configuración `xliff-generator.php`

```php
$xliff_generator->setFolder('set_the_project_path_to_make_i18n');
$xliff_generator->setLanguages(array('pt_BR','en','es'));
$xliff_generator->setExtensions(array('php','twig'));

//this regex to search all words into "->trans(' ... ')" used in Silex Micro-Framework
$xliff_generator->addRegex("->trans\(['\"](.*)['\"]\)");

//this regex to search all words into "{' ... '|trans}" used in Twig Template Language
$xliff_generator->addRegex("\{ *['\"](.*)['\"] *\|trans\}");
```

### Ejecutando

```sh
$ php xliff-generator.php
```

### Virtaal para traducir los textos

Virtaal es una sencilla pero potente herramienta de traducción. Se puede encontrar [aquí](http://virtaal.translatehouse.org/)

#### Uso

1. Instale el programa Virtual `# aptitude install virtual` o utilice la documentación através del repositório [aqui](https://github.com/translate/virtaal)

2. Abrir el Virtaal y seleccione uno de los archivos generados por xliff-file-generador para traducir las frases