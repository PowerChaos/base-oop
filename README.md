# base-oop
Base CMS Rewritten to OOP and Classes

# Base CMS
Basis Systeem van mijn Bare Metal CMS Systeem

## Inhoud
+ Registreer Gebruikers
+ Login Systeem
+ Groepen
+ Verander Wachtwoord
+ Delete Gebruikers
+ Pagina Systeem
+ Simpel om nieuwe pagina's toe te voegen ( gewoon droppen in /pages )
+ Admin arena ( a() <- shortcode voor admin only) in /pages/a/
+ Staff Arena ( s() <-) Shortcode voor Staff only ) in /pages/s/
+ Gebruikers arena ( u() <- Shortcode voor users only ) in /pages
+ Standaard HomePage met login
+ Versie Controle ( in geval Base systeem word geupdate)
+ Hashed Passwords met een hash script ( Sha1 + md5 + blowfish ...)
+ Gemaakt met BootStrap template
+ Template in /template/ folder om gemakkelijk templates te maken
+ Ajax Login Systeem en Modal voor gebruikers
+ Ajax bestanden in /ajax Folder
+ Classes in /inc/classes met autoloader
+ alles met comments om gemakkelijk te bewerken
+ Nog andere zaken die ik ben vergeten

## Gebruikers
+ Admin Account standaard om in te loggen
+ gebruikers toevoegen en rechten aanpassen
+ Gebruikers van Naam veranderen
+ Gebruikers wachtwoord veranderen

## Groepen
+ 1 eigenaar per groep
+ Zoveel gebruikers per groep als je wilt
+ Zoveel groepen als je wilt
+ bedoeld om iedereen in de groep weer te geven waar je eigenaar van bent

## Gebruikers menu
+ Uitloggen
+ Wachtwoord Veranderen

##Login
+ Home.php bevat een login om de rest van de website te sluiten
+ home.php bevat code als voorbeeld waneer je bent ingelogt

## Template
+ Header
+ SideBar
+ Footer
# header
+ Bevat CDN links om zo klein mogelijk te houden
# sidebar
+ Bevat de header NavBar met een admin menu als je inlogt als admin
+ Bevat de start voor de container
# Footer
+ Bevat een footer en sluiting van container

##HowTo
+ voeg een nieuwe pagina toe bij een php bestand in /pages te zetten ( test.php)
+ roep de pagina op met url/test
+ Admin pagina's zijn altijd in /a en worden opgeroepen via url/a/test ( test.php )
+ Staff pagina's zijn altijd in /s en worden opgeroepen via url/s/test ( test.php )
+ Pagina's die niet bestaan gaan terug naar /home ( home.php)
+ Geen rechten voor /a of /s gaan terug naar /home (niet bestaand volgens systeem zonder rechten)


execute de SQL script en je kan beginnen 

gebruiker : admin 
wachtwoord : 123456

#Database opbouw

## gebruikers
| id |   naam 	 | wachtwoord | rechten |groep|
|----|-----------|------------|---------|-----|
| 1	 |	 Admin	 | 	  SHA1	  |    3  	|  1  |
| 15 | 	 User	 |    SHA1	  |	   1  	|     |
### info
- 1 = gebruiker
- 2 = staff
- 3 = admin

## groep
| id | user  |    naam 	 |
|----|-------|-----------|
| 1  |  1,15 | TestGroep |

## user_sessions
Word gebruikt om sessies in database op te slaan
