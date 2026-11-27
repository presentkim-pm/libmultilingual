# Changelog

## 2.0.0 (2026-11-27)

The Poggit virion version (1.2.0) for the original [pmmp/PocketMine-MP](https://github.com/pmmp/PocketMine-MP) 5.x is kept on the
[`legacy/pmmp-5.44`](https://github.com/presentkim-pm/libmultilingual/tree/legacy/pmmp-5.44) branch.

### ⚠️ Breaking changes
- Targets [axolotl-pm/PocketMine-MP](https://github.com/axolotl-pm/PocketMine-MP) and **PHP 8.4+** (`ext-mbstring` required).
- Distributed with Composer: the Poggit virion files (`.poggit.yml`, `virion.yml`) are removed.
- `LocaleConverter` uses PocketMine's file names for German and French: `de_DE` is now `deu` (was `ger`) and
  `fr_FR` / `fr_CA` are now `fra` (was `fre`). `Translator` still finds existing `ger` / `fre` language files
  when no `deu` / `fra` language is registered (`LocaleConverter::LEGACY_ALIASES`).
- `LocaleConverter::convertCode()` returns the first listed tag when several share a code (`en_US`, `zh_CN`, `es_ES`, ...).
- Parameters passed to `translate()` override global parameters of the same name, and numeric keys are preserved.
- `{%uXXXX}` Unicode placeholders are no longer written to `GlobalParams`; they are decoded while translating.
- Language files with sections or array-style keys ignore those entries.

### ✨ Features
- `{%uXXXX}` supports 1 to 6 hex digits, so emoji such as `{%u1F600}` work. Invalid code points are left untouched.
- `LocaleConverter`: new `lv_LV` to `lav` and `vi_VN` to `vie`.
- `Translator` works without a running server (unit tests, tools): it falls back to the fallback language.

### 🐛 Fixes
- Placeholders are replaced in a single pass, so a replaced value is never scanned for placeholders again.
- A malformed `.ini` file returns an empty `Language` instead of a PHP warning (an exception under PocketMine-MP's error handler).
- `PluginTranslationModifiableTrait`: the fallback language is named `eng` and found through the locale file pattern.
- `MultilingualResourceTrait` replaces `%s` with `str_replace()` and no longer emits warnings when `mkdir()` or `copy()` fails.

### 🧪 Tests
- PHPUnit tests and GitHub Actions CI on PHP 8.4 / 8.5.
