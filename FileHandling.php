<?php
    class FileHandling{
        public $fileUploadSuccess=true;
        public $fileUploadFail=1;
        public $largeFile = 2;
        public $invalidExtension = 3;
        protected function error($text){
            $error .= "<br><br>Please refer to the docs<br><br>";
            $error .= "SYNTAX ERROR::".$text."<br>";
            echo $error;
        }

        function FileHandling(){
            ini_set('file_uploads','on');
        }
        //uploads file to the server
        //upload(str tagname,str filename,str extension,int size,array allowedExtensions)
        //upload(str tagname,str filename,int size,str extension)
        //upload(str tagname,str filename,int size,array allowedExtensions)
        //upload(str tagname,str filename,str extension,array allowedExtensions)
        //upload(str tagname,str filename,str extension)
        //upload(str tagname,str filename,int size)
        //upload(str tagname,str filename,array allowedExtensions)
        //upload(str tagname,str filename)
        //upload(str tagname)
        function upload(){
            $args = func_get_args();
            $cnt = count($args);
            $tagname = $args[0];
            if($cnt==5){
                $file = $args[1];
                $ext = strtolower(pathinfo(files($tagname,'name'),PATHINFO_EXTENSION));
                $size = $args[3];
                $allExt = $args[4];
                $filename = $file.'.'.$args[2];
                $accept=false;

                foreach($allExt as $check){
                    if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                        $accept=true;
                    }
                }

                if($accept==true){
                    if(files($tagname,'size')<=($size*1000000)){
                       return $this->upload($tagname,$filename);
                    }
                    else{
                        return $this->largeFile;
                    }
                }
                else{
                    return $this->invalidExtension;
                }
            }
            elseif($cnt==4){
                $file = $args[1];
                if(is_int($args[2])){
                    $size = $args[2];
                    if(is_string($args[3])){
                        $filename = $file.'.'.$args[3];
                        if(files($tagname,'size')<=($size*1000000)){
                            return $this->upload($tagname,$filename);
                        }
                        else{
                            return $this->largeFile;
                        }
                    }
                    elseif(is_array($args[3])){
                        $ext = strtolower(pathinfo(files($tagname,'name'),PATHINFO_EXTENSION));
                        $allExt = $args[3];
                        $filename = $file.'.'.$ext;
                        $accept=false;

                        foreach($allExt as $check){

                            if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                                $accept=true;
                            }
                        }

                        if($accept==true){
                            if(files($tagname,'size')<=($size*1000000)){
                               return $this->upload($tagname,$filename);
                            }
                            else{
                                return $this->largeFile;
                            }
                        }
                        else{
                            return $this->invalidExtension;
                        }
                    }
                    else{
                        $this->error("invalid Parameters");
                    }
                }
                elseif(is_string($args[2])){
                    $ext = strtolower(pathinfo(files($tagname,'name'),PATHINFO_EXTENSION));
                    $allExt = $args[3];
                    $filename = $file.'.'.$args[2];
                    $accept=false;

                    foreach($allExt as $check){
                        if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                            $accept=true;
                        }
                    }

                    if($accept==true){
                       return $this->upload($tagname,$filename);
                    }
                    else{
                        return $this->invalidExtension;
                    }
                }
}
            elseif($cnt==3){
                $file = $args[1];
                if(is_int($args[2])){
                    $ext = strtolower(pathinfo(files($tagname,'name'),PATHINFO_EXTENSION));
                    $size = $args[2];
                    $filename = $file.'.'.$ext;
                    if(files($tagname,'size')<=($size*1000000)){
                       return $this->upload($tagname,$filename);
                    }
                    else{
                        return $this->largeFile;
                    }
}
                elseif(is_string($args[2])){
                    $filename = $file.'.'.$args[2];
                   return $this->upload($tagname,$filename);
}
                elseif(is_array($args[2])){
                    $ext = strtolower(pathinfo(files($tagname,'name'),PATHINFO_EXTENSION));
                    $allExt = $args[2];
                    $filename = $file.'.'.$ext;
                    $accept=false;

                    foreach($allExt as $check){
                        if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                            $accept=true;
                        }
                    }

                    if($accept==true){
                       return $this->upload($tagname,$filename);
                    }
                    else{
                        return $this->invalidExtension;
                    }
}
                else{
                    $this->error("Invalid Parameters");
                }
            }
            elseif($cnt==2){
                $filename = $args[1];
                if (move_uploaded_file(files($tagname,'tmp_name'), $filename)) {
                    return $this->fileUploadSuccess;
                } else {
                    return $this->fileUploadFail;
                }
            }
            elseif($cnt==1){
                $this->upload($tagname,files($tagname,'tmp_name'));
            }
            else{
                $this->error("Invalid parameter passed");
}
        }
        //uploads multi files to the server
        //uploadMultiple(array tagname,str filename,str extension,int size,array allowedExtensions)
        //uploadMultiple(array tagname,str filename,int size,str extension)
        //uploadMultiple(array tagname,str filename,int size,array allowedExtensions)
        //uploadMultiple(array tagname,str filename,str extension,array allowedExtensions)
        //uploadMultiple(array tagname,str filename,str extension)
        //uploadMultiple(array tagname,str filename,int size)
        //uploadMultiple(array tagname,str filename,array allowedExtensions)
        //uploadMultiple(array tagname,str filename)
        //uploadMultiple(array tagname)
        function uploadMultiple(){
            $args = func_get_args();
            $cnt = count($args);
            $tagname = $args[0];
            $tagcount = count(files($tagname,'name'));
            $return = array();
            if($cnt==5){
                $file = $args[1];
                $size = $args[3];
                $allExt = $args[4];
                for($i=0;$i<$tagcount;$i++){
                    $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                    $filename = $file.$i.'.'.$args[2];
                    $accept=false;
                    
                    foreach($allExt as $check){
                        if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                            $accept=true;
                        }
                    }   
                    
                    if($accept==true){
                        if(files($tagname,'size',$i)<=($size*1000000)){
                            $this->uploadMultiple($tagname,$filename,$i,true);
                        }
                        else{
                            $return[count($return)-1] = $this->largeFile;
                        }
                    }
                    else{
                        $return[count($return)-1] = $this->invalidExtension;
                    }
                }
            }
            elseif($cnt==4){
                $file = $args[1];
                if(is_bool($args[3])){
                    $filename = $args[1];
                    $index = $args[2];
                    if (move_uploaded_file(files($tagname,"tmp_name",$index), $filename)) {
                        $return[count($return)-1] = $this->fileUploadSuccess;
                    } else {
                        $return[count($return)-1] = $this->fileUploadFail;
                    }
                }
                elseif(is_int($args[2])){
                    $size = $args[2];
                    if(is_string($args[3])){
                        for($i=0;$i<$tagcount;$i++){
                            $filename = $file.$i.'.'.$args[3];
                            if(files($tagname,'size',$i)<=($size*1000000)){
                                $this->uploadMultiple($tagname,$filename,$i,true);
                            }
                            else{
                                $return[count($return)-1] = $this->largeFile;
                            }
                        }
                    }
                    elseif(is_array($args[3])){
                        $allExt = $args[3];
                        for($i=0;$i<$tagcount;$i++){
                            $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                            $filename = $file.$i.'.'.$ext;
                            $accept=false;

                            foreach($allExt as $check){
                                if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                                    $accept=true;
                                }
                            }   

                            if($accept==true){
                                if(files($tagname,'size',$i)<=($size*1000000)){
                                    $this->uploadMultiple($tagname,$filename,$i,true);
                                }
                                else{
                                    $return[count($return)-1] = $this->largeFile;
                                }
                            }
                            else{
                                $return[count($return)-1] = $this->invalidExtension;
                            }
                        }
                    }
                    else{
                        $this->error("Invalid Parameters");
                    }
                }
                elseif(is_string($args[2])){
                    $allExt = $args[3];
                    for($i=0;$i<$tagcount;$i++){
                        $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                        $filename = $file.$i.'.'.$args[2];
                        $accept=false;

                        foreach($allExt as $check){
                            if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                                $accept=true;
                            }
                        }   

                        if($accept==true){
                            $this->uploadMultiple($tagname,$filename,$i,true);
                        }
                        else{
                            $return[count($return)-1] = $this->invalidExtension;
                        }
                    }
                }
                else{
                    $this->error("Invalid parameters");
                }
            }
            elseif($cnt==3){
                if(is_string($args[2])){
                    $file = $args[1];
                    for($i=0;$i<$tagcount;$i++){
                        $filename = $file.$i.'.'.$args[2];
                        $this->uploadMultiple($tagname,$filename,$i,true);
                    }
                }
                elseif(is_int($args[2])){
                    $file = $args[1];
                    $size = $args[2];
                    for($i=0;$i<$tagcount;$i++){
                        $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                        $filename = $file.$i.'.'.$ext;
                        if(files($tagname,'size',$i)<=($size*1000000)){
                            $this->uploadMultiple($tagname,$filename,$i,true);
                        }
                        else{
                            $return[count($return)-1] = $this->largeFile;
                        }
                    }
                }
                elseif(is_array($args[2])){
                    $file = $args[1];
                    $allExt = $args[2];
                    for($i=0;$i<$tagcount;$i++){
                        $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                        $filename = $file.$i.'.'.$ext;
                        $accept=false;

                        foreach($allExt as $check){
                            if($ext==strtolower($check) || ('.'.$ext)==strtolower($check)){
                                $accept=true;
                            }
                        }   

                        if($accept==true){
                            $this->uploadMultiple($tagname,$filename,$i,true);
                        }
                        else{
                            $return[count($return)-1] = $this->invalidExtension;
                        }
                    }
                }
                else{
                    $this->error("Invalid Parameters");
                }
            }
            elseif($cnt==2){
                $file = $args[1];
                for($i=0;$i<$tagcount;$i++){
                    $ext = strtolower(pathinfo(files($tagname,'name',$i),PATHINFO_EXTENSION));
                    $filename = $file.$i.'.'.$ext;
                    $this->uploadMultiple($tagname,$filename,$i,true);
                }
            }
            elseif($cnt==1){
                for($i=0;$i<$tagcount;$i++){
                    $filename = files($tagname,"tmp_name",$i);
                    $this->uploadMultiple($tagname,$filename,$i,true);
                }
            }
            else{
                $this->error("Invalid Parameters");
            }
            return $return;
        }
        
        function files(){
            $data = "";
            $readModes = array('r','r+');
            $writeModes = array('w','a','x','w+','a+','x+');
            $args = func_get_args();
            $count=count($args);
            $filename = $args[0];
            if(is_string($filename)){
                if($count==1){
                    //function file($filename){}
                    $data = readfile($filename);
                }
                elseif($count==2){
                    //function file($filename,$mode){}
                    $mode = strtolower($args[1]);
                    if(in_array($mode,$readModes)){
                        $data = $this->fileRead($filename,$mode,null);
                    }
                    elseif(in_array($mode,$writeModes)){
                        $data = $this->fileWrite($filename,$mode,null);
                    }
                    else{
                        $this->error("file mode not recognized");
                    }
                }
                elseif($count==3){
                    $mode = strtolower($args[1]);
                    $lineNo = $args[2];
                    $text = $args[2];
                    //function file($filename,$mode,$lineNo){}
                    if(in_array($mode,$readModes)){
                        return $this->fileRead($filename,$mode,$lineNo);
                    }
                    //function file($filename,$mode,$text){}
                    elseif(in_array($mode,$writeModes)){
                        return $this->fileWrite($filename,$mode,$text);
                    }
                    else{
                        $this->error("file mode not recognized");
                    }
                }
                elseif($count==4){
                    $mode = strtolower($args[1]);
                    $length = $args[2];
                    $readChar = $args[3];
                    //function file($filename,$mode,index,bool $readChars){}
                    if(in_array($mode,$readModes) && is_bool($readChar) && $readChar){
                        return $this->fileCharRead($filename,$length);
                    }
                    else{
                        $this->error("file mode not recognized for reading characters");
                    }
                }
                else{
                    $this->error("Invalid Parameters passed");
                }
            }
            elseif(is_array($filename)){
                if($count==1){
                    //function file(array $filename){}
                    $data = "";
                    for($i=0;$i<count($filename);$i++){
                        $data .= readfile($filename[$i])."<br>";
                    }
                    return $data;
                }
                elseif($count==2){
                    $mode = $args[1];
                    //function file(array $filename,$mode);
                    if(!is_array($mode)){
                        for($i=0;$i<count($filename);$i++){
                            if(in_array($mode,$readModes)){
                                $data .= $this->fileRead($filename[$i],$mode,null);
                            }
                            elseif(in_array($mode,$writeModes)){
                                $data .= $this->fileWrite($filename[$i],$mode,null);
                            }
                            else{
                                $this->error("Unrecogized File mode to access file:Unable To access using:".$mode);
                            }
                        }
                    }
                    //function file(array $filename,array $mode);
                    else{
                        if(count($filename)==count($mode)){
                            for($i=0;$i<count($modes);$i++){
                                if(in_array($mode,$readModes)){
                                    $data .= $this->fileRead($filename[$i],$mode[$i],null);
                                }
                                elseif(in_array($mode,$writeModes)){
                                    $data .= $this->fileWrite($filename[$i],$mode[$i],null);
                                }
                                else{
                                    $this->error("Unrecogized File mode to access file:Unable To access using:".$mode[$i]);
                                }
                            }
                        }
                        else{
                            $this-error("unequal arrays passed for file access");
                        }
                    }
                }
                elseif($count==3){
                    $mode=$args[1];
                    $var=$args[2];
                    if(is_array($mode)){
                        if(is_array($var)){
                            if(count($filename)==count($mode) && count($mode)==count($var)){
                                for($i=0;$i<count($filename);$i++){
                                    //function file(array $filename,array $mode,array $index){}
                                    if(in_array($mode[$i],$readModes)){
                                        $data .= $this->fileRead($filename[$i],$mode[$i],$var[$i]);
                                    }
                                    //function file(array $filename,array $mode,array $text){}
                                    elseif(in_array($mode[$i],$writeModes)){
                                        $data .= $this->fileWrite($filename[$i],$mode[$i],$var[$i]);
                                    }
                                    else{
                                        $this->error($mode[$i]." Not Recognized to execute");
                                    }
                                }
                            }
                            else{
                                $this->error("indexes of arrays passed not equal");
                            }
                        }
                        else{
                            if(count($filename)==count($mode)){
                                for($i=0;$i<count($filename);$i++){
                                    //function file(array $filename,array $mode,$index){}
                                    if(in_array($mode[$i],$readModes)){
                                        $data .= $this->fileRead($filename[$i],$mode[$i],$var);
                                    }
                                    //function file(array $filename,array $mode,$text){}
                                    elseif(in_array($mode[$i],$writeModes)){
                                        $data .= $this->fileWrite($filename[$i],$mode[$i],$var);
                                    }
                                    else{
                                        $this->error($mode[$i]." Not Recognized to execute");
                                    }
                                }
                            }
                            else{
                                $this->error("indexes of arrays passed not equal");
                            }
                        }
                    }
                    else{
                        if(is_array($var)){
                            if(count($filename)==count($var)){
                                //function file(array $filename,$mode,array $index){}
                                if(in_array($mode,$readModes)){
                                    for($i=0;$i<count($filename);$i++){
                                        $data .= $this->fileRead($filename[$i],$mode,$var[$i]);
                                    }
                                }
                                //function file(array $filename,$mode,array $text){}
                                elseif(in_array($mode,$writeModes)){
                                    for($i=0;$i<count($filename);$i++){
                                        $data .= $this->fileWrite($filename[$i],$mode,$var[$i]);
                                    }
                                }
                                else{
                                    $this->error($mode." Not Recognized to execute");
                                }
                            }
                            else{
                                $this->error("indexes of arrays passed not equal");
                            }
                        }
                        else{
                            //function file(array $filename,$mode,$lineNo){}
                            if(in_array($mode,$readModes)){
                                for($i=0;$i<count($filename);$i++){
                                    $data .= $this->fileRead($filename[$i],$mode,$var);
                                }
                            }
                            //function file(array $filename,$mode,$text){}
                            elseif(in_array($mode,$writeModes)){
                                for($i=0;$i<count($filename);$i++){
                                    $data .= $this->fileWrite($filename[$i],$mode,$var);
                                }
                            }
                            else{
                                $this->error($mode." Not Recognized to execute");
                            }
                        }
                    }
                }
                elseif($count==4){
                    $mode=$args[1];
                    $index=$args[2];
                    $readChar=args[3];
                    if($readChar){
                        //function file(array $filename,$mode,array $index,bool $readChar){}
                        if(is_array($index)){
                            if(in_array($mode,$readModes)){
                                for($i=0;$i<count($filename);$i++){
                                    $data .= $this->fileCharRead($filename[$i],$index[$i])."<br>";
                                }
                            }
                            else{
                                $this->error($mode." Not Recognized to read Characters from file");
                            }
                        }
                        else{
                            //function file(array $filename,$mode,$index,bool $readChar){}
                            if(in_array($mode,$readModes)){
                                for($i=0;$i<count($filename);$i++){
                                    $data .= $this->fileCharRead($filename[$i],$index)."<br>";
                                }
                            }
                            else{
                                $this->error($mode." Not Recognized to read Characters from file");
                            }
                        }
                    }

                }
            }
            return $data;
        }
        
        //helps in the actual character Reading of the file
        protected function fileCharRead($filename,$index){
            $data = "";
            $file = fopen($filename,"r+") or die("Unable to open file for reading Please Check Permissions!");
            if($index==null){
                for($i=0;(!feof($file));$i++){
                    $data .= "".fgetc($file);
                }
            }
            else{
                while(!feof($file)){
                    if($index>0){
                        $data = $data+""+parse_str(fgetc($file));
                        $index = $index-1;
                    }
                    else{
                        break;
                    }
                }
            }
            fclose($file);
            return $data;
        }
        //helps in the actual reading of the file
        protected function fileRead($filename,$mode,$length){
            $file = fopen($filename, $mode) or die("Unable to open file for ".$mode." Please Check Permissions!");
            $data = "";
            if($length==null){
                while(!feof($file)){
                    $data .= fgets($file)."<br>";
                }
            }
            else{
//                for($i=0;$i<$length-1;$i++){
                while(!feof($file)){
                    if($length>0){
                        $data .= fgets($file)."<br>";
                        $length -= 1;
                    }
                    else{
                        break;
                    }
                }
            }
            fclose($file);
            return $data;
            
        }
        //helps in the actual writing of the file
        protected function fileWrite($filename,$mode,$text){
            $file = fopen($filename, $mode) or die("Unable to open file for ".$mode." Please Check Permissions!");
            fwrite($file,$text);
            fclose($file);
        }
    }
?>