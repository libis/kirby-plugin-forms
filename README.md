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
- Select veld met de optie om het ontvang adres (email) te veranderen afhankelijk van de optie

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

### Stijl & functionaliteiten
#### Stijl
Deze plugin komt met een standaard styling deze kan je aanpassen door de classes in je iegen css op te roepen en aan te passen. Gebruik je tailwind voeg deze file dan niet toe en kopieer alle snippet files naar je project in `site/snippets` en voeg de classes toe.
Voeg dit in je head toe:
```
<link rel="stylesheet" href="/media/plugins/libis/forms/css/index.css">
```

<br/>

#### Functionaliteiten
Voeg volgende JS file toe in je footer (zonder deze file zal de plugin niet werken):
```
<script defer type="module" src='/media/plugins/libis/forms/js/index.js'></script>
```

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
Wanneer de plugin wordt toegevoegd aan je project zal de plugin automatisch een `forms` pagina creëeren. Deze kan je bereiken via `/panel/pages/forms`.

Op de forms pagina kan je de formulieren samenstellen. 
1. Voeg formulierpagina toe
2. Voeg formuliervelden naar keuze toe (zie alle opties bij [formulierveld opties](#user-content-formulierveld-opties))
3. Ga naar een pagina naar keuze waar vrije content mogelijk op is (layout of blocks field)
4. Voeg een form blok toe en selecteer welk formulier je wilt toevoegen.

### Formulierveld opties
- Input veld (tekst, email, telefoonnummer, nummer, url)
- Tekstveld
- Checkbox
- Select (met email configuratie of niet)
- File input

### Customalisatie
Je kan de look and feel van het formulier helemaal naar je hand zetten door de snippets van het formulier of van formuliervelden over te kopiëren in je eigen project. 
LET OP: Als je forumuliervelden overkopieerd dan is de naam en plaats niet dezelfde. `formfields/01_input` plaats je rechtstreeks in `snippets/blocks/input`

### Emails verzenden
Er zijn standaardtemplates voor de mail die verzonden wordt naar zowel de persoon die het formulier heeft ingevuld als de persoon die het moet ontvangen (het bedrijf). Deze kunnen volledig gepersonaliseerd worden door de emailtemplates uit `templates/email` over te kopiëren naar je project.

Wil je iets aanpassen in de code van de route die voor de verzending zorgt? Maak in je project een route (niet hetzelfde path) en kopieer de code over die in de huidige route zit en pas aan. LET OP: kopieer dan ook je snippet van je form in je project en pas de route daar aan naar de nieuwe.
