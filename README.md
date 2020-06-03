# EPSyLON ![Laravel](https://github.com/Deltachi/epsylon/workflows/Laravel/badge.svg)
Elektronisches Prüfungssystem für die Lehre Online

Anders als herkömmliche Ansätze, sollen Prüfende in einem digitalen Prüfungssystem für Studierende die Möglichkeit haben, Prüfungsaufgaben abseits von generischen Multiple Choice-Aufgaben und Freitextfeldern gestalten zu können. So ermöglicht dieses innovative Prüfungssystem größtmögliche Einschränkungsfreiheit, um nah an eine Prüfungssituation, die mit Stift und Papier bearbeitet wird, zu kommen und die bisherigen Prüfungsformate sogar zu bereichern.

## Das Team:

| Name  | Rolle |
| ------------- | ------------- |
| Dominik Scheffler (Deltachi)  | Projektmanager/Controller, Programmierer  |
| Jonas Strunk (RipDip) | Risikomanager, Programmierer  |
| Umut Güngör (Umsko010) | Qualitätsmanager, Programmierer  |

## Wie Richte ich Laravel nach einem "git clone" ein?
Wichtige Software-Abhängigkeiten (vorher installieren):
- PHP 7.+
- Node.js
- Composer
- SQLite (oder eine MySQL-Server-Verbindung)

[Full-Length-Tutorial zur Einrichtung (bei Interesse)](https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/)
**Hinweis: Schritt 8 und weiter bitte nicht beachten!**

**Kurzzusammenfassung** der wichtigsten Schritte:
1.  **Clone** GitHub repo for this project locally
2.  cd into your project `cd epsylon/app`
3.  Install **Composer** Dependencies via `composer install` (alternativ auch `composer update`)
4.  Install **NPM** Dependencies via `npm install`
5.  Copy the environment file via `cp .env.example .env`
6.  Setup .env file:
    - **SQLite**: Delete all `DB_` lines and insert ``DB_CONNECTION=sqlite``
        - Create an empty `database/database.sqlite`-file
    - **MySQL**: Wenn ein MySQL Server benutzt wird, müssen die IP, Benutzer, Passwort usw. eingetragen werden
7.  Generate an app encryption key via `php artisan key:generate`
8.  Start a PHP Server (Apache, XAMPP, Node.js)
    - **Laravel** wird mit einem **Apache-Server** ausgeliefert, dieser kann mit folgendem Befehl gestartet werden:
        - ```php artisan serve```
        - Nun ist der Server standardmäßig über `localhost:8000` erreichbar
    - Bei der Benutzung von **XAMPP (oder anderen)** muss der **root-Pfad** des Servers auf den Ordner `public` gesetzt werden
9.  Initialize the Database for first use (Create DB-Schema)
    - `php artisan migrate:fresh` Erstellt ein frisches Datanbankschema (löst vorheriges Löschen des alten Schemas aus) 

Fehlerbehandlung:
1. Wenn es zu einem Fehler bei `php artisan migrate:fresh` kommt, kann es daran liegen, dass die `extension=pdo_mysql`, `extension=pdo_sqlite` oder `extension=pdo_mysqli` in `php.ini` nicht aktiviert wurde
2. Kommt es bei `composer install` zu einem Fehler, kann dies daran liegen, dass `extension=fileinfo` in der `php.ini`-Datei nicht aktiviert wurde

___

## Nochmal ganz von vorne: Installation der Entwicklungsumgebung und eines Laravel-Projektes

Die Installation von Laravel wird in der Dokumentation erklärt: [Installationsanleitung](https://laravel.com/docs/6.x/installation)

Weitere Hinweise für die Installation unter Ubuntu 16.04: [Hinweise](https://websiteforstudents.com/install-laravel-php-framework-on-ubuntu-16-04-17-10-18-04-with-apache2-and-php-7-2-support/)

## Einstieg in Laravel
Dokumentation: [Documentation](https://laravel.com/docs/6.x)

### Youtube-Tutorial
In diesem Tutorial wird Laravel eingerichtet, erklärt und ein einfacher Instagram-Klon erstellt: [Link zum Video](https://www.youtube.com/watch?v=ImtZ5yENzgE)

##### HINWEIS:
- Ab Version 6 von Laravel hat sich die Einrichtung des Authentifizierungs-Systems geändert. 
Jedoch ist das System auf dem Repository bereits eingerichtet. Lediglich fürs Verständnis ist diese Seite der Doku zu beachten: 
[Doku zur Authentication](https://laravel.com/docs/6.x/authentication)
 
