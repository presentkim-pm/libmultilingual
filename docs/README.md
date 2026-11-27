<!-- PROJECT BADGES -->
<div align="center">

[![Stars][stars-badge]][stars-url]
[![License][license-badge]][license-url]

</div>


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  <h3>libmultilingual</h3>
  <p align="center">
    Language management library for multilingual message support!

[Report a bug][issues-url] · [Request a feature][issues-url]

  </p>
</div>


<!-- ABOUT THE PROJECT -->

## About The Project

:heavy_check_mark: Multilingual support for plugin messages  
:heavy_check_mark: Translation language is set according to the player  
:heavy_check_mark: Translation setting with According to PMMP settings

-----

## Installation

```
composer require presentkim/libmultilingual
```

Requires PHP 8.4+ and `ext-mbstring`. Targets axolotl-pm/PocketMine-MP 5.51 and above.

-----

## How to use?

> - **Quick start (recommended)**: Use `MultilingualPluginTrait` or `MultilingualPluginModifiableTrait` for a single-trait setup.
> > See [MultilingualPluginTrait guide](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/multilingual-plugin-trait.md)

> - If you want more control with individual traits:
> > See [PluginTranslationTrait guide](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/plugin-translation-trait.md)

> - If you want implement multilingual support in your self:
> > See [this guide](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/plugin-translation-self.md)

-----

## More documentations

- [**MultilingualPluginTrait**](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/multilingual-plugin-trait.md)
  One-trait entry point for the simplest setup.

- [**LocaleConverter**](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/locale-converter.md)
  Cross-convert `IETF` and `ISO 639-3` locale codes.

- [**GlobalParams**](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/global-params.md)
  global parameters for translation.

- [**Translator**](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/translator.md)
  The translator of this library.

- [**MultilingualResourceTrait
  **](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/multilingual-resource-trait.md)
  Implements multilingual support for resource files.

- [**TranslatorHolderTrait
  **](https://github.com/presentkim-pm/libmultilingual/blob/main/docs/translator-holder-trait.md)
  Implements `TranslatorHolder` interface.

## License

Distributed under the **LGPL 3.0**. See [LICENSE][license-url] for more information


[stars-badge]: https://img.shields.io/github/stars/presentkim-pm/libmultilingual.svg?style=for-the-badge

[license-badge]: https://img.shields.io/github/license/presentkim-pm/libmultilingual.svg?style=for-the-badge

[stars-url]: https://github.com/presentkim-pm/libmultilingual/stargazers

[issues-url]: https://github.com/presentkim-pm/libmultilingual/issues

[license-url]: https://github.com/presentkim-pm/libmultilingual/blob/main/LICENSE

[project-icon]: https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png
