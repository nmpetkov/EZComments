<?php 
// $Id: global.php 431 2007-08-13 19:31:11Z landseer $
// ----------------------------------------------------------------------
// EZComments
// Attach comments to any module calling hooks
// ----------------------------------------------------------------------
// Author: J�rg Napp
// Author: Florian Schie�l
// ----------------------------------------------------------------------
// LICENSE
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------




// new for 2.0 (.8only)

// ContactList integration
define('_EZCOMMENTS_USER_IGNORES_YOU',		'Der Besitzer des zu kommentierenden Inhaltes hat Dich auf seiner Ignorierliste. Du kannst hier keinen Kommentar hinterlassen!');

// admin interface
define('_EZCOMMENTS_TOOWNERORADMIN',		'Die Benachrichtigung wird, wenn ein Inhaltsbesitzer ermittelt werden kann (z.B. der Benutzer, dessen Profil kommentiert wurde), an diesen geschickt. Ansonsten wird die Email an den Seitenadministrator verschickt.');
define('_EZCOMMENTS_OWNERUSERNAME',			'Inhaltsbesitzer');
define('_EZCOMMENTS_UNKNOWNOWNER',			'unbekannt');

// myprofile plugin
define('_EZCOMMENTS_TABTITLE', 				'Pinnwand');
define('_EZCOMMENTS_PINBOARDFOR',			'Pinnwand f�r das Communitymitglied');
define('_EZCOMMENTS_HOOKREGFAILED',			'Der EZComments-Hook f�r MyProfile konnte nicht registriert werden');
define('_EZCOMMENTS_PINBOARDDEACT',			'Der Benutzer hat seine Pinnwand deaktiviert');
define('_EZCOMMENTS_PINBOARDENTRYS',		'Anzahl Pinnwandeintr�ge');
define('_EZCOMMENTS_REGISTERTOVIEW',		'Pinnwandwintr�ge sind nur f�r registrierte Mitglieder sichtbar. Bitte dazu anmelden oder einloggen!');
// my account panel
define('_EZCOMMENTS_MANAGEMYCOMMENTS', 		'Kommentare verwalten');

define('_EZCOMMENTS_ILLEGALSTATUS', 'falscher Status');
define('_EZCOMMENTS_ANONNAMEMISSING', 'Name f�r den anonymen Benutzer fehlt');
define('_EZCOMMENTS_ANONMAILMISSING', 'Emailadresse des anonymen Benutzers fehlt oder ist ung�ltig');
define('_EZCOMMENTS_ANONWEBSITEINVALID', 'Webseite des anonymen Benutzers ist ung�ltig');
define('_EZCOMMENTS_SENDMEBACK', 'Nach Abschlu� zur�ck zum kommentierten Inhalt');
define('_EZCOMMENTS_MISSINGVALUE', 'Wert fehlt');
// end of new defines

define('_EZCOMMENTS',                       'Kommentare');

// admin interface
define('_EZCOMMENTS_NOAUTH',                'Keine Berechtigung f�r die Kommentare.');
define('_EZCOMMENTS_ONLYREG',               'Nur angemeldete Benutzer d�rfen Kommentare verfassen.');
define('_EZCOMMENTS_GOTOREG',               'Zur Registrierung/Anmeldung');
define('_EZCOMMENTS_ADD',                   'Hinzuf�gen');
define('_EZCOMMENTS_DEL',                   'Diesen Kommentar l�schen');
define('_EZCOMMENTS_COMMENT_ADD',           'Einen Kommentar hinzuf�gen');
define('_EZCOMMENTS_COMMENT_ANSWER',        'Hierauf antworten');
define('_EZCOMMENTS_CREATED',               'Kommentar hinzugef�gt');
define('_EZCOMMENTS_DELETED',               'Kommentar gel�scht');
define('_EZCOMMENTS_FAILED',                'Interner Fehler');
define('_EZCOMMENTS_RULES',                 'Hier sollten die Regeln f�r die Benutzung der Kommentaren hinterlegt werden.');
define('_EZCOMMENTS_ADMIN',                 'EZComments Administration');
define('_EZCOMMENTS_ADMIN_MAIN',            'Hauptmen�');
define('_EZCOMMENTS_SENDINFOMAIL',          'Mail bei neuen Kommentaren verschicken');
define('_EZCOMMENTS_OK',                    'Best�tigen');
define('_EZCOMMENTS_LASTCOMMENTS',          'Die letzten Kommentare');
define('_EZCOMMENTS_USERNAME',              'Benutzer');
define('_EZCOMMENTS_MODULE',                'Modul');
define('_EZCOMMENTS_TEMPLATE',              'Layout');
define('_EZCOMMENTS_ALLCOMMENTS',           'Alle %s% Kommentare');
define('_EZCOMMENTS_EDIT',                  'Kommentar bearbeiten');
define('_EZCOMMENTS_ITEMSPERPAGE',          'Kommentare pro Seite (f�r den Administrator)');
define('_EZCOMMENTS_ALLOWANONUSERSETINFO',  'Anonyme User d�rfen ihre Daten angeben');

