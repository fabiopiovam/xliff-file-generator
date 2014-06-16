xliff-file-generator
====================

Gerador de arquivos de internacionalização (i18n) no formato [XLIFF (XML Localisation Interchange File Format)](http://en.wikipedia.org/wiki/XLIFF).

Este projeto foi criado a partir da necessidade de se fazer a internacionalização do site [laborautonomo.org](http://laborautonomo.org), desenvolvido com Silex PHP Micro-estrutura e linguagem de template Twig, que agora tem seu conteúdo em Português, Inglês e Espanhol.

### Requerimentos

PHP 5.3 >=

Uso e Instalação
----------------

1. Execute `git clone https://github.com/laborautonomo/xliff-file-generator.git`

2. Adicione permissão de escrita (777) ao diretório "generated" 

3. Altere o arquivo de configurações `xliff-generator.php`

```php
$xliff_generator->setFolder('set_the_project_path_to_make_i18n');
$xliff_generator->setLanguages(array('pt_BR','en','es'));
$xliff_generator->setExtensions(array('php','twig'));

//this regex to search all words into "->trans(' ... ')" used in Silex Micro-Framework
$xliff_generator->addRegex("->trans\(['\"](.*)['\"]\)");

//this regex to search all words into "{' ... '|trans}" used in Twig Template Language
$xliff_generator->addRegex("\{ *['\"](.*)['\"] *\|trans\}");
```

Executando
----------

```sh
$ php xliff-generator.php
```

Virtaal para traduzir os textos
-------------------------------

Virtaal é uma simples e poderosa ferramenta de tradução

### Uso

1. Instale o programa Virtaal `# aptitude install virtaal` ou utilize a documentação através do repositório [aqui](https://github.com/translate/virtaal)

2. Abra o Virtaal e selecione um dos arquivos gerados pelo xliff-file-gerador para traduzir as frases  