xliff-file-generator
====================

[XLIFF (XML Localisation Interchange File Format)](http://en.wikipedia.org/wiki/XLIFF) i18n files generator.

This project was created from the need to make the internationalization of [laborautonomo.org](http://laborautonomo.org) website, developed with Silex PHP micro-framework and Twig template language, which now has its content in Portuguese, English and Spanish.

### Requeriments

PHP 5.3 >=

Installation / Usage
--------------------

1. Run `git clone https://github.com/laborautonomo/xliff-file-generator.git`

2. The "generated" folder require 777 write permission 

3. Alter the `xliff-generator.php` configuration file

```php
$xliff_generator->setFolder('set_the_project_path_to_make_i18n');
$xliff_generator->setLanguages(array('pt_BR','en','es'));
$xliff_generator->setExtensions(array('php','twig'));

//this regex to search all words into "->trans(' ... ')" used in Silex Micro-Framework
$xliff_generator->addRegex("->trans\(['\"](.*)['\"]\)");

//this regex to search all words into "{' ... '|trans}" used in Twig Template Language
$xliff_generator->addRegex("\{ *['\"](.*)['\"] *\|trans\}");
```

Executing
---------

```sh
$ php xliff-generator.php
```

Virtaal to make translation
---------------------------

Virtaal is easy-to-use and powerful offline translation tool

### Using

1. Install Virtaal `# aptitude install virtaal` or use repository documentation [here](https://github.com/translate/virtaal)

2. Open Virtaal program and select the generated files with xliff-file-gerador  