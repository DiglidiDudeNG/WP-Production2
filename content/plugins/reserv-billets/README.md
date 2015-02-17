Système de Réservation de Billets
======

## Informations utiles

### Sécurité

#### User Capabilities

Lorsqu'on change de quoi dans les posts (ou sur tout autre information importante impliquant la BD) :
```PHP
if ( ! current_user_can( 'edit_others_posts' ) )
	return;
```
Est pas mal utile!

_Source:_ https://developer.wordpress.org/plugins/security/checking-user-capabilities/

#### Something

blah