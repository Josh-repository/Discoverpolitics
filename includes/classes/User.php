<?php 
class User
	{
		private $user;
		private $con;

		public function __construct($con,$user)
		{
			$this->con=$con;
			$user_details_query=mysqli_query($con,"SELECT * FROM voters WHERE username='$user'");
			$this->user=mysqli_fetch_array($user_details_query);
		}
	public function getusername()
		{
			return $this->user['username'];
		}
		public function getNumPost()
		{
			$username=$this->user['username'];
			$query=mysqli_query($this->con,"SELECT num_post FROM voters WHERE username='$username'");
			$row=mysqli_fetch_array($query);
			return $row['num_post'];
		}
		
	public function getcharacter()
		{
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"SELECT * FROM voters WHERE username='$username'");
		$row=mysqli_fetch_array($query);
		return $row['username'];
		}
		public function isClosed()
		{
			$username=$this->user['username'];
			$query=mysqli_query($this->con,"SELECT user_closed FROM voters WHERE username='$username'");
			$row=mysqli_fetch_array($query);

			if($row['user_closed']=='yes')
				return true;
			else
				return false;
		}
		
	public function isFriend($username_to_check) 
		{
		$usernameComma = "," . $username_to_check . ",";
		if((strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['username'])) 
		{
			return true;
		}
		else 
		{
			return false;
		}
		}

	
	public function getProfilePic()
		{
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"SELECT * FROM voters WHERE username='$username'");
		$row=mysqli_fetch_array($query);
		return $row['profile_pic'];
		}

	public function didReceiveRequest($user_from)
	{
		$user_to=$this->user['username'];
		$check_request_query=mysqli_query($this->con,"SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function didSendRequest($user_to)
	{
		$user_from=$this->user['username'];
		$check_request_query=mysqli_query($this->con,"SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query)>0)
		{   
			
			return true;
		}
		else
		{
			return false;
		}
	}
	public function removeFriend($user_to_remove)
	{   
		$logged_in_user=$this->user['username'];
		$query=mysqli_query($this->con,"SELECT friend_array FROM voters WHERE username='$user_to_remove'");
		$row=mysqli_fetch_array($query);
		$friend_array_username=$row['friend_array'];
		
		$new_friend_array=str_replace($user_to_remove.",","",$this->user['friend_array']);
		$remove_friend=mysqli_query($this->con,"UPDATE voters SET friend_array='$new_friend_array' WHERE username='$logged_in_user'");

		$new_friend_array=str_replace($this->user['username'] . "," ,"", $friend_array_username);
		$remove_friend=mysqli_query($this->con,"UPDATE voters SET friend_array='$new_friend_array' WHERE username='$user_to_remove'");
	}

	public function sendRequest($user_to)
	{
		$user_from=$this->user['username'];
		$query=mysqli_query($this->con,"INSERT INTO friend_requests VALUES('','$user_to','$user_from')");
	}
	public function getFriendArray()
		{
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"SELECT * FROM voters WHERE username='$username'");
		$row=mysqli_fetch_array($query);
		return $row['friend_array'];
		}


}

 ?>