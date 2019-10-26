<?php
/**
 *this is a doc block for the OOP.
 *
 * This is a much more detailed outline of whats going on in this page and why but I dont really know  or understand this yet
 * @author Damian Arya <darya@cnm.edu>
 */
namespace Darya\objectOrientedProgramming;

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
/** @author Damian Arya <darya@cnm.edu
 *@version (7.3)
 */
use Ramsey\Uuid\Uuid;
/** docblock section of author */
class Author implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this author; this is the primary key
	 * @var  Uuid $authorId
	 **/
	private $authorId;
	/**
	 * at Username for this author; this is a unique index
	 * @var string $authorId
	 **/
	private $authorActivationToken;
	/**
	 * token handed out to verify that the author is valid and not malicious.
	 *v@var $authorActivationToken
	 **/
	private $authorAvatarUrl;
	/**
	 * email for this author; this is a unique index
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for author password
	 * @var $authorHash
	 **/
	private $authorHash;
	/**
	 * phone number for this author
	 * @var string $authorPhone
	 **/
	private $authorUsername;

	/**
	 * constructor for this author
	 * @param Uuid | string $newAuthorId new user id
	 * @param string $newAuthorActivationToken
	 * @param string $newAuthorAvatarUrl
	 * @param string $newAuthorEmail address
	 * @param string $newAuthorHash new password
	 * @param string $newAuthorUsername
	 * @trows \RangeException if data vales are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \InvalidArgumentException if data types are not valid
	 **/
public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
	try {
		$this->setAuthorId($newAuthorId);
		$this->setAuthorActivationToken($newAuthorActivationToken);
		$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
		$this->setAuthorEmail($newAuthorEmail);
		$this->setAuthorHash($newAuthorHash);
		$this->setAuthorUsername($newAuthorUsername);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		//deturmine what exeption type was thrown
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 97, $exception));
	}
}
	/**
	 * Specify data which should be serialized to JSON
	 * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */

/**
 * accessor method for author id
 *
 * @return  Uuid value of author id (or null if new author)
 * */
public function getAuthorId(): Uuid {
	return ($this->authorId);
}

/**
 * mutator method for author id
 *
 * @param Uuid| string $newauthorId value of new author id
 * @throws \RangeException if $newauthorId is not positive
 * @throws \TypeError if the author Id is not
 **/
public function setAuthorId($newAuthorId): void {
	try {
		$uuid = self::validateUuid($newAuthorId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the author id
	$this->authorId = $uuid;
}

/**
 * accessor method for account activation token
 *
 * @return string value of the activation token
 */
public function getAuthorActivationToken(): ?string {
	return ($this->authorActivationToken);
}

/**
 * mutator method for account activation token
 *
 * @param string $newAuthorActivationToken
 * @throws \InvalidArgumentException  if the token is not a string or insecure
 * @throws \RangeException if the token is not exactly 32 characters
 * @throws \TypeError if the activation token is not a string
 */
public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
	if($newAuthorActivationToken === null) {
		$this->authorActivationToken = null;
		return;
	}
	$newauthorActivationToken = strtolower(trim($newAuthorActivationToken));
	if(ctype_xdigit($newAuthorActivationToken) === false) {
		throw(new\RangeException("user activation is not valid"));
	}
	//make sure user activation token is only 32 characters
	if(strlen($newAuthorActivationToken) !== 32) {
		throw(new\RangeException("user activation token has to be 32"));
	}
	$this->authorActivationToken = $newAuthorActivationToken;
}

/**
 *
 * accessor method for at Email
 *
 * @return string value of at Email
 **/
public function getAuthorEmail(): string {
	return $this->authorEmail;
}

/**
 * mutator method for at avatar
 *
 * @return  string value of avatar or null
 * */
public function getAuthorAvatarUrl(): ?string {
	return ($this->authorAvatarUrl);
}

/**
 * mutator method for avatar
 *
 * @param string $newAuthorAvatarUrl new value of avatar
 * @throws \InvalidArgumentException if $newAvatar is not a string or insecure
 * @throws \RangeException if $newAvatar is > 32 characters
 * @throws \TypeError if $newAvatar is not a string
 **/
public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
	// if $authorAvatarUrl is null return it right away
	If($newAuthorAvatarUrl === null) {
		$this->authorAvatarUrl = null;
		return;
	}
// verify the avatar is secure
	$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
	$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newAuthorAvatarUrl) === true) {
		throw(new \InvalidArgumentException("Author URL is empty or insecure"));
	}
	// verify the avatar will fit in the database
	if(strlen($newAuthorAvatarUrl) > 255) {
		throw(new \RangeException("Avatar is too large"));
	}
	// store the Avatar
	$this->authorAvatarUrl = $newAuthorAvatarUrl;
}

/**
 * mutator method for email
 *
 * @param string $newAuthorEmail new value of email
 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
 * @throws \RangeException if $newEmail is > 128 characters
 * @throws \TypeError if $newEmail is not a string
 **/
public function setAuthorEmail(string $newAuthorEmail): void {
	// verify the email is secure
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
	if(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("author email is empty or insecure"));
	}
	// verify the email will fit in the database
	if(strlen($newAuthorEmail) > 128) {
		throw(new \RangeException("author email is too large"));
	}
	// store the email
	$this->authorEmail = $newAuthorEmail;
}

