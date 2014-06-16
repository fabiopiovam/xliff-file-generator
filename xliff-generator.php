<?php
require('xliff-generator.class.php');

try{
        
    $xliff_generator = new XliffGenerator();
    
    $xliff_generator->setFolder('set_the_project_path_to_make_i18n');
    $xliff_generator->setLanguages(array('pt_BR','en','es'));
    $xliff_generator->setExtensions(array('php','twig'));
    
    //this regex to search all words into "->trans(' ... ')" used in Silex Micro-Framework
    $xliff_generator->addRegex("->trans\(['\"](.*)['\"]\)");
    
    //this regex to search all words into "{' ... '|trans}" used in Twig Template Language
    $xliff_generator->addRegex("\{ *['\"](.*)['\"] *\|trans\}");
    
    $xliff_generator->generate();
    
} catch(Exception $e){
    
    echo "Erro code {$e->getCode()}: {$e->getMessage()}";
    
}