<?php

/**
* The class is a kind of model. It represents methods for interaction with DB.
* It is not a model in MVC conception but something like a wrapper between database 
* and business logic.
* It contains static methods and each one of them used for a single task of for a 
* small group of tasks.
* Each method should return a code (integer) or an Object
* For example method getIssue returns Issue() Object
**/
class DB {
	/**
	* Method for getting User object by provided email.
	* If succeeded returns User object. 
	* Otherwise returns 
	* - code 1 if user not found
	* - code 2 if provided email validation failed
	**/
	public static function getUserById($id) {
		$db = Flight::db();
		$stmt = $db->prepare('select * from user where id=?');
		$stmt->execute(array($id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
		$user = $stmt->fetch();
		if($user){
			return $user;
		} else {
			return 1;
		}
	}
	
	/**
	* Method for getting User object by provided email.
	* If succeeded returns User object. 
	* Otherwise returns 
	* - code 1 if user not found
	* - code 2 if provided email validation failed
	**/
	public static function getUserByMail($mail) {
		$db = Flight::db();
		if($mail = filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$query = $db->query('select * from user where mail="' . $mail . '"', PDO::FETCH_CLASS, 'User');
			$user = $query->fetch();
			if($user){
				return $user;
			} else {
				return 1;
			}
		} else {
			return 2;
		}
	}

	/**
	* User registration method
	* Returns 0 if succeded
	* 1 in case of PDO exception
	**/
	public static function registerUser($name, $surname, $mail, $pwd) {
		$db = Flight::db();
		try {
			$pwd = password_hash($pwd, PASSWORD_DEFAULT);
			$stmt = $db->prepare('insert into user (`name`,`surname`,`mail`,`pwd`) values (?, ?, ?, ?)');
			$stmt->execute(array($name, $surname,$mail, $pwd));
			return 0;
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* Method for checking if a email is used.
	* Returns 
	* - 0: email free
	* - 1: email occupied
	* - 2: provided email validation failed
	**/
	public static function checkMailRegistered($mail) {
		$db = Flight::db();
		if($mail = filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$query = $db->query('select count(*) from user where mail="' . $mail . '"');
			$count = $query->fetch(PDO::FETCH_NUM)[0];
			if($count == 0){
				return 0;
			} else {
				return 1;
			}
		} else {
			return 2;
		}
	}
	
	/**
	* Method for storing user data in database
	**/
	public static function storeFile($type, $name) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('insert into `user_data` (`user_id`, `type`, `name`) values (?, ?, ?)');
			$stmt->execute(array(Flight::getGlobal('user_id'), $type, $name));
			return 0;
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* Method returns File objects from database by names
	* Requires array of names
	* Returns FileFactory object
	**/
	public static function getFilesByNames($names) {
		$db = Flight::db();
		if(empty($names) || $names == null) {
			return 1;
		}
		$names_filtered = array();
		foreach($names as $name) {
			array_push($names_filtered, $db->quote($name));
		}
		$stmt = $db->prepare('SELECT * FROM `user_data` WHERE `name` IN (' . join(',', $names_filtered) . ')');
		$stmt->execute();
		$objects = $stmt->fetchAll(PDO::FETCH_CLASS, 'File');
		if(count($objects) > 0){
			$Files = new FileFactory();
			foreach($objects as $File) {
				$Files->addFile($File);
			}
			return $Files;
		} else {
			return 1;
		}
	}
	
	/**
	* Method returns File objects from database by ids
	* Requires array of ids
	* Returns FileFactory object
	**/
	public static function getFilesByIds($ids) {
		$db = Flight::db();
		if(empty($ids) || $ids == null) {
			return 1;
		}
		$ids_filtered = array();
		foreach($ids as $item) {
			if($item = filter_var($item, FILTER_VALIDATE_INT)) {
				array_push($ids_filtered, $item);
			}
		}
		$stmt = $db->prepare('SELECT * FROM `user_data` WHERE `id` IN (' . join(',', $ids_filtered) . ')');
		$stmt->execute();
		$objects = $stmt->fetchAll(PDO::FETCH_CLASS, 'File');
		if(count($objects) > 0){
			$Files = new FileFactory();
			foreach($objects as $File) {
				$Files->addFile($File);
			}
			return $Files;
		} else {
			return 1;
		}
	}
	
	/**
	* Method returns File object from database by id
	**/
	public static function getFileById($id) {
		$db = Flight::db();
		$stmt = $db->prepare('select * from `user_data` where `id`=?');
		$stmt->execute(array($id));
		$File = $stmt->fetch(PDO::FETCH_CLASS, 'File');
		if($File){
			return $File;
		} else {
			return 1;
		}
	}
	
	/**
	* Method returns File object from database by name
	**/
	public static function getFileByName($name){
		$db = Flight::db();
		$stmt = $db->prepare('select * from `user_data` where `name`=?');
		$stmt->execute(array($name));
		$File = $stmt->fetch(PDO::FETCH_CLASS, 'File');
		if($File){
			return $File;
		} else {
			return 1;
		}
	}
	
	/**
	* Method removes file record from database by its id
	**/
	public static function removeFile($id) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('delete from `user_data` where `id`=?');
			$stmt->execute(array($id));
			return 0;
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* The method returns issues stored in database.
	* Params:
	* $start - initial position
	* $num - number of elements
	* $sort - 0: date, 1: rating
	* $order - 0: desc, 1: asc
	* $user - <user_id>: issues created by user <user_id>, '*': created by all users
	**/
	public static function getIssues($start, $num, $sort, $order, $user) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('
				SELECT `issues`.`id`, `head`, `text`, `creator`, `date`, `issue_status`.`name` as `status`, `rating`, `attachments` 
				FROM `issues` 
				LEFT JOIN `issue_status` ON `issues`.`status`=`issue_status`.`id`
				' . ($user != '*' ? 'WHERE `creator`=' . $user : '') . '
				ORDER BY `' . ($sort == 0 ? 'date' : 'rating') . '` 
				' . ($order == 0 ? 'DESC' : 'ASC') . ' 
				LIMIT ' . $start . ', ' . $num);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(count($results) > 0) {
				$Issues = new IssueFactory();
				foreach($results as $row => $issue) {
					$Files = DB::getFilesByIds(explode(',', $issue['attachments']));
					if($Files === 1) {
						$Files = new FileFactory();
					}
					$Issue = new Issue($issue['id'], $issue['head'], $issue['text'], $issue['creator'], $issue['date'], $issue['status'], $issue['rating'], $Files);
					$Issues->addIssue($Issue);
				}
				return $Issues;
			} else {
				return 1;
			}
		} catch(PDOException $e) {
			return 2;
		}
	}
	
	/**
	* Add Issue to database
	**/
	public static function addIssue($head, $text, $attachments) {
		$db = Flight::db();
		$attachments = json_decode($attachments);
		$Files = DB::getFilesByNames($attachments);
		if($Files === 1) {
			$Files = new FileFactory();
		}
		$ids = $Files->getIds();
		$ids_string = join(',', $ids);
		try {
			$stmt = $db->prepare('INSERT INTO `issues` (`head`, `text`, `attachments`, `creator`) values (?, ?, ?, ?)');
			$stmt->execute(array($head, $text, $ids_string, Flight::getGlobal('user_id')));
			return 0;
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* The method returns threads stored in database.
	* Params:
	* $start - initial position
	* $num - number of elements
	* $order - 0: desc, 1: asc
	* $user - <user_id>: issues created by user <user_id>, '*': created by all users
	**/
	public static function getThreads($start, $num, $order, $user) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('
				SELECT `forum`.`id`, `head`, `text`, `attachments`, `forum`.`creator`, `date`, `polls`.`id` AS `poll_id`, `polls`.`items` AS `poll_items`, `polls`.`creator` AS `poll_creator`
				FROM `forum`
				LEFT JOIN `polls` ON `polls`.`id`=`forum`.`poll`
				' . ($user != '*' ? 'WHERE `creator`=' . $user : '') . '
				ORDER BY `date`
				' . ($order == 0 ? 'DESC' : 'ASC') . '
				LIMIT ' . $start . ', ' . $num);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(count($results) > 0) {
				$Threads = new ThreadsFactory();
				foreach($results as $row => $thread) {
					$Files = DB::getFilesByIds(explode(',', $thread['attachments']));
					if($Files === 1) {
						$Files = new FileFactory();
					}
					$Poll;
					if($thread['poll_id'] != -1) {
						$Poll = DB::getPoll($thread['poll_id']);
					} else {
						$Poll = new Poll();
					}
					$Thread = new Thread($thread['id'], $thread['head'], $thread['text'], $thread['creator'], $thread['date'], $Poll, $Files);
					$Threads->addThread($Thread);
				}
				return $Threads;
			} else {
				return 1;
			}
		} catch(PDOException $e) {
			return 2;
		}
	}
	
	/**
	* Method for Poll extraction from database
	**/
	public static function getPoll($id) {
		$db = Flight::db();
		$stmt = $db->prepare('SELECT * FROM `polls` WHERE `id`=?');
		$stmt->execute(array($id));
		$poll = $stmt->fetch(PDO::FETCH_ASSOC);
		$Poll = new Poll();
		if($poll){
			$Poll->setId($id);
			$Poll->setCreator($poll['creator']);

			$stmt = $db->prepare('SELECT `item_id`, COUNT(*) as `number` FROM `poll_votes` WHERE `poll_id`=? GROUP BY `item_id`');
			$stmt->execute(array($id));
			$votes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$items = json_decode($poll['items']);
			for($i = 0; $i < count($items); $i++) {
				$votes_num = 0;
				foreach($votes as $vote) {
					if(intval($vote['item_id']) == $i) {
						$votes_num = $vote['number'];
						break;
					}
				}
				$Poll->addItem($items[$i], $votes_num);
			}
		}
		return $Poll;
	}
	
	/**
	* Method for insertion Poll into database
	**/
	public static function createPoll($items) {
		$db = Flight::db();
		json_decode($items);
		if(json_last_error() == JSON_ERROR_NONE) {
			try {
				$stmt = $db->prepare('INSERT INTO `polls` (`items`, `creator`) values (?, ?)');
				$stmt->execute(array($items, Flight::getGlobal('user_id')));
				
				$query = $db->query('SELECT MAX(`id`) FROM `polls`');
				$id = $query->fetch(PDO::FETCH_NUM)[0];
				
				return DB::getPoll($id);
			} catch(PDOException $e) {
				return 2;
			}
		} else {
			return 1;
		}
	}
	
	/**
	* Add Thread to database
	**/
	public static function createThread($head, $text, $poll, $attachments) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('INSERT INTO `forum` (`head`, `text`, `poll`, `attachments`, `creator`) values (?, ?, ?, ?, ?)');
			$stmt->execute(array($head, $text, $poll, $attachments, Flight::getGlobal('user_id')));
			
			$query = $db->query('SELECT MAX(`id`) FROM `forum`');
			$id = $query->fetch(PDO::FETCH_NUM)[0];
				
			return DB::getThreadById($id);
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* Retrive Thread from database
	**/
	public static function getThreadById($id) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('SELECT * FROM `forum` WHERE `id`=?');
			$stmt->execute(array($id));
			$thread = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$Files = DB::getFilesByIds(explode(',', $thread['attachments']));
			if($Files === 1) {
				$Files = new FileFactory();
			}
			$Poll;
			if($thread['poll'] != -1) {
				$Poll = DB::getPoll($thread['poll']);
			} else {
				$Poll = new Poll();
			}
			$Thread = new Thread($thread['id'], $thread['head'], $thread['text'], $thread['creator'], $thread['date'], $Poll, $Files);
			
			return $Thread;
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* Retrive Pages from database
	**/
	public static function getPages() {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('SELECT * FROM `pages`');
			$stmt->execute();
			$objects = $stmt->fetchAll(PDO::FETCH_CLASS, 'Page');
			if(count($objects) > 0) {
				$Pages = new PageFactory();
				foreach($objects as $Page) {
					$Pages->addPage($Page);
				}
				return $Pages;
			} else {
				return 2;
			}
		} catch(PDOException $e) {
			return 1;
		}
	}
	
	/**
	* Get modules for page`id`
	**/
	public static function getPageModules($id) {
		$db = Flight::db();
		try {
			$stmt = $db->prepare('
				SELECT `page_modules`.`id`, `page_id`, `module_id`, `styles`, `scripts`, `position_id`, `params`, `modules`.`name` AS `module_name`, `position`, `positions`.`name` AS `position_name`, `file`, `block_id`, `max_row_items`
				FROM `page_modules`
				LEFT JOIN `positions` ON `positions`.`id`=`page_modules`.`position_id`
				LEFT JOIN `position_block` ON `position_block`.`id`=`positions`.`block_id`
				LEFT JOIN `modules` ON `modules`.`id`=`page_modules`.`module_id` 
				WHERE `page_id`=?'
			);
			$stmt->execute(array($id));
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(count($data) > 0) {
				$Modules = new ModuleFactory();
				foreach($data as $row) {
					$styles = explode(',', $row['styles']);
					$scripts = explode(',', $row['scripts']);
					$Position = new Position($row['position_id'], $row['position_name'], $row['position'], $row['block_id'], ( isset($row['max_row_items']) ? $row['max_row_items'] : 0 ));
					$Module = new Module($row['id'], $row['module_id'], $row['page_id'], $row['module_name'], $Position, $row['file'], json_decode($row['params'], true), $styles, $scripts);
					$Modules->addModule($Module);
				}
				return $Modules;
			} else {
				return 2;
			}
		} catch(PDOException $e) {
			return 1;
		}
	}
	
}