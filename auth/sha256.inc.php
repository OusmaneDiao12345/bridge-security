<?php

/**
 * Main routine called from an application using this include.
 *
 * General usage:
 *   require_once('sha256.inc.php');
 *   $hashstr = spip_sha256('abc');
 *
 * @param string $str Chaîne dont on veut calculer le SHA
 * @return string Le SHA de la chaîne
 */
function spip_sha256($str) {
	return hash('sha256', $str);
}

/**
 * @param string $str Chaîne dont on veut calculer le SHA
 * @param bool $ig_func
 * @return string Le SHA de la chaîne
 * @deprecated
 */
function _nano_sha256($str, $ig_func = true) {
	return spip_sha256($str);
}

// 2009-07-23: Added check for function as the Suhosin plugin adds this routine.
if (!function_exists('sha256')) {
	/**
	 * Calcul du SHA256
	 *
	 * @param string $str Chaîne dont on veut calculer le SHA
	 * @param bool $ig_func
	 * @return string Le SHA de la chaîne
	 * @deprecated
	 */
	function sha256($str, $ig_func = true) { return spip_sha256($str); }
}