<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: MultilingualResourceTrait</h1>
</div>

## :tada: Overview
This library given `MultilingualResourceTrait` which implements multilingual support for resource files.  
Used to change the language of the resource file according to the plugin user server's language setting.  

-----
<br/>
  
## :bulb: Prerequisite knowledge
### Locale name rules
This library uses locale codes according to [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) standard, likes PMMP.  
Therefore, need to name the language resource file according to the established rules.

### Required locale value
This library uses fallback local code of PMMP.  
Therefore, need to `eng` locale file must exist for normal use.

> **Note**: **Example**  
> > :test_tube: Given path pattern: `config/%s.yml`
>
> Match as follows:
> - `resources/config/eng.yml` :warning: MUST require
> - `resources/config/kor.yml`
> - `resources/config/chz.yml`
> - `resources/config/ind.yml`
> - `resources/config/jpn.yml`

-----
<br/>

## :book: What does provides?
This trait provides the following methods:
```php
/**
 * It works like getResourcePath(), but automatically convert resource path according to server language.
 *
 * @param string $resourcePattern The resource path string containing %s (it will replace to locale code)
 */
public function getResourcePathByLanguage(string $resourcePattern) : string;

/**
 * It works like saveResource(), but automatically convert resource path according to server language.
 *
 * @param string $filename The name of the file to be saved
 * @param string $resourcePattern The resource path string containing %s (it will replace to locale code)
 * @param bool   $replace Whether to replace the file if it already exists
 */
public function saveResourceByLanguage(string $filename, string $resourcePattern, bool $replace = false) : bool
```
[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/traits/MultilingualResourceTrait.php)

-----
<br/>

## :book: How to use?
#### :sparkles: Example 1) **Localization of the `LICENSE` file**
````php  
use kim\present\libmultilingual\traits\MultilingualResourceTrait;  

/**
  Plugin resources/ contents
  - resources/LICENSE_eng
  - resources/LICENSE_kor
  - resources/LICENSE_ger
  - ...
*/        
//Example source for saving the config.yml file  
class Main extends PluginBase{  
    use MultilingualResourceTrait;  

    public function saveDefaultConfig() : bool{  
        return $this->saveResourceByLanguage("LICENSE", "LICENSE_%s");  
    }  
}  
````
-----

#### :sparkles: Example 2) **Localization of the `config.yml` file**
````php  
use kim\present\libmultilingual\traits\MultilingualResourceTrait;  
/**
  Plugin resources/ contents
  - resources/config/eng.yml
  - resources/config/kor.yml
  - resources/config/ger.yml
  - ...
*/        
//Example source for saving the config.yml file  
class Main extends PluginBase{  
    use MultilingualResourceTrait;  

    public function saveDefaultConfig() : bool{  
        return $this->saveResourceByLanguage("config.yml", "config/%s.yml");  
    }  
}  
````
> **Note**: In the example above, additional trait are prepared.
> #### :sparkles: Use `MultilingualConfigTrait`
> ```php  
> use kim\present\libmultilingual\traits\MultilingualConfigTrait;  
> 
> //Example source for saving the config.yml file  
> class Main extends PluginBase{  
>     use MultilingualConfigTrait;  
> }  
> ```