// user errors/status messages
define('_EZCOMMENTS_EMPTYCOMMENT',          'Fehler! Kommentar enth�lt keinen Text');

//cleanup of orphaned comments
define('_EZCOMMENTS_CLEANUP_NOTHINGTODO',   'Es gibt keine verwaisten Kommentare');
define('_EZCOMMENTS_CLEANUP_GOBACK',        'Zur�ck');
define('_EZCOMMENTS_CLEANUP_EXPLAIN',       'Mit dieser Funktionalit�t k�nnen Kommentare zu Modulen, die entfernt wurden, gel�scht werden.');
define('_EZCOMMENTS_CLEANUP_LABEL',         'Modul ausw�hlen:');
define('_EZCOMMENTS_CLEANUP_GO',            'Alle Kommentare zu diesem Modul l�schen');
define('_EZCOMMENTS_CLEANUP',               'Verwaiste Kommentare l�schen');

//comment migration
define('_EZCOMMENTS_MIGRATE_EXPLAIN',       'Hiermit k�nnen Kommentare aus bestehenden Modulen importiert werden.');
define('_EZCOMMENTS_MIGRATE_NOTHINGTODO',   'Es gibt keine zu migrierenden Module');
define('_EZCOMMENTS_MIGRATE_GOBACK',        'Zur�ck');
define('_EZCOMMENTS_MIGRATE_LABEL',         'Migration von:');
define('_EZCOMMENTS_MIGRATE_GO',            'Migration starten');
define('_EZCOMMENTS_MIGRATE',               'Kommentare migrieren');

//errors/status meesages for init script
define('_EZCOMMENTS_FAILED1',               'Erstellung der Tabelle fehlgeschlagen');
define('_EZCOMMENTS_FAILED2',               'Registrierung des Hooks fehlgeschlagen');
define('_EZCOMMENTS_FAILED3',               'L�schen der Tabelle fehlgeschlagen');
define('_EZCOMMENTS_FAILED4',               'L�schen des Hooks fehlgeschlagen');
define('_EZCOMMENTS_FAILED5',               'Update der Tabellen fehlgeschlagen');

// e-mail messages
define('_EZCOMMENTS_MAILSUBJECT',           'Neuer Kommentar'); 
define('_EZCOMMENTS_MAILBODY',              'Ein neuer Kommentar wurde eingegeben'); 
define('_EZCOMMENTS_SHOW',                  'Anzeigen');
define('_EZCOMMENTS_MODERATE2',             'Freigeben/Ablehnen');
define('_EZCOMMENTS_DELETE',                'L�schen');

//useful phrases for the user templates
define('_EZCOMMENTS_POSTED',                'verfasst'); 
define('_EZCOMMENTS_REG_SINCE',             'registriert'); 
define('_EZCOMMENTS_NOTREG',                'nicht registriert'); 
define('_EZCOMMENTS_STATUS',                'Status'); 
define('_EZCOMMENTS_OFFLINE',               'Offline'); 
define('_EZCOMMENTS_ONLINE',                'Online'); 
define('_EZCOMMENTS_PROFILE',               'Profil'); 
define('_EZCOMMENTS_SEND_PM',               'PM senden'); 
define('_EZCOMMENTS_FROM',                  'Wohnort'); 
define('_EZCOMMENTS_SUBJECT',               'Titel');
define('_EZCOMMENTS_TOP',                   'Top');
define('_EZCOMMENTS_BOTTOM',                'Bottom');
define('_EZCOMMENTS_COMMENTSOFAR',          'Kommentare derzeit');
define('_EZCOMMENTS_WROTEON',               'geschrieben am');
define('_EZCOMMENTS_AT',                    'um');
define('_EZCOMMENTS_LEAVEACOMMENT',         'Sie haben die M�glichkeit, einen Kommentar abzugeben');
define('_EZCOMMENTS_COMMENT_FROM',          'von');
define('_EZCOMMENTS_COMMENT_ON',            'am');

// comment form
define('_EZCOMMENTS_ANONNAME',              'Name');
define('_EZCOMMENTS_ANONMAIL',              'E-mail Adresse');
define('_EZCOMMENTS_ANONWEBSITE',           'Webseite'); 
define('_EZCOMMENTS_AUTHOR',                'Autor');
define('_EZCOMMENTS_COMMENT',               'Kommentar');

