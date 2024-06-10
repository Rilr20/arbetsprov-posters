# arbetsprov-posters

## Installation

```sh
composer install
import poster.sql to mysql
```

## Tid
    - Databas setup and design                  ~1h
    - Admin Search functionality incl testing   2h
    - Multipage funktionality                   0.5h
    - Gemini pre-study + installation           1h
    - Gemini Implementation                     0.75h
    - Processing Generated Results              0.75h
    - OpenAi pre-study + installation           0.5h
    - Add OpenAi api call and testing           0.75h
    - Processing new Generated Results          1h
    - Index page and Image page and styling     1h


## Instructions

1. Sökfunktion och slumpmässig visning av bilder via Pexels API:

    - Administratör ska kunna söka efter bilder baserat på nyckelord eller visa bilder slumpmässigt.
    - Varje bild visas endast en gång, med alternativen "Ja" och "Nej" för att godkänna eller avvisa bilden.


2. Textgenerering och granskning:

    - För varje godkänd bild genererar systemet automatiskt en titel, beskrivning, rubrik och nyckelord med hjälp av ChatGPT API.
    - De genererade texterna visas tillsammans med bilden och ska kunna godkännas eller redigeras.


3. Administrationspanel:

    - Enkel inloggningsfunktionalitet för administratörer.
    - Separata funktionaliteter för bildsökning och granskning.
    - Översikt över godkända bilder och deras data.


### Backend

    - Använd HTML och CSS för struktur och enkel design.
    - Använd jQuery för att hantera användarinteraktioner och AJAX-anrop.
    - Bygg systemet med Core PHP för att hantera API-anrop och databasinteraktioner.
    - Integrera Pexels API och ChatGPT API.
    - Använd MySQL för att lagra textuell data, spara bilderna i hög upplösning samt ett thumbnail separat.
    - Håll reda på vilka bilder som har visats och godkänts/avvisats.
