<!-- PROJECT BADGES -->
<div align="center">

[![Packagist][packagist-badge]][packagist-url]
[![CI][ci-badge]][ci-url]
[![Stars][stars-badge]][stars-url]
[![License][license-badge]][license-url]

</div>


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  <h3>libmultilingual</h3>
  <p align="center">
    Translate your plugin's messages into every player's own language.

[Packagist][packagist-url] · [Changelog](CHANGELOG.md) · [Report a bug][issues-url] · [Request a feature][issues-url]

  </p>
</div>

```php
class Main extends PluginBase{
    use MultilingualPluginTrait; // reads resources/locale/*.ini

    public function onPlayerJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        $player->sendMessage($this->translate("welcome.message", [$player->getName()], $player)); // in the player's language
    }
}
```

-----

## 🌟 Why libmultilingual?

Hard-coded English messages are fine until half your players speak something else. Doing it properly means finding
the player's language, converting Minecraft's `ko_KR` into PocketMine's `kor`, loading `.ini` files, falling back when
a translation is missing, and substituting parameters. This library does it once:

- **One trait, done** : add `MultilingualPluginTrait` to your plugin and call `translate()`
- **Per-player language** : pass a `Player` (or any sender with a locale) and get their language, or the server's if it is forced
- **Always has an answer** : a missing key or language falls back to `eng`, a missing `eng` key returns the key itself
- **Plain `.ini` files** : the same format PocketMine-MP uses for its own languages
- **Parameters** : `{%0}`, `{%name}`, plus global parameters for new lines, tabs and emoji (`{%n}`, `{%tab}`, `{%uE100}`)
- **Editable by server owners** : optionally copy the locale files to the data folder so they can change the messages
- **Never throws on bad files** : a malformed `.ini` becomes an empty language instead of a warning
- **Works without a server** : `Translator` falls back gracefully in unit tests and tools
- **Tested** : run against the real server code on PHP 8.4 / 8.5

## 🎯 Use cases

| You are building...                        | Use                                                       |
|--------------------------------------------|-----------------------------------------------------------|
| Command and system messages in many languages | `MultilingualPluginTrait` + `translate()`              |
| Messages server owners should be able to edit | `MultilingualPluginModifiableTrait`                    |
| A `config.yml` shipped per server language | `MultilingualConfigTrait`                                 |
| Dynamic text (player count, server name)   | `GlobalParams::set()`                                     |
| Mapping a player's `ko_KR` to `kor`        | `LocaleConverter`                                         |

-----

## 📦 Installation

```sh
composer require presentkim/libmultilingual
```

| Requirement | Version                                                           |
|-------------|-------------------------------------------------------------------|
| Server      | [axolotl-pm/PocketMine-MP][axolotl-url] (fork of PocketMine-MP 5) |
| PHP         | **8.4** or newer (with `ext-mbstring`)                            |

> The Poggit virion for the original PocketMine-MP 5.44 and older is kept on the
> [`legacy/pmmp-5.44`][legacy-url] branch (no longer maintained).

-----

## 🚀 Quick start

### 1. Write the language files

