<?php

function ecrit_xml($titre, $texte) {

    $date = date("c");

    $document = new DomDocument();
    $document->load("article/article.xml");
    $article = $document->getElementsByTagName("article")->item(0);

    $nouveau = $document->createElement("item");
    $nTitre = $document->createElement("titre");
    $nouveau->appendChild($nTitre);
    $txt = $document->createTextNode(utf8_encode($titre));
    $nTitre->appendChild($txt);
    $nTexte = $document->createElement("texte");
    $nouveau->appendChild($nTexte);
    $txt = $document->createTextNode(utf8_encode($texte));
    $nTexte->AppendChild($txt);
    $nDate = $document->createElement("date");
    $nouveau->appendChild($nDate);
    $txt = $document->createTextNode($date);
    $nDate->AppendChild($txt);

    $ancien = $article->getElementsByTagName("item")->item(0);
    $article->replaceChild($nouveau, $ancien);

    $document->save("article/article.xml");
}

function lit_xml() {
    $document = new DomDocument();
    $document->load("article/article.xml");

    $article = $document->getElementsByTagName("article")->item(0);
    $item = $article->getElementsByTagName("item")->item(0);
    $titre = $item->getElementsByTagName("titre")->item(0)->nodeValue;
    $titre = utf8_decode($titre);
    $texte = $item->getElementsByTagName("texte")->item(0)->nodeValue;
    $texte = utf8_decode($texte);
    $date = $item->getElementsByTagName("date")->item(0)->nodeValue;
    $dateFr = convDate($date);
    $donnees = array($titre, $texte, $dateFr);
    return $donnees;
}

function convDate($date) {
    $time = new DateTime($date);
    $dateFr = $time->format("d/m/Y à H:i:s");

    return $dateFr;
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Dev-Tec : Développement et Technique</title>
        <meta name="Content-Language" content="fr">
        <meta name="Description" content="Site curriculum vitae de Stéphane Curet, développeur logiciel technicien">
        <meta name="Keywords" content="Curriculum vitae, Stéphane Curet, développement, technique, informatique, internet, développeur, logiciel">
        <meta name="Subject" content="développement">
        <meta name="Copyright" content="Stéphane Curet">
        <meta name="Author" content="Stéphane Curet">
        <meta name="Publisher" content="Stéphane Curet">
        <meta name="Revisit-After" content="15 days">
        <meta name="Rating" content="general">
        <meta name="Distribution" content="global">
        <meta name="Geography" content="Tours,France,37000">
        <meta name="Category" content="Internet">
        <link type="text/css" rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <main>


            <section>
                <h1>articleXML</h1>
                <br/><br/>
                <?php
                if (isset($_POST['valider'])) {

                    $titre = $_POST['titre'];
                    $texte = $_POST['texte'];

                    ecrit_xml($titre, $texte);

                    $donnees = lit_xml();

                    echo "<article><br/><div id=\"titre_article\">" . $donnees[0] . "</div><br/><div id=\"contenu_article\">" . $donnees[1] . "</div><br/> <div id=\"horodateur\">Article enregistré le " . $donnees[2] . "</div><br/></article>";
                }
                ?>
                Cliquez <a href="" onclick="javascript:ouvre_popup('article/article.xml');">ici</a> pour voir le fichier XML contenant l'article.
                <br/><br/>



                Choisissez un titre et un texte à afficher ci-dessus :
                <br/><br/>
                <form action="articleXML.php" method="post">

                    <label for="titre">Titre : </label>
                    <select name="titre" id="titre">
                        <option value="Un article super !">Un article super !</option>
                        <option value="Voici le titre">Voici le titre</option>
                        <option value="Voici la dernière nouvelle">Voici la dernière nouvelle</option>
                        <option value="De notre correspondant">De notre correspondant</option>
                    </select>
                    <br/>

                    <label for="texte">Texte : </label>
                    <select name="texte" id="texte">
                        <option value="Et bla bla bla.">Et bla bla bla.</option>
                        <option value="Formidable cet exemple.">Formidable cet exemple.</option>
                        <option value="Enfin un truc qui marche.">Enfin un truc qui marche.</option>
                        <option value="Il fait beau temps.">Il fait beau temps.</option>
                        <option value="Le Soleil brille.">Le Soleil brille.</option>
                    </select>
                    <br/>

                    <input type="submit" value="Valider" name="valider" />
                </form>
            </section>

            <script>
                function ouvre_popup(page) {
                    window.open(page, "nom_popup", "menubar=no, status=no, scrollbars=no, menubar=no, width=500, height=500", 'top=10,left=10');
                }
            </script>
        </main>
    </body>
</html>
