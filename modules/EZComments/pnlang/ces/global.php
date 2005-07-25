<?php 
// $Id$
// ----------------------------------------------------------------------
// EZComments
// Attach comments to any module calling hooks
// ----------------------------------------------------------------------
// Translated by David Mach, watchingeye@users.sourceforge.net
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

define('_EZCOMMENTS',                       'Koment��e');
define('_EZCOMMENTS_NOAUTH',                'Nem�te p��stup ke koment���m.');
define('_EZCOMMENTS_ONLYREG',               'Pouze p�ihl�en� u�ivatel� mohou komentovat.');
define('_EZCOMMENTS_GOTOREG',               'Registrovat/P�ihl�sit');
define('_EZCOMMENTS_ADD',                   'P�idat');
define('_EZCOMMENTS_DEL',                   'Smazat koment��');
define('_EZCOMMENTS_COMMENT_ADD',           'P�idat nov� koment��');
define('_EZCOMMENTS_COMMENT_ANSWER'         'Odpov��');
define('_EZCOMMENTS_COMMENT_FROM',          'od');
define('_EZCOMMENTS_COMMENT_ON',            'pro');
define('_EZCOMMENTS_CREATED',               'Koment�� byl p�id�n');
define('_EZCOMMENTS_DELETED',               'Koment�� byl smaz�n');
define('_EZCOMMENTS_FAILED',                'Intern� chyba');
define('_EZCOMMENTS_NODIRECTACCESS',        'K tomuto modulu nelze p�istupovat p��mo');
define('_EZCOMMENTS_RULES',                 'Definujte pravidla pro va�e koment��e');

define('_EZCOMMENTS_ADMIN',                 'Administrace EZComments');
define('_EZCOMMENTS_ADMIN_MAIN',            'Hlavn� administrace EZComments');
define('_EZCOMMENTS_SENDINFOMAIL',          'Odeslat mail p�i ka�d�m nov�m koment��i');
define('_EZCOMMENTS_OK',                    'Ulo�it');
define('_EZCOMMENTS_LASTCOMMENTS',          'Posledn� koment��e');
define('_EZCOMMENTS_USERNAME',              'U�ivatel');
define('_EZCOMMENTS_MODULE',                'Modul');
define('_EZCOMMENTS_TEMPLATE',              'Default template');
define('_EZCOMMENTS_DELETESELECTED',        'Delete selected comments');

define('_EZCOMMENTS_CLEANUP_NOTHINGTODO',   'Nejsou ��dn� osi�el� koment��e');
define('_EZCOMMENTS_CLEANUP_GOBACK',        'Zp�t');
define('_EZCOMMENTS_CLEANUP_EXPLAIN',       'Zde m��ete smazat v�echny koment��e, kter� v datab�zi osi�ely po odstran�n�ch modulech.');
define('_EZCOMMENTS_CLEANUP_LABEL',         'Vyberte modul:');
define('_EZCOMMENTS_CLEANUP_GO',            'Smazat v�echny koment��i k tomuto modulu');
define('_EZCOMMENTS_CLEANUP',               'Smazat osi�el� koment��e');

define('_EZCOMMENTS_MIGRATE_EXPLAIN',       'Import koment��� z jin�ch modul�');
define('_EZCOMMENTS_MIGRATE_NOTHINGTODO',   'Plugin pro migraci nen� k dispozici');
define('_EZCOMMENTS_MIGRATE_GOBACK',        'Zp�t');
define('_EZCOMMENTS_MIGRATE_LABEL',         'Migrovat z:');
define('_EZCOMMENTS_MIGRATE_GO',            'Zah�jit migraci');
define('_EZCOMMENTS_MIGRATE',               'Migrovat koment��e');

define('_EZCOMMENTS_FAILED1',               'Chyba p�i vytv��en� tabulky');
define('_EZCOMMENTS_FAILED2',               'Chyba p�i vytv��en� hook');
define('_EZCOMMENTS_FAILED3',               'Chyba p�i maz�n� tabulky');
define('_EZCOMMENTS_FAILED4',               'Chyba p�i maz�n� hook');
define('_EZCOMMENTS_FAILED5',               'Aktualizace tabulky selhala');

define('_EZCOMMENTS_MAILSUBJECT',           'Byl p�id�n nov� koment��'); 
define('_EZCOMMENTS_MAILBODY',              'Byl p�id�n nov� koment��'); 

