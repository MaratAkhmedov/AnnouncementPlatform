<?php
/**
 * Created by PhpStorm.
 * User: igugl
 * Date: 14/07/2019
 * Time: 12:14
 */
use Illuminate\Http\Request;


class FileHelper
{
    protected $validate_extension;
    protected $request;

     public function __construct(Request $request)
     {
         $this->request = $request;
     }

    /**
     * @param $extensionSupported array with extensions that are supported
     * @param $fileName string with name of the file that we want validate
     * @return bool
     */
     public function validateExtension($extensionSupported, $fileName){
             $files = $this->request->file("$fileName");
             if(is_array($files)){
                 foreach ($files as $file){
                     $extension = $file->getClientOriginalExtension();
                     $compatible = in_array($extension,$extensionSupported);
                 }
                 return $compatible;
             }else{
                 $extension = $files->getClientOriginalExtension();
                 $compatible = in_array($extension,$extensionSupported);
                 return $compatible;
             }

    }
}