Put one `.ini` file per language in `resources/locale/`. The file name is the three letter
[ISO 639-3](https://en.wikipedia.org/wiki/ISO_639-3) code that PocketMine-MP uses (`eng`, `kor`, `jpn`, ...).
**`eng.ini` is required**: it is the fallback language.

```ini
; resources/locale/eng.ini
language.name = English
welcome.message = Welcome, {%0}!
commands.give.success = Gave {%amount} x {%item} to {%0}{%n}Enjoy {%u2764}
```

```ini
; resources/locale/kor.ini
language.name = 한국어
welcome.message = {%0}님, 환영합니다!
```

A full example is in [`resources-example/locale`](resources-example/locale).

### 2. Add the trait

```php
use kim\present\libmultilingual\traits\MultilingualPluginTrait;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

final class Main extends PluginBase{
    use MultilingualPluginTrait;

    public function onPlayerJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();

        // In the player's language ($player->getLocale() is converted for you)
        $player->sendMessage($this->translate("welcome.message", [$player->getName()], $player));

        // In the server's language
        $this->getLogger()->info($this->translate("welcome.message", ["console"]));

        // In a specific language
        $this->translate("welcome.message", ["Steve"], "kor");
    }
}
```

The translator is created the first time it is needed. Missing languages and missing keys fall back to `eng`,
and a key that exists nowhere is returned as it is.

### 3. Let server owners edit the messages (optional)

```php
use kim\present\libmultilingual\traits\MultilingualPluginModifiableTrait;

final class Main extends PluginBase{
    use MultilingualPluginModifiableTrait; // same API, loads from plugin_data/<plugin>/locale/
}
```

The default files are copied to the data folder once, and loaded from there afterwards.
The `eng` fallback is always read from the plugin resources, so a broken edit or a plugin update cannot remove it.

| Trait                               | Messages come from | Updated on plugin upgrade | Server owner can edit |
|-------------------------------------|--------------------|---------------------------|-----------------------|
| `MultilingualPluginTrait`           | Plugin resources   | Yes                       | No                    |
| `MultilingualPluginModifiableTrait` | Data folder        | No                        | Yes                   |

-----

## 🧩 Language file format

Standard `.ini` lines (`key = value`) with a few rules:

- Keys are matched exactly. `language.name` is the display name of the language.
- Values are raw text. Surrounding double quotes are removed and C-style escapes such as `\n` are unescaped.
- Lines starting with `;` are comments.
- Sections (`[name]`) and array keys (`a[b] = c`) are **not supported** and ignored.
- A file that cannot be parsed becomes an empty language without any warning, so its messages fall back to `eng`.

### Parameters

| Placeholder    | Replaced with                                                                 |
|----------------|-------------------------------------------------------------------------------|
| `{%0}`, `{%1}` | The parameters passed to `translate()` by position                            |
| `{%name}`      | The parameter with that key in the `translate()` array                        |
| `{%n}` `{%br}` | A new line                                                                    |
| `{%t}` `{%tab}` | A tab                                                                        |
| `{%uXXXX}`     | The Unicode character of that code point: 1 to 6 hex digits, such as `{%u2764}` or `{%u1F600}` (emoji, Minecraft icons) |
| Your own       | Anything registered with `GlobalParams::set()`                                |

- Parameter names contain only letters and digits.
- Parameters passed to `translate()` win over a global parameter of the same name, and numeric keys are kept as given.
- All placeholders are replaced in a single pass, so a replaced value is never scanned for placeholders again.
- An invalid `{%u...}` (non-hex, more than 6 digits, above `10FFFF`, a surrogate) is left untouched.
  Unicode placeholders are decoded on the fly and are not added to `GlobalParams`.

```php
GlobalParams::set("serverName", "My Server");
$this->translate("commands.give.success", ["amount" => 3, "item" => "Apple", "Steve"]);
```

-----

## 📚 Examples

<details open>
<summary><b>Command messages in the sender's language</b></summary>

```ini
; eng.ini
commands.generic.num.tooBig = The number you have entered ({%0}) is too big, it must be at most {%1}
```

```php
public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
    $amount = (int) ($args[0] ?? 1);
    if($amount > 64){
        // translate() accepts a CommandSender: players use their own language, the console the server's
        $sender->sendMessage($this->translate("commands.generic.num.tooBig", [$amount, 64], $sender));
        return true;
    }
    return true;
}
```

</details>

<details>
<summary><b>Dynamic global parameters</b></summary>

```php
public function onEnable() : void{
    GlobalParams::set("serverName", $this->getServer()->getName());

    $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
        GlobalParams::set("playerCount", (string) count($this->getServer()->getOnlinePlayers()));
    }), 20);
}
```

```ini
motd = {%serverName}: {%playerCount} players online
```

</details>

<details>
<summary><b>A config.yml per server language</b></summary>

```
resources/config/eng.yml   <- required
resources/config/kor.yml
```

```php
use kim\present\libmultilingual\traits\MultilingualConfigTrait;

final class Main extends PluginBase{
    use MultilingualConfigTrait; // saveDefaultConfig() now copies config/<server language>.yml
}
```

If the server's language has no file, `eng.yml` is used. `MultilingualResourceTrait` offers the same for any
resource through `getResourcePathByLanguage()` and `saveResourceByLanguage()`.

</details>

<details>
<summary><b>Using the Translator directly</b></summary>

```php
use kim\present\libmultilingual\Language;
use kim\present\libmultilingual\Translator;

$translator = new Translator([
    Language::fromFile($path . "eng.ini", "eng"),
    Language::fromContents("welcome.message = {%0}님, 환영합니다!", "kor"),
]);

$translator->translate("welcome.message", ["Steve"], "kor"); // 'Steve님, 환영합니다!'
$translator->hasKey("welcome.message", "kor");               // true
```

`Translator::translate()` works without a running server: it uses the fallback language when there is no server.

</details>

<details>
<summary><b>Converting locale codes</b></summary>

```php
use kim\present\libmultilingual\utils\LocaleConverter;

LocaleConverter::convertIETF("ko_KR"); // 'kor'
LocaleConverter::convertIETF("de_DE"); // 'deu'
LocaleConverter::convertCode("eng");   // 'en_US' (the first listed tag)
LocaleConverter::convertIETF("xx_XX"); // null
```

</details>

-----

## 📖 API reference

### Traits

Namespace `kim\present\libmultilingual\traits`.

| Trait                               | Description                                                                              |
|-------------------------------------|------------------------------------------------------------------------------------------|
| `MultilingualPluginTrait`           | `PluginTranslationTrait` + `DelegatedTranslatorHolderTrait`: translator from resources, `translate()` on the plugin |
| `MultilingualPluginModifiableTrait` | Same, but the languages are loaded from the data folder                                  |
| `PluginTranslationTrait`            | `getTranslator()` built from `resources/locale/*.ini`                                    |
| `PluginTranslationModifiableTrait`  | `getTranslator()` built from the data folder, `eng` fallback from resources              |
| `DelegatedTranslatorHolderTrait`    | `translate()`, `getLanguage()`, ... on the holder, delegating to `getTranslator()`       |
| `TranslatorHolderTrait`             | Stores a `Translator` for a class that implements `TranslatorHolder`                     |
| `MultilingualResourceTrait`         | `getResourcePathByLanguage()`, `saveResourceByLanguage()`                                |
| `MultilingualConfigTrait`           | `saveDefaultConfig()` that picks `config/<language>.yml`                                 |

To change where the files are or how they are named, override `getLocaleResourcePath()` (default `"locale"`) and
`getLocaleFilePattern()` (default `/^([a-zA-Z]{3})\.ini$/`, the first group is the locale code).

### `Translator`

Namespace `kim\present\libmultilingual`.

| Method                                                                 | Description                                                                           |
|------------------------------------------------------------------------|---------------------------------------------------------------------------------------|
| `new Translator(array $languages = [], ?Language $fallbackLanguage = null)` | Throws `RuntimeException` if there is no fallback and no `eng` language          |
| `translate(string $str, array $params = [], string\|object\|null $locale = null): string` | `$locale` is a locale code, a player or sender, or `null` for the server language |
| `hasKey(string $key, ?string $locale = null): bool`                    | Whether the language has this key                                                     |
| `getLanguage(?string $locale = null): Language`                        | The language of a locale, or the fallback. Legacy `ger` / `fre` files are still found for `deu` / `fra` |
| `getLanguages(): Language[]` / `getLocaleList(): string[]`             | Registered languages / their locale codes                                             |
| `addLanguage(Language)` / `removeLanguage(string $locale)`             | Add or replace / remove a language                                                    |
| `getFallbackLanguage()` / `setFallbackLanguage(Language)`              | The language used for missing languages and keys                                      |

### `Language`

| Method                                                | Description                                                       |
|-------------------------------------------------------|-------------------------------------------------------------------|
| `new Language(array $map, string $locale)`            | `$map` is `id => text`                                            |
| `Language::fromContents(string $contents, string $locale): Language` | Parses `.ini` contents; never throws or warns, bad input gives an empty language |
| `Language::fromFile(string $path, string $locale): ?Language` | `null` if the file does not exist or cannot be read       |
| `get(string $id): ?string` / `getNonNull(string $id): string` | The text, or `null` / the id itself                       |
| `getLocale(): string` / `getName(): string`           | The locale code / the `language.name` value                       |

### `GlobalParams`

| Method                                         | Description                                  |
|------------------------------------------------|----------------------------------------------|
| `GlobalParams::set(string $name, string $contents)` | Register or change a global parameter   |
| `GlobalParams::remove(string $name)`           | Remove one                                   |
| `GlobalParams::getAll(): array`                | All global parameters                        |

### `LocaleConverter`

| Method                                      | Description                                                              |
|---------------------------------------------|--------------------------------------------------------------------------|
| `convertIETF(string $locale): ?string`      | Minecraft tag to PocketMine code: `ko_KR` to `kor`. `null` if unknown    |
| `convertCode(string $locale): ?string`      | PocketMine code to the first listed tag: `eng` to `en_US`, `chs` to `zh_CN` |

PocketMine's file names are used for German (`deu`) and French (`fra`). Existing `ger` / `fre` language files keep working.

### Detailed guides

- [Documentation index](docs/README.md)
- [MultilingualPluginTrait](docs/multilingual-plugin-trait.md) : the simplest setup
- [PluginTranslationTrait](docs/plugin-translation-trait.md) : language files, locale names and individual traits
- [Implement it yourself](docs/plugin-translation-self.md)
- [Translator](docs/translator.md)
- [GlobalParams](docs/global-params.md)
- [LocaleConverter](docs/locale-converter.md) : the full list of supported languages
- [MultilingualResourceTrait](docs/multilingual-resource-trait.md)
- [TranslatorHolderTrait](docs/translator-holder-trait.md)

-----

## 🧪 Development

```sh
composer install --ignore-platform-req='ext-*'
composer test
```

The tests use the real `axolotl-pm/pocketmine-mp` code without its native extensions.

-----

## 📄 License

Distributed under the **LGPL-3.0-or-later** License. See [LICENSE][license-url] for more information.


[packagist-badge]: https://img.shields.io/packagist/v/presentkim/libmultilingual.svg?style=for-the-badge

[packagist-url]: https://packagist.org/packages/presentkim/libmultilingual

[ci-badge]: https://img.shields.io/github/actions/workflow/status/presentkim-pm/libmultilingual/ci.yml?branch=main&style=for-the-badge

[ci-url]: https://github.com/presentkim-pm/libmultilingual/actions/workflows/ci.yml

[stars-badge]: https://img.shields.io/github/stars/presentkim-pm/libmultilingual.svg?style=for-the-badge

[license-badge]: https://img.shields.io/github/license/presentkim-pm/libmultilingual.svg?style=for-the-badge

[stars-url]: https://github.com/presentkim-pm/libmultilingual/stargazers

[issues-url]: https://github.com/presentkim-pm/libmultilingual/issues

[license-url]: https://github.com/presentkim-pm/libmultilingual/blob/main/LICENSE

[legacy-url]: https://github.com/presentkim-pm/libmultilingual/tree/legacy/pmmp-5.44

[axolotl-url]: https://github.com/axolotl-pm/PocketMine-MP
