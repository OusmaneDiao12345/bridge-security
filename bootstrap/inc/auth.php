<?php

/**
 * Indique si on est dans l'espace prive
 *
 * @return bool
 *     true si c'est le cas, false sinon.
 */
function test_espace_prive() {
	return defined('_ESPACE_PRIVE') ? _ESPACE_PRIVE : false;
}

/**
 * Prédicat sur les scripts de ecrire qui n'authentifient pas par cookie
 * et beneficient d'une exception
 *
 * @param string $nom
 * @param bool $strict
 * @return bool
 */
function autoriser_sans_cookie($nom, $strict = false) {
	static $autsanscookie = ['install', 'base_repair'];

	if (in_array($nom, $autsanscookie)) {
		if (test_espace_prive()) {
			include_spip('base/connect_sql');
			if (!$strict || !spip_connect()) {
				return true;
			}
		}
	}
	return false;
}


/**
 * Retourne le statut du visiteur s'il s'annonce.
 *
 * Pour que cette fonction marche depuis mes_options,
 * il faut forcer l'init si ce n'est fait
 * mais on risque de perturber des plugins en initialisant trop tot
 * certaines constantes.
 * @return string|0|false
**/
function verifier_visiteur() {
	@spip_initialisation_core(
		(_DIR_RACINE . _NOM_PERMANENTS_INACCESSIBLES),
		(_DIR_RACINE . _NOM_PERMANENTS_ACCESSIBLES),
		(_DIR_RACINE . _NOM_TEMPORAIRES_INACCESSIBLES),
		(_DIR_RACINE . _NOM_TEMPORAIRES_ACCESSIBLES)
	);

	// Demarrer une session NON AUTHENTIFIEE si on donne son nom
	// dans un formulaire sans login (ex: #FORMULAIRE_FORUM)
	// Attention on separe bien session_nom et nom, pour eviter
	// les melanges entre donnees SQL et variables plus aleatoires
	$variables_session = ['session_nom', 'session_email'];
	foreach ($variables_session as $var) {
		if (_request($var) !== null) {
			$init = true;
			break;
		}
	}
	if (isset($init)) {
		#@spip_initialisation_suite();
		$session = charger_fonction('session', 'inc');
		$session();
		include_spip('inc/texte');
		foreach ($variables_session as $var) {
			if (($a = _request($var)) !== null) {
				$GLOBALS['visiteur_session'][$var] = safehtml($a);
			}
		}
		if (!isset($GLOBALS['visiteur_session']['id_auteur'])) {
			$GLOBALS['visiteur_session']['id_auteur'] = 0;
		}
		$session($GLOBALS['visiteur_session']);

		return 0;
	}

	$h = (isset($_SERVER['PHP_AUTH_USER']) && !$GLOBALS['ignore_auth_http']);
	if ($h || isset($_COOKIE['spip_session']) || isset($_COOKIE[$GLOBALS['cookie_prefix'] . '_session'])) {
		$session = charger_fonction('session', 'inc');
		if ($session()) {
			return $GLOBALS['visiteur_session']['statut'];
		}
		if ($h && isset($_SERVER['PHP_AUTH_PW'])) {
			include_spip('inc/auth');
			$h = lire_php_auth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		}
		if ($h) {
			$GLOBALS['visiteur_session'] = $h;

			return $GLOBALS['visiteur_session']['statut'];
		}
	}

	// au moins son navigateur nous dit la langue preferee de cet inconnu
	include_spip('inc/lang');
	utiliser_langue_visiteur();

	return false;
}


/**
 * Renvoie une chaîne qui identifie la session courante
 *
 * Permet de savoir si on peut utiliser un cache enregistré pour cette session.
 * Cette chaîne est courte (8 cars) pour pouvoir être utilisée dans un nom
 * de fichier cache.
 *
 * @pipeline_appel definir_session
 *
 * @param bool $force
 * @return string
 *     Identifiant de la session
 **/
function spip_session($force = false) {
	static $session;
	if ($force || !isset($session)) {
		$s = '';
		if (!empty($GLOBALS['visiteur_session'])) {
			include_spip('inc/session');
			$cookie = lire_cookie_session();
			$s = serialize($GLOBALS['visiteur_session']) . '_' . ($cookie ?: '');
		}
		$s = pipeline('definir_session', $s);
		$session = ($s ? substr(md5($s), 0, 8) : '');
	}

	#spip_logger()->info('session: '.$session);
	return $session;
}
