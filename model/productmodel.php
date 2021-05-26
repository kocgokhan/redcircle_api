<?php

/**
 * Products Model
 */
class ProductModel
{
	private $DB;
	private $table_users = 'product';

	public function __construct()
	{
		$this->DB = DB::getDBInstance();
	}

	/**
	* Destructor
	* close database connection as soon as the ProductModel object is destroyed
	*/
	public function __destruct()
	{
		DB::closeDB();
	}

	/*
	* getAll
	* Return all product details
	* @return object 
	*/
/*
	public function getAll($user_id)
	{
		$query = $this->DB->prepare("SELECT * FROM user_post where user_id!=? order by post_id DESC");
		$query->execute(array($user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
				$inspection_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
				$inspection_reg->execute(array($row['user_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$display_name=$inspection_reg_row['display_name'];
					$username=$inspection_reg_row['username'];
					$images=$inspection_reg_row['images'];
					
				}	
				
				$inspection_reg =$this->DB->prepare("SELECT COUNT(like_id) as count_like FROM post_like WHERE  post_id=? ");
				$inspection_reg->execute(array($row['post_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$count_like=$inspection_reg_row['count_like'];
					
				}
				
				$querys = $this->DB->prepare("SELECT user_id from post_like where post_id=? and user_id=?");
				$querys->execute(array($row['post_id'],$user_id));
				if($staff_row= $querys->fetch()){$user_fetcc=1;}else{$user_fetcc=0;}	
				
					
				$inspection_level[$count]=$row;
				$inspection_level[$count]['isLike']=$user_fetcc;
				$inspection_level[$count]['count_like']=$count_like;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['images']=$images;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
	}
*/
	