// navigation bar
define('_EZCOMMENTS_DISPLAY',               'Darstellung');
define('_EZCOMMENTS_FLAT',                  'Flach');
define('_EZCOMMENTS_NEWESTFIRST',           'aufsteigend');
define('_EZCOMMENTS_OLDESTFIRST',           'absteigend');
define('_EZCOMMENTS_ORDER',                 'Reihenfolge');
define('_EZCOMMENTS_THREADED',              'Kommentarbaum');

// search plugin
define('_EZCOMMENTS_SEARCH',                'Durchsuche Kommentare');
define('_EZCOMMENTS_NOCOMMENTSFOUND',       'Keine passenden Kommentare gefunden');

// comment moderation
define('_EZCOMMENTS_MODERERATE',            'Aktiviere Moderation der Kommentare');
define('_EZCOMMENTS_MODLINKCOUNT',          'H�chstanzahl an Links, bevor freigeschaltet werden muss');
define('_EZCOMMENTS_MODLIST',               'W�rter, die automatisch Moderation erfordern');
define('_EZCOMMENTS_BLACKLINKCOUNT',        'Anzahl der Links im Kommentar bis zum Blacklisting');
define('_EZCOMMENTS_BLACKLIST',             'W�rter die zur L�schung f�hren');
define('_EZCOMMENTS_BLACKLISTNOTE',         'Achtung: Kommentare, die diese W�rter enthalten, werden nicht zugelassen');
define('_EZCOMMENTS_SEPERATELINE',          'Ein Stichwort pro Zeile');
define('_EZCOMMENTS_SENDINFOMAILMOD',       'Mail bei Kommentaren verschicken, die eine Moderation erfordern');
define('_EZCOMMENTS_MODMAILSUBJECT',        'Neuer Kommentar');
define('_EZCOMMENTS_MODMAILBODY',           'Ein neuer Kommentar wurde erstellt und erfordert Moderation.');
define('_EZCOMMENTS_ALWAYSMODERERATE',      'Nur moderierte Kommentare freigeben');
define('_EZCOMMENTS_HELDFORMODERATION',     'Der Kommentar wird so bald wie m�glich freigeschaltet. Vielen Dank');
define('_EZCOMMENTS_COMMENTBLACKLISTED',    'Der Kommentar wurde aufgrund inhaltlicher M�ngel nicht freigeschaltet');
define('_EZCOMMENTS_PROXYBLACKLIST',        'Kommentare, die �ber unsichere Proxies abgegeben werden, ablehnen');
define('_EZCOMMENTS_DONTMODERATEIFCOMMENTED', 'Benutzer, die bereits Kommentare abgegeben haben, nicht moderieren');
define('_EZCOMMENTS_MODERATIONON',            '<strong>Bitte beachten:</strong> Die Moderation ist eingeschaltet, deshalb erscheint der Kommentar nicht sofort. Dies ist kein Grund, den Kommentar ein weiteres Mal einzureichen.');
define('_EZCOMMENTS_APPLYMODRULES',           'Moderationsregeln anwenden');
define('_EZCOMMENTS_APPLYMODRULESINTRO',      'Hier k�nnen Sie die vordefinierten Moderationsregeln auf alle Kommentare neu anwenden. Wurden die Moderationsregeln ver�ndert, werden erneut alle existierenden Kommentare einzeln �berpr�ft.');
define('_EZCOMMENTS_APPLYMODRULESALL',        'Moderationsregeln auf alle Kommentare anwenden');
define('_EZCOMMENTS_APPLYMODRULESSTATUS',     'Moderationsregeln auf Kommentare mit folgenden Status anwenden:');
define('_EZCOMMENTS_TOBEREJECTED',            'Die folgenden Kommentare werden abgelehnt');
define('_EZCOMMENTS_TOBEMODERATED',           'Die folgenden Kommentare erfordern eine Moderation');
define('_EZCOMMENTS_APPLYNEWRULES',           'Neue Kommentarregeln anwenden');

// comment statuses
define('_EZCOMMENTS_APPROVED',              'freigeschaltet');
define('_EZCOMMENTS_PENDING',               'wartend');
define('_EZCOMMENTS_REJECTED',              'abgelehnt');
define('_EZCOMMENTS_SPAM',                  'Spam');

// modifyconfig fieldsets
define('_EZCOMMENTS_MISCSETTINGS',          'Einstellungen');
define('_EZCOMMENTS_MODERATIONSETTINGS',    'Moderation');
define('_EZCOMMENTS_NOTIFICATIONSETTINGS',  'Benachrichtigungen');

// comment purging options
define('_EZCOMMENTS_PURGE',                 'Kommentare entfernen');
define('_EZCOMMENTS_PURGEPENDING',          'Alle noch nicht freigegebenen Kommentare entfernen');
define('_EZCOMMENTS_PURGEREJECTED',         'Alle zur�ckgewiesenen Kommentare entfernen');

