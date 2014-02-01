<?php

 namespace Lazer\Classes\Helpers;

use Lazer\Classes\LazerException;

if( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * File managing class
  *
  * @category Helpers
  * @author Grzegorz Kuźnik
  * @copyright (c) 2013, Grzegorz Kuźnik
  * @license http://opensource.org/licenses/MIT The MIT License
  */
 class File implements FileInterface {

     /**
      * File name
      * @var string
      */
     protected $name;

     /**
      * File type (data|config)
      * @var string
      */
     protected $type;

     public static function table($name)
     {
         $file = new File;
         $file->name = $name;

         return $file;
     }

     public final function setType($type)
     {
         $this->type = $type;
     }

     public final function getPath()
     {
         if (!empty($this->type))
         {
             return $this->data_path(LAZER_DATA_PATH).$this->name.'.'.$this->type.'.json';
         }
         else
         {
             throw new LazerException('You must specify the type of file in class: '.__);
         }
     }

     public final function get($assoc = false)
     {
         return json_decode(file_get_contents($this->getPath()), $assoc);
     }

     public final function put($data)
     {
         return file_put_contents($this->getPath(), json_encode($data));
     }

     public final function exists()
     {
         return file_exists($this->getPath());
     }

     public final function remove()
     {
         $type = ucfirst($this->type);
         if ($this->exists())
         {
             if (unlink($this->getPath()))
                 return TRUE;

             throw new LazerException($type.': Deleting failed');
         }

         throw new LazerException($type.': File does not exists');
     }

     function data_path($path='')
     {
         $dataPath = ( $path != '' ) ? DOCPATH . 'files' . DIRECTORY_SEPARATOR . '.' . $path . DIRECTORY_SEPARATOR : DOCPATH . 'files' . DIRECTORY_SEPARATOR . '.data' . DIRECTORY_SEPARATOR;

         if( ! file_exists($dataPath) )
         {
             if ( mkdir($dataPath, 0777, TRUE) ) {
                 /**
                 // Create index.html template
                 if( fopen($dataPath . 'index.html', 'w') )
                 {
                 $indexHTML = fopen($dataPath . 'index.html', 'w');

                 $indexHTMLcontent = "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
                 fwrite($indexHTML, $indexHTMLcontent);

                 fclose($indexHTML);
                 }
                 else {
                 log_message('ERROR', 'Could not open file.');
                 }
                  **/
                 // Create .htaccess for block direct access to *.json files
                 if( ! file_exists($dataPath . '.htaccess') ) {
                     $htaccessFile = fopen($dataPath . '.htaccess', 'w');

                     fwrite($htaccessFile, "<Files '*.json'>\r\n");
                     fwrite($htaccessFile, "Order Allow,Deny\r\n");
                     fwrite($htaccessFile, "Deny from all\r\n");
                     fwrite($htaccessFile, "</Files>\r\n");

                     fclose($htaccessFile);
                 }
                 else {
                     log_message('ERROR', 'Could not open file.');
                 }
             }
             else {
                 log_message('ERROR', 'Failed to create ' . $dataPath . ' folder');
             }
         }

         // log_message('ERROR', '#dataPath :: ' . $dataPath);

         return $dataPath;
     }
 }

