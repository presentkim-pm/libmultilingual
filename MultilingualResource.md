<p align="right">  
  <a href="https://github.com/presentkim-pm/libmultilingual/blob/main/MultilingualConfig_KOR.md">  
    <img src="https://img.shields.io/static/v1?label=%ED%95%9C%EA%B5%AD%EC%96%B4&message=%EB%A1%9C+%EC%9D%BD%EA%B8%B0&labelColor=success">  
  </a>  
</p>  

## :zap: Usage  
This library supports `MultilingualResourceTrait` which can be used in PluginBase.  
Multilingual support of resource files is possible using this trait.  
This library uses the language resource name pattern used by PMMP  
Therefore, need to name the language resource file according to the established rules  
> Code of the language according to the [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) standard
> ```php  
> $resourcePath = "config/%s.yml";  
> // Match to:  
> // - resources/config/eng.yml  
> // - resources/config/kor.yml  
> // - resources/config/chz.yml  
> // - resources/config/ind.yml  
> // - resources/config/jpn.yml  
> ```  
  
  
#### :sparkles: Example: Support multilingual in `config.yml` file
````php  
use kim\present\traits\multilingual\MultilingualResourceTrait;  

//Example source for saving the config.yml file  
class Main extends PluginBase{  
    use MultilingualResourceTrait;  

    public function saveDefaultConfig() : bool{  
        return $this->saveResourceByLanguage("config.yml", "config/%s.yml");  
    }  
}  
````  
  
> #### :sparkles: Use `MultilingualConfigTrait`  
> ```php  
> use kim\present\traits\multilingual\MultilingualConfigTrait;  
> 
> //Example source for saving the config.yml file  
> class Main extends PluginBase{  
>     use MultilingualConfigTrait;  
> }  
> ```  
  
  
## :zap: API  
````php  
public function saveResourceByLanguage(string $filename, string $resourcePath, bool $replace = false) : bool  
````  
| Param name        | Description                                                     |
|:------------------|:----------------------------------------------------------------|
| **$filename**     | File save path. It is saved in the plug-in data folder.         |
| **$resourcePath** | Resource file path. It is read from the plugin resource folder. |
| **$replace**      | Whether to overwrite the file                                   |
  
----------  
  
````php  
public function getResourceByLanguage(string $path) : ?resource  
````  
| Param name | Description                                                     |
|:-----------|:----------------------------------------------------------------|
| **$path**  | Resource file path. It is read from the plugin resource folder. |
