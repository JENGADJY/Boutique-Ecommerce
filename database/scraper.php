<?php
require 'vendor/autoload.php';
require 'config/database.php';

use Goutte\Client;

$client = new Client();
$baseUrl = "https://vinylcollector.store/collections/promos"; 
$page = 1;  
$firstPageScraped = false;

while (true) {
    $url = $page === 1 ? $baseUrl : "$baseUrl?page=$page";  
    echo "Scraping de la page : $url\n";

    $crawler = $client->request('GET', $url);

    if ($crawler->filter('.product_card')->count() === 0) {
        echo "Plus de produits trouvés, fin du scraping.\n";
        break; 
    }

    # Récupération des produits sur la page actuelle
    $crawler->filter('.product_card')->each(function ($node) use ($conn) {
        try {
            $name = trim($node->filter('.card__title p')->text());
            $priceText = trim($node->filter('.price__current')->text());
            $price = floatval(str_replace(['€', ','], ['', '.'], $priceText));

            $oldPriceText = $node->filter('.price__compare')->count() ? trim($node->filter('.price__compare')->text()) : null;
            $oldPrice = $oldPriceText ? floatval(str_replace(['€', ','], ['', '.'], $oldPriceText)) : null;

            $image = $node->filter('.card__image img')->attr('src');

            # Vérifier si le produit existe déjà en base
            $stmt = $conn->prepare("SELECT id FROM products WHERE name = ?");
            $stmt->execute([$name]);

            if ($stmt->rowCount() === 0) {
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, "Vinyle en promotion", $price, rand(10, 100), $image]);
                echo "Produit ajouté : $name - $price €\n";
            } else {
                echo "Produit déjà présent : $name\n";
            }
        } catch (Exception $e) {
            echo "Erreur lors du scraping : " . $e->getMessage() . "\n";
        }
    });

    $page++; 
}

echo "Scraping terminé !";
?>
