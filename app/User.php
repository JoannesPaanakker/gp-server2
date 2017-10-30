<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];



	// executes a push notification
	public static function triggerPush($message, $destination){
	
		$curl = curl_init();

		// if $destination is a string, send only to that token
		// if $destination is a list of users, send to all of them

		$payload = ['content' => $message];

		if(empty($destination)){
			return false;
		}

		// destination is only one user
		if (is_string($destination)) {

			$data = [
				[
					'to' => $destination,
					'data' => json_encode($payload),
					'sound' => 'default',
					'body' => $message,
					'badge' => '1',
				],
			];

		}else{

			// if $destination is empty, exit
			if(!is_array($destination) || count($destination) == 0){
				return false;
			}

			$data = [];
			foreach($destination as $user){
				$data[] = [
					'to' => $user->device_token,
					'data' => json_encode($payload),
					'sound' => 'default',
					'body' => $message,
					'badge' => '1',
				];
			}

		}


		// splits the array and sends pushes
		$push_queue = array_chunk($data, 98);
		foreach ($push_queue as $batch) {
			curl_setopt_array($curl, array(
				CURLOPT_URL => env('PUSH_ENDPOINT'),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($batch),
				CURLOPT_HTTPHEADER => array(
					"content-type: application/json",
					"accept: application/json",
					"accept-encoding: application/json",
				),
			));
		}

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		return $response;
		
	}


	// sends a push notification to the user
	public function sendPushNotification($message) {
		User::triggerPush($message, $this->device_token);
	}

	public static function sendPushNotificationToMultipleUsers($users, $message) {
		User::triggerPush($message, $users);
	}



	public function getImage()
    {

    	if(empty($this->picture)){
    		return env('APP_URL') . '/photos/default-user.jpg';
    	}

    	if(strstr($this->picture, 'facebook.com')){
    		$hires = str_replace('picture?type=large', 'picture?width=500&height=500', $this->picture);
    		return $hires;
    	}else{
    		return $this->picture;
    	}
        
    }

	public function pages() {
		return $this->hasMany(Page::class);
	}

	public function reviews() {
		return $this->hasMany(Review::class);
	}

	public function goals() {
		return $this->hasMany(Goal::class);
	}

	public function tips() {
		return $this->hasMany(Tip::class);
	}

	public function following_pages() {
		return $this->belongsToMany(Page::class, 'follows')->withTimestamps();
	}

	public function following_users() {
		return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id')->withTimestamps();
	}

	public function followed_by() {
		return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id')->withTimestamps();
	}

	public function sendEmail($subject, $body) {
		$user = $this;
		\Mail::send('emails.notification', ['title' => $subject, 'content' => $body], function ($m) use ($user, $subject) {
			$m->from('noreply@greenplatform.org', 'GreenPlatform');
			$m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject($subject);
		});
	}

}
