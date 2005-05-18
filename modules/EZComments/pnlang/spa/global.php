<?php
// $Id$
// ----------------------------------------------------------------------
// EZComments
// Attach comments to any module calling hooks
// ----------------------------------------------------------------------
// Author: J�rg Napp, http://postnuke.lottasophie.de
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

define('_EZCOMMENTS',                       'Comentarios');
define('_EZCOMMENTS_NOAUTH',                'No tienes acceso a los comentarios.');
define('_EZCOMMENTS_ONLYREG',               'S�lo los usuarios con sesi�n iniciada pueden comentar.');
define('_EZCOMMENTS_GOTOREG',               'registrarse/iniciar sesi�n');
define('_EZCOMMENTS_ADD',                   'Agregar');
define('_EZCOMMENTS_DEL',                   'Borrar este comentario');
define('_EZCOMMENTS_COMMENT_ADD',           'Agregar un nuevo comentario');
define('_EZCOMMENTS_COMMENT_ANSWER',        'Respuesta');
define('_EZCOMMENTS_COMMENT_FROM',          'por');
define('_EZCOMMENTS_COMMENT_ON',            'en');
define('_EZCCOMMENTSCREATED',               'Comentario agregado');
define('_EZCCOMMENTSDELETED',               'Comentario borrado');
define('_EZCOMMENTS_FAILED',                'Error Interno');
define('_EZCOMMENTS_NODIRECTACCESS',        'No hay acceso directo a este m�dulo');
define('_EZCOMMENTS_RULES',                 'Define las reglas para tus comentarios aqu�');

define('_EZCOMMENTS_ADMIN',                 'Administraci�n de EZComments');
define('_EZCOMMENTS_ADMIN_MAIN',            'Administraci�n Principal de EZComments');
define('_EZCOMMENTS_SENDINFOMAIL',          'Enviar correo cuando haya un comentario nuevo');
define('_EZCOMMENTS_OK',                    'Aceptar');
define('_EZCOMMENTS_LASTCOMMENTS',          'Los �ltimos comentarios');
define('_EZCOMMENTS_USERNAME',              'Usuario');
define('_EZCOMMENTS_MODULE',                'M�dulo');
define('_EZCOMMENTS_TEMPLATE',              'Plantilla predeterminada');

define('_EZCOMMENTS_CLEANUP_NOTHINGTODO', 'No hay comentarios hu�rfanos');
define('_EZCOMMENTS_CLEANUP_GOBACK',      'Regresar');
define('_EZCOMMENTS_CLEANUP_EXPLAIN',     'Esta funcionalidad te permite borrar comentarios que est�n en la base de datos para m�dulos removidos.');
define('_EZCOMMENTS_CLEANUP_LABEL',       'Seleccionar m�dulo:');
define('_EZCOMMENTS_CLEANUP_GO',          'Borrar todos los comentarios de este m�dulo');
define('_EZCOMMENTS_CLEANUP',             'Borrar comentarios hu�rfanos');

define('_EZCOMMENTS_MIGRATE_EXPLAIN',     'Importar comentarios de otros m�dulos');
define('_EZCOMMENTS_MIGRATE_NOTHINGTODO', 'No hay plugins de migraci�n disponibles');
define('_EZCOMMENTS_MIGRATE_GOBACK',      'Regresar');
define('_EZCOMMENTS_MIGRATE_LABEL',       'Migrar:');
define('_EZCOMMENTS_MIGRATE_GO',          'Iniciar migraci�n');
define('_EZCOMMENTS_MIGRATE',             'Migrar Comentarios');

define('_EZCOMMENTS_FAILED1',             'Error creando tabla');
define('_EZCOMMENTS_FAILED2',             'Error creando hook');
define('_EZCOMMENTS_FAILED3',             'Error borrando tabla');
define('_EZCOMMENTS_FAILED4',             'Error borrando hook');
define('_EZCOMMENTS_FAILED5',             'Fall� la actualizaci�n de la Tabla');

define('_EZCOMMENTS_MAILSUBJECT',         'Se recibi� un nuevo comentario');
define('_EZCOMMENTS_MAILBODY',            'Se recibi� un nuevo comentario');

