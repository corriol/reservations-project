# Reservations

Projecte d'exemple que il·lustra la gestió i validació de formularis, l'accés a dades amb PDO i la gestió de sessions.

Es tracta un sistema simplificat de gestió de reserves de pistes esportives.

## Reserva de pistes
Es tracta d’un formulari on l’usuari podrà reservar pistes i es guardaran en la base de dades.

## Cancel·lació de reserves
L’usuari podrà cancel·lar una reserva introduint el número de reserva i el seu nom. Caldrà demanar confirmació.

### Panell de control (reservations.php)

En la part administrativa tindrem:
* Un llistat de reserves ordenades de forma descendent per data de reserva. Les del dia actual tindran algun distinctiu (fons roig, icona, etc).
* Un buscador per poder buscar reserves pel nom de l’usuari.
* Una opció que ens permetrà cancel·lar reserves, demanant confirmació.

Requisits de validació:
* Tots els camps són obligatoris.
* El nom no pot ser superar els 50 caràcters.
* La data de la reserva no podrà ser anterior al dia de hui i sols podrà tenir el format indicat en l’etiqueta.

Caldrà comprovar abans d’inserir una nova reserva que la pista està disponible.

Bones pràctiques
* Cal sanejar i validar totes les entrades.
* Cal usar consultes preparades.
* Cal separar la lògica de la presentació.
* Cal fer una correcta gestió dels errors (compte amb la jerarquia d’errors).

## Docker

El projecte està preparat per a llançar-se en un contenidor amb 3 serveis:

* Apache amb PHP 7.4.16, en `http://localhost:8080`
* MySQL 5.0.1
* PHPMyAdmin 5.0.1, en `http://localhost:5000`

