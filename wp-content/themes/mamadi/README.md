# Mamadi WordPress Theme

Ein benutzerdefiniertes WordPress-Theme mit Sass-Unterstützung und WooCommerce-Integration.

## Übersicht

Mamadi ist ein modernes, responsives WordPress-Theme, das für Flexibilität und einfache Bedienung entwickelt wurde. Es bietet ein klares Design, ein responsives Layout und eine nahtlose Integration mit WooCommerce.

## Hauptfunktionen

**WooCommerce-Integration**: Vollständige E-Commerce-Unterstützung mit angepassten Produktseiten-Layouts, responsivem Warenkorb und Checkout sowie optimierten Shop-Seiten.

**Sass-basiertes Styling**: Moderne CSS-Präprozessor-Unterstützung für erweiterte Styling-Möglichkeiten.

**Saubere Code-Struktur**: Gut organisiert für einfache Anpassungen und Wartung.

**Anpassbare Menüs**: Unterstützung für Header- und Footer-Menüs mit flexibler Konfiguration.

**Leistungsoptimierung**: Minimierte CSS- und JavaScript-Dateien für bessere Ladezeiten.

## Systemanforderungen

- WordPress 5.0 oder höher
- PHP 7.4 oder höher
- MySQL 5.6 oder höher

## Installation

**Wichtiger Hinweis**: Dieses Repository enthält nicht den WordPress-Core (wp-admin, wp-includes, usw.). Bitte laden Sie WordPress von wordpress.org herunter oder verwenden Sie Composer, um es zu installieren.

### Für Endbenutzer

1. Laden Sie das Theme-Verzeichnis `mamadi` in `/wp-content/themes/` hoch
2. Aktivieren Sie das Theme unter 'Design > Themes' in WordPress
3. Konfigurieren Sie die Einstellungen über 'Design > Anpassen'

### Empfohlene Plugins

- **WooCommerce**: Für E-Commerce-Funktionalitäten
- **WooCommerce-payments**: Für Zahlungsabwicklung
- **WooCommerce-service**: Für erweiterte Services
- **Weltall**: Für erweiterte Planetendaten-Anzeige

## Entwicklungs-Setup

### Voraussetzungen

- Node.js und npm
- Composer (für PHP-Abhängigkeiten)
- Sass (für CSS-Präprozessor)
- MySQL (für WordPress-Datenbank)

### Projekt klonen

```bash
# Klonen Sie das Repository
git clone https://git@github.com:diarrisso/weltall.git

```

### WordPress-Installation (Lokale Entwicklung)

#### Option 1: Manuelle Installation

1. Laden Sie WordPress von [wordpress.org](https://wordpress.org/download/) herunter
2. Extrahieren Sie die Dateien in Ihr Webserver-Verzeichnis
3. Erstellen Sie eine MySQL-Datenbank für WordPress
4. Kopieren Sie `wp-config-sample.php` zu `wp-config.php` und konfigurieren Sie die Datenbankeinstellungen
5. Starten Sie den PHP-Entwicklungsserver:
   ```bash
   # Im WordPress-Hauptverzeichnis
   php -S localhost:8000
   ```
6. Öffnen Sie http://localhost:8000 im Browser und folgen Sie dem Installationsassistenten
7. Melden Sie sich im Admin-Bereich an (http://localhost:8000/wp-admin)
8. Navigieren Sie zu 'Design > Themes' und aktivieren Sie das Mamadi-Theme

#### Option 2: Lokale Entwicklungsumgebung

Verwenden Sie Tools wie:
- **XAMPP/MAMP**: Für lokale Apache/MySQL/PHP-Umgebung
- **Docker**: Mit WordPress-Container

### Theme-Installation und -Konfiguration

1. Aktivieren Sie das Theme im WordPress-Admin
2. Aktivieren Sie empfohlene Plugins
3. Konfigurieren Sie Theme-Optionen über den WordPress-Customizer

### Installation der Entwicklungsabhängigkeiten

```bash
# Navigieren Sie zum Theme-Verzeichnis
cd wp-content/themes/mamadi

# Installieren Sie die NPM-Abhängigkeiten
npm install
```

## Sass-Kompilierung

Das Theme verwendet Sass für das Styling. Die Sass-Dateien befinden sich im Verzeichnis `assets/scss` und werden in CSS im Verzeichnis `assets/css` kompiliert.

### Einmalige Kompilierung

```bash
cd wp-content/themes/mamadi
npm run build-css
# oder direkt
sass assets/scss/style.scss assets/css/style.css
```

### Watch-Modus (automatische Kompilierung bei Änderungen)

```bash
cd wp-content/themes/mamadi
npm run watch-css
# oder direkt
sass --watch assets/scss/style.scss:assets/css/style.css
```

## Anpassung

### WordPress-Customizer

Das Theme kann über den WordPress-Customizer angepasst werden:

1. Navigieren Sie zu 'Design > Anpassen'
2. Verfügbare Optionen:
   - Farben und Typografie
   - Layout-Einstellungen
   - Header- und Footer-Optionen
   - WooCommerce-Einstellungen

### Menüs einrichten

Das Theme unterstützt zwei Menü-Positionen:

**Header-Menü**: Wird in der Kopfzeile der Website angezeigt
**Footer-Menü**: Wird in der Fußzeile der Website angezeigt

So richten Sie die Menüs ein:

1. Navigieren Sie zu 'Design > Menüs' in WordPress
2. Erstellen Sie ein neues Menü oder wählen Sie ein vorhandenes aus
3. Fügen Sie Seiten, Beiträge oder benutzerdefinierte Links hinzu
4. Weisen Sie das Menü einer Position zu (Header-Menü oder Footer-Menü)
5. Speichern Sie die Änderungen

### Code-Anpassungen

Für erweiterte Anpassungen:

1. Erstellen Sie ein Child-Theme für Sicherheit
2. Bearbeiten Sie die Sass-Dateien in `assets/scss/`
3. Kompilieren Sie die Änderungen mit `npm run build-css`
4. Testen Sie Änderungen in verschiedenen Browsern

## WooCommerce-Integration

Das Theme bietet vollständige WooCommerce-Unterstützung:

- Angepasste Produktseiten-Layouts
- Responsive Warenkorb und Checkout
- Optimierte Shop-Seiten
- Kompatibilität mit WooCommerce-Erweiterungen

## Fehlerbehebung

### ENOENT-Fehler bei Sass-Kompilierung

Falls Sie den Fehler "ENOENT: no such file or directory, uv_cwd" erhalten:

1. Stellen Sie sicher, dass Sie sich im richtigen Verzeichnis befinden
2. Prüfen Sie, ob Node.js korrekt installiert ist
3. Führen Sie `npm install` erneut aus
4. Bei WSL-Umgebungen kann ein Neustart des Terminals helfen

## Unterstützung

Bei Problemen oder Fragen:

- Erstellen Sie ein Issue im GitHub-Repository
- Konsultieren Sie die WordPress-Dokumentation
- Besuchen Sie die WordPress-Community-Foren

## Changelog

### Version 1.1.0
- Footer-Menü-Unterstützung hinzugefügt
- Verbesserte Menü-Dokumentation
- CSS-Styles für Footer-Menü
- CSS-Styles für WooCommerce-Produktseiten
- Caching-Optimierungen
- Sicherheitsverbesserungen
- Allgemeine Leistungsoptimierung

### Version 1.0.0
- Erste Veröffentlichung
- Grundlegende Theme-Funktionalität
- WooCommerce-Integration
- Sass-Kompilierung eingerichtet
- Weltall-Plugin-Kompatibilität