// Steffen 01/2005
define('_EZCOMMENTS_POSTED',              'escrito');
define('_EZCOMMENTS_REG_SINCE',           'registrado');
define('_EZCOMMENTS_STATUS',              'Estado');
define('_EZCOMMENTS_OFFLINE',             'Desconectado');
define('_EZCOMMENTS_ONLINE',              'Conectado');
define('_EZCOMMENTS_PROFILE',             'Perfil');
define('_EZCOMMENTS_SEND_PM',             'enviar MP');
define('_EZCOMMENTS_FROM',                'Localizaci�n');

define('_EZCOMMENTS_SUBJECT',           'Asunto');
define('_EZCOMMENTS_EDIT',              'Editar Comentario');
define('_EZCOMMENTS_DELETE',            'Borrar Comentario');
define('_EZCOMMENTS_ITEMSPERPAGE',      'Art�culos por p�gina');

define('_EZCOMMENTS_AUTHOR',            'Autor');
define('_EZCOMMENTS_COMMENT',           'Comentario');

// navigation bar
define('_EZCOMMENTS_DISPLAY',            'Mostrar');
define('_EZCOMMENTS_FLAT',               'Plano');
define('_EZCOMMENTS_NEWESTFIRST',        'Los m�s nuevos primero');
define('_EZCOMMENTS_OLDESTFIRST',        'Los m�s viejos primero');
define('_EZCOMMENTS_ORDER',              'Orden');
define('_EZCOMMENTS_THREADED',           'Por hilos');

define('_EZCOMMENTS_ALLOWANONUSERSETINFO', 'Permitir usuarios no registrados especificar informaci�n de usuario');
define('_EZCOMMENTS_ANONNAME',             'Nombre');
define('_EZCOMMENTS_ANONMAIL',             'Direcci�n de correo electr�nico');

define('_EZCOMMENTS_SEARCH',               'Buscar comentarios');
define('_EZCOMMENTS_NOCOMMENTSFOUND',      'Ning�n comentario concuerda con tu b�squeda');

define('_EZCOMMENTS_TOP',                  'Arriba');
define('_EZCOMMENTS_BOTTOM',               'Abajo');

// comment moderation
define('_EZCOMMENTS_MODERERATE',           'Habilitar comentarios moderados');
define('_EZCOMMENTS_MODLINKCOUNT',         'N�mero de enlaces en el comentario antes de moderar');
define('_EZCOMMENTS_MODLIST',              'Palabras para activar la moderaci�n');
define('_EZCOMMENTS_BLACKLIST',            'Palabras no permitidas en comentarios');
define('_EZCOMMENTS_BLACKLISTNOTE',        'Nota: Los comentarios que contengan palabras listadas aqu� ser�n ignorados or completo del m�dulo de comentarios');
define('_EZCOMMENTS_SEPERATELINE',         'Separar m�ltiples palabras con nuevas l�neas');
define('_EZCOMMENTS_SENDINFOMAILMOD',      'Enviar comentarios que requieran ser moderados');
define('_EZCOMMENTS_MODMAILSUBJECT',       'Nuevo comentario para tu sitio');
define('_EZCOMMENTS_MODMAILBODY',          'Se envi� un nuevo comentario a tu sitio que requiere ser moderado');
define('_EZCOMMENTS_ALWAYSMODERERATE',     'Todos los comentarios requieren ser moderados');
define('_EZCOMMENTS_HELDFORMODERATION',    'Tu comentario se ha retenido par ser moderado y ser� revisado pronto');
define('_EZCOMMENTS_COMMENTBLACKLISTED',   'Tu comentario contiene contenido inaceptable y ha sido rechazado');
define('_EZCOMMENTS_PROXYBLACKLIST',       'Rechazar comentarios de proxies inseguros');

// comment statuses
define('_EZCOMMENTS_APPROVED', 'Aprobado');
define('_EZCOMMENTS_PENDING', 'Pendiente');
define('_EZCOMMENTS_REJECTED', 'Rechazado');

// modifyconfig fieldsets
define('_EZCOMMENTS_MISCSETTINGS', 'Miscel�neo');
define('_EZCOMMENTS_MODERATIONSETTINGS', 'Moderaci�n');
define('_EZCOMMENTS_NOTIFICATIONSETTINGS', 'Notificaci�n');

?>