<?php

/**
 * Products
 * Performs CRUD operation on products 
 * @author sandeep varma
 */
class Products
{
	
	private $product;
	public function __construct()
	{
		$this->product = new ProductModel;
		
	}
	
	/**
	* getAll
	* Returns an array of products with their details
	* @return array
	*/
	public function allpost()
	{
		$request_data = file_get_contents('php://input');
		$user_id=json_decode($request_data)->user_id;
		$page=json_decode($request_data)->page;
		

		
		$pegination = $this->product->pagination($user_id,$page);
		if($pegination) {
			Response::json(200,'success',$pegination);
		}else {
			Response::json(403,'failed',$pegination);
		}
	}
	public function get_all_songs()
	{
		$get_request_data = file_get_contents('php://input');
		$token=json_decode($get_request_data)->token;
		$key=json_decode($get_request_data)->key;
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.spotify.com/v1/search?q=".$key."&type=track,artist,album&limit=40&market=TR",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer ".$token,
		),
		));
		$user_info = curl_exec($curl);
		$user_info_response = json_decode($user_info, true);  
        
			 
/*
         $rows_album = $user_info_response["albums"]["items"];
         $rows_artist = $user_info_response["artists"]["items"];
*/
         $rows_tracks = $user_info_response["tracks"]["items"];
		 $song_arr=array();
         