/**
 * accessor method for authorHash
 *
 * @return string for authorHash hashed password
 */
public function getAuthorHash(): string {
	return ($this->authorHash);
}

/**
 * mutator method for author hash password
 *
 * @param string $newauthorHash vale of new author hashed password
 * @throws \InvalidArgumentException if the hash is not secure
 * @throws \RangeException if the hash is not 128 characters
 * @throws \TypeError if author hash is not a string
 */
public function setAuthorHash(string $newAuthorHash): void {
	//enforce that the hash is properly formatted
	$newAuthorHash = trim($newAuthorHash);
	$newAuthorHash = strtolower($newAuthorHash);
	if(empty($newAuthorHash) === true) {
		throw(new \InvalidArgumentException("author password hash empty or insecure"));
	}
	//enforce the hash is string represention of a hexadecimal
	//$authorHashInfo = password_get_info($newauthorHash);
	if(!ctype_xdigit($newAuthorHash)) {
		throw(new \InvalidArgumentException("author passphrase is empty or insecure"));
	}
	//enforce that the hash is exactly 128 characters.
	if(strlen($newAuthorHash) !== 97) {
		throw(new \RangeException("author hash must be 97 characters"));
	}
	//store the hash
	$this->authorHash = $newAuthorHash;
}

/**
 * accessor method for Username
 *
 * @return string value of Username
 **/
public function getAuthorUsername(): ?string {
	return ($this->authorUsername);
}

/**
 * mutator method for Username
 *
 * @param string $newAuthorUsername
 **/
public function setAuthorUsername(string $newAuthorUsername): void {
	// verify the at handel is secure
	$newAuthorUsername = trim($newAuthorUsername);
	$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newAuthorUsername) === true) {
		throw(new \InvalidArgumentException("Username is empty or insecure"));
	}
	// verify the at handle will fit in the database
	if(strlen($newAuthorUsername) > 32) {
		throw(new \RangeException("Username is too large"));
	}
	// store the Username
	$this->authorUsername = $newAuthorUsername;
}

	/**
	 * inserts author into mysql
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOExceptionwhen mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public  function insert(\PDO $pdo): void {
		//creates query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES (:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);
		// this creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"authorId" => $this->authorId->getBytes(),
			"authorAvatarUrl" => $this->authorAvatarUrl,
			"authorEmail" => $this->authorEmail,
			"authorHash" => $this->authorHash,
			"authorUserName" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * deletes author from mysql database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//creates query template
		$query = "DELETE FROM author WHERE authorId = :authorID";
		$statement = $pdo->prepare($query);

		//creates relationship between php state variables and PDO/mysql variables
		$parameters = ["authorID" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * update author in mysql database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function  update(\PDO $pdo): void {
		//create query template
		$query = "UPDATE author SET authorId = :authorId, authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"authorId" => $thisauthorId->getBytes(),
			"authorActivationToken" => $this->authorActivationToken,
			"authorAvatarUrl" => $this->authorAvatarUrl,
			"authorEmail" => $this->authorEmail,
			"authorHash" => $this->authorHash,
			"authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * function returns author username when querying by author Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId to search for
	 * @return Author|null author found or null if not found
	 * @throws \PDOException when mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function getAuthorUsernameByAuthorId(\PDO $pdo, $authorId) {
		//sanitizes the authorId befor querying
		try {
				$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	}
	//creates query template that SELECTs Author WHERE authorId is :authorId
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//creates relationship between php authorId and PDO/mysql authorId
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);
		//grab authorUsername from mysql
		try {
				$author = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
						$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);

				}
		} catch(\Exception $exception) {
			//if row couldent be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		};
		return  ($author);

}

	/**
	 * function returnes an array of authors containing the string in their username
	 *
	 * @param  \PDO $pdo PDO connection object
	 * @param  Uuid|string $authorUsername to search for
	 * @return \SplFixedArray of authors found
	 * @throws \PDOException when mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
public function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername): \SplFixedArray {
			//sanitize authorUsername string
			$authorUsername = trim($authorUsername);
			$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($authorUsername) === true) {
				throw (new \PDOException("content invalid fool"));
			}
			//escape any wildcards
	$authorUsername = str_replace("_", "\\_", str_replace("%", "\\%", $authorUsername));
	//create query templates that select authors from author where authorUsername contains %string%
	$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorUsername LIKE :authorUsername";
	$statement = $pdo->prepare($query);
	//creates relationship between mysql %string% query and placeholder
	$authorUsername = "%authorUsername%";
	$parameters = ["authorUsername" => $authorUsername];
	//execute() function passes $parameters to prepare() 'd function and runs the $query with $parameters
	$statement->execute($parameters);
	//build and array of authors
	$authors = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorUsername"]);
			$authors[$authors->key()] = $author;
			$authors->next();
		} catch(\Exception $exception) {
			//if the row couldent be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
return  ($authors);
}

	/**
	 * formats the state variables for Json serializable
	 *
	 * @return array resulting state variables to serialize
	 */
public function jsonSerialize(): array {
	//this collects all state variables
		$fields = get_object_vars($this);
		//turns Uuid into string
		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorHash"]);
		return ($fields);
	}
}