# Aristotle's VerifiedVoter

A PHP package for working w/ the Aristotle VerifiedVoter API.

## Install

Normal install via Composer.

## Usage

```php
use Travis\Aristotle\VerifiedVoter;

$response = VerifiedVoter::run([
	'username'	=> $username,
	'password'	=> $password,
	'siteid'	=> $siteid,
	'first'		=> 'Paul',
	'last'		=> 'Tarsus',
	'address'	=> '777 Pearly Gates',
	#'city'		=> '',
	#'state'	=> '',
	'zip'		=> '77777',
]);
```