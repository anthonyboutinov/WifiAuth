<?php
/** German (Deutsch)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 */

$namespaceNames = array(
	NS_MEDIA            => 'Medium',
	NS_SPECIAL          => 'Spezial',
	NS_TALK             => 'Diskussion',
	NS_USER             => 'Benutzer',
	NS_USER_TALK        => 'Benutzer_Diskussion',
	NS_PROJECT_TALK     => '$1_Diskussion',
	NS_FILE             => 'Datei',
	NS_FILE_TALK        => 'Datei_Diskussion',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki_Diskussion',
	NS_TEMPLATE         => 'Vorlage',
	NS_TEMPLATE_TALK    => 'Vorlage_Diskussion',
	NS_HELP             => 'Hilfe',
	NS_HELP_TALK        => 'Hilfe_Diskussion',
	NS_CATEGORY         => 'Kategorie',
	NS_CATEGORY_TALK    => 'Kategorie_Diskussion',
);

$namespaceAliases = array(
	'Bild' => NS_FILE,
	'Bild_Diskussion' => NS_FILE_TALK,
);

$namespaceGenderAliases = array(
	NS_USER => array( 'male' => 'Benutzer', 'female' => 'Benutzerin' ),
	NS_USER_TALK => array( 'male' => 'Benutzer_Diskussion', 'female' => 'Benutzerin_Diskussion' ),
);

