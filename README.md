# Kirby-plugin-forms
Een Kirby CMS-plugin voor het beheren, weergeven en verwerken van formulieren.

---

## ✨ Features
- Maak formulieren aan via het Kirby Panel.
- Voeg formulieren toe aan pagina's via een block of layout block
- Verzend formulierdata via e-mail.
- Configureer ontvangers, onderwerp en bevestigingsberichten.
- Herbruik formulieren op meerdere pagina's.
- Volledig geïntegreerd in Kirby CMS.

<br/>

## ⚠️ Vereisten
- Kirby 5+
- PHP >= 8.3

<br/>

## Instalatie
### Docker
Laat de plugin in je docker image draaien en zet enkel de pagina's die je wilt aanpassen of bijcreëren (zie project structuur) in je project zelf.
```php
ARG KIRBY_PLUGIN_FORMS_BRANCH=main
RUN wget --no-verbose "https://github.com/libis/kirby-plugin-forms/archive/${KIRBY_PLUGIN_FORMS_BRANCH}.zip" -O /var/www/html/site/plugins/forms.zip \
    && unzip -q /var/www/html/site/plugins/forms.zip -d /var/www/html/site/plugins/ \
    && rm /var/www/html/site/plugins/forms.zip \
    && mv /var/www/html/site/plugins/kirby-plugin-forms-${KIRBY_PLUGIN_FORMS_BRANCH} /var/www/html/site/plugins/forms \
    && chown -R www-data:www-data /var/www/html/site/plugins/forms
```
<br/>

### Manually
1. Download of clone deze repository.
2. Plaats de plugin in de map:

<br/>

## Configuratie
### Recaptcha
Voeg volgende gegevens in `env.php`:
``` php
'libis.forms' => [
    'recaptchaSiteKey' => '',
    'recaptchaSecretKey' => '',
],
```

<br/>

### E-mailconfiguratie
De plugin maakt gebruik van de Kirby e-mailfunctionaliteit. Configureer daarom een mailtransport in je `config.php`. bekijk de officiele handleiding voor [info](https://getkirby.com/docs/guide/emails)

<br/>

### Toevoegen in de nav
Als je graag een link in je navigatie toevoegd die je de pagina laat zien waar al je formulieren opgelijst staan. Voeg dan volgende toe aan je `config.php`.
```php
'panel' => [
  'menu' => [
    'forms' => [
        'icon' => 'dashboard',
        'label' => 'libis.forms',
        'link' => 'pages/forms',
        'current' => function (string $current): bool {
            $path = Kirby\Cms\App::instance()->path();
            return Str::contains($path, 'pages/forms');
        }
    ],
  ]
]
```
Let op dit overschrijft heel de navigatie voor meer info bekijk de officiële [handleiding van kirby](https://getkirby.com/docs/reference/system/options/panel/panel-menu).

<br/>

### Toevoegen in een layout of block fieldset
```yml
- form
```

<br/>

## Gebruik