// Block
define('_EZCOMMENTS_NUMENTRIES',            'Anzahl der anzuzeigenden Kommentare');
define('_EZCOMMENTS_SHOWUSERNAME',          'Benutzernamen anzeigen?');
define('_EZCOMMENTS_LINKUSERNAME',          'Benutzername mit Link zum Profil versehen?');
define('_EZCOMMENTS_SHOWDATE',              'Datum des Kommentars anzeigen?');
define('_EZCOMMENTS_SHOWPENDING',           'Noch nicht freigeschaltete Kommentare anzeigen?');
define('_EZCOMMENTS_SELECT_MODULE',         'Kommentare f�r das folgende Modul anzeigen');
define('_EZCOMMENTS_ALLMODULES',            'Alle');

// ip address logging
define('_EZCOMMENTS_IPADDR',                'IP-Adressen');
define('_EZCOMMENTS_LOGIPADDR',             'IP-Adressen protokollieren');
define('_EZCOMMENTS_IPADDRNOTLOGGED',       'IP-Adressen nicht protokolliert');

// multiple comment processing
define('_EZCOMMENTSWITHSELECTED',            'Die ausgew�hlten Kommentare');
define('_EZCOMMENTS_APPROVE',                'freischalten');
define('_EZCOMMENTS_REJECT',                 'ablehnen');
define('_EZCOMMENTS_HOLD',                   'auf "wartend" setzen');

// comment stats
define('_EZCOMMENTS_STATS',                  'Statistiken');
define('_EZCOMMENTS_TOTAL',                  'Gesamtanzahl');
define('_EZCOMMENTS_ITEM',                   'Element-ID');
define('_EZCOMMENTS_CONFIRMDELETEMODULE',    'Die L�schung aller zum Modul %m% geh�rigen Kommentaren best�tigen');
define('_EZCOMMENTS_CANCELDELETEMODULE',     'Die L�schung aller zum Modul %m% geh�rigen Kommentaren abbrechen');
define('_EZCOMMENTS_CONFIRMDELETEITEM',      'Die L�schung aller zum Modul %m%, Element %o% geh�rigen Kommentaren best�tigen');
define('_EZCOMMENTS_CANCELDELETEITEM',       'Die L�schung aller zum Modul %m%, Element %o% geh�rigen Kommentaren abbrechen');

// comment typing
define('_EZCOMMENTS_TYPE',                    'Kommentartyp');

// comment feeds
define('_EZCOMMENTS_FEEDS',	                  'Feeds');
define('_EZCOMMENTS_FEEDTYPE',                'Art des Feeds');
define('_EZCOMMENTS_FEEDCOUNT',               'Anzahl der Kommentare im Feed');
define('_EZCOMMENTS_ATOM',                    'Atom 0.3');
define('_EZCOMMENTS_RSS',                     'RSS 2.0');
define('_EZCOMMENTS_FEEDNOTE',                'Hinweis: Sowohl der Typ des Feeds als auch die Anzahl der angezeigten Kommentare k�nnen �berschrieben werden, indem die Parameter feedtype und feedcount an die URL des Feeds angeh�ngt werden.');

// pager defines
define('_EZCOMMENTS_ENABLEPAGER',             'Paginierung einschalten (Benutzersicht)');
define('_EZCOMMENTS_COMMENTSPERPAGE',         'Kommentare pro Seite (Benutzersicht)');

// status filter
define('_EZCOMMENTS_FILTERBYSTATUS',          'Filtern nach Status :');
define('_EZCOMMENTS_SHOWALL',                 'Alle Kommentare anzeigen');

// askismet
define('_EZCOMMENTS_AKISMET',                 'Akismet Spamerkennungsdienst');
define('_EZCOMMENTS_AKISMETNOTE',             '<a href="http://akismet.com/">Akismet</a> ist ein Spamerkennungsdienst, der in vielen F�llen Spam in Kommentaren, Trackback, etc. elimieren kann. Das Modul muss installiert und konfiguriert werden. <a href="http://code.zikula.org/ezcomments/">Download Akismet</a>');
define('_EZCOMMENTS_ENABLEAKISMET',           'Akismet aktivieren');
define('_EZCOMMENTS_AKISMETSTATUS',           'Welchen Status sollen die von Akismet identifizierten Spams annehmen?');

// username requried for guest comments
define('_EZCOMMENTS_ANON_NAME',               'Absendername f�r anonyme User notwendig');
define('_EZCOMMENTS_ANON_NAME_FORM',          '(notwendig f�r unregistrierte Besucher)');
define('_EZCOMMENTS_ANON_NAME_REJECT',        'Fehler! Das Namensfeld ist notwendig. Kommentar abgelehnt');






