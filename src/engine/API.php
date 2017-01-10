<?php

/**
* Class represents API methods which are accessible from outside.
* Each of methods might be called useng REST API like http://<hostname>/api/<methodName>/
* Sample:
* /api/Auth/
* with POST data `mail` and `pwd`
* returns JSON with.
* Each method recieves parameters from POST data
* Each method returns JSON data of format:
* {	
*	response: {
*		code: 0, // 0 - always success
*		error: '<error message>',
*		data: { 
*			User: {
*				name: ...,
*				surname: ...
*				...
*			}
*		}
*	}
* }
**/
class API {

	/**
	* Method for user authentication
	* Recieves `mail` and `pwd`
	**/
	public static function Auth() {
		$response = array();
		if(!Flight::getGlobal('user_logged')){
			if(isset($_POST['mail']) && isset($_POST['pwd'])) {
				$User = DB::getUserByMail($_POST['mail']);
				if($User === 1) {
					$response['code'] = 1;
					$response['error'] = 'User doesn\'t exist';
				} else if($User === 2) {
					$response['code'] = 2;
					$response['error'] = 'Email doesn\'t match allowed format';
				} else {
					if(password_verify($_POST['pwd'], $User->getPwd())) {
						Flight::setGlobal('user_logged', true);
						Flight::setGlobal('user_name', $User->getName());
						Flight::setGlobal('user_surname', $User->getSurname());
						Flight::setGlobal('user_id', $User->getId());
						$response['code'] = 0;
						$response['error'] = '';
					} else {
						$response['code'] = 3;
						$response['error'] = 'Incorrect password';
					}
				}
			} else {
				$response['code'] = 3;
				$response['error'] = 'Email or password not provided';
			}
		} else {
			$response['code'] = 4;
			$response['error'] = 'User is logged in already';
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for user registration
	* Recieves `mail`, `name`, `surname` and `pwd`
	**/
	public static function Register() {
		$response = array();
		if(!Flight::getGlobal('user_logged')){
			if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['mail']) && isset($_POST['pwd'])) {
				if(DB::checkMailRegistered($_POST['mail']) == 0) {
					if(DB::registerUser($_POST['name'], $_POST['surname'], $_POST['mail'], $_POST['pwd']) == 0){
						$response['code'] = 0;
						$response['error'] = '';
					} else {
						$response['code'] = 2;
						$response['error'] = 'Register failed';
					}
				} else {
					$response['code'] = 1;
					$response['error'] = 'Email is occupied';
				}
			} else {
				$response['code'] = 3;
				$response['error'] = 'Email, name, surname or password not provided';		
			}
		} else {
			$response['code'] = 4;
			$response['error'] = 'User is logged in already';
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for uploading file to server
	**/
	public static function FileUpload() {
		$response = array();
		if(!Flight::getGlobal('user_logged')) {
			$response['code'] = 2;
			$response['error'] = 'User is not logged in';
		} else {
			$ds = DIRECTORY_SEPARATOR;
			$storeFolder = '..' . $ds . 'data' . $ds;
			if(!empty($_FILES)) {
				for( $i = 0; $i < count($_FILES['file']['tmp_name']); $i++) {
					$type = explode('/', $_FILES['file']['type'][$i])[0];
					$tempFile = $_FILES['file']['tmp_name'][$i];
					$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $type . $ds;
					$targetFile = $targetPath . $_FILES['file']['name'][$i];
					move_uploaded_file($tempFile, $targetFile);
					if(DB::storeFile($type, $_FILES['file']['name'][$i]) !== 0) {
						$response['code'] = 2;
						if(isset($response['error'])) {
							$response['error'] .= ', ' . $_FILES['file']['name'][$i];
						} else {
							$response['error'] = 'Unable to store some files: ' . $_FILES['file']['name'][$i];
						}
					}
				}
				if($response['code'] != 2) {
					$response['code'] = 0;
					$response['error'] = '';
				}
			} else {
				$response['code'] = 1;
				$response['error'] = 'Files not provided';
			}
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for removing a file from server
	**/
	public static function FileRemove() {
		$response = array();
		if(!Flight::getGlobal('user_logged')) {
			$response['code'] = 2;
			$response['error'] = 'User is not logged in';
		} else {
			if (isset($_POST['file'])) {
				$File = DB::getFileByName($_POST['file']);
				if($File === 1) {
					$response['code'] = 1;
					$response['error'] = 'File not found';
				} else {
					if(Flight::getGlobal('user_id') == $File->getUserId()){
						$storeFolder = '..' . $ds . '..' . $ds . 'data' . $ds . $File->type;
						$targetPath = dirname(__FILE__) . $ds. $storeFolder . $ds . $File->name;
						if(file_exists($targetPath)){
							unlink($targetPath);
							if(file_exists($targetPath)) {
								$response['code'] = 3;
								$response['error'] = 'Unable to remove file';
							}
						}
						if(DB::removeFile($File->id) === 0) {
							$response['code'] = 0;
							$response['error'] = '';
						} else {
							$response['code'] = 4;
							$response['error'] = 'Unable to remove file from database';
						}
					} else {
						$response['code'] = 5;
						$response['error'] = 'File not belongs to the user';
					}
				}
			}
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method returns issues. Might be filtered.
	* Params:
	* $start - initial position
	* $num - number of elements
	* $sort - 0: date, 1: rating
	* $order - 0: desc, 1: asc
	* $user - <user_id>: issues created by user <user_id>, '*': created by all users
	**/
	public static function GetIssues() {
		$response	= array();
		
		$params = func_get_args();
		
		$start		= isset($params['start'])	? $params['start']	: (isset($_POST['start'])	? $_POST['start']	: null	);
		$num		= isset($params['num'])		? $params['num']	: (isset($_POST['num'])		? $_POST['num']		: null	);
		$sort		= isset($params['sort'])	? $params['sort']	: (isset($_POST['sort'])	? $_POST['sort']	: null	);
		$order		= isset($params['order'])	? $params['order']	: (isset($_POST['order'])	? $_POST['order']	: null	);
		$user		= isset($params['user'])	? $params['user']	: (isset($_POST['user'])	? $_POST['user']	: null	);
		
		$start		= is_numeric($start)					? intval($start)	: 0;
		$num		= is_numeric($num)						? intval($num)		: 30;
		$sort		= ($sort === 0 | $sort === 1)			? intval($sort)		: 0;
		$order		= ($order === 0 | $order === 1)			? intval($order)	: 0;
		$user		= (is_numeric($user) | $user == '*')	? (string)$user		: '*';
		
		$Issues = DB::getIssues($start, $num, $sort, $order, $user);
		if($Issues === 1) {
			$response['code'] = 1;
			$response['error'] = 'No issues found';
		} else if($Issues === 2) {
			$response['code'] = 2;
			$response['error'] = 'There was an error during issues extraction';
		} else {
			$response['code'] = 0;
			$response['error'] = '';
			$response['data'] = $Issues;
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for creating an Issue
	* Note: attachments is a JSON string got from array of file names
	* It should look as '[0 => "file1_name.ext", 1 => "file2_name.ext"]'
	**/
	public static function CreateIssue() {
		$response = array();
		if(Flight::getGlobal('user_logged')) {
			if (isset($_POST['head']) && isset($_POST['text']) && isset($_POST['attachments'])) {
				if(DB::addIssue($_POST['head'], $_POST['text'], $_POST['attachments']) == 0) {
					$response['code'] = 0;
					$response['error'] = '';
				} else {
					$response['code'] = 3;
					$response['error'] = 'There was an error while inserting into DB';
				}
			} else {
				$response['code'] = 1;
				$response['error'] = 'Parameters `head`, `text` or `attachments` are not passed';
			}
		} else {
			$response['code'] = 2;
			$response['error'] = 'User is not logged in';
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method returns threads. Might be filtered.
	* Params:
	* $start - initial position
	* $num - number of elements
	* $order - 0: desc, 1: asc
	* $user - <user_id>: issues created by user <user_id>, '*': created by all users
	**/
	public static function GetThreads() {
		$response = array();
		$start	= isset($_POST['start'])	&& is_numeric($_POST['start'])							? intval($_POST['start'])	: 0;
		$num	= isset($_POST['num'])		&& is_numeric($_POST['num'])							? intval($_POST['num'])		: 30;
		$order	= isset($_POST['order'])	&& ($_POST['order'] === 0 | $_POST['order'] === 1)		? intval($_POST['order'])	: 0;
		$user	= isset($_POST['user'])		&& (is_numeric($_POST['user']) | $_POST['user'] == '*')	? (string)$_POST['user']	: '*';
	
		$Threads = DB::getThreads($start, $num, $order, $user);
		if($Threads === 1) {
			$response['code'] = 1;
			$response['error'] = 'No threads found';
		} else if($Threads === 2) {
			$response['code'] = 2;
			$response['error'] = 'There was an error during threads extraction';
		} else {
			$response['code'] = 0;
			$response['error'] = '';
			$response['data'] = $Threads;
		}
	
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for creating a Poll
	**/
	public static function CreatePoll() {
		$response = array();
		if(!Flight::getGlobal('user_logged')) {
			$response['code'] = 2;
			$response['error'] = 'User is not logged in';
		} else {
			if (isset($_POST['items'])) {
				$Poll = DB::createPoll($_POST['items']);
				if($Poll === 1){
					$response['code'] = 4;
					$response['error'] = 'Items is not a valid JSON';
				} else if($Poll === 2){
					$response['code'] = 3;
					$response['error'] = 'There was an error during poll insertion';
				} else {
					$response['code'] = 0;
					$response['error'] = '';
					$response['data'] = $Poll;
				}
			} else {
				$response['code'] = 1;
				$response['error'] = 'Items argument not provided';
			}
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	* Method for creating a Poll
	**/
	public static function CreateThread() {
		$response = array();
		if(!Flight::getGlobal('user_logged')) {
			$response['code'] = 2;
			$response['error'] = 'User is not logged in';
		} else {
			if(isset($_POST['head']) && isset($_POST['text'])) {
				$poll = isset($_POST['poll']) && is_numeric($_POST['poll']) ? intval($_POST['poll']) : -1;
				$attachments = isset($_POST['attachments']) ? $_POST['attachments'] : '';
				$Thread = DB::createThread($_POST['head'], $_POST['text'], $poll, $attachments);
				if($Thread === 1){
					$response['code'] = 3;
					$response['error'] = 'There was an error during thread insertion';
				} else {
					$response['code'] = 0;
					$response['error'] = '';
					$response['data'] = $Thread;
				}
			} else {
				$response['code'] = 1;
				$response['error'] = 'Head or text not provided';
			}
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}
}