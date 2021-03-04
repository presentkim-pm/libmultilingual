<p align="right">  
  <a href="https://github.com/PresentKim/libtranslator/blob/main/doc/eng/HowToUse.md">  
    <img src="https://img.shields.io/static/v1?label=read%20in&message=English&color=success">
  </a>  
</p>  


## :clipboard: 목차  
- [:books: Intro](https://github.com/PresentKim/libtranslator/blob/main/README_KOR.md)  
- :book: 어떻게 사용하나요?
  
<br>  
  
## :book: 어떻게 사용하나요?
아래의 기본 사용법 4단계를 따르세요:  
1. [:zap: 언어 파일 작성하기](#zap-%EC%96%B8%EC%96%B4-%ED%8C%8C%EC%9D%BC-%EC%9E%91%EC%84%B1%ED%95%98%EA%B8%B0)  
2. [:zap: 기본 언어 파일들 저장하기](#zap-%EA%B8%B0%EB%B3%B8-%EC%96%B8%EC%96%B4-%ED%8C%8C%EC%9D%BC%EB%93%A4-%EC%A0%80%EC%9E%A5%ED%95%98%EA%B8%B0)  
3. [:zap: `Translator` 인스턴스 생성하기](#zap-translator-%EC%9D%B8%EC%8A%A4%ED%84%B4%EC%8A%A4-%EC%83%9D%EC%84%B1%ED%95%98%EA%B8%B0)  
4. [:zap: `Translator` 사용하기](#zap-translator-%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0)  
  
+ [:sparkles: `TranslatablePluginTrait`를 통한 빠르게 사용하기](#sparkles-translatableplugintrait%EB%A5%BC-%ED%86%B5%ED%95%9C-%EB%B9%A0%EB%A5%B4%EA%B2%8C-%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0)  
  
<br>  
  
#### :zap: 언어 파일 작성하기  
> 이 라이브러리는 PMMP에서 사용하는 언어 리소스 이름 패턴을 사용합니다  
> 따라서 설정된 규칙에 따라 언어 자원 파일의 이름을 지정해야합니다  
> ```php  
> Rules:  
> /resources/locale/{$locale}.ini  
> ```  
> - **$locale**은 [`ISO_639-3`](https://en.wikipedia.org/wiki/ISO_639-3) 표준에 따른 언어 코드입니다  
> ```php  
> Examples:  
> /resources/locale/eng.ini  
> /resources/locale/kor.ini  
> /resources/locale/chz.ini  
> /resources/locale/ind.ini  
> /resources/locale/jpn.ini  
> ```  
  
<br>  
  
#### :zap: 기본 언어 파일들 저장하기
> 이 라이브러리는 사용자가 메시지를 수정할 수 있도록 플러그인 데이터 폴더에서 언어 파일을 로드합니다 (플러그인 resources/ 폴더가 아님)  
> 따라서 `Translator` 인스턴스를 만들기 전에 기본 언어 파일을 저장해야 합니다  
> ```php  
> //플러그인이 로드 될 때 기본 언어 파일들을 저장하는 예제 소스  
> class Main extends PluginBase{  
>     public function saveDefaultLanguages() : void{  
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
  
#### :zap: `Translator` 인스턴스 생성하기  
> 이제 플러그인을 위한 `Translator` 인스턴스를 만들 수 있습니다  
> 위에 저장된 모든 언어 파일이 로드 되어야 합니다  
> 기본 언어 파일도 플러그인 리소스에서 로드 해야 합니다  
> ```php  
> //플러그인이 로드 될 때 `Translator` 인스턴스를 생성하는 예제 소스  
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
>     private function saveDefaultLanguages() : void; //위와 같음
> }
> ```  
  
<br>  
  
#### :zap: `Translator` 사용하기  
> 이제 `Translator`를 사용하는 것만 남았습니다  
> 1. 플레이어의 언어 설정과 일치하는 번역 된 메시지를 받으려면 `Translator::translateTo(string, string [], CommandSender) : string`을 사용하세요  
> 1. 서버의 언어 설정과 일치하는 번역 된 메시지를 받으려면 `Translator::translate(string, string []) : string`을 사용하세요  
> ```php  
> //플레이어가 참여할 때 기본 서버 소개를 보내는 예제 소스  
> class Main extends PluginBase implements Listener{  
>     private Translator $translator;  
> 
>     public function getTranslator() : Translator; //위와 같음
>  
>     public function onLoad() : void; //위와 같음
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
>     private function saveDefaultLanguages() : void;     //위와 같음
>     private function loadLanguages() : array;           //위와 같음
>     private function loadDefaultLanguage() : ?Language; //위와 같음
> }
> ```  
  
<br>  
  
--------  
  
<br>  
  
#### :sparkles: `TranslatablePluginTrait`를 통한 빠르게 사용하기  
> `TranslatorHolder` 인터페이스는 이 클래스가 `Translator`를 소유함을 의미합니다  
> 기본적으로 플러그인의 메인 클래스에 구현되는 것이 가장 좋습니다  
> 따라서 이 라이브러리는 빠른 사용을 위해 `PluginBase`에 사용할 수 있는 Trait을 제공합니다  
> 이 trait은 getTranslator() 메소드가 호출 될 때 기본 언어 파일 저장과 로드를 모두 자동으로 수행합니다  
> 그리고 PluginBase 에 `translateTo()` 메서드를 추가합니다  
> ```php
> //플레이어가 참여할 때 기본 서버 소개 메세지를 보내는 예제 소스  
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