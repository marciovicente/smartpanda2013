<?php
/**
* Identifica o sistema operacional do servidor, considerando que pode
  ser Windows ou Linux.
*/
$operatingSystem = stripos($_SERVER['SERVER_SOFTWARE'],'win32')!== FALSE ? 'WINDOWS' :
    'LINUX';
$bar = $operatingSystem == 'WINDOWS' ? '\\' : '/';
$pathSeparator = $operatingSystem == 'WINDOWS' ? ';' : ':';
$documentRoot = $operatingSystem == 'WINDOWS' ? str_replace('/','\\',$_SERVER['DOCUMENT_
    ROOT']) : $_SERVER['DOCUMENT_ROOT'];
/**
* Configura o caminho a ser procurado em todos os includes.
* Irá procurar no diretório ../library, no application/models
* e no caminho original do PHP.
* É interessante utilizar set_include_path para definir onde se
* encontram todos os arquivos do projeto, pois assim se evita que o
* mesmo código seja escrito várias vezes, gerando menos linhas e
* facilitando qualquer alteração de path.
*/
$path = $pathSeparator.$documentRoot.$bar.'library';
$path .= $pathSeparator.$documentRoot.$bar.basename(getcwd()).$bar.'application'.$bar.'models';
set_include_path(get_include_path().$path);
?>
