When using any of the `json-import` console commands, you need to specify a URL that contains the JSON file you want to import.

### The following JSON format should be used:

#### Cargos:
```jsmin
{
    // Internal ID for the cargo used within the game as well as any other extracted data
    "id": "",
    // Default name for the cargo used by the game, if the name is not localized
    "defaultName": "",
    // An object with each property representing a locale and the value being the localized name of said locale
    "localizedNames": {
        "bg_bg": "",
        "ca_es": "",
        "cs_cz": "",
        "da_dk": "",
        "de_de": "",
        "el_gr": "",
        "en_gb": "",
        "en_us": "",
        "es_es": "",
        "es_la": "",
        "et_ee": "",
        "eu_es": "",
        "fi_fi": "",
        "fr_fr": "",
        "gl_es": "",
        "hr_hr": "",
        "hu_hu": "",
        "it_it": "",
        "ja_jp": "",
        "ka_ge": "",
        "ko_kr": "",
        "lt_lt": "",
        "lv_lv": "",
        "mk_mk": "",
        "nl_nl": "",
        "no_no": "",
        "pl_pl": "",
        "pl_si": "",
        "pt_br": "",
        "pt_pt": "",
        "ro_ro": "",
        "ru_ru": "",
        "sk_sk": "",
        "sl_sl": "",
        "sr_sp": "",
        "sr_sr": "",
        "sv_se": "",
        "tr_tr": "",
        "uk_uk": "",
        "vi_vn": "",
        "zh_cn": "",
        "zh_tw": ""
    },
    // An array of the groups the cargo belongs to (can be used to locate special transport cargo, "oversize")
    "groups": [
        ""
    ]
}
```

#### Cities:
```jsmin
{
    // Internal ID for the city used within the game as well as any other extracted data
    "id": "",
    // Internal ID of the country that the city belongs to
    "countryId": "",
    // Default name for the city used by the game, if the name is not localized (likely the value exposed by the game API)
    "defaultName": "",
    // Default short name for the city used by the game, if the short name is not localized (likely the value exposed by the game API)
    "defaultShortName": "",
    // An object with each property representing a locale and the value being the localized name of said locale
    "localizedNames": {
        "bg_bg": "",
        "ca_es": "",
        "cs_cz": "",
        "da_dk": "",
        "de_de": "",
        "el_gr": "",
        "en_gb": "",
        "en_us": "",
        "es_es": "",
        "es_la": "",
        "et_ee": "",
        "eu_es": "",
        "fi_fi": "",
        "fr_fr": "",
        "gl_es": "",
        "hr_hr": "",
        "hu_hu": "",
        "it_it": "",
        "ja_jp": "",
        "ka_ge": "",
        "ko_kr": "",
        "lt_lt": "",
        "lv_lv": "",
        "mk_mk": "",
        "nl_nl": "",
        "no_no": "",
        "pl_pl": "",
        "pl_si": "",
        "pt_br": "",
        "pt_pt": "",
        "ro_ro": "",
        "ru_ru": "",
        "sk_sk": "",
        "sl_sl": "",
        "sr_sp": "",
        "sr_sr": "",
        "sv_se": "",
        "tr_tr": "",
        "uk_uk": "",
        "vi_vn": "",
        "zh_cn": "",
        "zh_tw": ""
    },
    // An object with each property representing a locale and the value being the localized short name of said locale
    "localizedShortNames": {
        "bg_bg": "",
        "ca_es": "",
        "cs_cz": "",
        "da_dk": "",
        "de_de": "",
        "el_gr": "",
        "en_gb": "",
        "en_us": "",
        "es_es": "",
        "es_la": "",
        "et_ee": "",
        "eu_es": "",
        "fi_fi": "",
        "fr_fr": "",
        "gl_es": "",
        "hr_hr": "",
        "hu_hu": "",
        "it_it": "",
        "ja_jp": "",
        "ka_ge": "",
        "ko_kr": "",
        "lt_lt": "",
        "lv_lv": "",
        "mk_mk": "",
        "nl_nl": "",
        "no_no": "",
        "pl_pl": "",
        "pl_si": "",
        "pt_br": "",
        "pt_pt": "",
        "ro_ro": "",
        "ru_ru": "",
        "sk_sk": "",
        "sl_sl": "",
        "sr_sp": "",
        "sr_sr": "",
        "sv_se": "",
        "tr_tr": "",
        "uk_uk": "",
        "vi_vn": "",
        "zh_cn": "",
        "zh_tw": ""
    }
}
```

#### Companies:
```jsmin
{
    // Internal ID for the company used within the game as well as any other extracted data
    "id": "",
    // Name of the company (company names aren't localized)
    "name": "",
    // An array of internal city IDs that features this company
    "cityIds": [
        ""
    ],
    // An array of internal cargo IDs that this company accepts
    "acceptedCargoIds": [
        ""
    ],
    // An array of internal cargo IDs that this company provides
    "providedCargoIds": [
        ""
    ]
}
```

#### Countries:
*Currently not stored in a separete table*
```jsmin
{
    // Internal ID for the country used within the game as well as any other extracted data
    "id": "",
    // Default name for the country used by the game, if the name is not localized (likely the value exposed by the game API)
    "defaultName": "",
    // An object with each property representing a locale and the value being the localized name of said locale
    "localizedNames": {
        "bg_bg": "",
        "ca_es": "",
        "cs_cz": "",
        "da_dk": "",
        "de_de": "",
        "el_gr": "",
        "en_gb": "",
        "en_us": "",
        "es_es": "",
        "es_la": "",
        "et_ee": "",
        "eu_es": "",
        "fi_fi": "",
        "fr_fr": "",
        "gl_es": "",
        "hr_hr": "",
        "hu_hu": "",
        "it_it": "",
        "ja_jp": "",
        "ka_ge": "",
        "ko_kr": "",
        "lt_lt": "",
        "lv_lv": "",
        "mk_mk": "",
        "nl_nl": "",
        "no_no": "",
        "pl_pl": "",
        "pl_si": "",
        "pt_br": "",
        "pt_pt": "",
        "ro_ro": "",
        "ru_ru": "",
        "sk_sk": "",
        "sl_sl": "",
        "sr_sp": "",
        "sr_sr": "",
        "sv_se": "",
        "tr_tr": "",
        "uk_uk": "",
        "vi_vn": "",
        "zh_cn": "",
        "zh_tw": ""
    }
}
```
