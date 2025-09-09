<?php
function getCategoryIcon($categoryName) {

    $iconMap = [

    'Homme' => 'fas fa-male',
    'Femme' => 'fas fa-female',
    'Enfant' => 'fas fa-child',
    'Durable' => 'fas fa-leaf',
    'Collaborations' => 'fas fa-handshake',
    
   
    'Vêtements' => 'fas fa-tshirt',
    'Chaussures' => 'fas fa-shoe-prints',
    'Accessoires'=>'bx bx-watch',
    'Sport'=> 'fas fa-running',
    'Équipement outdoor'=> 'fas fa-mountain',
    'Lingerie'=> 'fas fa-tshirt',
    'Maillots de bain'=> 'fas fa-swimmer',
    'Haute Couture'=> 'fas fa-chess-queen',
    'École'=> 'fas fa-school',
    

    'Vestes'=> 'fas fa-user-tie',
    'Hauts'=> 'fas fa-tshirt',
    'Pantalons'=> 'fas fa-pants',
    'Robes'=> 'fas fa-dress',
    'Jupes'=> 'fas fa-skirt',
    'T-shirts'=> 'fas fa-tshirt',
    'Chemises'=> 'fas fa-shirt',
    'Pulls'=> 'fas fa-sweater',
    'Blazers'=> 'fas fa-vest',
    'Vestes en cuir'=> 'fas fa-leather',
    'Short de sport'=> 'fas fa-running',
    
    // Chaussures
    'Paires de ville'=> 'fas fa-shoe-prints',
    'Tennis'=> 'fas fa-shoe-prints',
    'Sandales'=> 'fas fa-shoe-prints',
    'Escarpins'=> 'fas fa-shoe-prints',
    'Baskets'=> 'fas fa-shoe-prints',
    'Bottes'=> 'fas fa-shoe-prints',
    
    // Accessoires
    'Montres'=> 'fas fa-clock',
    'Parfums'=> 'fas fa-spray-can',
    'Ceintures'=> 'fas fa-belt',
    'Chapeaux'=> 'fas fa-hat-cowboy',
    'Cravates'=> 'fas fa-user-tie',
    'Portefeuilles'=> 'fas fa-wallet',
    'Bijoux'=> 'fas fa-gem',
    'Sacs'=> 'fas fa-shopping-bag',
    'Écharpes'=> 'fas fa-mitten',
    'Lunettes'=> 'fas fa-glasses',
    'Colliers'=> 'fas fa-gem',
    'Bracelets'=> 'fas fa-gem',
    'Techwear'=> 'fas fa-microchip',
    
    ];

    // Vérification directe
    if (array_key_exists($categoryName, $iconMap)) {
        return $iconMap[$categoryName];
    }

    // Vérification insensible à la casse
    $lowerName = strtolower($categoryName);
    foreach ($iconMap as $key => $icon) {
        if (strpos($lowerName, strtolower($key)) !== false) {
            return $icon;
        }
    }

    return 'fas fa-tag';
}

?>