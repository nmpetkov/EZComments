<?php
// $Id: global.php 427 2007-08-02 10:34:04Z markwest $
// ----------------------------------------------------------------------
// EZComments
// Attach comments to any module calling hooks
// ----------------------------------------------------------------------
// Author: J�rg Napp
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

define('_EZCOMMENTS',                         'Commentaires');
define('_EZCOMMENTS_NOAUTH',                  'Pas d\'acc�s aux commentaires.');
define('_EZCOMMENTS_ONLYREG',                 'Seuls les utilisateurs enregistr�s peuvent ajouter un commentaire.');
define('_EZCOMMENTS_GOTOREG',                 'S\'enregister/S\'identifier');
define('_EZCOMMENTS_ADD',                     'Ajouter');
define('_EZCOMMENTS_DEL',                     'Effacer ce commentaire');
define('_EZCOMMENTS_COMMENT_ADD',             'Ajouter un nouveau commentaire');
define('_EZCOMMENTS_COMMENT_ANSWER',          'R�pondre');
define('_EZCOMMENTS_COMMENT_FROM',            'par');
define('_EZCOMMENTS_COMMENT_ON',              'le');
define('_EZCOMMENTS_CREATED',                 'Commentaire ajout�');
define('_EZCOMMENTS_DELETED',                 'Commentaire effac�');
define('_EZCOMMENTS_FAILED',                  'Erreur interne');
define('_EZCOMMENTS_NODIRECTACCESS',          'Pas d\'acc�s direct � ce module');
define('_EZCOMMENTS_RULES',                   'D�finissez les r�gles pour vos commentaires ici');

define('_EZCOMMENTS_ADMIN',                   'Administration EZComments');
define('_EZCOMMENTS_ADMIN_MAIN',              'Administration principale');
define('_EZCOMMENTS_SENDINFOMAIL',            'envoyer un mail en cas de nouveau commentaire');
define('_EZCOMMENTS_OK',                      'Accepter');
define('_EZCOMMENTS_LASTCOMMENTS',            'Les %c% derniers commentaires');
define('_EZCOMMENTS_USERNAME',                'Utilisateur');
define('_EZCOMMENTS_MODULE',                  'Module');
define('_EZCOMMENTS_TEMPLATE',                'Template par d�faut');

define('_EZCOMMENTS_CLEANUP_NOTHINGTODO',     'Pas de commentaire orphelin');
define('_EZCOMMENTS_CLEANUP_GOBACK',          'Retour');
define('_EZCOMMENTS_CLEANUP_EXPLAIN',         'Cette fonctionnalit� vous permet de supprimer les commentaires qui sont dans la base de donn�es pour les modules enlev�s.');
define('_EZCOMMENTS_CLEANUP_LABEL',           'S�lectionner le module :');
define('_EZCOMMENTS_CLEANUP_GO',              'Effacer tous les commentaires pour ce module');
define('_EZCOMMENTS_CLEANUP',                 'Effacer les commentaires orphelins');

define('_EZCOMMENTS_MIGRATE_EXPLAIN',         'Importer les commentaires � partir d\'autres modules');
define('_EZCOMMENTS_MIGRATE_NOTHINGTODO',     'Pas de plugin de migration disponible');
define('_EZCOMMENTS_MIGRATE_GOBACK',          'Retour');
define('_EZCOMMENTS_MIGRATE_LABEL',           'Migrer :');
define('_EZCOMMENTS_MIGRATE_GO',              'D�marrer la migration');
define('_EZCOMMENTS_MIGRATE',                 'Migrer les Commentaires');

define('_EZCOMMENTS_FAILED1',                 'Erreur lors de la cr�ation d\'une table');
define('_EZCOMMENTS_FAILED2',                 'Erreur lors de la cr�ation d\'un hook');
define('_EZCOMMENTS_FAILED3',                 'Erreur lors de la suppression d\'une table');
define('_EZCOMMENTS_FAILED4',                 'Erreur lors de la suppression d\'un hook');
define('_EZCOMMENTS_FAILED5',                 'La mise � jour d\'une table a �chou�');

define('_EZCOMMENTS_MAILSUBJECT',             'Un nouveau commentaire a �t� entr�');
define('_EZCOMMENTS_MAILBODY',                'Un nouveau commentaire a �t� entr�');

