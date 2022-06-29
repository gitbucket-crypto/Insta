<?php 

class FeedBack
{

    function __contruct()
    {
        clearstatcache();
    }


    function addFeedback($text,$nome,$mail)
    {
       $path = 'feed.json';
        //========determine-filesize==/
        $size= filesize($path);
       //========open file============/
       if((int)$size==0)
        {
            $file=fopen('feed.json',"w");
            $array_data=array();
            $feed=array(
                'name'=>$nome,
                'email'=>$mail,
                'text'=>trim($text)
            );
            $array_data[] = $feed;
            $final_data = json_encode($array_data);
            //var_dump($array_data);
            $i = fwrite($file, $final_data);
            fclose($file);
            echo $i;
        }
        if((int)$size>0)
        {
            $current_data = file_get_contents('feed.json');
            $array_data = json_decode($current_data);
            $feed=array(
                'name'=>$nome,
                'email'=>$mail,
                'text'=>trim($text)
            );
            $array_data[] = $feed;
            $final_data = json_encode($array_data);
            unlink($path);
            $file = fopen($path,"w+");
            $i = fwrite($file, $final_data);
            fclose($file);
            echo $i;

        }
    }

    function getAllFedd()
    {
        $current_data = file_get_contents('feed.json');
        $array_data = json_decode($current_data,true);
        return(array_values($array_data));
    }



}


?>