	public function pagination($user_id,$paging){
		$inspection_reg =$this->DB->prepare("SELECT COUNT(*) as cont_post FROM user_post ");
		$inspection_reg->execute(array());
		if($inspection_reg_row=$inspection_reg->fetch()){
			
			$cont_post=$inspection_reg_row['cont_post'];
			
		}	
		$row_per_page=10;
		$pages = ceil($cont_post / $row_per_page);
	

		$offset = ($paging - 1)  * $row_per_page;
		$query = $this->DB->prepare("SELECT * FROM user_post ORDER BY post_id DESC LIMIT :limit OFFSET :offset");
	    $query->bindParam(':limit', $row_per_page, PDO::PARAM_INT);
	    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->execute();
		
		
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

				array_slice($row, ($paging-1)*$row_per_page, $row_per_page);

				$inspection_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
				$inspection_reg->execute(array($row['user_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$display_name=$inspection_reg_row['display_name'];
					$username=$inspection_reg_row['username'];
					$images=$inspection_reg_row['images'];
					
				}	
				
				$inspection_reg =$this->DB->prepare("SELECT COUNT(like_id) as count_like FROM post_like WHERE  post_id=? ");
				$inspection_reg->execute(array($row['post_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$count_like=$inspection_reg_row['count_like'];
					
				}
				
				$querys = $this->DB->prepare("SELECT user_id from post_like where post_id=? and user_id=?");
				$querys->execute(array($row['post_id'],$user_id));
				if($staff_row= $querys->fetch()){$user_fetcc=1;}else{$user_fetcc=0;}	
				

					
				$inspection_level[$count]=$row;
				$inspection_level[$count]['isLike']=$user_fetcc;
				$inspection_level[$count]['count_like']=$count_like;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['images']=$images;
				$inspection_level[$count]['max_page_count']=$pages;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
	}
	
	
	public function user_post($user_id,$paging)
	{
		
		$inspection_reg =$this->DB->prepare("SELECT COUNT(*) as cont_post FROM user_post where user_id=?");
		$inspection_reg->execute(array($user_id));
		if($inspection_reg_row=$inspection_reg->fetch()){
			
			$cont_post=$inspection_reg_row['cont_post'];
			
		}	
		$row_per_page=10;
		$pages = ceil($cont_post / $row_per_page);		
		
		$offset = ($paging - 1)  * $row_per_page;
		$query = $this->DB->prepare("SELECT * FROM user_post where user_id= :user_id ORDER BY post_id DESC LIMIT :limit OFFSET :offset");
	    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	    $query->bindParam(':limit', $row_per_page, PDO::PARAM_INT);
	    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->execute();		
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			array_slice($row, ($paging-1)*$row_per_page, $row_per_page);
			
				$inspection_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
				$inspection_reg->execute(array($row['user_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$display_name=$inspection_reg_row['display_name'];
					$username=$inspection_reg_row['username'];
					$images=$inspection_reg_row['images'];
					
				}	
				
				$inspection_reg =$this->DB->prepare("SELECT COUNT(like_id) as count_like FROM post_like WHERE  post_id=? ");
				$inspection_reg->execute(array($row['post_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$count_like=$inspection_reg_row['count_like'];
					
				}
					
				$inspection_level[$count]=$row;
				$inspection_level[$count]['count_like']=$count_like;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['images']=$images;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
	}
	
	public function post_detail($post_id)
	{
		$query = $this->DB->prepare("SELECT * FROM user_post where post_id=? ");
		$query->execute(array($post_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
				$inspection_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
				$inspection_reg->execute(array($row['user_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$display_name=$inspection_reg_row['display_name'];
					$username=$inspection_reg_row['username'];
					$images=$inspection_reg_row['images'];
					
				}	
				
				$inspection_reg =$this->DB->prepare("SELECT COUNT(like_id) as count_like FROM post_like WHERE  post_id=? ");
				$inspection_reg->execute(array($row['post_id']));
				if($inspection_reg_row=$inspection_reg->fetch()){
					
					$count_like=$inspection_reg_row['count_like'];
					
				}
				
				$inspection_level[$count]=$row;
				$inspection_level[$count]['count_like']=$count_like;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['images']=$images;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
	}
	
	public function getUserCheck($email){
		
		$querys = $this->DB->prepare("SELECT email from users where email=? and status=1");
		$querys->execute(array($email));
		if($staff_row= $querys->fetchAll()){$result=1;}else{$result=0;}
		
		return $result;
	}
	
	public function do_update_token($user_id,$token){
		
		$edit_case = $this->DB->prepare("UPDATE users SET token=?  WHERE  id=?");
		$edit_case->execute(array($token,$user_id));
		if($edit_case){return  true;}else{return  false;}
	}
	
	
	
	public function getUserInfo($email,$token,$osi){
		
		$query = $this->DB->prepare("SELECT * FROM users where email=? and status=1");
		$query->execute(array($email));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			
			$count_of_following_reg =$this->DB->prepare("SELECT COUNT(receiver_user_id) as count_of_following FROM user_follow WHERE  sender_user_id=? ");
			$count_of_following_reg->execute(array($row['id']));
			if($count_of_following_reg_row=$count_of_following_reg->fetch()){
				
				$count_of_following=$count_of_following_reg_row['count_of_following'];
			}
			
			$count_of_followers_reg =$this->DB->prepare("SELECT COUNT(sender_user_id) as count_of_followers FROM user_follow WHERE  receiver_user_id=? ");
			$count_of_followers_reg->execute(array($row['id']));
			if($count_of_followers_reg_row=$count_of_followers_reg->fetch()){
				
				$count_of_followers=$count_of_followers_reg_row['count_of_followers'];
			}
			
			$count_of_like_reg =$this->DB->prepare("SELECT COUNT(post_like.post_id) as count_of_like FROM post_like,user_post WHERE  post_like.post_id=user_post.post_id and user_post.user_id=? ");
			$count_of_like_reg->execute(array($row['id']));
			if($count_of_like_reg_row=$count_of_like_reg->fetch()){
				
				$count_of_like=$count_of_like_reg_row['count_of_like'];
			}
				
										
			
				$inspection_level[$count]=$row;
				$inspection_level[$count]['count_of_following']=$count_of_following;
				$inspection_level[$count]['count_of_followers']=$count_of_followers;
				$inspection_level[$count]['count_of_like']=$count_of_like;
								        
		        $count ++;
		    }
		} 
		
		$edit_case = $this->DB->prepare("UPDATE users SET token=?, osi=?  WHERE  email=? ");
		$edit_case->execute(array($token,$osi,$email));
		
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;	
		
	}
	
	public function getUserSign($display_name,$email,$spotify_id,$spotify_type,$country,$images,$token,$osi){
		
		
		$change_class = $this->DB->prepare("INSERT INTO users (display_name , email ,product, country, images, token, osi, regDate,profile_lock,status,premium) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$change_class->execute(array($display_name,$email,$spotify_type,$country,$images,$token,$osi,date('Y-m-d'),0,1,0));
			
		$query = $this->DB->prepare("SELECT * FROM users where email=?");
		$query->execute(array($email));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
							
				$inspection_level[$count]=$row;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	
	public function do_save_posted($user_id,$song_uri,$song_image,$song_name,$song_artist,$post_text,$post_images){
		
		
		$change_class = $this->DB->prepare("INSERT INTO user_post (user_id, song_uri, song_image, song_name, song_artist, post_text, post_image, proccess_time) VALUES (?,?,?,?,?,?,?,?)");
		$change_class->execute(array($user_id,$song_uri,$song_image,$song_name,$song_artist,$post_text,$post_images,date('Y-m-d H:m:s')));
			
		
		if($change_class){return  true;}else{return  false;}	
		
	}
	
	public function do_like_posted($user_id,$post_id){
		
		
		$change_class = $this->DB->prepare("INSERT INTO post_like (user_id, post_id, proccess_time) VALUES (?,?,?)");
		$change_class->execute(array($user_id,$post_id,date('Y-m-d H:m:s')));
		if($change_class){
			
			$post_detail_reg =$this->DB->prepare("SELECT user_id,post_text FROM user_post WHERE  post_id=? ");
			$post_detail_reg->execute(array($post_id));
			if($post_detail_reg_row=$post_detail_reg->fetch()){
				
				$post_user_id=$post_detail_reg_row['user_id'];
				$post_text=$post_detail_reg_row['post_text'];
			}	
			$poster_user_reg =$this->DB->prepare("SELECT osi,display_name FROM users WHERE  id=? ");
			$poster_user_reg->execute(array($post_user_id));
			if($poster_user_reg_row=$poster_user_reg->fetch()){
				
				$user_osi=$poster_user_reg_row['osi'];
			}
			$poster_user_reg =$this->DB->prepare("SELECT display_name FROM users WHERE  id=? ");
			$poster_user_reg->execute(array($user_id));
			if($poster_user_reg_row=$poster_user_reg->fetch()){
				
				$display_name=$poster_user_reg_row['display_name'];
			}
				

			if($user_id!=$post_user_id){
				
			$message=$display_name.' adlı kullanıcı, '.$post_text.' içerikli gönderinizi beğendi.';
				
			$content = array(
			"en" => $display_name
			);
			$heading = array(
			   "en" => 'Gönderinizi Beğendi'
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($user_osi),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,post_id ,message, proccess_time) VALUES (?,?,?,?,?)");
			$change_class->execute(array($user_id,$post_user_id,$post_id,$message,date('Y-m-d H:m:s')));
				
				
			}
			
		}	
		
		if($change_class){return  true;}else{return  false;}	
		
	}
	
	public function send_follow($my_id,$user_id){
		
		$liker_user_reg =$this->DB->prepare("SELECT profile_lock,display_name,osi FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($my_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$name=$liker_user_reg_row['display_name'];
		}
		
		$liker_user_reg =$this->DB->prepare("SELECT profile_lock,display_name,osi FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($user_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$profile_lock=$liker_user_reg_row['profile_lock'];
			$osi_id=$liker_user_reg_row['osi'];
		}
		
		if($profile_lock==1){
			$do_following = $this->DB->prepare("INSERT INTO user_follow (sender_user_id, receiver_user_id, follow_status, proccess_time) VALUES (?,?,?,?)");
			$do_following->execute(array($my_id,$user_id,0,date('Y-m-d H:m:s')));
			if($do_following){
				
			$message=$name.' adlı kullanıcı, seni takip etmek istiyor.';
				
			$content = array(
			"en" => '1 Yeni Takip İsteği'
			);
			$heading = array(
			   "en" => $message
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($osi_id),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
			$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
				
			}
		}else{
				$do_following = $this->DB->prepare("INSERT INTO user_follow (sender_user_id, receiver_user_id, follow_status, proccess_time) VALUES (?,?,?,?)");
				$do_following->execute(array($my_id,$user_id,1,date('Y-m-d H:m:s')));
				if($do_following){

				$message=$name.' adlı kullanıcı, seni takip etmeye başladı.';

				$content = array(
				"en" => '1 Yeni Takip'
				);
				$heading = array(
				   "en" => $message
				);

				$fields = array(
				  'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
				  'include_player_ids' => array($osi_id),
				  'data' => array("foo" => "bar"),
				  'headings' => $heading,
				  'contents' => $content
				);
				$fields = json_encode($fields);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

				$response = curl_exec($ch);
				curl_close($ch);

				$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
				$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
				}
			
			}
			
		
		
		if($do_following){return  true;}else{return  false;}
	}
	
	
	public function send_unfollow($my_id,$user_id){
		
		$change_class = $this->DB->prepare("DELETE FROM user_follow WHERE sender_user_id =? and receiver_user_id=?");
		$change_class->execute(array($my_id,$user_id));
		if($change_class){
			
			$liker_user_reg =$this->DB->prepare("SELECT premium,display_name,osi FROM users WHERE  id=? ");
			$liker_user_reg->execute(array($my_id));
			if($liker_user_reg_row=$liker_user_reg->fetch()){

				$premium=$liker_user_reg_row['premium'];
				$display_name=$liker_user_reg_row['display_name'];
				$osi_id=$liker_user_reg_row['osi'];
			}
			if($premium!=0){
				
				$message=$display_name.' adlı kullanıcı, seni takipten çıkarttı';

				$content = array(
				"en" => 'Üzgünüz..'
				);
				$heading = array(
				   "en" => $message
				);

				$fields = array(
				  'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
				  'include_player_ids' => array($osi_id),
				  'data' => array("foo" => "bar"),
				  'headings' => $heading,
				  'contents' => $content
				);
				$fields = json_encode($fields);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

				$response = curl_exec($ch);
				curl_close($ch);

				$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
				$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
				
				
			}
			
			
			
			
			
			
			
			
			return  true;}else{return  false;}	
	}
	
	
	
	
	public function do_unlike_posted($user_id,$post_id){
		
		$change_class = $this->DB->prepare("DELETE FROM post_like WHERE user_id =? and post_id=?");
		$change_class->execute(array($user_id,$post_id));
		if($change_class){return  true;}else{return  false;}	
	}
	
	
	public function my_notif($user_id){
		
		$query = $this->DB->prepare("SELECT * FROM user_notification where receiver_user_id=?");
		$query->execute(array($user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			
			$poster_user_reg =$this->DB->prepare("SELECT images FROM users WHERE  id=? ");
			$poster_user_reg->execute(array($row['sender_user_id']));
			if($poster_user_reg_row=$poster_user_reg->fetch()){
				
				$user_sender_images=$poster_user_reg_row['images'];
			}			
										
				$inspection_level[$count]=$row;
				$inspection_level[$count]['sender_images']=$user_sender_images;
				$inspection_level[$count]['like_time']=date("H:m", strtotime($row['proccess_time']));
				
				
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	
	public function user_information($my_user_id,$other_user_id){
		
		$query = $this->DB->prepare("SELECT id,display_name,username,images,profile_lock FROM users where id=?");
		$query->execute(array($other_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			$querys = $this->DB->prepare("SELECT follow_status from user_follow where receiver_user_id=? and sender_user_id=?");
			$querys->execute(array($row['id'],$my_user_id));
			if($staff_row= $querys->fetchAll()){$fol=1;}else{$fol=0;}
			
			
			$count_of_following_reg =$this->DB->prepare("SELECT COUNT(receiver_user_id) as count_of_following FROM user_follow WHERE  sender_user_id=? ");
			$count_of_following_reg->execute(array($row['id']));
			if($count_of_following_reg_row=$count_of_following_reg->fetch()){
				
				$count_of_following=$count_of_following_reg_row['count_of_following'];
			}
			
			$count_of_followers_reg =$this->DB->prepare("SELECT COUNT(sender_user_id) as count_of_followers FROM user_follow WHERE  receiver_user_id=? ");
			$count_of_followers_reg->execute(array($row['id']));
			if($count_of_followers_reg_row=$count_of_followers_reg->fetch()){
				
				$count_of_followers=$count_of_followers_reg_row['count_of_followers'];
			}
			
			$count_of_like_reg =$this->DB->prepare("SELECT COUNT(post_like.post_id) as count_of_like FROM post_like,user_post WHERE  post_like.post_id=user_post.post_id and user_post.user_id=? ");
			$count_of_like_reg->execute(array($row['id']));
			if($count_of_like_reg_row=$count_of_like_reg->fetch()){
				
				$count_of_like=$count_of_like_reg_row['count_of_like'];
			}
				
										
				$inspection_level[$count]=$row;
				$inspection_level[$count]['isfollow']=$fol;
				$inspection_level[$count]['count_of_following']=$count_of_following;
				$inspection_level[$count]['count_of_followers']=$count_of_followers;
				$inspection_level[$count]['count_of_like']=$count_of_like;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	public function my_information($my_user_id){
		
		$query = $this->DB->prepare("SELECT id,display_name,username,images,profile_lock FROM users where id=?");
		$query->execute(array($my_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			
			
			$count_of_following_reg =$this->DB->prepare("SELECT COUNT(receiver_user_id) as count_of_following FROM user_follow WHERE  sender_user_id=? ");
			$count_of_following_reg->execute(array($row['id']));
			if($count_of_following_reg_row=$count_of_following_reg->fetch()){
				
				$count_of_following=$count_of_following_reg_row['count_of_following'];
			}
			
			$count_of_followers_reg =$this->DB->prepare("SELECT COUNT(sender_user_id) as count_of_followers FROM user_follow WHERE  receiver_user_id=? ");
			$count_of_followers_reg->execute(array($row['id']));
			if($count_of_followers_reg_row=$count_of_followers_reg->fetch()){
				
				$count_of_followers=$count_of_followers_reg_row['count_of_followers'];
			}
			
			$count_of_like_reg =$this->DB->prepare("SELECT COUNT(post_like.post_id) as count_of_like FROM post_like,user_post WHERE  post_like.post_id=user_post.post_id and user_post.user_id=? ");
			$count_of_like_reg->execute(array($row['id']));
			if($count_of_like_reg_row=$count_of_like_reg->fetch()){
				
				$count_of_like=$count_of_like_reg_row['count_of_like'];
			}
				
										
				$inspection_level[$count]=$row;
				$inspection_level[$count]['count_of_following']=$count_of_following;
				$inspection_level[$count]['count_of_followers']=$count_of_followers;
				$inspection_level[$count]['count_of_like']=$count_of_like;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	
	public function user_song_match($my_user_id){
		
		$query = $this->DB->prepare("SELECT * FROM user_match_song where user_one=? and status!=4 and status!=2 and status!=1 order by status ASC");
		$query->execute(array($my_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			$querys = $this->DB->prepare("SELECT follow_status from user_follow where receiver_user_id=? and sender_user_id=?");
			$querys->execute(array($row['user_two'],$my_user_id));
			if($staff_row= $querys->fetchAll()){$fol=1;}else{$fol=0;}
			
			
			$info =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
			$info->execute(array($row['user_two']));
			if($info_row=$info->fetch()){
				
				$display_name=$info_row['display_name'];
				$image=$info_row['images'];
				$osi=$info_row['osi'];
				$username=$info_row['username'];
				$bio=$info_row['bio'];
			}
			
			$count_of_following_reg =$this->DB->prepare("SELECT COUNT(receiver_user_id) as count_of_following FROM user_follow WHERE  sender_user_id=? ");
			$count_of_following_reg->execute(array($row['user_two']));
			if($count_of_following_reg_row=$count_of_following_reg->fetch()){
				
				$count_of_following=$count_of_following_reg_row['count_of_following'];
			}
			
			$count_of_followers_reg =$this->DB->prepare("SELECT COUNT(sender_user_id) as count_of_followers FROM user_follow WHERE  receiver_user_id=? ");
			$count_of_followers_reg->execute(array($row['user_two']));
			if($count_of_followers_reg_row=$count_of_followers_reg->fetch()){
				
				$count_of_followers=$count_of_followers_reg_row['count_of_followers'];
			}
			
				
										
				$inspection_level[$count]=$row;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['user_image']=$image;
				$inspection_level[$count]['user_bio']=$bio;
				$inspection_level[$count]['osi']=$osi;
				$inspection_level[$count]['isfollow']=$fol;
				$inspection_level[$count]['count_of_following']=$count_of_following;
				$inspection_level[$count]['count_of_followers']=$count_of_followers;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	
	public function accept_match($my_id,$match_id){
		
		
		$liker_user_reg =$this->DB->prepare("SELECT * FROM user_match_song WHERE  match_id=? ");
		$liker_user_reg->execute(array($match_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$user_two=$liker_user_reg_row['user_two'];
		}	
		
		
		$liker_user_reg =$this->DB->prepare("SELECT profile_lock,display_name,osi FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($user_two));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$profile_lock=$liker_user_reg_row['profile_lock'];
			$osi_id=$liker_user_reg_row['osi'];
		}
		
		$liker_user_reg =$this->DB->prepare("SELECT display_name FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($my_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$display_name=$liker_user_reg_row['display_name'];
		}
		
		
		$fuxk_reg =$this->DB->prepare("SELECT * FROM user_match_song WHERE  user_one=? and user_two=?");
		$fuxk_reg->execute(array($user_two,$my_id));
		if($fuxk_reg_row=$fuxk_reg->fetch()){

			$match_id_two=$fuxk_reg_row['match_id'];
			$status_two=$fuxk_reg_row['status'];
		}

		
		if($profile_lock==1){
			
			if($status_two=='0'){
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=2 WHERE  match_id=? ");
				$edit_case->execute(array($match_id));
				
			}elseif($status_two=='2'){
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=1 WHERE  match_id=? ");
				$edit_case->execute(array($match_id));	
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=1 WHERE  match_id=? ");
				$edit_case->execute(array($match_id_two));				
			}
			
			if($edit_case){
				
			$message=$display_name.' adlı kullanıcı, eşleşmeyi kabul etti.';
				
			$content = array(
			"en" => '1 Yeni Takip İsteği'
			);
			$heading = array(
			   "en" => $message
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($osi_id),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
			$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
				
			}
		}else{
			
			
			if($status_two=='0'){
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=2 WHERE  match_id=? ");
				$edit_case->execute(array($match_id));
				
			}elseif($status_two=='2'){
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=1 WHERE  match_id=? ");
				$edit_case->execute(array($match_id));	
				
				$edit_case = $this->DB->prepare("UPDATE user_match_song SET status=1 WHERE  match_id=? ");
				$edit_case->execute(array($match_id_two));				
			}
			
			
			}
			
		return $edit_case;
	}
	
	public function decline_match($my_id,$user_id){
		
		$change_class = $this->DB->prepare("UPDATE user_match_song SET status=3 WHERE  user_one =? and user_two=? ");
		$change_class->execute(array($my_id,$user_id));
		
		
		if($change_class){
			
		$liker_user_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($user_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$display_name=$liker_user_reg_row['display_name'];
			$osi=$liker_user_reg_row['osi'];
		}	
			
			$message=$display_name.' adlı kullanıcı, eşleşmeyi reddedti.';
				
			$content = array(
			"en" => '1 Yeni Takip İsteği'
			);
			$heading = array(
			   "en" => $message
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($osi),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
			$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
			
		
			
			$change_classes = $this->DB->prepare("UPDATE user_match_song SET status=4 WHERE  user_one =? and user_two=? ");
			$change_classes->execute(array($user_id,$my_id));

		
		
		}
		
			if($change_classes){return  true;}else{return  false;}
		
		
		
		
	}
	public function undecline_match($my_id,$user_id){
		
		$change_class = $this->DB->prepare("UPDATE user_match_song SET status=0 WHERE  user_one =? and user_two=? ");
		$change_class->execute(array($my_id,$user_id));
		
		
		if($change_class){
			
		$liker_user_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($user_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$display_name=$liker_user_reg_row['display_name'];
			$osi=$liker_user_reg_row['osi'];
		}	
			
			$message=$display_name.' adlı kullanıcı, eşleşmeyi geri çekti.';
				
			$content = array(
			"en" => '1 Yeni Takip İsteği'
			);
			$heading = array(
			   "en" => $message
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($osi),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
			$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
			
		
			
			$change_classes = $this->DB->prepare("UPDATE user_match_song SET status=0 WHERE  user_one =? and user_two=? ");
			$change_classes->execute(array($user_id,$my_id));

		
		
		}
		
			if($change_classes){return  true;}else{return  false;}
		
		
		
		
	}
	public function delete_match($my_id,$user_id){
		
		$change_class = $this->DB->prepare("DELETE FROM user_match_song WHERE user_one =? and user_two=?");
		$change_class->execute(array($my_id,$user_id));
		
		
		if($change_class){
			
		$liker_user_reg =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
		$liker_user_reg->execute(array($user_id));
		if($liker_user_reg_row=$liker_user_reg->fetch()){

			$display_name=$liker_user_reg_row['display_name'];
			$osi=$liker_user_reg_row['osi'];
		}	
			
			$message=$display_name.' adlı kullanıcı, eşleşmeyi reddetti.';
				
			$content = array(
			"en" => '1 Yeni Takip İsteği'
			);
			$heading = array(
			   "en" => $message
			);

		    $fields = array(
		      'app_id' => "ea03e363-3132-4a69-a472-80b4e8ccd660",
		      'include_player_ids' => array($osi),
		      'data' => array("foo" => "bar"),
		      'headings' => $heading,
		      'contents' => $content
		    );
			$fields = json_encode($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
			$response = curl_exec($ch);
			curl_close($ch);
				
			$change_class = $this->DB->prepare("INSERT INTO user_notification (sender_user_id, receiver_user_id ,message, proccess_time) VALUES (?,?,?,?)");
			$change_class->execute(array($my_id,$user_id,$message,date('Y-m-d H:m:s')));
		
			
			$change_classes = $this->DB->prepare("DELETE FROM user_match_song WHERE user_one =? and user_two=?");
			$change_classes->execute(array($user_id,$my_id));

		
		
		}
		
			if($change_classes){return  true;}else{return  false;}
		
		
		
		
	}
	
	public function connect_list($my_user_id){
		
		$query = $this->DB->prepare("SELECT user_id FROM user_song_preview where user_id!=?  group by user_id");
		$query->execute(array($my_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			
				$liker_user_reg =$this->DB->prepare("SELECT COUNT(*) as count_user,user_id FROM user_song_preview WHERE  user_id=?  ");
				$liker_user_reg->execute(array($row['user_id']));
				if($liker_user_reg_row=$liker_user_reg->fetch()){
					
					$count_user=$liker_user_reg_row['count_user'];
					$user_id=$liker_user_reg_row['user_id'];
				}
			
					$info =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
					$info->execute(array($user_id));
					if($info_row=$info->fetch()){

						$display_name=$info_row['display_name'];
						$images=$info_row['images'];
						$username=$info_row['username'];
					}			
			
			
				
				
					
				$inspection_level[$count]['user_id']=$user_id;
				$inspection_level[$count]['count_user']=$count_user;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['images']=$images;
					
				
										
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	public function chat_list($my_user_id){
		
		$query = $this->DB->prepare("SELECT * FROM user_match_song where user_two=? and status=1");
		$query->execute(array($my_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			

			$querys = $this->DB->prepare("SELECT follow_status from user_follow where receiver_user_id=? and sender_user_id=?");
			$querys->execute(array($row['user_two'],$my_user_id));
			if($staff_row= $querys->fetchAll()){$fol=1;}else{$fol=0;}
			
			
			$info =$this->DB->prepare("SELECT * FROM users WHERE  id=? ");
			$info->execute(array($row['user_one']));
			if($info_row=$info->fetch()){
				
				$display_name=$info_row['display_name'];
				$image=$info_row['images'];
				$osi=$info_row['osi'];
				$username=$info_row['username'];
			}
			
			$count_of_following_reg =$this->DB->prepare("SELECT COUNT(receiver_user_id) as count_of_following FROM user_follow WHERE  sender_user_id=? ");
			$count_of_following_reg->execute(array($row['user_one']));
			if($count_of_following_reg_row=$count_of_following_reg->fetch()){
				
				$count_of_following=$count_of_following_reg_row['count_of_following'];
			}
			
			$count_of_followers_reg =$this->DB->prepare("SELECT COUNT(sender_user_id) as count_of_followers FROM user_follow WHERE  receiver_user_id=? ");
			$count_of_followers_reg->execute(array($row['user_one']));
			if($count_of_followers_reg_row=$count_of_followers_reg->fetch()){
				
				$count_of_followers=$count_of_followers_reg_row['count_of_followers'];
			}
										
				$inspection_level[$count]=$row;
				$inspection_level[$count]['display_name']=$display_name;
				$inspection_level[$count]['user_image']=$image;
				$inspection_level[$count]['username']=$username;
				$inspection_level[$count]['osi']=$osi;
				$inspection_level[$count]['isfollow']=$fol;
				$inspection_level[$count]['count_of_following']=$count_of_following;
				$inspection_level[$count]['count_of_followers']=$count_of_followers;
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	public function list_preview_song($my_user_id){
		
		$query = $this->DB->prepare("SELECT * FROM user_song_preview where user_id=?   group by song_uri order by listen_id desc");
		$query->execute(array($my_user_id));
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			
			
			
					
				$inspection_level[$count]=$row;
					
			
										
								        
		        $count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	public function top_played($limit){
		
		$query = $this->DB->prepare("SELECT *, COUNT(*) AS magnitude FROM user_song_preview GROUP BY song_uri ORDER BY magnitude DESC LIMIT ".$limit);
		$query->execute(array());
		if ( $query->rowCount() ){
		$count = 0;
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				
				$inspection_level[$count]=$row;
				$count ++;
		    }
		} 
              
       if(isset($inspection_level)){$inspection_level=$inspection_level;}else{$inspection_level=null;}
       return $inspection_level;
		
	}
	public function connect_host($host_id,$user_id){
		
		$change_class = $this->DB->prepare("INSERT INTO connect_host (host_id, user_id ,status) VALUES (?,?,?)");
		$change_class->execute(array($host_id,$user_id));
		if($change_class){return  true;}else{return  false;}
	}
	public function first_update($user_id,$name,$username,$bio){
		
		$edit_case = $this->DB->prepare("UPDATE users SET display_name=?, username=?, bio=? WHERE  id=? ");
		$edit_case->execute(array($name,$username,$bio,$user_id));
		if($edit_case){return  true;}else{return  false;}
	}
}