define('_EZCOMMENTS_POSTED',                  'post�');
define('_EZCOMMENTS_REG_SINCE',               'enregistr�');
define('_EZCOMMENTS_NOTREG',                  'pas enregistr�');
define('_EZCOMMENTS_STATUS',                  'Status');
define('_EZCOMMENTS_OFFLINE',                 'd�connect�');
define('_EZCOMMENTS_ONLINE',                  'en ligne');
define('_EZCOMMENTS_PROFILE',                 'Profil');
define('_EZCOMMENTS_SEND_PM',                 'Envoi MP');
define('_EZCOMMENTS_FROM',                    'Location');
define('_EZCOMMENTS_SUBJECT',                 'Sujet');

define('_EZCOMMENTS_EDIT',                    'Modifier le commentaire');
define('_EZCOMMENTS_ITEMSPERPAGE',            'Nombre de commentaires par page');

define('_EZCOMMENTS_AUTHOR',                  'Auteur');
define('_EZCOMMENTS_COMMENT',                 'Commentaire');

// navigation bar
define('_EZCOMMENTS_DISPLAY',                 'Affichage');
define('_EZCOMMENTS_FLAT',                    'A plat');
define('_EZCOMMENTS_NEWESTFIRST',             'Les plus r�cents d\'abord');
define('_EZCOMMENTS_OLDESTFIRST',             'Les plus anciens d\'abord');
define('_EZCOMMENTS_ORDER',                   'Ordre');
define('_EZCOMMENTS_THREADED',                'Par discussions');

define('_EZCOMMENTS_ALLOWANONUSERSETINFO',    'Permettre aux invit�s de laisser des informations personnelles');
define('_EZCOMMENTS_ANONNAME',                'Nom');
define('_EZCOMMENTS_ANONMAIL',                'Addresse E-mail');
define('_EZCOMMENTS_ANONWEBSITE',             'Site Internet');

define('_EZCOMMENTS_SEARCH',                  'Chercher dans les commentaires');
define('_EZCOMMENTS_NOCOMMENTSFOUND',         'Aucun commentaire ne correspond � votre recherche');

define('_EZCOMMENTS_TOP',                     'D�but');
define('_EZCOMMENTS_BOTTOM',                  'Fin');

// comment moderation
define('_EZCOMMENTS_MODERERATE',              'Activer la mod�ration des commentaires');
define('_EZCOMMENTS_MODLINKCOUNT',            'Nombre de liens dans un commentaire pour provoquer la mod�ration');
define('_EZCOMMENTS_MODLIST',                 'Mots-cl�s provoquant la mod�ration');
define('_EZCOMMENTS_BLACKLIST',               'Mots-cl�s interdits dans les commentaires');
define('_EZCOMMENTS_BLACKLISTNOTE',           'Note: Les commentaires contenant des mots-cl�s de cette liste seront compl�tement ignor�s');
define('_EZCOMMENTS_SEPERATELINE',            'S�parez les mots par des retour � la ligne');
define('_EZCOMMENTS_SENDINFOMAILMOD',         'Envoi par email des commentaires n�cessitant la mod�ration');
define('_EZCOMMENTS_MODMAILSUBJECT',          'Nouveau commentaire sur votre site.');
define('_EZCOMMENTS_MODMAILBODY',             'Un nouveau commentaire n�cessitant une mod�ration a �t� inscrit sur votre site.');
define('_EZCOMMENTS_ALWAYSMODERERATE',        'Mod�rer tous les commentaires');
define('_EZCOMMENTS_HELDFORMODERATION',       'Votre commentaire est en attente de mod�ration et sera examin� prochainement');
define('_EZCOMMENTS_COMMENTBLACKLISTED',      'Votre commentaire a un contenu inacceptable et a �t� rejet�');
define('_EZCOMMENTS_PROXYBLACKLIST',          'Blacklist comments from insecure proxies');
define('_EZCOMMENTS_DONTMODERATEIFCOMMENTED', 'Ne pas mod�rer les commentaires des utilisateurs ayant d�j� comment�');
define('_EZCOMMENTS_MODERATIONON',            '<strong>Notez bien :</strong> La mod�ration des commentaires est activ�e ce qui peut retarder l\'apparition de votre commentaire. Vous n\'avez aucun besoin de soumettre � nouveau votre commentaire.');

// comment statuses
define('_EZCOMMENTS_APPROVED',                'Approuv�');
define('_EZCOMMENTS_PENDING',                 'En attente');
define('_EZCOMMENTS_REJECTED',                'Rejet�');

