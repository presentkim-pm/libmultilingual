<p align="right">  
  <a href="https://github.com/Blugin/libTranslator-PMMP/blob/master/README_KOR.md">  
    <img src="https://img.shields.io/static/v1?label=%ED%95%9C%EA%B5%AD%EC%96%B4&message=%EB%A1%9C+%EC%9D%BD%EA%B8%B0&labelColor=success">  
  </a>  
</p>  


## :clipboard: Table of Contents  
- [:books: Intro](https://github.com/Blugin/libTranslator-PMMP/blob/master/README.md)  
- :book: How to use it?
  
<br>  
  
## :book: How to use it?
Follow the four basic steps to use below:  
1. [:zap: Write language files](#zap-write-language-files)  
2. [:zap: Save default language files](#zap-save-default-language-files)  
3. [:zap: Create `Translator` instance](#zap-create-translator-instance)  
4. [:zap: Use `Translator`](#zap-use-translator)  
  
+ [:sparkles: Quick use via `TranslatorHolderTrait`](#sparkles-quick-use-via-translatorholdertrait)
+ [:sparkles: Support multilingual in `config.yml` file](#sparkles-support-multilingual-in-configyml-file)  
  
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
> Examples:  
> //Roughly, example source that save default language files on plugin load 
> class Main extends PluginBase{  
>     public function onLoad() : void{  
>         $this->saveDefaultLocales();  
>     }  
>  
>     public function saveDefaultLocales() : void{  
>         foreach($this->getResources() as $filePath => $info){  
>             if(preg_match('/^locale\/[a-zA-Z]{3}\.ini$/', $filePath)){  
>                 $this->saveResource($filePath);  
>             }  
>         }  
>     }  
> }  
> ```  
  
<br>  
  
#### :zap: Create `Translator` instance  
> Now you can create `Translator` instances for the plugin  
> `Translator` constructor requires `PluginBase` argument for load languages from plugin data folder  
> Language files of the plugin provided as argument is automatically loaded. (no need to write load it yourself)  
> ```php  
> Examples:  
> //Roughly, example source that create `Translator` instance on plugin load
> class Main extends PluginBase{  
>     /** @var Translator */  
>     private $translator;  
>  
>     public function onLoad() : void{  
>         $this->saveDefaultLocales();  
>         $this->translator = new Translator($this);
>     }  
>  
>     ...
> }
> ```  
> `saveDefaultLocales()` is omitted. See [this](#zap-save-default-language-files)
  
<br>  
  
#### :zap: Use `Translator`
> Now it remains only to use the translator  
> 1. Use `Translator::translateTo(string, string[], CommandSender) : string` for get translated messages that match the player's language settings  
> 2. Use `Translator::translateTo(string, string[], CommandSender) : string` for get translated messages that match the server's language settings  
> ```php  
> Examples:  
> //Roughly, example source that sends a basic server introduction when the player join  
> class Main extends PluginBase implements Listener{  
>     /** @var Translator */  
>     private $translator;  
>  
>     public function onLoad() : void{  
>         $this->saveDefaultLocales();  
>         $this->translator = new Translator($this);
>     }  
> 
>     public function onEnable() : void{  
>       $this->getServer()->getPluginManager()->registerEvents($this, $this);  
>     }  
> 
>     public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>         $player = $event->getPlayer();  
>         $player->sendMessage($this->getTranslator()->translateTo("basic.server.introduction", [], $player));  
>     }  
> }
> ```  
> `saveDefaultLocales()` is omitted. See [this](#zap-save-default-language-files)
  
<br>  
  
--------  
  
<br>  
  
#### :sparkles: Quick use via `TranslatorHolderTrait`
> The `TranslatorHolder` interface means that this class owns the `Translator`  
> Basically, it is best structured by the main class of the plugin to implement it  
> Therefore, This library provide a trait for `PluginBase` for quick use  
> ```php
> Examples: 
> //Roughly, example source that sends a basic server introduction when the player join  
> class Main extends PluginBase implements Listener{  
>     use TranslatorHolderTrait;  
>     
>     public function onLoad() : void{  
>         $this->loadTranslator();  
>     }  
> 
>     public function onEnable() : void{  
>       $this->getServer()->getPluginManager()->registerEvents($this, $this);  
>     }  
> 
>     public function onPlayerJoin(PlayerJoinEvent $event) : void{  
>         $player = $event->getPlayer();  
>         $player->sendMessage($this->getTranslator()->translateTo("basic.server.introduction", [], $player));  
>     }  
> }  
> ```  
  
<br>  
  
#### :sparkles: Support multilingual in `config.yml` file
> This is a separate features using the plugin resource file pattern  
> The format is almost the same as for existing language files  
> Just change the extension from `ini` to `yml`
> This library provide a `MultilingualConfigTrait` for `PluginBase` for multilingual support of the config file  
> ```php  
> Examples: 
> //Roughly, example source that  example source that save default config file with multilingual  
> class Main extends PluginBase{  
>     use MultilingualConfigTrait;  
> 
>     public function onLoad() : void{  
>         $this->saveDefaultConfig();  
>     }  
> }  
> ```  