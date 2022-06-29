<?php
require_once('define.php');


class Oauth
{

    public function __contruct()
    {

    }

    public function fetchData($url,$method,array $fields)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $url);

      switch($method)
      {
        case 'POST':
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
          if(!empty($fields))
          {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
          }
        break;
        case 'PUT':
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        break;
        case 'DELETE':
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        break;
        default:
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');        
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        break;
      }

      curl_setopt($ch, CURLOPT_TIMEOUT, 20);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }

    private function handler()
	{
	 	while((file_get_contents("php://input")))
  		{
  			return	trim(file_get_contents("php://input"));
  		}
	}

    public function oauth($CLIENT_ID,$REDIREC_URI)
    {
        //https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=token
        //http://your-redirect-uri#access_token=ACCESS-TOKEN
        $code = $this->fetchData("https://api.instagram.com/oauth/authorize/?client_id={$CLIENT_ID}&redirect_uri={$REDIRECT_URI}&response_type=code",'GET',[]);
        return $code;
    }

    public function redirectURL($URL,$TOKEN)
    {
        $res = $this->fetchData("{$URL}#access_token={$TOKEN}",'GET',[]);
    }

}



?>