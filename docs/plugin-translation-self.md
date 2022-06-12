<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: Implement plugin translation yourself</h1>
</div>

## :tada: Overview
This document is for developers who want to implement their own without using the traits of the plugin.  
We recommend implementing it by following the instructions below.  

-----
<br/>

## :bulb: Prerequisite knowledge
### Locale name rules
This library uses locale codes according to [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) standard, likes PMMP.  

### Required locale value
This library uses fallback local code of PMMP.  
Therefore, need to `eng` locale file must exist for normal use.

> Rules:  
> /resources/locale/{$locale}.ini  


> Examples:
> - `resources/locale/eng.ini` :warning: MUST require
> - `resources/locale/kor.ini`
> - `resources/locale/chz.ini`
> - `resources/locale/ind.ini`
> - `resources/locale/jpn.ini`

-----
<br/>

## :book: How to implement?
#### :zap: Write language files
> Need to name the language resource file according to the established rules.  
> ```php  
> Examples:  
> /resources/locale/eng.ini  
> /resources/locale/kor.ini  
> /resources/locale/chz.ini  
> /resources/locale/ind.ini  
> /resources/locale/jpn.ini  
> ```  

#### :zap: Save default language files
> This library load language files from the plugin data folder for user can modifying message (not the plugin resources/ folder)  
> Therefore, need to save the default language file before creating `Translator`
> ```php  
> //Example source that save default language files on plugin load 
> class Main extends PluginBase{  
>     private function saveDefaultLanguages() : void{  
>         foreach($this->getResources() as $filePath => $info){  
>             if(preg_match("/^locale\/[a-zA-Z]{3}\.ini$/", $filePath)){  
>                 $this->saveResource($filePath);  
>             }  
>         }  
>     }  
> 
>     public function onLoad() : void{  
>         $this->saveDefaultLanguages();  
>     }  
> }  
> ```  

#### :zap: Create `Translator` instance
> Now you can create `Translator` instances for the plugin  
> You need all language files saved above are load  
> Default language files must also be load from the plugin resource
> ```php  
> //Example source that create `Translator` instance on plugin load
> class Main extends PluginBase{  
>     private Translator $translator;  
>  
>     public function onLoad() : void{  
>         $this->saveDefaultLanguages();  
>         $this->translator = new Translator($this->loadLanguages(), $this->loadDefaultLanguage());  
>     }  
> 
>     private function loadLanguages() : array{  
>         /** @var PluginBase|TranslatablePluginTrait $this */  
>         $languages = [];  
> 
>         $path = $this->getDataFolder() . "locale/";  
>         if(!is_dir($path))  
>             throw new RuntimeException("Language directory {$path} does not exist or is not a directory");  
> 
>         foreach(scandir($path, SCANDIR_SORT_NONE) as $_ => $filename){  
>             if(!preg_match("/^([a-zA-Z]{3})\.ini$/", $filename, $matches) || !isset($matches[1]))  
>                 continue;  
> 
>             $languages[$matches[1]] = Language::fromFile($path . $filename, $matches[1]);  
>         }  
>         return $languages;  
>     }  
> 
>     private function loadDefaultLanguage() : ?Language{  
>         $resource = $this->getResource("locale/{$this->getServer()->getLanguage()->getLang()}.ini"); 
>         if($resource === null){  
>             //Use the first searched file as fallback  
>             foreach($this->getResources() as $filePath => $info){  
>                 if(!preg_match("/^locale\/([a-zA-Z]{3})\.ini$/", $filePath, $matches) || !isset($matches[1]))  
>                     continue;  
> 
>                 $locale = $matches[1];  
>                 $resource = $this->getResource($filePath);  
>                 if($resource !== null)  
>                     break;  
>             }  
>         }  
>         if($resource !== null){  
>             $contents = stream_get_contents($resource);  
>             fclose($resource);  
>             return Language::fromContents($contents, strtolower($locale));  
>         }  
> 
>         return null;  
>     }  
>  
>     private function saveDefaultLanguages() : void; //Same as above  
> }  
> ```  

#### :zap: Use `Translator`
> Now it remains only to use the translator
> 1. Use `Translator::translate(string, string[], CommandSender) : string` for get translated messages that match the player's language settings
> 2. Use `Translator::translate(string, string[]) : string` for get translated messages that match the server's language settings
> 3. Use `Translator::translate(string, string[], string $locale) : string` for get translated messages that match the given locale code
> ```php  
> //Example source that sends a basic server introduction when the player join
> public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>     $player = $event->getPlayer();  
>     $player->sendMessage($this->getTranslator()->translate("basic.server.introduction", [], $player));  
> }
> ```  