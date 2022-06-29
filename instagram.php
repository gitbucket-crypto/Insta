<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);

date_default_timezone_set('America/Sao_Paulo');
ignore_user_abort(true);

// My APP Class que gerecia a conta do istagram

class Instagram
{
    private  $client_id,$secret,$token, $fields,$fbToken;

    function __construct($client_id,$secret,$token)
    {
      $this->fields = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption,posts,username,website,name,comments,like_count,comments_count,feeds";
      $this->token= $token;
      $this->client_id= $client_id;
      $this->secret= $secret;
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
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
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

    public function browserData($url)
    {
        $ch=curl_init($url);       
 
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    } 

    public function getMyPosts()
    {
       $result = $this->fetchData("https://graph.instagram.com/me/media?fields={$this->fields}&access_token={$this->token}",'GET',[]);
       $result_decode = json_decode($result, true);
      return $result_decode; exit;
             
    }

    public function feed($token)
    {
       //https://www.instagram.com/graphql/query/?query_hash=3f01472fb28fb8aca9ad9dbc9d4578ff
       return $url="https://www.instagram.com/graphql/query/?query_hash=3f01472fb28fb8aca9ad9dbc9d4578ff&access_token='.$token,";
      //  $res = $this->browserData($url,'GET');  return $res; exit;
      //  return json_decode($res,true);
    }

    public function getFollowing()
    {
      //https://www.instagram.com/graphql/query/?query_id=17861995474116400&fetch_media_item_count=12&fetch_media_item_cursor=&fetch_comment_count=4&fetch_like=10
    }

    public function getFollowingTotal()
    {
       //https://www.instagram.com/graphql/query/?query_id=17874545323001329&id=40130617284&first={{1}}&after={{10}}
       $url="https://www.instagram.com/graphql/query/?query_id=17874545323001329&id=40130617284&first={{1}}&after={{10}}";
       $res = $this->fetchData($url,'GET',[]); 
       return json_decode($res,true);
    }

    public function getFollowersCount()
    {
       //https://www.instagram.com/graphql/query/?query_id=17851374694183129&id=40130617284&first={{1}}&after={{20}}
       $url="https://www.instagram.com/graphql/query/?query_id=17851374694183129&id=40130617284&first={{1}}&after={{20}}";
       $res = $this->fetchData($url,'GET',[]); 
       return json_decode($res,true);
    }

    public function explorer($username,$fbtoken)
    { 
        //return 'https://graph.facebook.com/v3.2/'.$username.'?fields=instagram_business_account&access_token='.$fbtoken;
        //"https://graph.facebook.com/v3.2/$username?fields=instagram_business_account&access_token=$fbtoken"
        $result = $this->fetchData('https://graph.facebook.com/v3.2/'.$username.'?fields=instagram_business_account&access_token='.$fbtoken,'GET',[]);
        return ['URL:'."https://graph.facebook.com/v3.2/{$username}?fields=instagram_business_account&access_token={fbtoken}", $result]; exit;    
    }

    public function meta($uname)
    {
        $res =$this->fetchData("https://www.instagram.com/$uname/?__a=1",'GET',[]);   
        return $res;
        /**
          * $url = 'http://.../.../yoururl/...';
          * $obj = json_decode(file_get_contents($url), true);
          * echo $obj['access_token']
          */     
    }
    
    public function acessOthers($accontID,$token)
    {
      //: https://graph.facebook.com/some-facebook-account-id-here?fields=instagram_business_account&access_token=something-here|and-here
    }

    public function refreshToken()
    {
        $res = $this->fetchData('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$token,'GET',[]);
        return $res['access_token'];
    }

    public function renewToken($app_id=1194156994685797,
          $app_secret='d33c25600f805a36cc00469eb65edf91',
          $fbToken='EAAQZBFFd5a2UBAHYvnPcviJsx7rU5Nhy2Q2XGzgzZA85eDPARaiU8gxcOI2jLgFbr0kzuvZAkrAljIZBEFQW3J4Q45SbwITkKQcZArdVRZAJ0euaSiffdcMDAVHYshfcldSb8aqUGl98ye168MO7XRcpPbhRgvhek4GN7CcZBeshiut1KOlhyZCvm4QiaPrQdZAxTECDWwxiKRZBCA0qRWmGwn')
    {
        /*curl -i -X GET "https://graph.facebook.com/{graph-api-version}/oauth/access_token?  
        grant_type=fb_exchange_token&          
        client_id={app-id}&
        client_secret={app-secret}&
        fb_exchange_token={your-access-token}" */
        $url="https://graph.facebook.com/v3.2/oauth/access_token?grant_type=fb_exchange_token&client_id={$app_id}&client_secret={$app_secret}&fb_exchange_token={$fbToken}";
        $res =$this->fetchData($url,'GET',[]);
        return $res;
    }

    public function metadataAcont()
    {
       //https://www.instagram.com/graphql/query/?query_id=17861995474116400&fetch_media_item_count=4&fetch_media_item_cursor=&fetch_comment_count=100&fetch_like=10
       $url="/https://www.instagram.com/graphql/query/?query_id=17861995474116400&fetch_media_item_count=4&fetch_media_item_cursor=&fetch_comment_count=100&fetch_like=10";
       $res = $this->fetchData($url,'GET',[]); 
       return json_decode($res,true);

    }

    public function topSearch($query)
    {
        //https://www.instagram.com/web/search/topsearch/?query=netflix
        $url = "https://www.instagram.com/web/search/topsearch/?query={$query}&access_token={$this->token}";
        $res = $this->asBrowser($url,'GET'); 
        return json_decode($res,true);
    }

    public function inspectToken($fbtoken)
    {
        //graph.facebook.com/debug_token?input_token={token-to-inspect}&access_token={app-token-or-admin-token}
        $url="https://graph.facebook.com/debug_token?input_token={$fbtoken}&access_token={$fbtoken}";
        return $this->fetchData($url,'GET',[]); exit;
        return json_decode($res,true);
    }

    private function asBrowser($url,$method='GET')
    {
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $headers = array();
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
        $headers[] = 'Accept-Language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
      
    }

}

?>