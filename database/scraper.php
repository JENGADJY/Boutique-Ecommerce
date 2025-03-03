<?php
require 'vendor/autoload.php';
require 'config/database.php';

use Goutte\Client;

$client = new Client();
$url = "https://vinylcollector.store/collections/promos";  
$crawler = $client->request('GET', $url);

if ($crawler->count() === 0) {
    die("Erreur : Impossible de charger la page !");
}
#Recuperation des données sur le site vinylcollector
$crawler->filter('.product_card')->each(function ($node) use ($conn) {
    try {
        
        $name = trim($node->filter('.card__title p')->text());

        
        $priceText = trim($node->filter('.price__current')->text());
        $price = floatval(str_replace(['€', ','], ['', '.'], $priceText)); 

        $oldPriceText = $node->filter('.price__compare')->count() ? trim($node->filter('.price__compare')->text()) : null;
        $oldPrice = $oldPriceText ? floatval(str_replace(['€', ','], ['', '.'], $oldPriceText)) : null;

        $image = $node->filter('.card__image img')->attr('src');

        

        $stmt = $conn->prepare("SELECT id FROM products WHERE name = ?");
        $stmt->execute([$name]);
        #Insertion des produits dans la db
        if ($stmt->rowCount() === 0) {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, "Vinyle en promotion", $price, rand(10, 100), $image]);
            echo "Produit ajouté : $name - $price €\n";
        } else {
            echo "Produit déjà présent : $name\n";
        }
    } catch (Exception $e) {
        echo " Erreur lors du scraping : " . $e->getMessage() . "\n";
    }
});

echo "Scraping terminé !";
?>
