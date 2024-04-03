<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: TranslatorHolderTrait</h1>
</div>

## :tada: Overview

This library given `TranslatorHolderTrait` which implements TranslatorHolder interface.  
It provides simplify the usage of `TranslatorHolder` interface.

-----
<br/>

## :book: What does provides?

This trait provides the following methods:

```php
protected Translator $translator;

public function getTranslator() : Translator
```

[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/traits/TranslatorHolderTrait.php)

-----
<br/>

## :book: How to use?

Just add this trait to your class and set the `$translator` property.

```php  
use kim\present\libmultilingual\traits\TranslatorHolderTrait;  

class Main extends PluginBase{  
    use TranslatorHolderTrait;  

    public function onLoad(){  
        $this->translator = new Translator($this->loadLanguages());  
    }
    
    public function onEnable(){
        $this->getLogger()->info($this->translator->translate("plugin.enabled"));
    }
    
    private function loadLanguages() : array // implements
}  
````

-----
<br/>

## :sparkles: Use `DelegatedTranslatorHolderTrait`

If you want delegate the `Translator` methods, you can use `DelegatedTranslatorHolderTrait`.

This trait provides the all of `Translator` methods.  
[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/traits/DelegatedTranslatorHolderTrait.php)

Just add this trait to your class and set the `$translator` property.  
And then use the `Translator` methods.

```php  
use kim\present\libmultilingual\traits\DelegatedTranslatorHolderTrait;  

class Main extends PluginBase{  
    use DelegatedTranslatorHolderTrait;  

    public function onLoad(){  
        $this->translator = new Translator($this->loadLanguages());  
    }
    
    public function onEnable(){
        $this->getLogger()->info($this->translate("plugin.enabled"));
    }
    
    private function loadLanguages() : array // implements
}  
````