$specialPageAliases = array(
	'Activeusers'               => array( 'Aktive_Benutzer' ),
	'Allmessages'               => array( 'MediaWiki-Systemnachrichten', 'Systemnachrichten' ),
	'AllMyUploads'              => array( 'Alle_meine_Dateien' ),
	'Allpages'                  => array( 'Alle_Seiten' ),
	'ApiHelp'                   => array( 'API-Hilfe' ),
	'Ancientpages'              => array( 'Älteste_Seiten' ),
	'Badtitle'                  => array( 'Ungültiger_Seitenname' ),
	'Blankpage'                 => array( 'Leerseite', 'Leere_Seite' ),
	'Block'                     => array( 'Sperren' ),
	'Booksources'               => array( 'ISBN-Suche' ),
	'BrokenRedirects'           => array( 'Defekte_Weiterleitungen', 'Kaputte_Weiterleitungen' ),
	'Categories'                => array( 'Kategorien' ),
	'ChangeEmail'               => array( 'E-Mail-Adresse_ändern' ),
	'ChangePassword'            => array( 'Passwort_ändern', 'Passwort_zurücksetzen' ),
	'ComparePages'              => array( 'Seiten_vergleichen' ),
	'Confirmemail'              => array( 'E-Mail_bestätigen', 'E-Mail_bestaetigen' ),
	'Contributions'             => array( 'Beiträge' ),
	'CreateAccount'             => array( 'Benutzerkonto_anlegen' ),
	'Deadendpages'              => array( 'Sackgassenseiten' ),
	'DeletedContributions'      => array( 'Gelöschte_Beiträge' ),
	'Diff'                      => array( 'Diff', 'Differenz', 'Unterschied' ),
	'DoubleRedirects'           => array( 'Doppelte_Weiterleitungen' ),
	'EditWatchlist'             => array( 'Beobachtungsliste_bearbeiten' ),
	'Emailuser'                 => array( 'E-Mail_senden', 'Mailen', 'E-Mail' ),
	'ExpandTemplates'           => array( 'Vorlagen_expandieren' ),
	'Export'                    => array( 'Exportieren' ),
	'Fewestrevisions'           => array( 'Wenigstbearbeitete_Seiten' ),
	'FileDuplicateSearch'       => array( 'Dateiduplikatsuche', 'Datei-Duplikat-Suche' ),
	'Filepath'                  => array( 'Dateipfad' ),
	'Import'                    => array( 'Importieren' ),
	'Invalidateemail'           => array( 'E-Mail_nicht_bestätigen', 'E-Mail_nicht_bestaetigen' ),
	'JavaScriptTest'            => array( 'JavaScript-Test' ),
	'BlockList'                 => array( 'Liste_der_Sperren', 'Gesperrte_IP-Adressen', 'Gesperrte_IPs', 'Sperrliste' ),
	'LinkSearch'                => array( 'Weblinksuche', 'Weblink-Suche' ),
	'Listadmins'                => array( 'Administratoren' ),
	'Listbots'                  => array( 'Bots' ),
	'Listfiles'                 => array( 'Dateien', 'Dateiliste' ),
	'Listgrouprights'           => array( 'Gruppenrechte' ),
	'Listredirects'             => array( 'Weiterleitungen' ),
	'ListDuplicatedFiles'       => array( 'Dateiduplikate' ),
	'Listusers'                 => array( 'Benutzer', 'Benutzerliste' ),
	'Lockdb'                    => array( 'Datenbank_sperren' ),
	'Log'                       => array( 'Logbuch' ),
	'Lonelypages'               => array( 'Verwaiste_Seiten' ),
	'Longpages'                 => array( 'Längste_Seiten' ),
	'MediaStatistics'           => array( 'Medienstatistiken' ),
	'MergeHistory'              => array( 'Versionsgeschichten_vereinen' ),
	'MIMEsearch'                => array( 'MIME-Typ-Suche' ),
	'Mostcategories'            => array( 'Meistkategorisierte_Seiten' ),
	'Mostimages'                => array( 'Meistbenutzte_Dateien' ),
	'Mostinterwikis'            => array( 'Meiste_Interwikilinks' ),
	'Mostlinked'                => array( 'Meistverlinkte_Seiten' ),
	'Mostlinkedcategories'      => array( 'Meistbenutzte_Kategorien' ),
	'Mostlinkedtemplates'       => array( 'Meistbenutzte_Vorlagen' ),
	'Mostrevisions'             => array( 'Meistbearbeitete_Seiten' ),
	'Movepage'                  => array( 'Verschieben' ),
	'Mycontributions'           => array( 'Meine_Beiträge' ),
	'MyLanguage'                => array( 'Meine_Sprache' ),
	'Mypage'                    => array( 'Meine_Benutzerseite' ),
	'Mytalk'                    => array( 'Meine_Diskussionsseite' ),
	'Myuploads'                 => array( 'Meine_hochgeladenen_Dateien' ),
	'Newimages'                 => array( 'Neue_Dateien' ),
	'Newpages'                  => array( 'Neue_Seiten' ),
	'PagesWithProp'             => array( 'Seiten_mit_Eigenschaften' ),
	'PageLanguage'              => array( 'Seitensprache' ),
	'PasswordReset'             => array( 'Passwort_neu_vergeben' ),
	'PermanentLink'             => array( 'Permanenter_Link', 'Permalink' ),
	'Popularpages'              => array( 'Beliebteste_Seiten' ),
	'Preferences'               => array( 'Einstellungen' ),
	'Prefixindex'               => array( 'Präfixindex' ),
	'Protectedpages'            => array( 'Geschützte_Seiten' ),
	'Protectedtitles'           => array( 'Geschützte_Titel', 'Gesperrte_Titel' ),
	'Randompage'                => array( 'Zufällige_Seite' ),
	'RandomInCategory'          => array( 'Zufällig_in_Kategorie' ),
	'Randomredirect'            => array( 'Zufällige_Weiterleitung' ),
	'Recentchanges'             => array( 'Letzte_Änderungen' ),
	'Recentchangeslinked'       => array( 'Änderungen_an_verlinkten_Seiten' ),
	'Redirect'                  => array( 'Weiterleitung' ),
	'ResetTokens'               => array( 'Tokens_zurücksetzen' ),
	'Revisiondelete'            => array( 'Versionslöschung' ),
	'RunJobs'                   => array( 'Aufträge_ausführen' ),
	'Search'                    => array( 'Suche' ),
	'Shortpages'                => array( 'Kürzeste_Seiten' ),
	'Specialpages'              => array( 'Spezialseiten' ),
	'Statistics'                => array( 'Statistik' ),
	'Tags'                      => array( 'Markierungen' ),
	'TrackingCategories'        => array( 'Tracking-Kategorien' ),
	'Unblock'                   => array( 'Freigeben' ),
	'Uncategorizedcategories'   => array( 'Nicht_kategorisierte_Kategorien' ),
	'Uncategorizedimages'       => array( 'Nicht_kategorisierte_Dateien' ),
	'Uncategorizedpages'        => array( 'Nicht_kategorisierte_Seiten' ),
	'Uncategorizedtemplates'    => array( 'Nicht_kategorisierte_Vorlagen' ),
	'Undelete'                  => array( 'Wiederherstellen' ),
	'Unlockdb'                  => array( 'Datenbank_entsperren' ),
	'Unusedcategories'          => array( 'Unbenutzte_Kategorien' ),
	'Unusedimages'              => array( 'Unbenutzte_Dateien' ),
	'Unusedtemplates'           => array( 'Unbenutzte_Vorlagen' ),
	'Unwatchedpages'            => array( 'Ignorierte_Seiten', 'Unbeobachtete_Seiten' ),
	'Upload'                    => array( 'Hochladen' ),
	'UploadStash'               => array( 'Hochladespeicher' ),
	'Userlogin'                 => array( 'Anmelden' ),
	'Userlogout'                => array( 'Abmelden' ),
	'Userrights'                => array( 'Benutzerrechte' ),
	'Wantedcategories'          => array( 'Gewünschte_Kategorien' ),
	'Wantedfiles'               => array( 'Gewünschte_Dateien', 'Fehlende_Dateien' ),
	'Wantedpages'               => array( 'Gewünschte_Seiten' ),
	'Wantedtemplates'           => array( 'Gewünschte_Vorlagen', 'Fehlende_Vorlagen' ),
	'Watchlist'                 => array( 'Beobachtungsliste' ),
	'Whatlinkshere'             => array( 'Linkliste', 'Verweisliste' ),
	'Withoutinterwiki'          => array( 'Fehlende_Interwikis' ),
);

