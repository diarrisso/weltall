# Weltall WordPress Plugin

Ein benutzerdefiniertes WordPress-Plugin zur Verwaltung und Anzeige von Planetendaten mit Markdown-Unterstützung.

## Beschreibung
Weltall ist ein umfassendes WordPress-Plugin zur Verwaltung und Anzeige von Planetendaten. Es bietet ein vollständiges System zum Speichern, Abfragen und Präsentieren von Planetendaten mit Unterstützung für das Markdown-Format.

## Funktionen
- **Markdown-Unterstützung**: Zusätzliche Informationen können in Markdown formatiert werden
- **Shortcode-Integration**: Einfache Einbindung in Seiten und Beiträge
- **Admin-Dashboard**: Benutzerfreundliche Verwaltungsoberfläche
- **Automatische Dateneinfügung**: Beim Aktivieren des Plugins werden automatisch Beispielplaneten eingefügt


## Installation
1. Laden Sie den `weltall`-Ordner in das `/wp-content/plugins/`-Verzeichnis hoch
2. Aktivieren Sie das Plugin über das Menü 'Plugins' in WordPress
   - Bei der Aktivierung erstellt das Plugin automatisch eine Datenbanktabelle und füllt diese mit Beispielplaneten (Mars, Pluto, Saturn, Erde und Dagobah)
   - Jeder Planet enthält Name, Umfang, Entfernung zur Sonne und eine Markdown-Beschreibung
3. Navigieren Sie zu 'Weltall' im Admin-Menü zur Konfiguration oder zum Hinzufügen weiterer Planeten

## Verwendung

### Admin-Oberfläche
Das Plugin fügt Ihrem WordPress-Admin-Panel ein 'Weltall'-Menü mit den folgenden Abschnitten hinzu:

1. **Einstellungen**: Konfigurieren Sie die Standardanzahl der anzuzeigenden Planeten (Limit). Hier können Sie das Standard-Limit für die Anzahl der angezeigten Planeten ändern.
2. **Planet hinzufügen**: Fügen Sie neue Planeten mit den folgenden Informationen hinzu:
    - Name
    - Umfang (km)
    - Entfernung zur Sonne
    - Zusätzliche Informationen (unterstützt Markdown)
3. **Planetenliste**: Sehen Sie alle Planeten in der Datenbank an und verwalten Sie diese

### Shortcode
Verwenden Sie den `[weltall]`-Shortcode, um Planeten auf einer beliebigen Seite oder einem Beitrag anzuzeigen:

```
[weltall]
```

#### Shortcode-Parameter
- `limit`: Anzahl der anzuzeigenden Planeten (Standard: in den Einstellungen festgelegter Wert)

Beispiel:
```
[weltall limit="5"]
```

## Systemanforderungen
- WordPress 5.2 oder höher
- PHP 7.4 oder höher
- MySQL 5.7 oder höher
- Composer für die Abhängigkeitsverwaltung
- Node.js und npm für die Asset-Kompilierung (nur für Entwicklung)

## Projekt-Setup (Für Entwickler)

### Repository klonen

```bash
# Klonen Sie das Repository
git clone git@github.com:diarrisso/weltall.git

# Wechseln Sie in das Plugin-Verzeichnis
cd /wp-content/plugins/weltall
```

### Composer-Abhängigkeiten installieren

Das Plugin verwendet die PHP-Bibliothek "michelf/php-markdown" für die Markdown-Konvertierung:

```bash
# Installieren Sie die Composer-Abhängigkeiten
composer install
```

### Entwicklungsumgebung einrichten

#### Voraussetzungen für die Entwicklung
- Node.js (Version 14 oder höher)
- npm (wird mit Node.js mitgeliefert)
- Sass (für Styling)

#### NPM-Abhängigkeiten installieren

```bash
# Installieren Sie die NPM-Abhängigkeiten
npm install
```

### SCSS-Dateien kompilieren

Das Plugin verwendet Sass für das Styling. Wenn Sie Änderungen an den SCSS-Dateien vornehmen, müssen Sie diese in CSS kompilieren:

