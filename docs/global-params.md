<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: GlobalParams</h1>
</div>

## :tada: Overview
This library given `GlobalParams` which manage default translation parameters.  
This global parameter list is used common to all translations.  
This feature was added to make it easier to use line breaks and Minecraft emojis.  
You can also add them through plugins!

#### Default global params list

| Param name |  Character   |            In game            |
|:----------:|:------------:|:-----------------------------:|
|    {%n}    |     `\n`     |      New line charactor       |
|   {%br}    |     `\n`     |      New line charactor       |
|   {%tab}   |     `\t`     |         Tab charactor         |
|    {%t}    |     `\t`     |         Tab charactor         |
| {%u[CODE]} | `\u{[CODE]}` | Unicode character from [CODE] | 

The `Unicode character` feature is supported for representing [emoji characters](https://wiki.bedrock.dev/concepts/emojis.html).  
ex) `{%uE100}` => `` => <code><img src="https://wiki.bedrock.dev/assets/images/concepts/emojis/hud/food.png" width="16px"></code>  


-----
<br/>

## :book: What does provides?  
This class provides the following static methods:
```php
/** @return array<string, string> The list of global translate parameters */
public static function getAll() : array

/**
 * Sets a global translate parameter
 *
 * @param string $paramName The parameter name
 * @param string $contents The parameter's replacement contents
 */
public static function set(string $paramName, string $contents) : void

/**
 * Removes a global translate parameter
 *
 * @param string $paramName The parameter name
 */
public static function remove(string $paramName) : void
```
[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/GlobalParams.php)

-----
<br/>

## :book: How to register my custom parameters?
You can always add parameters via the `GlobalParams::register()` static method.
```php
use kim\present\libmultilingual\GlobalParams;

//Example source that set `server-name` parameter
public function onEnable() : void{  
    GlobalParams::set("server-name", $this->getServer()->getName()); 
}
```

Also can update parameters in real time to create dynamic messages.
```php
use kim\present\libmultilingual\GlobalParams;

//Example source that set `player-count` parameter
public function onEnable() : void{  
   $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
       GlobalParams::set("player-count", (string) count($this->getServer()->getOnlinePlayers()));
   }), 1);
}
```   

-----
