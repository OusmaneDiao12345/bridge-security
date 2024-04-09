# spip-remix/bridge-security

```bash
git clone --single-branch --no-tags git@git.spip.net:spip/spip.git bridge-security \
    && cd bridge-security
git filter-repo \
    --path ecrire/auth \
    --path ecrire/bootstrap/inc/auth.php \
    --path ecrire/inc/acces.php \
    --path ecrire/inc/admin.php \
    --path ecrire/inc/auth.php \
    --path ecrire/inc/autoriser.php \
    --path ecrire/src/Chiffrer \
    --path-rename ecrire/auth:auth \
    --path-rename ecrire/bootstrap/inc/auth.php:bootstrap/inc/auth.php \
    --path-rename ecrire/inc/acces.php:inc/acces.php \
    --path-rename ecrire/inc/admin.php:inc/admin.php \
    --path-rename ecrire/inc/auth.php:inc/auth.php \
    --path-rename ecrire/inc/autoriser.php:inc/autoriser.php \
    --path-rename ecrire/src/Chiffrer:src/Chiffrer \
  --force
git branch -m 0.1
```

Impact

```txt
/Users/klike/Sites/spip-remix/legacy_vidage/ecrire/action/inscrire_auteur.php
  18,10: use Spip\Chiffrer\Chiffrement;
  19,10: use Spip\Chiffrer\SpipCles;
  354,69:     // Un morceau du jeton est lisible en bdd pour éviter de devoir déchiffrer
  358,51:     $jeton_chiffre_prefixe = $public . Chiffrement::chiffrer($jeton, SpipCles::secret_du_site());
  380,27:     $jeton = Chiffrement::dechiffrer($jeton_chiffre, SpipCles::secret_du_site());
  411,29:         $_jeton = Chiffrement::dechiffrer($jeton_chiffre, SpipCles::secret_du_site());
  413,17:         spip_logger('chiffrer')->error('Échec du déchiffrage du jeton d’auteur: ' . $e->getMessage());

/Users/klike/Sites/spip-remix/legacy_vidage/ecrire/inc/securiser_action.php
  18,11:  use Spip\Chiffrer\SpipCles;

/Users/klike/Sites/spip-remix/legacy_vidage/ecrire/install/etape_3b.php
  89,17:         $cles = \Spip\Chiffrer\SpipCles::instance();
```
