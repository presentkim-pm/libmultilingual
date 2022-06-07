<p align="right">  
  <a href="https://github.com/presentkim-pm/libmultilingual/blob/main/MultilingualConfig.md">  
    <img src="https://img.shields.io/static/v1?label=read%20in&message=English&color=success">  
  </a>  
</p>  
  
## :zap: 사용법  
이 라이브러리는 `PluginBase`에 사용할 수 있는 `MultilingualResourceTrait`을 지원합니다.  
이 trait을 사용해 리소스 파일의 다국어 지원이 가능합니다.  
다국어 지원에는 PMMP에서 사용하는 언어 리소스 이름 패턴을 사용합니다.  
따라서 설정된 규칙에 따라 언어 자원 파일의 이름을 지정해야합니다.  
> [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) 표준에 따른 언어 코드  
> ```php  
> $resourcePath = "config/%s.yml";  
> // Match to:  
> // - resources/config/eng.yml  
> // - resources/config/kor.yml  
> // - resources/config/chz.yml  
> // - resources/config/ind.yml  
> // - resources/config/jpn.yml  
> ```  
  
  
#### :sparkles: 예제: `config.yml`파일 다국어 지원하기  
```php  
use kim\present\traits\multilingual\MultilingualResourceTrait;  

//config.yml 파일을 저장하는 예제 소스  
class Main extends PluginBase{  
    use MultilingualResourceTrait;  

    public function saveDefaultConfig() : bool{  
        return $this->saveResourceByLanguage("config.yml", "config/%s.yml");  
    }  
}  
```  
  
> #### :sparkles: `MultilingualConfigTrait`를 사용  
> ```php  
> use kim\present\traits\multilingual\MultilingualConfigTrait;  
> 
> //config.yml 파일을 저장하는 예제 소스  
> class Main extends PluginBase{  
>     use MultilingualConfigTrait;  
> }  
> ```  
  
  
## :zap: API  
```php  
public function saveResourceByLanguage(string $filename, string $resourcePath, bool $replace = false) : bool  
```  
| Param name        | Description                     |
|:------------------|:--------------------------------|
| **$filename**     | 파일 저장 경로. 플러그인 데이터 폴더에 저장됩니다.   |
| **$resourcePath** | 리소스 파일 경로. 플러그인 리소스 폴더에서 읽어옵니다. |
| **$replace**      | 파일을 덮어씌울 지 여부                   |
  
----------  
  
```php  
public function getResourceByLanguage(string $path) : ?resource  
```  
| Param name | Description                     |
|:-----------|:--------------------------------|
| **$path**  | 리소스 파일 경로. 플러그인 리소스 폴더에서 읽어옵니다. |
