<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: PluginTranslationTrait</h1>
</div>

## :tada: Overview
This library given two traits which implements TranslatorHolder interface to PluginBase.  
Written language files in the plugin resources, and multilingual support of the plug-in is possible through this.  

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

## :book: How to use?
The `TranslatorHolder` interface means that this class owns the `Translator`  
Basically, it is best structured by the main class of the plugin to implement it.  
Therefore, This library provide a traits for `PluginBase` for quick use.  
It automatically create translator when the getTranslator() method called.

### Method 1: Use `PluginTranslationTrait` to create translator from resources
This method creates a translator from the plugin's resources.  
The advantage is that when the plugin is updated, the message is also updated.  

> ```php
> use use kim\present\libmultilingual\traits\PluginTranslationTrait;
> 
> class Main extends PluginBase implements Listener{  
>     use PluginTranslationTrait;  
> }  
> ```   

### Method 2: Use `PluginTranslationModifiableTrait` to create translator from data folder
This method creates a translator from the plugin's data folder.  
The advantage is that the user can modify and use the message.  

> ```php
> use use kim\present\libmultilingual\traits\PluginTranslationModifiableTrait;
> 
> class Main extends PluginBase implements Listener{  
>     use PluginTranslationModifiableTrait;  
> }  
> ```   

[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/traits/TranslatorHolderTrait.php)


-----
<br/>

## :question:  How to implement myself?
If you want implements it yourself, follow the [this guide](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/plugin-translation-self.md)