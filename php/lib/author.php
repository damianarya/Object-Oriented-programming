<?php
require_once ("../Classes/Author.php");
use Darya\objectOrientedProgramming\Author;

require_once(dirname(__DIR__) . "/Classes/Author.php");
$damian = new Author("9b5865bc-f4de-49e7-9575-061a5f645589",
	"39878cc1c57a568d8464c9b54ec3fb4e",
	"https://google.com",
	"fictionalEmail@yahoo.com",
	"65b8b305d598c8089ab4cc98d54d5e933c6d30c43eaf928fff49e8c4c95e7d4518b94357d5b11f6ae28f31452cb558954",
	"fictional name"
);
echo($damian->getAuthorUsername());
echo($damian ->getAuthorEmail());
echo($damian->getAuthorAvatarUrl());
echo($damian->getAuthorHash());
echo($damian->getAuthorActivationToken());
echo($damian->getAuthorId());


