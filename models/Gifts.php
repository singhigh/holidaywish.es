<?php

$classBuilder['Gifts'] = new GiftsModel();

class GiftsModel {

	/*
	 * Purpose: Get all the details for a user's gifts
	 *
	 * @param int user's id
	 *
	 * @return bool false=didn't work
	 * @return array of gift object literals
	*/
	public function getGiftDetails($id) {
		if(!is_numeric($id)) return false;

		$sql = "SELECT gifts.name, gifts.thumbnail, gifts.description, gifts.notes, gifts.price, gifts.link, gifts.purchased, gifts.go_in_on, users.username".
			" FROM gifts, users".
			" WHERE gifts.user_id = users.id AND gifts.deleted = 0 AND gifts.user_id=".$id;

		$data = mysql_query($sql);

		$allGifts = array();

		while($gift = mysql_fetch_object($data)) {
			array_push($allGifts, $gift);
		}

		return $allGifts;
	}

	/*
	 * Purpose: Add a gift to the database
	 *
	 * @param int user's id
	 * @param string gift name
	 * @param string thumbnail link
	 * @param string description
	 * @param double price
	 * @param string purchase link
	 *
	 * @return boolean true=worked
	 * @return string error message
	*/
	public function addGift($id, $name, $thumbnail, $description, $price, $link) {
		if(!is_numeric($id)) return "You can't add gifts!";
		if(!is_numeric($price)) return "The price has to be a number!";
		
		$name = mysql_escape_string($name);
		$description = mysql_escape_string($description);
		$thumbnail = mysql_escape_string($thumbnail);
		$link = mysql_escape_string($link);

		$sql = "INSERT INTO gifts (`user_id`, `name`, `thumbnail`, `description`, `price`, `link`) VALUES (".
			$id.", '".$name."', '".$thumbnail."', '".$description."', ".$price.", '".$link."')";

		mysql_query($sql);
	
		return true;
	}

}

?>
