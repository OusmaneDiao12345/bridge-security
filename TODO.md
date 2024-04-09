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