/*
		 foreach($rows_album as $key_album){
			 
			 $album_type = $key_album['album_type'];
			 $name = $key_album['name'];
			 $uri = $key_album['uri'];
			
			 
			 $album_arr = array('uri' => $key_album['uri'],'artists' => $key_album['artists'][0]['name'],'images' => $key_album['images'][0]['url'], 'album_type' => $album_type, 'name' =>  $name);
			 
			 array_push($song_arr, $album_arr);
			 
		 }
		 foreach($rows_artist as $key_artist){
			 
			 if(isset($key_artist['images'][0]['url'])){
				$images= $key_artist['images'][0]['url'];
			 }else{
				$images='bos'; 
			 }
			 
			 $album_type = 'album';
			 $name = $key_artist['name'];
			 $uri = $key_artist['uri'];
			
			 
			 $artist_arr = array('uri' => $uri,'artists' => $key_artist['name'],'images' => $images, 'album_type' => $album_type, 'name' =>  $name);
			 
			 array_push($song_arr, $artist_arr);
			 
		 }
*/
		 
		 foreach($rows_tracks as $key_tracks){
			 
			 $album_type = $key_tracks['album']['album_type'];
			 $name = $key_tracks['name'];
			 $uri = $key_tracks['uri'];
			
			 
			 $tracks_arr = array('uri' => $uri,'artists' => $key_tracks['artists'][0]['name'],'images' => $key_tracks['album']['images'][0]['url'], 'album_type' => $album_type, 'name' =>  $name);
			 
			 array_push($song_arr, $tracks_arr);
			 
		 }		
		if($song_arr) {
			Response::json(200,'success',$song_arr);
		}else {
			Response::json(403,'failed',$song_arr);
		}
	}
	public function login()
	{
		
		$get_request_data = file_get_contents('php://input');
		$token=json_decode($get_request_data)->token;
		$osi=json_decode($get_request_data)->osi;
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.spotify.com/v1/me",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer ".$token,
		),
		));
		$user_info = curl_exec($curl);
		$user_info_response = json_decode($user_info, true); 
	        
		    if(isset($user_info_response['display_name']) ){
				
				$display_name = $user_info_response['display_name'];
		        $email = $user_info_response['email'];
		        $spotify_id = $user_info_response['id'];
		        $spotify_type = $user_info_response['product'];
		        $country = $user_info_response['country'];
		        foreach($user_info_response['images'] as $key){
					 $images = html_entity_decode($key['url']);
				}
				$user_check = $this->product->getUserCheck($email);
				
				$user_images 	= rand().".JPG";
				$user_image = file_put_contents("upload_user_pic/".$user_images,file_get_contents($images));
				if($user_check==1)
				{
					$user_check = $this->product->getUserInfo($email,$token,$osi);
					Response::json(200,'success',$user_check);
				}
				else{
					$user_sign = $this->product->getUserSign($display_name,$email,$spotify_id,$spotify_type,$country,$user_images,$token,$osi);
					
					if($user_sign) {
						Response::json(200,'success',$user_sign);
					}else {
						Response::json(403,'failed',$user_sign);
					}
				}				
			}
			else{
				
				Response::json(403,'failed','Token Expired');
			}
	}
	
	public function update_token(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		$token=json_decode($get_request_data)->token;
		
		
		if(isset($get_request_data)){
			
		$user_like_post = $this->product->do_update_token($user_id,$token);
			
		if($user_like_post) 
		{
			Response::json(200,'success',$user_like_post);
		}else {
			Response::json(403,'failed',$user_like_post);
		}	
			
			
			
		}
	}
	public function do_save_post(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		$song_uri=json_decode($get_request_data)->song_uri;
		$song_image=json_decode($get_request_data)->song_image;
		$song_name=json_decode($get_request_data)->song_name;
		$song_artist=json_decode($get_request_data)->song_artist;
		$post_text=json_decode($get_request_data)->post_text;
		$post_image=json_decode($get_request_data)->post_image;
		
		
		if(isset($get_request_data)){
			
			
		$decodedImage = base64_decode($post_image);
 
		$post_images 	= rand().".JPG";
		$return = file_put_contents("upload_post_pic/".$post_images, $decodedImage);
			
			
		$user_posted = $this->product->do_save_posted($user_id,$song_uri,$song_image,$song_name,$song_artist,$post_text,$post_images);
			
		if($user_posted) 
		{
			Response::json(200,'success',$user_posted);
		}else {
			Response::json(403,'failed',$user_posted);
		}	
			
			
			
		}
	}
	
	
	public function like_post(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		$post_id=json_decode($get_request_data)->post_id;
		
		
		if(isset($get_request_data)){
			
		$user_like_post = $this->product->do_like_posted($user_id,$post_id);
			
		if($user_like_post) 
		{
			Response::json(200,'success',$user_like_post);
		}else {
			Response::json(403,'failed',$user_like_post);
		}	
			
			
			
		}
	}
	
	public function unlike_post(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		$post_id=json_decode($get_request_data)->post_id;
		
		
		if(isset($get_request_data)){
			
		$user_unlike_post = $this->product->do_unlike_posted($user_id,$post_id);
			
		if($user_unlike_post) 
		{
			Response::json(200,'success',$user_unlike_post);
		}else {
			Response::json(403,'failed',$user_unlike_post);
		}	
			
			
			
		}
	}
	
	
	public function follow_user(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->my_user_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$do_follow = $this->product->send_follow($my_user_id,$user_id);
			
		if($do_follow) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$do_follow);
		}	
			
			
			
		}
	}
	
	public function unfollow_user(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->my_user_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$do_unfollow = $this->product->send_unfollow($my_user_id,$user_id);
			
		if($do_unfollow) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$do_unfollow);
		}	
			
			
			
		}
	}
	
	public function my_notification(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$my_notification = $this->product->my_notif($user_id);
			
		if($my_notification) 
		{
			Response::json(200,'success',$my_notification);
		}else {
			Response::json(403,'failed',$my_notification);
		}	
			
			
			
		}
	}
	
	public function connect_list(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$connect_list = $this->product->connect_list($user_id);
			
		if($connect_list) 
		{
			Response::json(200,'success',$connect_list);
		}else {
			Response::json(403,'failed',$connect_list);
		}	
			
			
			
		}
	}
	
	public function chat_list(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$chat_list = $this->product->chat_list($user_id);
			
		if($chat_list) 
		{
			Response::json(200,'success',$chat_list);
		}else {
			Response::json(403,'failed',$chat_list);
		}	
			
			
			
		}
	}
	
	public function user_post(){
		
		
		$get_request_data = file_get_contents('php://input');

		if(isset(json_decode($get_request_data)->user_id)){
			
			$user_id=json_decode($get_request_data)->user_id;
		}
		if(isset(json_decode($get_request_data)->post_id)){
			
			$post_id=json_decode($get_request_data)->post_id;
		}
		
		if(isset($get_request_data)){
			
		if(isset($post_id)){
			
			$post_detail = $this->product->post_detail($post_id);
			
			if($post_detail) 
			{
				Response::json(200,'success',$post_detail);
			}else {
				Response::json(403,'failed',$post_detail);
			}			
			
		}else{
			$user_post = $this->product->user_post($user_id);

			if($user_post) 
			{
				Response::json(200,'success',$user_post);
			}else {
				Response::json(403,'failed',$user_post);
			}
		}
	
			
			
			
		}
	}

	
	public function list_preview_song(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$connect_list = $this->product->list_preview_song($user_id);
			
		if($connect_list) 
		{
			Response::json(200,'success',$connect_list);
		}else {
			Response::json(403,'failed',$connect_list);
		}	
			
			
			
		}
	}
	public function get_user_information(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->my_user_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$my_notification = $this->product->user_information($my_user_id,$user_id);
			
		if($my_notification) 
		{
			Response::json(200,'success',$my_notification);
		}else {
			Response::json(403,'failed',$my_notification);
		}	
			
			
			
		}
	}
	public function get_my_information(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$my_notification = $this->product->my_information($my_user_id);
			
		if($my_notification) 
		{
			Response::json(200,'success',$my_notification);
		}else {
			Response::json(403,'failed',$my_notification);
		}	
			
			
			
		}
	}
	public function get_user_song_match(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$user_song_matchs = $this->product->user_song_match($my_user_id);
			
		if($user_song_matchs) 
		{
			Response::json(200,'success',$user_song_matchs);
		}else {
			Response::json(403,'failed',$user_song_matchs);
		}	
			
			
			
		}
	}
	
		
	
	public function accept_match(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_user_id=json_decode($get_request_data)->user_id;
		$match_id=json_decode($get_request_data)->match_id;
		
		
		if(isset($get_request_data)){
			
		$do_follow = $this->product->accept_match($my_user_id,$match_id);
			
		if($do_follow) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$do_follow);
		}	
			
			
			
		}
	}
	
	public function decline_match(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_id=json_decode($get_request_data)->my_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$decline_match = $this->product->decline_match($my_id,$user_id);
			
		if($decline_match) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$decline_match);
		}	
			
			
			
		}
	}
	
	public function undecline_match(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_id=json_decode($get_request_data)->my_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$undecline_match = $this->product->undecline_match($my_id,$user_id);
			
		if($undecline_match) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$undecline_match);
		}	
			
			
			
		}
	}
	public function delete_match(){
		
		
		$get_request_data = file_get_contents('php://input');
		$my_id=json_decode($get_request_data)->my_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$delete_match = $this->product->delete_match($my_id,$user_id);
			
		if($delete_match) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$delete_match);
		}	
			
			
			
		}
	}
	
	public function top_played(){
		
		
		$get_request_data = file_get_contents('php://input');
		$limit=json_decode($get_request_data)->limit;
		
		
		if(isset($get_request_data)){
			
		$top_played = $this->product->top_played($limit);
			
		if($top_played) 
		{
			Response::json(200,'success',$top_played);
		}else {
			Response::json(403,'failed',$top_played);
		}	
			
			
			
		}
	}
	
	
	public function current_song(){
		
		$get_request_data = file_get_contents('php://input');
		$token=json_decode($get_request_data)->token;
		
			$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.spotify.com/v1/me/player/currently-playing?market=TR&additional_types=episode",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer ".$token,
		),
		));
		$user_info = curl_exec($curl);
		$user_info_response = json_decode($user_info, true);  
                	         
		  	if($user_info_response) 
		{
			Response::json(200,'success',$user_info_response);
		}else {
			Response::json(403,'failed',$user_info_response);
		}	
		
	}
	public function play_song(){
		
		$get_request_data = file_get_contents('php://input');
		$token=json_decode($get_request_data)->token;
		$song_uri=json_decode($get_request_data)->song_uri;
		
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,            'https://api.spotify.com/v1/me/player/play' );
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['uris' => [$song_uri]]));
	    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: json', 'Authorization: Bearer ' . $token));
	
	    $result=curl_exec($ch);
		$user_info_response = json_decode($result, true);  
		  	if($user_info_response) 
		{
			Response::json(200,'success',$user_info_response);
		}else {
			Response::json(403,'failed',$user_info_response);
		}	

	}
	
	public function connect_host(){
		
		
		$get_request_data = file_get_contents('php://input');
		$host_id=json_decode($get_request_data)->host_id;
		$user_id=json_decode($get_request_data)->user_id;
		
		
		if(isset($get_request_data)){
			
		$connect_host = $this->product->connect_host($host_id,$user_id);
			
		if($connect_host) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$connect_host);
		}	
			
			
			
		}
	}
	
	public function first_update(){
		
		
		$get_request_data = file_get_contents('php://input');
		$user_id=json_decode($get_request_data)->user_id;
		$name=json_decode($get_request_data)->name;
		$username=json_decode($get_request_data)->username;
		$bio=json_decode($get_request_data)->bio;
		
		
		if(isset($get_request_data)){
			
		$first_update = $this->product->first_update($user_id,$name,$username,$bio);
			
		if($first_update) 
		{
			Response::json(200,'success',true);
		}else {
			Response::json(403,'failed',$first_update);
		}	
			
			
			
		}
	}
}