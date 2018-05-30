<?php
//this class provieds html functions such as validation etc
class HTML{
    function HTML(){
//        echo "<!DOCTYPE HTML>";
    }
    protected function error($text,$type){
            $error .= "<br><br>Please refer to the docs<br><br>";
            $error .= "$type :: ".$text."<br>";
            echo $error;
        }
    //help in validating the text if its in the type specified
    //validation(str $type,obj $text[,int $maxlenght[,bool required]])
    function validation(){
        $args = func_get_args();
        $cnt = count($args);
        $type = $args[0];
        $text = $args[1];
        if($cnt==4 and $args[3]==true){
            if(empty($text)){
                return false;
            }
            if(strlen($text)!=$args[3]){
                return false;
            }
        }
        if($cnt==3){
            if(strlen($text)!=$args[3]){
                return false;
            }
        }
        if($type=="number"){
            for($i=0;$i<strlen($text);$i++){
                if(!(is_int($text[$i]) || $text[$i]==".")){
                    return false;
                }
            }
        }
        elseif($type=="name"){
            $name = test_input($text);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                return false; 
            }
        }
        elseif($type=="email"){
            $email = test_input($text);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        elseif($type=="url"){
            $website = test_input($text);
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                return false;
            }
        }
        elseif($type=="phone"){
            for($i=0;$i<strlen($text);$i++){
                if(!(is_int($text[$i]))){
                    return false;
                }
            }
        }
        else{
            $this->error("validation for $type is yet unavailable","Coming Soon");
        }
    }
    function a($text="",$id="",$class="",$href="",$target="",$type="",$rel="",$ping="",$other=""){
        echo "<a id='$id' class='$class' href='$href' target='$target' type='$type' rel='$rel' ping='$ping' $other>$text</a>";
    }
    function abbr($text="",$fullform="",$id="",$class="",$other=""){
        echo "<abbr id='$id' class='$class' title='$fullform' $other>$text</abbr>";
    }
    function article($content="",$id="",$class="",$other=""){}
    function aside($content="",$id="",$class="",$other=""){}
    function audio($attr="",$id="",$class="",$source=array(),$type=array(),$text="",$other=""){}
    function b($text="",$id="",$class="",$other=""){}
    function base($href="",$target="",$id="",$class="",$other=""){
        echo "<base id='$id' class='$class' href='$href' target='$target' $other>";
    }
    function blockquote($text="",$cite="",$id="",$class="",$other=""){
        echo "<blockquote id='$id' class='$class' cite='$cite' $other>$text</blockquote>";
    }
    function starthtml($text="",$other=""){
        echo "<html $other>$text</html>";
    }
    function head($text="",$other=""){
        echo "<head $other>$text</head>";
    }
    function body($text="",$other=""){
        echo "<body $other>$text</body>";
    }
    function div($text="",$id="",$class="",$other=""){
        echo "<div id='$id' class='$class' $other>$text</div>";
    }
    function footer($text="",$id="",$class="",$other=""){
        echo "<footer id='$id' class='$class' $other>$text</footer>";
    }
    function form($text="",$id="",$class="",$other=""){
        echo "<footer id='$id' class='$class' $other>$text</footer>";
    }
}
?>
