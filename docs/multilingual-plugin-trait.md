<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: MultilingualPluginTrait</h1>
</div>

## :tada: Overview

One-trait entry point for the simplest multilingual plugin setup.

Add a single trait to your `PluginBase` and use `translate()` directly without combining multiple traits.

-----
<br/>

## :book: Which trait to use?

| Trait | Use case |
|-------|----------|
| `MultilingualPluginTrait` | Messages from plugin resources. Updated on plugin upgrade. |
| `MultilingualPluginModifiableTrait` | Messages from data folder. Users can edit locale files. |

-----
<br/>

## :book: How to use?

### MultilingualPluginTrait (resource-based)

```php
use kim\present\libmultilingual\traits\MultilingualPluginTrait;

class Main extends PluginBase implements Listener {
    use MultilingualPluginTrait;

    public function onPlayerJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $player->sendMessage($this->translate("basic.server.introduction", [], $player));
    }
}
```

### MultilingualPluginModifiableTrait (data folder, user-editable)

```php
use kim\present\libmultilingual\traits\MultilingualPluginModifiableTrait;

class Main extends PluginBase implements Listener {
    use MultilingualPluginModifiableTrait;

    public function onPlayerJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $player->sendMessage($this->translate("basic.server.introduction", [], $player));
    }
}
```

-----
<br/>

## :bulb: Prerequisite

- Place language files in `resources/locale/` (e.g. `eng.ini`, `kor.ini`)
- `eng.ini` is required as fallback
- See [PluginTranslationTrait](plugin-translation-trait.md) for locale rules

-----
<br/>

## :question: Migration from existing traits

If you already use `PluginTranslationTrait` + `DelegatedTranslatorHolderTrait`:

```php
// Before
use PluginTranslationTrait, DelegatedTranslatorHolderTrait;

// After
use MultilingualPluginTrait;
```

Same for `PluginTranslationModifiableTrait` + `DelegatedTranslatorHolderTrait`:

```php
// Before
use PluginTranslationModifiableTrait, DelegatedTranslatorHolderTrait;

// After
use MultilingualPluginModifiableTrait;
```

[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/traits/MultilingualPluginTrait.php)
