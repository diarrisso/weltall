# WordPress Project

Ein benutzerdefiniertes WordPress-Projekt mit dem Mamadi-Theme und dem Weltall-Plugin.

## Übersicht

Dieses Repository enthält ein WordPress-Projekt mit benutzerdefinierten Komponenten:

- **Mamadi Theme**: Ein modernes, responsives WordPress-Theme mit WooCommerce-Integration
- **Weltall Plugin**: Ein Plugin zur Verwaltung und Anzeige von Planetendaten mit Markdown-Unterstützung

## ⚠️ Wichtiger Hinweis

Dieses Repository enthält nicht den WordPress-Core (wp-admin, wp-includes, etc.). Bitte laden Sie WordPress von wordpress.org herunter oder verwenden Sie Composer, um es zu installieren.

## Installation

```bash
# Klonen Sie das Repository
git clone https://git@github.com:diarrisso/weltall.git

# Wechseln Sie in das Projektverzeichnis
cd weltall
```

## Komponenten

### Mamadi Theme

Ein modernes, responsives WordPress-Theme mit folgenden Funktionen:

- WooCommerce-Integration
- Sass-basiertes Styling
- Responsive Design
- Anpassbare Menüs
- WordPress-Customizer-Unterstützung

Weitere Informationen finden Sie in der [Mamadi Theme README](wp-content/themes/MAMADI/README.md).

### Weltall Plugin

Ein spezialisiertes Plugin für die Verwaltung von Planetendaten:

- Planetendaten-Verwaltung
- Markdown-Unterstützung
- Frontend-Anzeige
- Admin-Interface

Weitere Informationen finden Sie in der [Weltall Plugin README](wp-content/plugins/weltall/README.md).

## Schnellstart

### Voraussetzungen

- PHP 7.4 oder höher
- MySQL 5.6 oder höher
- Node.js 14+ und npm
- Webserver (Apache/Nginx) oder PHP Development Server

### Setup

1. **Datenbank erstellen**
   ```sql
   CREATE DATABASE ;
   ```

2. **WordPress konfigurieren**
   ```bash
   cp wp-config-sample.php wp-config.php
   ```
   Bearbeiten Sie `wp-config.php` mit Ihren Datenbankdetails.

3. **Abhängigkeiten installieren**
   ```bash
   npm install
   ```

4. **Entwicklungsserver starten**
   ```bash
   php -S localhost:8000
   ```

5. **WordPress-Installation abschließen**
   - Öffnen Sie http://localhost:8000
   - Folgen Sie dem Installationsassistenten
   - Aktivieren Sie das Mamadi-Theme und das Weltall-Plugin

## Unterstützung

Bei Problemen oder Fragen:

- Erstellen Sie ein Issue im GitHub-Repository
- Konsultieren Sie die WordPress-Dokumentation