$magicWords = array(
	'redirect'                  => array( '0', '#WEITERLEITUNG', '#REDIRECT' ),
	'notoc'                     => array( '0', '__KEIN_INHALTSVERZEICHNIS__', '__KEININHALTSVERZEICHNIS__', '__NOTOC__' ),
	'nogallery'                 => array( '0', '__KEINE_GALERIE__', '__KEINEGALERIE__', '__NOGALLERY__' ),
	'forcetoc'                  => array( '0', '__INHALTSVERZEICHNIS_ERZWINGEN__', '__FORCETOC__' ),
	'toc'                       => array( '0', '__INHALTSVERZEICHNIS__', '__TOC__' ),
	'noeditsection'             => array( '0', '__ABSCHNITTE_NICHT_BEARBEITEN__', '__NOEDITSECTION__' ),
	'currentmonth'              => array( '1', 'JETZIGER_MONAT', 'JETZIGER_MONAT_2', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'             => array( '1', 'JETZIGER_MONAT_1', 'CURRENTMONTH1' ),
	'currentmonthname'          => array( '1', 'JETZIGER_MONATSNAME', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'       => array( '1', 'JETZIGER_MONATSNAME_GENITIV', 'JETZIGER_MONATSNAME_GEN', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'        => array( '1', 'JETZIGER_MONATSNAME_KURZ', 'CURRENTMONTHABBREV' ),
	'currentday'                => array( '1', 'JETZIGER_KALENDERTAG', 'JETZIGER_TAG', 'CURRENTDAY' ),
	'currentday2'               => array( '1', 'JETZIGER_KALENDERTAG_2', 'JETZIGER_TAG_2', 'CURRENTDAY2' ),
	'currentdayname'            => array( '1', 'JETZIGER_WOCHENTAG', 'CURRENTDAYNAME' ),
	'currentyear'               => array( '1', 'JETZIGES_JAHR', 'CURRENTYEAR' ),
	'currenttime'               => array( '1', 'JETZIGE_UHRZEIT', 'CURRENTTIME' ),
	'currenthour'               => array( '1', 'JETZIGE_STUNDE', 'CURRENTHOUR' ),
	'localmonth'                => array( '1', 'LOKALER_MONAT', 'LOKALER_MONAT_2', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'               => array( '1', 'LOKALER_MONAT_1', 'LOCALMONTH1' ),
	'localmonthname'            => array( '1', 'LOKALER_MONATSNAME', 'LOCALMONTHNAME' ),
	'localmonthnamegen'         => array( '1', 'LOKALER_MONATSNAME_GENITIV', 'LOKALER_MONATSNAME_GEN', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'          => array( '1', 'LOKALER_MONATSNAME_KURZ', 'LOCALMONTHABBREV' ),
	'localday'                  => array( '1', 'LOKALER_KALENDERTAG', 'LOKALER_TAG', 'LOCALDAY' ),
	'localday2'                 => array( '1', 'LOKALER_KALENDERTAG_2', 'LOKALER_TAG_2', 'LOCALDAY2' ),
	'localdayname'              => array( '1', 'LOKALER_WOCHENTAG', 'LOCALDAYNAME' ),
	'localyear'                 => array( '1', 'LOKALES_JAHR', 'LOCALYEAR' ),
	'localtime'                 => array( '1', 'LOKALE_UHRZEIT', 'LOCALTIME' ),
	'localhour'                 => array( '1', 'LOKALE_STUNDE', 'LOCALHOUR' ),
	'numberofpages'             => array( '1', 'SEITENANZAHL', 'NUMBEROFPAGES' ),
	'numberofarticles'          => array( '1', 'ARTIKELANZAHL', 'NUMBEROFARTICLES' ),
	'numberoffiles'             => array( '1', 'DATEIANZAHL', 'NUMBEROFFILES' ),
	'numberofusers'             => array( '1', 'BENUTZERANZAHL', 'NUMBEROFUSERS' ),
	'numberofactiveusers'       => array( '1', 'AKTIVE_BENUTZER', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'             => array( '1', 'BEARBEITUNGSANZAHL', 'NUMBEROFEDITS' ),
	'pagename'                  => array( '1', 'SEITENNAME', 'PAGENAME' ),
	'pagenamee'                 => array( '1', 'SEITENNAME_URL', 'PAGENAMEE' ),
	'namespace'                 => array( '1', 'NAMENSRAUM', 'NAMESPACE' ),
	'namespacee'                => array( '1', 'NAMENSRAUM_URL', 'NAMESPACEE' ),
	'namespacenumber'           => array( '1', 'NAMENSRAUMNUMMER', 'NAMESPACENUMBER' ),
	'talkspace'                 => array( '1', 'DISKUSSIONSNAMENSRAUM', 'DISK_NR', 'TALKSPACE' ),
	'talkspacee'                => array( '1', 'DISKUSSIONSNAMENSRAUM_URL', 'DISK_NR_URL', 'TALKSPACEE' ),
	'subjectspace'              => array( '1', 'HAUPTNAMENSRAUM', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'subjectspacee'             => array( '1', 'HAUPTNAMENSRAUM_URL', 'SUBJECTSPACEE', 'ARTICLESPACEE' ),
	'fullpagename'              => array( '1', 'VOLLER_SEITENNAME', 'FULLPAGENAME' ),
	'fullpagenamee'             => array( '1', 'VOLLER_SEITENNAME_URL', 'FULLPAGENAMEE' ),
	'subpagename'               => array( '1', 'UNTERSEITE', 'SUBPAGENAME' ),
	'subpagenamee'              => array( '1', 'UNTERSEITE_URL', 'SUBPAGENAMEE' ),
	'rootpagename'              => array( '1', 'STAMMSEITE', 'ROOTPAGENAME' ),
	'rootpagenamee'             => array( '1', 'STAMMSEITE_URL', 'ROOTPAGENAMEE' ),
	'basepagename'              => array( '1', 'OBERSEITE', 'BASEPAGENAME' ),
	'basepagenamee'             => array( '1', 'OBERSEITE_URL', 'BASEPAGENAMEE' ),
	'talkpagename'              => array( '1', 'DISKUSSIONSSEITE', 'DISK', 'TALKPAGENAME' ),
	'talkpagenamee'             => array( '1', 'DISKUSSIONSSEITE_URL', 'DISK_URL', 'TALKPAGENAMEE' ),
	'subjectpagename'           => array( '1', 'HAUPTSEITENNAME', 'VORDERSEITE', 'HAUPTSEITE', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ),
	'subjectpagenamee'          => array( '1', 'HAUPTSEITENNAME_URL', 'VORDERSEITE_URL', 'HAUPTSEITE_URL', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE' ),
	'subst'                     => array( '0', 'ERS:', 'SUBST:' ),
	'safesubst'                 => array( '0', 'SICHER_ERS:', 'SICHERERS:', 'SAFESUBST:' ),
	'img_thumbnail'             => array( '1', 'mini', 'miniatur', 'thumbnail', 'thumb' ),
	'img_manualthumb'           => array( '1', 'miniatur=$1', 'mini=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'                 => array( '1', 'rechts', 'right' ),
	'img_left'                  => array( '1', 'links', 'left' ),
	'img_none'                  => array( '1', 'ohne', 'none' ),
	'img_center'                => array( '1', 'zentriert', 'center', 'centre' ),
	'img_framed'                => array( '1', 'gerahmt', 'framed', 'enframed', 'frame' ),
	'img_frameless'             => array( '1', 'rahmenlos', 'frameless' ),
	'img_lang'                  => array( '1', 'sprache=$1', 'lang=$1' ),
	'img_page'                  => array( '1', 'seite=$1', 'seite_$1', 'page=$1', 'page $1' ),
	'img_upright'               => array( '1', 'hochkant', 'hochkant=$1', 'hochkant_$1', 'upright', 'upright=$1', 'upright $1' ),
	'img_border'                => array( '1', 'rand', 'border' ),
	'img_baseline'              => array( '1', 'grundlinie', 'baseline' ),
	'img_sub'                   => array( '1', 'tiefgestellt', 'tief', 'sub' ),
	'img_super'                 => array( '1', 'hochgestellt', 'hoch', 'super', 'sup' ),
	'img_top'                   => array( '1', 'oben', 'top' ),
	'img_text_top'              => array( '1', 'text-oben', 'text-top' ),
	'img_middle'                => array( '1', 'mitte', 'middle' ),
	'img_bottom'                => array( '1', 'unten', 'bottom' ),
	'img_text_bottom'           => array( '1', 'text-unten', 'text-bottom' ),
	'img_link'                  => array( '1', 'verweis=$1', 'link=$1' ),
	'img_alt'                   => array( '1', 'alternativtext=$1', 'alt=$1' ),
	'img_class'                 => array( '1', 'klasse=$1', 'class=$1' ),
	'int'                       => array( '0', 'NACHRICHT:', 'INT:' ),
	'sitename'                  => array( '1', 'PROJEKTNAME', 'SITENAME' ),
	'ns'                        => array( '0', 'NR:', 'NS:' ),
	'nse'                       => array( '0', 'NR_URL:', 'NSE:' ),
	'localurl'                  => array( '0', 'LOKALE_URL:', 'LOCALURL:' ),
	'localurle'                 => array( '0', 'LOKALE_URL_C:', 'LOCALURLE:' ),
	'articlepath'               => array( '0', 'ARTIKELPFAD', 'ARTICLEPATH' ),
	'pageid'                    => array( '0', 'SEITENID', 'SEITENKENNUNG', 'PAGEID' ),
	'scriptpath'                => array( '0', 'SKRIPTPFAD', 'SCRIPTPATH' ),
	'stylepath'                 => array( '0', 'STILPFAD', 'STYLEPFAD', 'STYLEPATH' ),
	'grammar'                   => array( '0', 'GRAMMATIK:', 'GRAMMAR:' ),
	'gender'                    => array( '0', 'GESCHLECHT:', 'GENDER:' ),
	'notitleconvert'            => array( '0', '__KEINE_TITELKONVERTIERUNG__', '__NOTITLECONVERT__', '__NOTC__' ),
	'nocontentconvert'          => array( '0', '__KEINE_INHALTSKONVERTIERUNG__', '__NOCONTENTCONVERT__', '__NOCC__' ),
	'currentweek'               => array( '1', 'JETZIGE_KALENDERWOCHE', 'JETZIGE_WOCHE', 'CURRENTWEEK' ),
	'currentdow'                => array( '1', 'JETZIGER_WOCHENTAG_ZAHL', 'CURRENTDOW' ),
	'localweek'                 => array( '1', 'LOKALE_KALENDERWOCHE', 'LOKALE_WOCHE', 'LOCALWEEK' ),
	'localdow'                  => array( '1', 'LOKALER_WOCHENTAG_ZAHL', 'LOCALDOW' ),
	'revisionid'                => array( '1', 'REVISIONSID', 'VERSIONSID', 'REVISIONID' ),
	'revisionday'               => array( '1', 'REVISIONSTAG', 'VERSIONSTAG', 'REVISIONDAY' ),
	'revisionday2'              => array( '1', 'REVISIONSTAG2', 'VERSIONSTAG2', 'REVISIONDAY2' ),
	'revisionmonth'             => array( '1', 'REVISIONSMONAT', 'VERSIONSMONAT', 'REVISIONMONTH' ),
	'revisionmonth1'            => array( '1', 'REVISIONSMONAT1', 'VERSIONSMONAT1', 'REVISIONMONTH1' ),
	'revisionyear'              => array( '1', 'REVISIONSJAHR', 'VERSIONSJAHR', 'REVISIONYEAR' ),
	'revisiontimestamp'         => array( '1', 'REVISIONSZEITSTEMPEL', 'VERSIONSZEITSTEMPEL', 'REVISIONTIMESTAMP' ),
	'revisionuser'              => array( '1', 'REVISIONSBENUTZER', 'VERSIONSBENUTZER', 'REVISIONUSER' ),
	'revisionsize'              => array( '1', 'VERSIONSGRÖSSE', 'REVISIONSIZE' ),
	'fullurl'                   => array( '0', 'VOLLSTÄNDIGE_URL:', 'FULLURL:' ),
	'fullurle'                  => array( '0', 'VOLLSTÄNDIGE_URL_C:', 'FULLURLE:' ),
	'canonicalurl'              => array( '0', 'KANONISCHE_URL:', 'CANONICALURL:' ),
	'canonicalurle'             => array( '0', 'KANONISCHE_URL_C:', 'CANONICALURLE:' ),
	'lcfirst'                   => array( '0', 'INITIAL_KLEIN:', 'LCFIRST:' ),
	'ucfirst'                   => array( '0', 'INITIAL_GROSS:', 'UCFIRST:' ),
	'lc'                        => array( '0', 'KLEIN:', 'LC:' ),
	'uc'                        => array( '0', 'GROSS:', 'UC:' ),
	'raw'                       => array( '0', 'ROH:', 'RAW:' ),
	'displaytitle'              => array( '1', 'SEITENTITEL', 'DISPLAYTITLE' ),
	'newsectionlink'            => array( '1', '__NEUER_ABSCHNITTSLINK__', '__PLUS_LINK__', '__NEWSECTIONLINK__' ),
	'nonewsectionlink'          => array( '1', '__KEIN_NEUER_ABSCHNITTSLINK__', '__KEIN_PLUS_LINK__', '__NONEWSECTIONLINK__' ),
	'currentversion'            => array( '1', 'JETZIGE_VERSION', 'CURRENTVERSION' ),
	'urlencode'                 => array( '0', 'URLENKODIERT:', 'URLENCODE:' ),
	'anchorencode'              => array( '0', 'ANKERENKODIERT:', 'SPRUNGMARKEENKODIERT:', 'ANCHORENCODE' ),
	'currenttimestamp'          => array( '1', 'JETZIGER_ZEITSTEMPEL', 'CURRENTTIMESTAMP' ),
	'localtimestamp'            => array( '1', 'LOKALER_ZEITSTEMPEL', 'LOCALTIMESTAMP' ),
	'directionmark'             => array( '1', 'TEXTAUSRICHTUNG', 'DIRECTIONMARK', 'DIRMARK' ),
	'language'                  => array( '0', '#SPRACHE:', '#LANGUAGE:' ),
	'contentlanguage'           => array( '1', 'INHALTSSPRACHE', 'CONTENTLANGUAGE', 'CONTENTLANG' ),
	'pagesinnamespace'          => array( '1', 'SEITEN_IM_NAMENSRAUM:', 'SEITEN_IN_NR:', 'SEITEN_NR:', 'PAGESINNAMESPACE:', 'PAGESINNS:' ),
	'numberofadmins'            => array( '1', 'ADMINANZAHL', 'NUMBEROFADMINS' ),
	'formatnum'                 => array( '0', 'ZAHLENFORMAT', 'FORMATNUM' ),
	'padleft'                   => array( '0', 'FÜLLENLINKS', 'PADLEFT' ),
	'padright'                  => array( '0', 'FÜLLENRECHTS', 'PADRIGHT' ),
	'special'                   => array( '0', 'spezial', 'special' ),
	'speciale'                  => array( '0', 'speziale', 'speciale' ),
	'defaultsort'               => array( '1', 'SORTIERUNG:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'filepath'                  => array( '0', 'DATEIPFAD:', 'FILEPATH:' ),
	'tag'                       => array( '0', 'erweiterung', 'tag' ),
	'hiddencat'                 => array( '1', '__VERSTECKTE_KATEGORIE__', '__WARTUNGSKATEGORIE__', '__HIDDENCAT__' ),
	'pagesincategory'           => array( '1', 'SEITEN_IN_KATEGORIE', 'SEITEN_KAT', 'SEITENINKAT', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                  => array( '1', 'SEITENGRÖSSE', 'PAGESIZE' ),
	'index'                     => array( '1', '__INDEXIEREN__', '__INDIZIEREN__', '__INDEX__' ),
	'noindex'                   => array( '1', '__NICHT_INDEXIEREN__', '__KEIN_INDEX__', '__NICHT_INDIZIEREN__', '__NOINDEX__' ),
	'numberingroup'             => array( '1', 'BENUTZER_IN_GRUPPE', 'NUMBERINGROUP', 'NUMINGROUP' ),
	'staticredirect'            => array( '1', '__PERMANENTE_WEITERLEITUNG__', '__STATICREDIRECT__' ),
	'protectionlevel'           => array( '1', 'SCHUTZSTATUS', 'PROTECTIONLEVEL' ),
	'cascadingsources'          => array( '1', 'KASKADENQUELLEN', 'CASCADINGSOURCES' ),
	'formatdate'                => array( '0', 'DATUMSFORMAT', 'formatdate', 'dateformat' ),
	'url_path'                  => array( '0', 'PFAD', 'PATH' ),
	'url_query'                 => array( '0', 'ABFRAGE', 'QUERY' ),
	'defaultsort_noerror'       => array( '0', 'keinfehler', 'noerror' ),
	'defaultsort_noreplace'     => array( '0', 'keineersetzung', 'noreplace' ),
	'pagesincategory_all'       => array( '0', 'alle', 'all' ),
	'pagesincategory_pages'     => array( '0', 'seiten', 'pages' ),
	'pagesincategory_subcats'   => array( '0', 'unterkategorien', 'unterkats', 'subcats' ),
	'pagesincategory_files'     => array( '0', 'dateien', 'files' ),
);

$datePreferences = array(
	'default',
	'dmyt',
	'dmyts',
	'dmy',
	'ymd',
	'ISO 8601'
);

$defaultDateFormat = 'dmy';

$dateFormats = array(
	'dmyt time' => 'H:i',
	'dmyt date' => 'j. F Y',
	'dmyt both' => 'j. M Y, H:i',

	'dmyts time' => 'H:i:s',
	'dmyts date' => 'j. F Y',
	'dmyts both' => 'j. M Y, H:i:s',

	'dmy time' => 'H:i',
	'dmy date' => 'j. F Y',
	'dmy both' => 'H:i, j. M Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y M j',
	'ymd both' => 'H:i, Y M j',

	'ISO 8601 time' => 'xnH:xni:xns',
	'ISO 8601 date' => 'xnY-xnm-xnd',
	'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns'
);

$capitalizeAllNouns = true;
$bookstoreList = array(
	'abebooks.de' => 'http://www.abebooks.de/servlet/BookSearchPL?ph=2&isbn=$1',
	'amazon.de' => 'http://www.amazon.de/gp/search/field-isbn=$1',
	'buch.de' => 'http://www.buch.de/shop/home/suche/?sswg=BUCH&sq=$1',
	'Karlsruher Virtueller Katalog (KVK)' => 'http://www.ubka.uni-karlsruhe.de/kvk.html?SB=$1',
	'Lehmanns Fachbuchhandlung' => 'http://www.lob.de/cgi-bin/work/suche?flag=new&stich1=$1'
);

$separatorTransformTable = array( ',' => '.', '.' => ',' );
$linkTrail = '/^([äöüßa-z]+)(.*)$/sDu';

$imageFiles = array(
	'button-bold'     => 'de/button_bold.png',
	'button-italic'   => 'de/button_italic.png',
);

