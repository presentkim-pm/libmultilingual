<p align="center"> <img src="https://i.ibb.co/YfKHnVh/icon.png" width="360"> </p>
<br> <h1 align="center"> libTranslator :: 자동 번역 라이브러리</h1>
<p align="right">  
  <a href="https://github.com/Blugin/libTranslator-PMMP/blob/stable/README.md">  
    <img src="https://img.shields.io/static/v1?label=read%20in&message=English&color=success">
  </a>  
</p>  
<p align="center">  
  <a href="https://github.com/Blugin/libTranslator-PMMP/releases">  
    <img src="https://img.shields.io/github/release/Blugin/libTranslator-PMMP.svg?style=flat-square">  
  </a>  
  <a href="https://github.com/Blugin/libTranslator-PMMP/releases">  
    <img src="https://img.shields.io/github/downloads/Blugin/libTranslator-PMMP/total.svg?style=flat-square">  
  </a>  
  </a>  
  <a href="https://github.com/Blugin/libTranslator-PMMP/blob/master/LICENSE">  
    <img src="https://img.shields.io/github/license/Blugin/libTranslator-PMMP.svg?style=flat-square">  
  </a>  
  <a href="http://hits.dwyl.com/Blugin/libTranslator-PMMP">  
    <img src="http://hits.dwyl.com/Blugin/libTranslator-PMMP.svg">  
  </a>  
  <br> ✔️ 플러그인 메시지에 대한 다국어 지원
  <br> ✔️ 플러그인 콘피그에 대한 다국어 지원
  <br> ✔️ 플레이어에 따라 번역 언어 설정
  <br> ✔️ PMMP 설정에 따른 번역 설정
</p>  
  
<br>  
  
## :file_folder: 대상 소프트웨어:  
**이 플러그인은 공식적으로 [**Pocketmine-MP**](https://github.com/pmmp/PocketMine-MP/)에서만 작동합니다**
> API [`3.x.x`](https://github.com/pmmp/PocketMine-MP/tree/stable) [`4.x.x`](https://github.com/pmmp/PocketMine-MP/tree/master) 모두 작동합니다
  
<br>  
  
## :wrench: 설치
1) 릴리즈에서 `.phar`을 [Download](#package-%EB%8B%A4%EC%9A%B4%EB%A1%9C%EB%93%9C) 받으세요  
2) 다운받는 `.phar`파일을 당신의 서버의 **/plugins/** 폴더에 넣으세요  
3) 서버를 재시작하세요 (혹은 `/reload` 명령어를 실행하세요)  
  
<br>  
  
## :package: 다운로드:  
  
| Version | Phar Download | Updates Note |  
| :-----: | :-----------: | :----------: |   
| 1.0.0 | [GitHub](https://github.com/Blugin/libTranslator-PMMP/releases/download/1.0.0/libTranslator_v1.0.0.phar) | **플러그인 게시 (플러그인 기능 구현)** |  
  
> **모든 출시 버전은 [여기](https://github.com/Blugin/ChatThin-PMMP/releases)에서 확인할 수 있습니다**  
  
<br>  
  
## :information_source: API 사용법  
libTranslator의 기본 사용법 4단계:  
1. [:zap: 언어 파일 작성하기](#zap-%EC%96%B8%EC%96%B4-%ED%8C%8C%EC%9D%BC-%EC%9E%91%EC%84%B1%ED%95%98%EA%B8%B0)  
2. [:zap: 기본 언어 파일들 저장하기](#zap-%EA%B8%B0%EB%B3%B8-%EC%96%B8%EC%96%B4-%ED%8C%8C%EC%9D%BC%EB%93%A4-%EC%A0%80%EC%9E%A5%ED%95%98%EA%B8%B0)  
3. [:zap: `Translator` 인스턴스 생성하기](#zap-translator-%EC%9D%B8%EC%8A%A4%ED%84%B4%EC%8A%A4-%EC%83%9D%EC%84%B1%ED%95%98%EA%B8%B0)  
4. [:zap: `Translator` 사용하기](#zap-translator-%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0)  
  
+ [:sparkles: `TranslatorHolderTrait`를 통한 빠르게 사용하기](#sparkles-translatorholdertrait%EB%A5%BC-%ED%86%B5%ED%95%9C-%EB%B9%A0%EB%A5%B4%EA%B2%8C-%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0)
+ [:sparkles: `config.yml`파일 다국어 지원하기](#sparkles-configyml%ED%8C%8C%EC%9D%BC-%EB%8B%A4%EA%B5%AD%EC%96%B4-%EC%A7%80%EC%9B%90%ED%95%98%EA%B8%B0)  
  
<br>  
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
> Examples:  
> //대충, 플러그인이 로드 될 때 기본 언어 파일들을 저장하는 예제 소스  
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
  
#### :zap: `Translator` 인스턴스 생성하기  
> 이제 플러그인을 위한 `Translator` 인스턴스를 만들 수 있습니다  
> `Translator`의 생성자에는 플러그인 데이터 폴더에서 언어를 로드하기 위해 `PluginBase`인자가 필요합니다  
> 인자로 제공된 플러그인의 언어 파일이 자동으로 로드됩니다 (직접 로드를 작성할 필요가 없습니다)  
> ```php  
> Examples:  
> //대충, 플러그인이 로드 될 때 `Translator` 인스턴스를 생성하는 예제 소스  
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
  
#### :zap: `Translator` 사용하기  
> 이제 `Translator`를 사용하는 것만 남았습니다  
> 1. 플레이어의 언어 설정과 일치하는 번역 된 메시지를 받으려면 `Translator::translateTo(string, string [], CommandSender) : string`을 사용하세요  
> 1. 서버의 언어 설정과 일치하는 번역 된 메시지를 받으려면 `Translator::translate(string, string []) : string`을 사용하세요  
> ```php  
> Examples:  
> //대충, 플레이어가 참여할 때 기본 서버 소개를 보내는 예제 소스  
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
  
#### :sparkles: `TranslatorHolderTrait`를 통한 빠르게 사용하기  
> `TranslatorHolder` 인터페이스는 이 클래스가 `Translator`를 소유함을 의미합니다  
> 기본적으로 플러그인의 메인 클래스에 구현되는 것이 가장 좋습니다  
> 따라서 이 라이브러리는 빠른 사용을 위해 'PluginBase'에 사용할 기본 Trait을 제공합니다  
> ```php
> Examples: 
> //대충, 플레이어가 참여할 때 기본 서버 소개 메세지를 보내는 예제 소스  
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
  
#### :sparkles: `config.yml`파일 다국어 지원하기
> 이 기능은 플러그인 리소스 파일 패턴을 사용하는 별도의 기능입니다  
> 파일 이름 형식은 언어 파일과 거의 동일합니다  
> 그냥 확장자를 `ini`에서 `yml`로 변경하면 됩니다  
> 이 라이브러리는 `config.yml`파일의 다국어 지원을 위해 'PluginBase'에 대한 'MultilingualConfigTrait'을 제공합니다  
> ```php  
> 예시: 
> //대충, 기본 언어 구성 파일을 다국어로 저장하는 예제 소스
> class Main extends PluginBase{  
>     use MultilingualConfigTrait;  
> 
>     public function onLoad() : void{  
>         $this->saveDefaultConfig();  
>     }  
> }  
> ```  
  
<br>  
  
## :memo: 라이센스 
> 라이센스 전문은 [여기](https://github.com/Blugin/ChatThin-PMMP/blob/stable/LICENSE)에서 확인할 수 있습니다  
  
이 프로젝트는 **LGPL 3.0**에 따라 라이센스가 부여됩니다