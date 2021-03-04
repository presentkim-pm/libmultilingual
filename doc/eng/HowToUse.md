<p align="right">  
  <a href="https://github.com/PresentKim/libtranslator/blob/main/doc/kor/HowToUse.md">  
    <img src="https://img.shields.io/static/v1?label=%ED%95%9C%EA%B5%AD%EC%96%B4&message=%EB%A1%9C+%EC%9D%BD%EA%B8%B0&labelColor=success">  
  </a>  
</p>  


## :clipboard: Table of Contents  
- [:books: Intro](https://github.com/PresentKim/libtranslator/blob/main/README.md)  
- :book: How to use it?
  
<br>  
  
## :book: How to use it?
Follow the four basic steps to use below:  
1. [:zap: Write language files](#zap-write-language-files)  
2. [:zap: Save default language files](#zap-save-default-language-files)  
3. [:zap: Create `Translator` instance](#zap-create-translator-instance)  
4. [:zap: Use `Translator`](#zap-use-translator)  
  
+ [:sparkles: Quick use via `TranslatablePluginTrait`](#sparkles-quick-use-via-translatableplugintrait)  
  
<br>  
  
#### :zap: Write language files
> This library uses the language resource name pattern used by PMMP  
> Therefore, need to name the language resource file according to the established rules  
> ```php  
> Rules:  
> /resources/locale/{$locale}.ini  
> ```  
> - **$locale** is the code of the language according to the [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) standard  
> ```php  
> Examples:  
> /resources/locale/eng.ini  
> /resources/locale/kor.ini  
> /resources/locale/chz.ini  
> /resources/locale/ind.ini  
> /resources/locale/jpn.ini  
> ```  
  
<br>  
  
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
  
<br>  
  
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
  
<br>  
  
#### :zap: Use `Translator`
> Now it remains only to use the translator  
> 1. Use `Translator::translateTo(string, string[], CommandSender) : string` for get translated messages that match the player's language settings  
> 2. Use `Translator::translateTo(string, string[], CommandSender) : string` for get translated messages that match the server's language settings  
> ```php  
> //Example source that sends a basic server introduction when the player join  
> class Main extends PluginBase implements Listener{  
>     private Translator $translator;  
> 
>     public function getTranslator() : Translator //Same as above 
>  
>     public function onLoad() : void //Same as above 
> 
>     public function onEnable() : void{  
>       $this->getServer()->getPluginManager()->registerEvents($this, $this);  
>     }  
> 
>     public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>         $player = $event->getPlayer();  
>         $player->sendMessage($this->getTranslator()->translateTo("basic.server.introduction", [], $player));  
>     }  
> 
>     private function saveDefaultLanguages() : void;     //Same as above  
>     private function loadLanguages() : array;           //Same as above  
>     private function loadDefaultLanguage() : ?Language; //Same as above  
> }
> ```  
  
<br>  
  
--------  
  
<br>  
  
#### :sparkles: Quick use via `TranslatablePluginTrait`
> The `TranslatorHolder` interface means that this class owns the `Translator`  
> Basically, it is best structured by the main class of the plugin to implement it  
> Therefore, This library provide a trait for `PluginBase` for quick use  
> It automatically performs both saving and loading of the main language file when the getTranslator() method called.  
> And add the translateTo() method to the PluginBase  
> ```php
> //Example source that sends a basic server introduction when the player join  
> class Main extends PluginBase implements Listener{  
>     use TranslatablePluginTrait;  
> 
>     public function onEnable() : void{  
>       $this->getServer()->getPluginManager()->registerEvents($this, $this);  
>     }  
> 
>     public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>         $player = $event->getPlayer();  
>         $player->sendMessage($this->translateTo("basic.server.introduction", [], $player));  
>     }  
> }  
> ```  