define('_EZCOMMENTS_POSTED',                'posted'); 
define('_EZCOMMENTS_REG_SINCE',             'registered'); 
define('_EZCOMMENTS_NOTREG',                'not registered'); 
define('_EZCOMMENTS_STATUS',                'Status'); 
define('_EZCOMMENTS_OFFLINE',  			    'Offline'); 
define('_EZCOMMENTS_ONLINE',  			    'Online'); 
define('_EZCOMMENTS_PROFILE',  			    'Profile'); 
define('_EZCOMMENTS_SEND_PM',  			    'send PM'); 
define('_EZCOMMENTS_FROM',  			    'Location'); 
define('_EZCOMMENTS_SUBJECT',               'Subject');

define('_EZCOMMENTS_EDIT',                  'Edit Comment');
define('_EZCOMMENTS_ITEMSPERPAGE',          'Items per page');

define('_EZCOMMENTS_AUTHOR',                'Author');
define('_EZCOMMENTS_COMMENT',               'Comment');

// navigation bar
define('_EZCOMMENTS_DISPLAY',               'Display');
define('_EZCOMMENTS_FLAT',                  'Flat');
define('_EZCOMMENTS_NEWESTFIRST',           'Newest First');
define('_EZCOMMENTS_OLDESTFIRST',           'Oldest First');
define('_EZCOMMENTS_ORDER',                 'Order');
define('_EZCOMMENTS_THREADED',              'Threaded');

define('_EZCOMMENTS_ALLOWANONUSERSETINFO',  'Allow unregistered users to set user information');
define('_EZCOMMENTS_ANONNAME',              'Name');
define('_EZCOMMENTS_ANONMAIL',              'E-mail address'); 

define('_EZCOMMENTS_SEARCH',                'Search comments');
define('_EZCOMMENTS_NOCOMMENTSFOUND',       'No comments matched your search');

define('_EZCOMMENTS_TOP',                   'Top');
define('_EZCOMMENTS_BOTTOM',                'Bottom');

// comment moderation
define('_EZCOMMENTS_MODERERATE',            'Enable comment moderation');
define('_EZCOMMENTS_MODLINKCOUNT',          'Number of links in comment before moderation');
define('_EZCOMMENTS_MODLIST',               'Words to trigger moderation');
define('_EZCOMMENTS_BLACKLIST',             'Words to blacklist from comments');
define('_EZCOMMENTS_BLACKLISTNOTE',         'Note: Comments containing words list here will completely ignored by comments module');
define('_EZCOMMENTS_SEPERATELINE',          'Separate multiple words with new lines');
define('_EZCOMMENTS_SENDINFOMAILMOD',       'Send mail comments requiring moderation');
define('_EZCOMMENTS_MODMAILSUBJECT',        'New comment for your site');
define('_EZCOMMENTS_MODMAILBODY',           'A new comment was submitted to your site that requires moderation');
define('_EZCOMMENTS_ALWAYSMODERERATE',      'All comments require moderation');
define('_EZCOMMENTS_HELDFORMODERATION',     'Your comment was held for moderation and will be reviewed shortly');
define('_EZCOMMENTS_COMMENTBLACKLISTED',    'Your comment contains unacceptable content and has been rejected');
define('_EZCOMMENTS_PROXYBLACKLIST',        'Blacklist comments from insecure proxies');

// comment statuses
define('_EZCOMMENTS_APPROVED',              'Approved');
define('_EZCOMMENTS_PENDING',               'Pending');
define('_EZCOMMENTS_REJECTED',              'Rejected');

// modifyconfig fieldsets
define('_EZCOMMENTS_MISCSETTINGS',          'Miscellaneous');
define('_EZCOMMENTS_MODERATIONSETTINGS',    'Moderation');
define('_EZCOMMENTS_NOTIFICATIONSETTINGS',  'Notification');

// mails
define('_EZCOMMENTS_SHOW',                  'Show');
define('_EZCOMMENTS_MODERATE2',             'Moderate');
define('_EZCOMMENTS_DELETE',                'Delete');

// comment purging options
define('_EZCOMMENTS_PURGE',                 'Purge comments');
define('_EZCOMMENTS_PURGEPENDING',          'Purge all pending comments');
define('_EZCOMMENTS_PURGEREJECTED',         'Purge all rejected comments');

// Block
define('_EZCOMMENTS_NUMENTRIES',            'Number of comments to display');
define('_EZCOMMENTS_SHOWUSERNAME',          'Show username?');
define('_EZCOMMENTS_LINKUSERNAME',          'Link username to profile?');
define('_EZCOMMENTS_SHOWDATE',              'Show Date?');
define('_EZCOMMENTS_SELECT_MODULE',         'Show comments for the following module');
define('_EZCOMMENTS_ALLMODULES',            'All');

?>
