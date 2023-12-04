# Proiect: Proiectarea și Realizarea Site-urilor Web - PHP
Proiectul 1 - tehnica OOP
## Studenți
- Roxana Chiriac
- Lucia-Corina Dobre
- Karina [Nume de familie]

## Descriere Proiect

Să se creeze un site care gestionează n jurnaliști care au un cont din care încarcă articole per categoriile/teme arondate lor. Un editor valideaza articolul si aproba incarcarea articolului pe site. Site-ul prezinta pe scurt titlul articolului, autorul data la care a fost scris daca se doreste citirea lui integrala se creaza un cont de cititor. Pe site articolele sunt grupate pe categorii (artistic, technic, science, moda). 

## Caracteristici

- Gestionarea a n jurnaliști cu conturi individuale.
- Categorisirea articolelor în funcție de teme prestabilite: artistic, tehnic, științific, modă.
- Proces de validare editorială și aprobare pentru încărcarea articolelor.
- Prezentarea detaliilor articolului, inclusiv titlu, autor și dată.
- Înregistrare utilizator și creare cont pentru cititori.

## Migrare Bază de Date

Pentru a inițializa baza de date și a crea tabelele necesare, rulați scriptul `migrate.php`. Asigurați-vă că aveți PHP și MySQL instalate local.

```bash
php migrate.php
```

## Configurare MySQL

- $servername = "localhost";
- $port = "8081";
- $username = "root";
- $password = "root";
- $database = "articole";

---------------
## TODO

- pagina de articole cu teme/categorii - casute care incadreaza UN PREVIEW al articolului ORGANIZATE PE CATEGORII (artistic, technic, science, moda) si in functie de rol apar butoane
- click pe casuta -> vezi postarea
- pagini CREATE(buton+pagina) EDIT(buton+pagina) DELETE(buton) - jurnalist
- buton VALIDATE - editor - le face vizibile pt cititor (ele vor fi vizibile oricum pentru jurnalist+editor)

- OPTIONAL: daca esti guest nu poti vedea articole -  daca dai click pe articol te trimite la login