// modifyconfig fieldsets
define('_EZCOMMENTS_MISCSETTINGS',            'Divers');
define('_EZCOMMENTS_MODERATIONSETTINGS',      'Mod�ration');
define('_EZCOMMENTS_NOTIFICATIONSETTINGS',    'Notification');

// mails
define('_EZCOMMENTS_SHOW',                    'Afficher');
define('_EZCOMMENTS_MODERATE2',               'Mod�rer');
define('_EZCOMMENTS_DELETE',                  'Supprimer');

// comment purging options
define('_EZCOMMENTS_PURGE',                   'Supprimer les commentaires');
define('_EZCOMMENTS_PURGEPENDING',            'Supprimer les commentaires en attente');
define('_EZCOMMENTS_PURGEREJECTED',           'Supprimer les commentaires rejet�s');

// Block
define('_EZCOMMENTS_BLOCKNUMITEMS',           'Nombre de commentaires � afficher :');
define('_EZCOMMENTS_BLOCKSHOWUNAME',          'Afficher le nom des utilisateurs ?');
define('_EZCOMMENTS_BLOCKLNKTOPROFILE',       'Lien avec le profil des utilisateurs ?');
define('_EZCOMMENTS_BLOCKSHOWDATE',           'Afficher la date ?');
define('_EZCOMMENTS_SELECT_MODULE',           'Afficher les commentaires des modules suivants');
define('_EZCOMMENTS_ALLMODULES',              'Tous');

// ip address logging
define('_EZCOMMENTS_IPADDR',                  'Adresse IP');
define('_EZCOMMENTS_LOGIPADDR',               'Enregistrer l\'adresse IP');
define('_EZCOMMENTS_IPADDRNOTLOGGED',         'Adresses IP non-enregistr�es');

// multiple comment processing
define('_EZCOMMENTSWITHSELECTED',             'Commentaires s�lectionn�s : ');
define('_EZCOMMENTS_APPROVE',                 'Approuver');
define('_EZCOMMENTS_REJECT',                  'Rejeter');
define('_EZCOMMENTS_HOLD',                    'En Attente');

// comment stats
define('_EZCOMMENTS_STATS',                   'Statistiques');
define('_EZCOMMENTS_TOTAL',                   'Total de commentaires');
define('_EZCOMMENTS_ITEM',                    'ID El�ment');
define('_EZCOMMENTS_CONFIRMDELETEMODULE',     'Confirmez la suppression de tous les commentaires li�s au module \'%m%\'');
define('_EZCOMMENTS_CANCELDELETEMODULE',      'Annuler la suppression de tous les commentaires li�s au modules \'%m%\'');
define('_EZCOMMENTS_CONFIRMDELETEITEM',       'Confirmez la suppression de tous les commentaires de l\'objet \'%o%\' li�s au module \'%m%\'');
define('_EZCOMMENTS_CANCELDELETEITEM',        'Annuler la suppression de tous les commentaires de l\'objet \'%o%\' li�s au module \'%m%\'');

// comment typing
define('_EZCOMMENTS_TYPE',                    'Type de Commentaire');

// comment feeds
define('_EZCOMMENTS_FEEDS',                   'Syndication RSS');
define('_EZCOMMENTS_FEEDTYPE',                'Type de syndication RSS');
define('_EZCOMMENTS_FEEDCOUNT',               'Nombre d\'�l�ments � afficher dans les fils RSS');
define('_EZCOMMENTS_ATOM',                    'Atom 0.3');
define('_EZCOMMENTS_RSS',                     'RSS 2.0');
define('_EZCOMMENTS_FEEDNOTE',                'Note : Le type de fil RSS ainsi que le nombre d\'�lements affich�s peuvent �tre forc�s en les appliquant les param�tres feedcount et feedtype � l\'adresse URL');

// some other users phrases in comment templates
define('_EZCOMMENTS_COMMENTSOFAR',            'Commentaires jusqu\'� maintenant');
define('_EZCOMMENTS_WROTEON',                 'a �crit sur');
define('_EZCOMMENTS_AT',                      '�');
define('_EZCOMMENTS_LEAVEACOMMENT',           'Laissez un commentaire');

// pager defines
define('_EZCOMMENTS_ENABLEPAGER',             'Activer la pagination (Vue utilisateur)');
define('_EZCOMMENTS_COMMENTSPERPAGE',         'Commentaires par page (Vue utilisateu)');

