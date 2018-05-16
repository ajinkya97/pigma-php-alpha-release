<?php
//contains all general utilities like date,time,etc
class Utils{
    function Utils(){
        date_default_timezone_set("Asia/Kolkata");
    }
    protected function error(){
        $error = "<br><br>Please refer to the summary of docs<br><br>";
        $error .= "SYNTAX ERROR::".$text."<br>";
        echo $error;
    }
    function setTimezone($text){
        date_default_timezone_set($text);
    }
    function getDateAt(){
        $args = func_get_args();
        $format = "Y-m-d";
        $dateString = '';
        //returns the date n days from current date(may be negative or positive) in the default format
        //function getDateAt($num){}
        if(count($args)==1){
            $dateString = strtotime((date($format)).$args[0]." days");
        }
        //returns the date n days from provided date(may be negative or positive) in the default format
        //function getDateAt($num,$date){}
        elseif(count($args)==2){
            $dateString = strtotime($args[1].$args[0]." days");
        }
        //returns the date n days from provided date(may be negative or positive) in the provided format
        //function getDateAt($num,$date,$format){}
        elseif(count($args)==3){
            $dateString = strtotime($args[1].$args[0]." days");
            $format = $args[2];
        }
        else{
            return $this->error('invalid number of parameters parameters');
        }
        return date($format, $dateString);
    }
    function getDate(){
        $args = func_get_args();
        //returns the current date in the default format
        //function getDate(){}
        $format = 'Y-m-d';
        $date = date($format);
        //returns the current date in the specified format
        //function getDate($format){}
        if(count($args)==1){
            $format = $args[0];
        }
        //returns the specified date in the specified format
        //function getDate($format,$date){}
        elseif(count($args)==2){
            $format = $args[0];
            $date = $args[1];
        }
        else{
            return $this->error('invalid number of parameters parameters');
        }
        $returndate = new DateTime($date);
        return $returndate->format($format);
    }
    function getTime(){
        $args = func_get_args();
        //returns the current time
        //function getTime(){}
        if(count($args)==0){
            $format = "H:i:s a";
            $time = date($format);
            return $time;
        }
        //returns the current time in the specified format
        //function getTime($format){}
        elseif(count($args)==1){
            return $time = date($args[0]);
        }
//        //returns the given time in the specified format
//        //function getTime($format,$time){
//        elseif(count($args)==2){
//            $format = $args[0];
//            $time = $args[1];
//            echo $dd = date_create_from_format('h:i:s a',$time);
//            echo date_format($dd,$format);
//        }
        else{
            return $this->error('invalid number of parameters parameters');
        }
    }
    //returns date in format of SQL databasess
    function getFullDate(){
        $args = func_get_args();
        //returns the current DateTime
        //function getTime(){}
        if(count($args)==0){
            return date("Y-m-d H:i:s");
        }
        //returns the current DateTime in the specified format
        //function getFullDate($format){}
        elseif(count($args)==1){
            return date($args[0]);
        }
        else{
            return $this->error('invalid number of parameters parameters');
        }
    }
}
?>
