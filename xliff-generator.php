<?php
require('xliff-generator.class.php');

try{
        
    $xliff_generator = new XliffGenerator();
    
    $xliff_generator->setFolder('/var/www/laborautonomo-site/');
    $xliff_generator->setLanguages(array('pt_BR','en','es'));
    $xliff_generator->setExtensions(array('php','twig'));
    $xliff_generator->addRegex("->trans\(['\"](.*)['\"]\)");
    $xliff_generator->addRegex("\{ *['\"](.*)['\"] *\|trans\}");
    
    $xliff_generator->generate();
    
} catch(Exception $e){
    
    echo "Erro code {$e->getCode()}: {$e->getMessage()}";
    
}