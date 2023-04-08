<?php

class Discussion
{

	// pole se smajlíky

	private array $emoticons = array(
		':-)' => '<img src = "pictures/emoticons/smile.png">',
		':)' => '<img src = "pictures/emoticons/smile.png">',
		':-(' => '<img src = "pictures/emoticons/unhappy.png">',
		':(' => '<img src = "pictures/emoticons/unhappy.png">',
		':-D' => '<img src = "pictures/emoticons/grin.png">',
		':D' => '<img src = "pictures/emoticons/grin.png">',
		':-P' => '<img src = "pictures/emoticons/tongue.png">',
		':P' => '<img src = "pictures/emoticons/tongue.png">',
		':-O' => '<img src = "pictures/emoticons/suprised.png">',
		':O' => '<img src = "pictures/emoticons/suprised.png">',
		';-D' => '<img src = "pictures/emoticons/wink.png">',
		';D' => '<img src = "pictures/emoticons/wink.png">',
	);

	// Přidá novou zprávu do databáze

	public function addMessage(string $nickname, string $message) : void
	{
		Database::ask('INSERT INTO `message` (`nickname`, `content`, `sent`) VALUES (?, ?, NOW())', array($nickname, $message));
	}

	// Zformátuje zprávu
	private function editMessage(string $message) : string
	{
		// Nahrazení rezervovaných HTML znaků 
		$message = htmlspecialchars($message);
		// Nahrazení smajlíků obrázky
		$message = strtr($message, $this->emoticons);
		// Nahrazení konců řádku z <br />
		$message = nl2br($message);
		return $message;
	}

	// Vypíše diskuzi

	public function list() : void
	{
		$result = Database::ask('SELECT * FROM `message` ORDER BY `sent` DESC LIMIT 10');
		$messages = $result->fetchAll();
		foreach ($messages as $message)
		{
			echo('<p><img src="pictures/avatar.png" alt="avatar" class="avatar"><strong>' . htmlspecialchars($message['nickname']) . '</strong><br />');
			echo($this->editMessage($message['content']) . '<br /><br />');
			echo('<p class="message"><small>' . date("j.m.Y", strtotime($message['sent'])) . '</small></p>');
			echo('</p><div class="clear"></div>');
		}
	}


}