#### Einmalige Kompilierung
```bash
# Mit NPM-Skript
npm run build-css

# Oder mit global installiertem Sass
sass assets/scss/style.scss assets/css/style.css
```

#### Watch-Modus (automatische Kompilierung bei Änderungen)
```bash
# Mit NPM-Skript
npm run watch-css

# Oder mit global installiertem Sass
sass --watch assets/scss/style.scss:assets/css/style.css
```

### Fehlerbehebung

#### Composer-Abhängigkeiten
Falls Sie Probleme mit Composer haben:
```bash
# Löschen Sie den vendor-Ordner und installieren Sie neu
rm -rf vendor
composer install
```

#### SCSS-Kompilierung
Falls die SCSS-Kompilierung fehlschlägt:
1. Stellen Sie sicher, dass Node.js und npm installiert sind
2. Führen Sie `npm install` aus, um alle Abhängigkeiten zu installieren
3. Überprüfen Sie, ob die SCSS-Dateien im `assets/scss/`-Verzeichnis vorhanden sind

## Datenbank-Schema

Das Plugin erstellt eine benutzerdefinierte Tabelle `wp_weltall` mit folgenden Spalten:
- `id`: Primärschlüssel
- `name`: Planetenname
- `umfang_km`: Umfang in km
- `entfernung_sonne`: Entfernung zur Sonne
- `zusatz`: Zusätzliche Informationen (Markdown)
- `created_at`: Erstellungsdatum


## Automatische Dateneinfügung

Das Plugin enthält eine Funktion zur automatischen Einfügung von Beispieldaten bei der Aktivierung:

### Funktionsweise
- Die Funktion `insert_weltall_data()` in der Klasse `Database` wird beim Aktivieren des Plugins aufgerufen
- Sie prüft zunächst, ob bereits Daten in der Tabelle vorhanden sind, um doppelte Einträge zu vermeiden
- Wenn die Tabelle leer ist, werden fünf Beispielplaneten eingefügt: Mars, Pluto, Saturn, Erde und Dagobah
- Jeder Planet erhält standardisierte Daten für Name, Umfang, Entfernung zur Sonne und eine Markdown-Beschreibung

### Vorteile
- Sofortige Nutzbarkeit des Plugins ohne manuelle Dateneingabe
- Demonstration der Funktionalität und des Datenformats
- Konsistente Beispieldaten für Tests und Entwicklung
- Gleiche Datenstruktur wie bei der manuellen Eingabe über das Formular

### Beziehung zum Formular
- Die automatisch eingefügten Daten haben die gleiche Struktur wie die über das Formular eingegebenen Daten
- Beide Methoden nutzen die gleiche Datenbanktabelle und das gleiche Datenformat
- Die automatisch eingefügten Daten können über das Admin-Interface angezeigt über das 'Planetenliste'-Formular angezeigt werden
- Das Formular kann verwendet werden, um weitere Planeten hinzuzufügen oder bestehende zu bearbeiten

## Sicherheit
- Alle Benutzereingaben werden validiert und bereinigt
- Nonce-Verifizierung für alle Formulare
- Capability-Checks für Admin-Funktionen
- SQL-Injection-Schutz durch prepared statements

## Unterstützung
Bei Problemen oder Fragen können Sie:
- Issues im GitHub-Repository erstellen

## Changelog

### Version 1.0.0
- Erste Veröffentlichung
- Grundlegende Planetenverwaltung
- Markdown-Unterstützung implementiert
- Shortcode-Funktionalität
- Admin-Dashboard erstellt


### Version 1.1.0
- **Objektorientierte Architektur**: Verbesserte Code-Organisation mit klaren Klassenstrukturen und Verantwortlichkeiten
- **Caching-Mechanismen**: Implementierung von Daten-Caching für verbesserte Leistung
- **Erweiterte Sicherheitsmaßnahmen**: Zusätzliche Validierung und Sanitierung von Benutzereingaben
- **Formular-Refactoring**: Verbesserte Formularstruktur und -validierung
- **Verbesserte Fehlerbehandlung**: Robustere Fehlerbehandlung und Benutzerrückmeldungen
- **Code-Optimierung**: Allgemeine Leistungsverbesserungen und Codebereinigung

