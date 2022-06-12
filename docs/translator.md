<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: Translator</h1>
</div>

## :tada: Overview


> This document describes how to use it based on the implementation class of TranslatorHolder.

-----
<br/>

## :book: What does provides?
This trait provides the following methods:
```php
/**
 * @param string                          $str original string
 * @param array<string|Stringable|number> $params translate parameters
 *
 * @return string the translated string
 */
public function translate(string $str, array $params = []) : string

/**
 * @param string $locale translate language locale
 * (Otherwise same as above)
 */
public function translate(string $str, array $params = [], string $locale) : string

/**
 * @param object $user translate target
 * (Otherwise same as above)
 */
public function translate(string $str, array $params = [], object $user) : string

public function getLanguages() : Language[]

public function getLocaleList() : string[]

/** @return Language if $locale is null, return fallback language */
public function getLanguage(?string $locale = null) : Language

public function getFallbackLanguage() : Language

public function setFallbackLanguage(Language $fallbackLanguage) : void
```
[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/Translator.php)

-----
<br/>

## :book: How to use?
If you have implemented TranslatorHolder or creating Translator, you are all set.  
Now it remains only to use the translator.  

> **Note** `Translator::translate` has three usages.  
> 
> 1. `translate(string, string[]) : string`  
>     translate messages that match the server's language settings  
> <br/>
> 2. `translate(string, string[], object $user) : string`  
>    translate messages that match the player's language settings  
>    <br/>
> 3. `translate(string, string[], string $locale) : string`  
>    translate messages that match the given locale code

You can use any of the methods above.

> ```php  
> //Example source that sends a basic server introduction when the player join
> public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>     $player = $event->getPlayer();  
>     $player->sendMessage($this->getTranslator()->translate("basic.server.introduction", [], $player));  
> }
> ```  