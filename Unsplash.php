<?php
define('UNSPLASH_RACINE', 'https://api.unsplash.com/photos/');


class Unsplash
{
    public $url;
    public $clientID = 'cd59d24ab20720ef7e6f5ca4c5ee114c2d0bed20b943502ad2b428428b8b26c5';
    

    public function constructionURL()
    {
        // Travail sur $this-url
        $this->url = UNSPLASH_RACINE . '?client_id=' . $this->clientID;
        return true;
    }

    public function launch()
    {
        // Process CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        
        $header = [];
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: ' . $this->clientID;

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $return = json_decode(curl_exec($curl)); 
        
        curl_close($curl);
        
        return $return;        
    }

    public function extrairePhoto()
    {
        $photo = [];
        foreach($this->launch() as $source){
            $photo[] = $source->urls->small;
        }

        return $photo;
    }
}