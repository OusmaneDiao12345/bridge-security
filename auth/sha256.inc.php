<?php

/**
 * SPIP, Système de publication pour l'internet
 *
 * Copyright © avec tendresse depuis 2001
 * Arnaud Martin, Antoine Pitrou, Philippe Rivière, Emmanuel Saint-James
 *
 * Ce programme est un logiciel libre distribué sous licence GNU/GPL.
 */

/**
 * Main routine called from an application using this include.
 *
 * General usage:
 *   require_once('sha256.inc.php');
 *   $hashstr = spip_sha256('abc');
 *
 * @deprecated 5.0 Use `hash('sha256', $str)`
 * @param string $str Chaîne dont on veut calculer le SHA
 * @return string Le SHA de la chaîne
 */
function spip_sha256($str)
{
    trigger_deprecation('spip', '5.0', 'Using "%s" is deprecated, use "%s" instead.', 'spip_sha256($str)', 'hash(\'sha256\', $str)');
    return hash('sha256', $str);
}
