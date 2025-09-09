<?php

/**
 * Configuration des groupes, secteurs et sous-catégories de la plateforme Afrix.
 * Ce fichier définit la structure hiérarchique complète des groupes, secteurs, et catégories de produits et services,
 * avec des métadonnées (nom, slug, description) pour chaque niveau.
 * Les groupes sont ajoutés pour organiser les secteurs sans modifier les chemins existants.
 * Utilisé pour générer dynamiquement les routes, modèles, contrôleurs, et vues des modules.
 *
 * @return array<string, array>
 */
return [
    'groups' => [
        'technologie_electronique' => [
            'name' => 'Technologie et Électronique',
            'description' => 'Appareils électroniques, solutions technologiques, et équipements de communication et de divertissement.',
            'sectors' => [
                'informatique_electronique',
                'gaming_jeux_videos',
                'cinematographie',
                'electronique_grand_public',
                'securite_electronique',
            ],
        ],
        'maison_mode_vie' => [
            'name' => 'Maison et Mode de Vie',
            'description' => 'Aménagement de la maison, décoration, confort domestique, et mode pour tous les âges.',
            'sectors' => [
                'maison_bureau',
                'mode',
                'mode_enfant',
                'bijouterie',
                'electromenager',
            ],
        ],
        'sante_bien_etre' => [
            'name' => 'Santé et Bien-Être',
            'description' => 'Produits pour la santé, le bien-être physique et mental, et les soins des animaux de compagnie.',
            'sectors' => [
                'sante',
                'beaute_bien_etre',
                'animaux_compagnie',
            ],
        ],
        'education_culture' => [
            'name' => 'Éducation et Culture',
            'description' => 'Ressources pour l’apprentissage, la culture, et la créativité intellectuelle ou artistique.',
            'sectors' => [
                'education',
                'librairie',
                'art_artisanat',
                'musique',
            ],
        ],
        'loisirs_activites_plein_air' => [
            'name' => 'Loisirs et Activités de Plein Air',
            'description' => 'Équipements pour les activités récréatives, sportives, et les voyages.',
            'sectors' => [
                'sport_loisirs',
                'voyage',
                'jardinage',
                'jouets_jeux',
            ],
        ],
        'alimentation_gastronomie' => [
            'name' => 'Alimentation et Gastronomie',
            'description' => 'Produits et équipements pour l’alimentation, la cuisine, et la gastronomie.',
            'sectors' => [
                'supermarche',
                'cuisine_gastronomie',
            ],
        ],
        'construction_bricolage' => [
            'name' => 'Construction et Bricolage',
            'description' => 'Matériel pour la construction, la rénovation, et les travaux manuels.',
            'sectors' => [
                'bricolage',
                'outillage_epi',
                'immobilier',
            ],
        ],
        'energie_solutions_durables' => [
            'name' => 'Énergie et Solutions Durables',
            'description' => 'Solutions pour l’énergie renouvelable et les équipements électriques.',
            'sectors' => [
                'energie_solaire_electrique',
            ],
        ],
        'enfants_maternite' => [
            'name' => 'Enfants et Maternité',
            'description' => 'Produits pour le confort et le bonheur des bébés et jeunes enfants.',
            'sectors' => [
                'enfants_maternite',
            ],
        ],
        'services_evenements' => [
            'name' => 'Services et Événements',
            'description' => 'Services professionnels et produits pour organiser des événements.',
            'sectors' => [
                'services',
                'evenements_festivites',
            ],
        ],
        'automobile' => [
            'name' => 'Automobile',
            'description' => 'Accessoires et pièces pour l’entretien et la personnalisation des véhicules.',
            'sectors' => [
                'automobile',
            ],
        ],
    ],



    'sectors' => [
        'informatique_electronique' => [
            'name' => 'Informatique et Électronique',
            'slug' => 'informatique-electronique',
            'description' => 'Solutions technologiques modernes pour la maison, le bureau, et les entreprises, avec une touche d’innovation africaine.',
            'subcategories' => [
                'telephones_tablettes' => [
                    'name' => 'Téléphones et Tablettes',
                    'slug' => 'telephones-tablettes',
                    'description' => 'Smartphones, tablettes, et accessoires pour une connectivité optimale et un style de vie numérique.',
                    'subcategories' => [
                        'smartphones_par_marques' => [
                            'name' => 'Smartphones par Marques',
                            'slug' => 'smartphones-par-marques',
                            'description' => 'Smartphones de marques renommées (Samsung, Apple, Huawei, etc.) pour tous les budgets.',
                        ],
                        'accessoires_telephones' => [
                            'name' => 'Accessoires Téléphones',
                            'slug' => 'accessoires-telephones',
                            'description' => 'Coques, chargeurs, écouteurs sans fil, et protections d’écran pour personnaliser et protéger vos appareils.',
                        ],
                        'tablettes' => [
                            'name' => 'Tablettes',
                            'slug' => 'tablettes',
                            'description' => 'Tablettes tactiles pour l’éducation, le travail, et le divertissement, adaptées à tous les âges.',
                        ],
                        'telephones_fixes' => [
                            'name' => 'Téléphones Fixes',
                            'slug' => 'telephones-fixes',
                            'description' => 'Téléphones fixes modernes et fiables pour la maison ou les bureaux professionnels.',
                        ],
                        'smartwatches' => [
                            'name' => 'Montres Connectées',
                            'slug' => 'smartwatches',
                            'description' => 'Montres intelligentes pour le suivi de la santé, des notifications, et un style moderne.',
                        ],
                        'accessoires_tablettes' => [
                            'name' => 'Accessoires Tablettes',
                            'slug' => 'accessoires-tablettes',
                            'description' => 'Claviers, stylets, et housses pour optimiser l’utilisation des tablettes.',
                        ],
                    ],
                ],
                'ordinateurs' => [
                    'name' => 'Ordinateurs',
                    'slug' => 'ordinateurs',
                    'description' => 'Ordinateurs portables, de bureau, et accessoires pour répondre aux besoins professionnels et personnels.',
                    'subcategories' => [
                        'ordinateurs_portables' => [
                            'name' => 'Ordinateurs Portables',
                            'slug' => 'ordinateurs-portables',
                            'description' => 'Laptops puissants pour le travail, les études, ou le gaming.',
                        ],
                        'ordinateurs_de_bureau' => [
                            'name' => 'Ordinateurs de Bureau',
                            'slug' => 'ordinateurs-de-bureau',
                            'description' => 'PC fixes pour des performances élevées, idéaux pour les bureaux et les gamers.',
                        ],
                        'peripheriques_accessoires' => [
                            'name' => 'Périphériques et Accessoires',
                            'slug' => 'peripheriques-accessoires',
                            'description' => 'Claviers ergonomiques, souris, écrans LED, et webcams pour une expérience utilisateur optimale.',
                        ],
                        'stockage_de_donnees' => [
                            'name' => 'Stockage de Données',
                            'slug' => 'stockage-de-donnees',
                            'description' => 'Disques durs externes, SSD, clés USB, et cartes mémoire pour sécuriser vos données.',
                        ],
                        'composants_pc' => [
                            'name' => 'Composants PC',
                            'slug' => 'composants-pc',
                            'description' => 'Cartes graphiques, processeurs, RAM, et cartes mères pour assembler ou améliorer votre PC.',
                        ],
                        'logiciels' => [
                            'name' => 'Logiciels',
                            'slug' => 'logiciels',
                            'description' => 'Systèmes d’exploitation, logiciels de bureautique, et antivirus pour une productivité accrue.',
                        ],
                    ],
                ],
                'imprimantes_scanners' => [
                    'name' => 'Imprimantes et Scanners',
                    'slug' => 'imprimantes-scanners',
                    'description' => 'Solutions d’impression et de numérisation pour les bureaux et les particuliers.',
                    'subcategories' => [
                        'imprimantes' => [
                            'name' => 'Imprimantes',
                            'slug' => 'imprimantes',
                            'description' => 'Imprimantes jet d’encre, laser, et multifonctions pour un usage domestique ou professionnel.',
                        ],
                        'scanners' => [
                            'name' => 'Scanners',
                            'slug' => 'scanners',
                            'description' => 'Scanners à plat ou portables pour numériser documents et photos.',
                        ],
                        'consommables_impression' => [
                            'name' => 'Consommables Impression',
                            'slug' => 'consommables-impression',
                            'description' => 'Cartouches d’encre, toners, et papier pour imprimantes.',
                        ],
                    ],
                ],
                'reseau_telecom' => [
                    'name' => 'Réseau et Télécom',
                    'slug' => 'reseau-telecom',
                    'description' => 'Équipements pour une connectivité réseau fiable et des communications fluides.',
                    'subcategories' => [
                        'communication' => [
                            'name' => 'Communication',
                            'slug' => 'communication',
                            'description' => 'Téléphones VoIP, interphones, et systèmes de communication d’entreprise.',
                        ],
                        'connectiques_wifi' => [
                            'name' => 'Connectiques et WiFi',
                            'slug' => 'connectiques-wifi',
                            'description' => 'Routeurs WiFi, câbles Ethernet, et adaptateurs pour une connexion optimale.',
                        ],
                        'solutions_telephoniques' => [
                            'name' => 'Solutions Téléphoniques',
                            'slug' => 'solutions-telephoniques',
                            'description' => 'Systèmes de téléphonie IP et PBX pour entreprises.',
                        ],
                        'modems' => [
                            'name' => 'Modems',
                            'slug' => 'modems',
                            'description' => 'Modems 4G/5G pour une connexion Internet rapide.',
                        ],
                        'amplificateurs_signal' => [
                            'name' => 'Amplificateurs de Signal',
                            'slug' => 'amplificateurs-signal',
                            'description' => 'Amplificateurs pour améliorer la réception WiFi et cellulaire.',
                        ],
                    ],
                ],
                'audio_hifi' => [
                    'name' => 'Audio Hi-Fi',
                    'slug' => 'audio-hifi',
                    'description' => 'Équipements audio de haute qualité pour une expérience sonore exceptionnelle.',
                    'subcategories' => [
                        'enceintes' => [
                            'name' => 'Enceintes',
                            'slug' => 'enceintes',
                            'description' => 'Enceintes Bluetooth, home cinéma, et systèmes Hi-Fi.',
                        ],
                        'casques_audio' => [
                            'name' => 'Casques Audio',
                            'slug' => 'casques-audio',
                            'description' => 'Casques filaires et sans fil pour musique et appels.',
                        ],
                        'microphones' => [
                            'name' => 'Microphones',
                            'slug' => 'microphones',
                            'description' => 'Microphones pour enregistrement, streaming, et karaoké.',
                        ],
                        'amplificateurs_audio' => [
                            'name' => 'Amplificateurs Audio',
                            'slug' => 'amplificateurs-audio',
                            'description' => 'Amplificateurs pour systèmes audio domestiques et professionnels.',
                        ],
                    ],
                ],
                'televiseurs' => [
                    'name' => 'Téléviseurs',
                    'slug' => 'televiseurs',
                    'description' => 'Téléviseurs modernes pour un divertissement immersif à la maison.',
                    'subcategories' => [
                        'televiseurs_led' => [
                            'name' => 'Téléviseurs LED',
                            'slug' => 'televiseurs-led',
                            'description' => 'Téléviseurs LED pour une qualité d’image éclatante.',
                        ],
                        'televiseurs_oled' => [
                            'name' => 'Téléviseurs OLED',
                            'slug' => 'televiseurs-oled',
                            'description' => 'Téléviseurs OLED pour des couleurs vibrantes et un contraste élevé.',
                        ],
                        'projecteurs' => [
                            'name' => 'Projecteurs',
                            'slug' => 'projecteurs',
                            'description' => 'Projecteurs pour home cinéma et présentations professionnelles.',
                        ],
                    ],
                ],
               
                'accessoires_tv' => [
                    'name' => 'Accessoires TV',
                    'slug' => 'accessoires-tv',
                    'description' => 'Accessoires pour améliorer votre expérience télévisuelle.',
                    'subcategories' => [
                        'supports_tv' => [
                            'name' => 'Supports TV',
                            'slug' => 'supports-tv',
                            'description' => 'Supports muraux et pieds pour téléviseurs.',
                        ],
                        'cables_connectiques' => [
                            'name' => 'Câbles et Connectiques',
                            'slug' => 'cables-connectiques',
                            'description' => 'Câbles HDMI, adaptateurs, et connecteurs pour TV.',
                        ],
                        'telecommandes' => [
                            'name' => 'Télécommandes',
                            'slug' => 'telecommandes',
                            'description' => 'Télécommandes universelles et spécifiques pour téléviseurs.',
                        ],
                    ],
                ],
            ],
        ],
        'electromenager' => [
            'name' => 'Électroménager',
            'slug' => 'electromenager',
            'description' => 'Appareils modernes pour simplifier la vie quotidienne à la maison.',
            'subcategories' => [
                'gros_electromenager' => [
                    'name' => 'Gros Électroménager',
                    'slug' => 'gros-electromenager',
                    'description' => 'Appareils essentiels pour équiper cuisines et buanderies.',
                    'subcategories' => [
                        'refrigerateurs_congelateurs' => [
                            'name' => 'Réfrigérateurs et Congélateurs',
                            'slug' => 'refrigerateurs-congelateurs',
                            'description' => 'Réfrigérateurs et congélateurs pour une conservation optimale des aliments.',
                        ],
                        'gazinieres_plaques' => [
                            'name' => 'Gazinières et Plaques',
                            'slug' => 'gazinieres-plaques',
                            'description' => 'Cuisinières à gaz, électriques, et plaques de cuisson modernes.',
                        ],
                        'machines_laver_secher' => [
                            'name' => 'Machines à Laver et Sèche-linge',
                            'slug' => 'machines-laver-secher',
                            'description' => 'Lave-linges et sèche-linges pour un entretien facile du linge.',
                        ],
                        'climatiseurs_ventilateurs' => [
                            'name' => 'Climatiseurs et Ventilateurs',
                            'slug' => 'climatiseurs-ventilateurs',
                            'description' => 'Climatiseurs et ventilateurs pour un confort thermique toute l’année.',
                        ],
                        'lave_vaisselle' => [
                            'name' => 'Lave-vaisselle',
                            'slug' => 'lave-vaisselle',
                            'description' => 'Lave-vaisselle pour une vaisselle impeccable sans effort.',
                        ],
                        'fours_encastrables' => [
                            'name' => 'Fours Encastrables',
                            'slug' => 'fours-encastrables',
                            'description' => 'Fours électriques et à gaz pour cuisines modernes.',
                        ],
                    ],
                ],
                'petit_electromenager' => [
                    'name' => 'Petit Électroménager',
                    'slug' => 'petit-electromenager',
                    'description' => 'Petits appareils pratiques pour la cuisine et le ménage.',
                    'subcategories' => [
                        'cuisine_art_de_la_table' => [
                            'name' => 'Cuisine et Art de la Table',
                            'slug' => 'cuisine-art-de-la-table',
                            'description' => 'Ustensiles et appareils pour préparer et servir des repas savoureux.',
                        ],
                        'appareils_menage' => [
                            'name' => 'Appareils Ménage',
                            'slug' => 'appareils-menage',
                            'description' => 'Aspirateurs, fers à repasser, et nettoyeurs vapeur pour un intérieur impeccable.',
                        ],
                        'patisserie_jus' => [
                            'name' => 'Pâtisserie et Jus',
                            'slug' => 'patisserie-jus',
                            'description' => 'Mixeurs, extracteurs de jus, et robots pâtissiers pour des créations gourmandes.',
                        ],
                        'petit_dejeuner' => [
                            'name' => 'Petit Déjeuner',
                            'slug' => 'petit-dejeuner',
                            'description' => 'Cafetières, grille-pains, et bouilloires pour un réveil en douceur.',
                        ],
                        'appareils_cuisson' => [
                            'name' => 'Appareils de Cuisson',
                            'slug' => 'appareils-cuisson',
                            'description' => 'Micro-ondes, friteuses sans huile, et cuiseurs vapeur pour une cuisine variée.',
                        ],
                        'blenders_hachoirs' => [
                            'name' => 'Blenders et Hachoirs',
                            'slug' => 'blenders-hachoirs',
                            'description' => 'Blenders et hachoirs pour smoothies, soupes, et préparations rapides.',
                        ],
                        'transformation' => [
                            'name' => 'Transformation',
                            'slug' => 'transformation',
                            'description' => 'Hachoirs à viande, moulins à café, et autres appareils de transformation alimentaire.',
                        ],
                        'grills_barbecues' => [
                            'name' => 'Grills et Barbecues',
                            'slug' => 'grills-barbecues',
                            'description' => 'Grills électriques et barbecues pour des repas conviviaux.',
                        ],
                    ],
                ],
            ],
        ],
        'mode' => [
            'name' => 'Mode',
            'slug' => 'mode',
            'description' => 'Vêtements, chaussures, et accessoires pour un style africain et international.',
            'subcategories' => [
                'vetements_femme' => [
                    'name' => 'Vêtements Femme',
                    'slug' => 'vetements-femme',
                    'description' => 'Mode féminine alliant élégance africaine et tendances modernes.',
                    'subcategories' => [
                        'couture_africaine' => [
                            'name' => 'Couture Africaine',
                            'slug' => 'couture-africaine',
                            'description' => 'Robes, boubous, et tenues traditionnelles africaines pour femmes.',
                        ],
                        'accessoires_femme' => [
                            'name' => 'Accessoires Femme',
                            'slug' => 'accessoires-femme',
                            'description' => 'Sacs à main, foulards, et bijoux pour compléter votre look.',
                        ],
                        'robes' => [
                            'name' => 'Robes',
                            'slug' => 'robes',
                            'description' => 'Robes de soirée, décontractées, et professionnelles pour toutes les occasions.',
                        ],
                        'hauts' => [
                            'name' => 'Hauts',
                            'slug' => 'hauts',
                            'description' => 'Chemisiers, tops, et tuniques pour femmes.',
                        ],
                        'pantalons_jupes' => [
                            'name' => 'Pantalons et Jupes',
                            'slug' => 'pantalons-jupes',
                            'description' => 'Pantalons, leggings, et jupes pour un style polyvalent.',
                        ],
                    ],
                ],
                'vetements_homme' => [
                    'name' => 'Vêtements Homme',
                    'slug' => 'vetements-homme',
                    'description' => 'Mode masculine moderne et traditionnelle pour toutes les occasions.',
                    'subcategories' => [
                        'accessoires_homme' => [
                            'name' => 'Accessoires Homme',
                            'slug' => 'accessoires-homme',
                            'description' => 'Ceintures, portefeuilles, cravates, et chapeaux pour hommes.',
                        ],
                        'chemises' => [
                            'name' => 'Chemises',
                            'slug' => 'chemises',
                            'description' => 'Chemises formelles et décontractées pour un look soigné.',
                        ],
                        'pantalons' => [
                            'name' => 'Pantalons',
                            'slug' => 'pantalons',
                            'description' => 'Pantalons classiques, jeans, et chinos pour hommes.',
                        ],
                        'costumes' => [
                            'name' => 'Costumes',
                            'slug' => 'costumes',
                            'description' => 'Costumes élégants pour événements et affaires.',
                        ],
                    ],
                ],
                'chaussures_femme' => [
                    'name' => 'Chaussures Femme',
                    'slug' => 'chaussures-femme',
                    'description' => 'Chaussures élégantes et confortables pour toutes les occasions.',
                    'subcategories' => [
                        'talons' => [
                            'name' => 'Talons',
                            'slug' => 'talons',
                            'description' => 'Escarpins et talons hauts pour un style sophistiqué.',
                        ],
                        'baskets' => [
                            'name' => 'Baskets',
                            'slug' => 'baskets',
                            'description' => 'Baskets décontractées et sportives pour femmes.',
                        ],
                        'sandales' => [
                            'name' => 'Sandales',
                            'slug' => 'sandales',
                            'description' => 'Sandales plates et élégantes pour l’été.',
                        ],
                    ],
                ],
                'chaussures_homme' => [
                    'name' => 'Chaussures Homme',
                    'slug' => 'chaussures-homme',
                    'description' => 'Chaussures formelles et décontractées pour un style affirmé.',
                    'subcategories' => [
                        'chaussures_formelles' => [
                            'name' => 'Chaussures Formelles',
                            'slug' => 'chaussures-formelles',
                            'description' => 'Mocassins et chaussures de ville pour hommes.',
                        ],
                        'baskets_homme' => [
                            'name' => 'Baskets Homme',
                            'slug' => 'baskets-homme',
                            'description' => 'Baskets pour un look décontracté et sportif.',
                        ],
                        'sandales_homme' => [
                            'name' => 'Sandales Homme',
                            'slug' => 'sandales-homme',
                            'description' => 'Sandales confortables pour les loisirs.',
                        ],
                    ],
                ],
                'seconde_main' => [
                    'name' => 'Seconde Main',
                    'slug' => 'seconde-main',
                    'description' => 'Vêtements et accessoires d’occasion en excellent état.',
                    'subcategories' => [
                        'vetements_seconde_main' => [
                            'name' => 'Vêtements Seconde Main',
                            'slug' => 'vetements-seconde-main',
                            'description' => 'Vêtements d’occasion pour hommes et femmes.',
                        ],
                        'accessoires_seconde_main' => [
                            'name' => 'Accessoires Seconde Main',
                            'slug' => 'accessoires-seconde-main',
                            'description' => 'Bijoux, sacs, et autres accessoires d’occasion.',
                        ],
                    ],
                ],
            ],
        ],
        'maison_bureau' => [
            'name' => 'Maison et Bureau',
            'slug' => 'maison-bureau',
            'description' => 'Mobilier et accessoires pour créer des espaces de vie et de travail confortables.',
            'subcategories' => [
                'chambre_literie' => [
                    'name' => 'Chambre et Literie',
                    'slug' => 'chambre-literie',
                    'description' => 'Lits, matelas, et accessoires pour des nuits reposantes.',
                    'subcategories' => [
                        'lits' => [
                            'name' => 'Lits',
                            'slug' => 'lits',
                            'description' => 'Lits simples, doubles, et superposés pour tous les espaces.',
                        ],
                        'matelas' => [
                            'name' => 'Matelas',
                            'slug' => 'matelas',
                            'description' => 'Matelas à mémoire de forme, orthopédiques, et classiques.',
                        ],
                        'linge_de_lit' => [
                            'name' => 'Linge de Lit',
                            'slug' => 'linge-de-lit',
                            'description' => 'Draps, housses de couette, et oreillers pour un confort optimal.',
                        ],
                    ],
                ],
                'salle_de_bain' => [
                    'name' => 'Salle de Bain',
                    'slug' => 'salle-de-bain',
                    'description' => 'Équipements et accessoires pour une salle de bain fonctionnelle.',
                    'subcategories' => [
                        'accessoires_salle_de_bain' => [
                            'name' => 'Accessoires Salle de Bain',
                            'slug' => 'accessoires-salle-de-bain',
                            'description' => 'Porte-savons, rideaux de douche, et miroirs.',
                        ],
                        'robinetterie' => [
                            'name' => 'Robinetterie',
                            'slug' => 'robinetterie',
                            'description' => 'Robinets, pommeaux de douche, et mitigeurs.',
                        ],
                        'meubles_salle_de_bain' => [
                            'name' => 'Meubles Salle de Bain',
                            'slug' => 'meubles-salle-de-bain',
                            'description' => 'Meubles de rangement pour salle de bain.',
                        ],
                    ],
                ],
                'salon_salle_a_manger' => [
                    'name' => 'Salon et Salle à Manger',
                    'slug' => 'salon-salle-a-manger',
                    'description' => 'Mobilier pour des espaces de vie conviviaux et élégants.',
                    'subcategories' => [
                        'canapes' => [
                            'name' => 'Canapés',
                            'slug' => 'canapes',
                            'description' => 'Canapés d’angle, convertibles, et classiques.',
                        ],
                        'tables_chaises' => [
                            'name' => 'Tables et Chaises',
                            'slug' => 'tables-chaises',
                            'description' => 'Tables de salle à manger et chaises assorties.',
                        ],
                        'meubles_tv' => [
                            'name' => 'Meubles TV',
                            'slug' => 'meubles-tv',
                            'description' => 'Meubles pour téléviseurs et équipements multimédias.',
                        ],
                    ],
                ],
                'decoration' => [
                    'name' => 'Décoration',
                    'slug' => 'decoration',
                    'description' => 'Articles pour personnaliser et embellir votre intérieur.',
                    'subcategories' => [
                        'decor_saisonnier' => [
                            'name' => 'Décor Saisonnier',
                            'slug' => 'decor-saisonnier',
                            'description' => 'Décorations pour Noël, Ramadan, et autres fêtes.',
                        ],
                        'tapis_rideaux' => [
                            'name' => 'Tapis et Rideaux',
                            'slug' => 'tapis-rideaux',
                            'description' => 'Tapis et rideaux pour un intérieur chaleureux.',
                        ],
                        'objets_decoratifs' => [
                            'name' => 'Objets Décoratifs',
                            'slug' => 'objets-decoratifs',
                            'description' => 'Vases, sculptures, et cadres pour une touche artistique.',
                        ],
                    ],
                ],
                'mobilier_bureau' => [
                    'name' => 'Mobilier de Bureau',
                    'slug' => 'mobilier-bureau',
                    'description' => 'Mobilier ergonomique pour des espaces de travail productifs.',
                    'subcategories' => [
                        'bureaux' => [
                            'name' => 'Bureaux',
                            'slug' => 'bureaux',
                            'description' => 'Bureaux modernes pour le télétravail et les bureaux.',
                        ],
                        'chaises_bureau' => [
                            'name' => 'Chaises de Bureau',
                            'slug' => 'chaises-bureau',
                            'description' => 'Chaises ergonomiques pour un confort prolongé.',
                        ],
                        'rangements_bureau' => [
                            'name' => 'Rangements Bureau',
                            'slug' => 'rangements-bureau',
                            'description' => 'Armoires, étagères, et classeurs pour organiser votre espace.',
                        ],
                    ],
                ],
            ],
        ],
        'securite_electronique' => [
            'name' => 'Sécurité Électronique',
            'slug' => 'securite-electronique',
            'description' => 'Solutions avancées pour protéger votre maison et votre entreprise.',
            'subcategories' => [
                'alarmes_incendie' => [
                    'name' => 'Alarmes Incendie',
                    'slug' => 'alarmes-incendie',
                    'description' => 'Détecteurs de fumée et alarmes incendie pour une sécurité optimale.',
                    'subcategories' => [
                        'detecteurs_fumee' => [
                            'name' => 'Détecteurs de Fumée',
                            'slug' => 'detecteurs-fumee',
                            'description' => 'Dispositifs pour détecter la fumée et prévenir les incendies.',
                        ],
                        'extincteurs' => [
                            'name' => 'Extincteurs',
                            'slug' => 'extincteurs',
                            'description' => 'Extincteurs portatifs pour une intervention rapide.',
                        ],
                    ],
                ],
                'alarmes_antivol' => [
                    'name' => 'Alarmes Antivol',
                    'slug' => 'alarmes-antivol',
                    'description' => 'Systèmes d’alarme pour protéger contre les intrusions.',
                    'subcategories' => [
                        'alarmes_residentielles' => [
                            'name' => 'Alarmes Résidentielles',
                            'slug' => 'alarmes-residentielles',
                            'description' => 'Systèmes d’alarme pour maisons et appartements.',
                        ],
                        'alarmes_commerciales' => [
                            'name' => 'Alarmes Commerciales',
                            'slug' => 'alarmes-commerciales',
                            'description' => 'Solutions de sécurité pour bureaux et commerces.',
                        ],
                    ],
                ],
                'videosurveillance' => [
                    'name' => 'Vidéosurveillance',
                    'slug' => 'videosurveillance',
                    'description' => 'Caméras et systèmes pour surveiller vos espaces en temps réel.',
                    'subcategories' => [
                        'cameras_ip' => [
                            'name' => 'Caméras IP',
                            'slug' => 'cameras-ip',
                            'description' => 'Caméras connectées pour une surveillance à distance.',
                        ],
                        'enregistreurs_video' => [
                            'name' => 'Enregistreurs Vidéo',
                            'slug' => 'enregistreurs-video',
                            'description' => 'DVR et NVR pour stocker les enregistrements vidéo.',
                        ],
                    ],
                ],
                'controle_acces' => [
                    'name' => 'Contrôle d’Accès',
                    'slug' => 'controle-acces',
                    'description' => 'Systèmes pour gérer l’accès aux bâtiments et espaces sécurisés.',
                    'subcategories' => [
                        'lecteurs_biometriques' => [
                            'name' => 'Lecteurs Biométriques',
                            'slug' => 'lecteurs-biometriques',
                            'description' => 'Systèmes à empreintes digitales et reconnaissance faciale.',
                        ],
                        'cartes_acces' => [
                            'name' => 'Cartes d’Accès',
                            'slug' => 'cartes-acces',
                            'description' => 'Cartes RFID et badges pour contrôle d’accès.',
                        ],
                    ],
                ],
                'gps_navigation' => [
                    'name' => 'GPS et Navigation',
                    'slug' => 'gps-navigation',
                    'description' => 'Dispositifs pour la navigation et le suivi en temps réel.',
                    'subcategories' => [
                        'gps_vehicules' => [
                            'name' => 'GPS pour Véhicules',
                            'slug' => 'gps-vehicules',
                            'description' => 'GPS pour voitures et motos avec cartographie détaillée.',
                        ],
                        'trackers_gps' => [
                            'name' => 'Trackers GPS',
                            'slug' => 'trackers-gps',
                            'description' => 'Dispositifs de suivi pour personnes et objets.',
                        ],
                    ],
                ],
                'compteurs_detecteurs' => [
                    'name' => 'Compteurs et Détecteurs',
                    'slug' => 'compteurs-detecteurs',
                    'description' => 'Outils pour la détection et le comptage dans divers contextes.',
                    'subcategories' => [
                        'detecteurs_metal' => [
                            'name' => 'Détecteurs de Métal',
                            'slug' => 'detecteurs-metal',
                            'description' => 'Détecteurs pour la sécurité et la recherche de métaux.',
                        ],
                        'compteurs_energie' => [
                            'name' => 'Compteurs d’Énergie',
                            'slug' => 'compteurs-energie',
                            'description' => 'Compteurs pour mesurer la consommation électrique.',
                        ],
                    ],
                ],
            ],
        ],
        'gaming_jeux_videos' => [
            'name' => 'Gaming et Jeux Vidéo',
            'slug' => 'gaming-jeux-videos',
            'description' => 'Consoles, jeux, et accessoires pour une expérience de gaming immersive.',
            'subcategories' => [
                'playstation' => [
                    'name' => 'PlayStation',
                    'slug' => 'playstation',
                    'description' => 'Consoles PlayStation, jeux, et accessoires associés.',
                    'subcategories' => [
                        'consoles_playstation' => [
                            'name' => 'Consoles PlayStation',
                            'slug' => 'consoles-playstation',
                            'description' => 'PS5, PS4, et éditions spéciales.',
                        ],
                        'jeux_playstation' => [
                            'name' => 'Jeux PlayStation',
                            'slug' => 'jeux-playstation',
                            'description' => 'Jeux vidéo pour PlayStation, neufs et d’occasion.',
                        ],
                    ],
                ],
                'xbox' => [
                    'name' => 'Xbox',
                    'slug' => 'xbox',
                    'description' => 'Consoles Xbox, jeux, et accessoires pour gamers.',
                    'subcategories' => [
                        'consoles_xbox' => [
                            'name' => 'Consoles Xbox',
                            'slug' => 'consoles-xbox',
                            'description' => 'Xbox Series X/S, Xbox One, et bundles.',
                        ],
                        'jeux_xbox' => [
                            'name' => 'Jeux Xbox',
                            'slug' => 'jeux-xbox',
                            'description' => 'Jeux vidéo pour Xbox, tous genres confondus.',
                        ],
                    ],
                ],
                'gaming_pc' => [
                    'name' => 'Gaming PC',
                    'slug' => 'gaming-pc',
                    'description' => 'PC et composants pour des performances gaming optimales.',
                    'subcategories' => [
                        'pc_gaming' => [
                            'name' => 'PC Gaming',
                            'slug' => 'pc-gaming',
                            'description' => 'Ordinateurs pré-assemblés pour le gaming.',
                        ],
                        'composants_gaming' => [
                            'name' => 'Composants Gaming',
                            'slug' => 'composants-gaming',
                            'description' => 'Cartes graphiques, processeurs, et refroidisseurs pour PC gaming.',
                        ],
                    ],
                ],
                'nintendo' => [
                    'name' => 'Nintendo',
                    'slug' => 'nintendo',
                    'description' => 'Consoles Nintendo et jeux pour tous les âges.',
                    'subcategories' => [
                        'consoles_nintendo' => [
                            'name' => 'Consoles Nintendo',
                            'slug' => 'consoles-nintendo',
                            'description' => 'Nintendo Switch, 3DS, et éditions limitées.',
                        ],
                        'jeux_nintendo' => [
                            'name' => 'Jeux Nintendo',
                            'slug' => 'jeux-nintendo',
                            'description' => 'Jeux vidéo pour Nintendo, familiaux et aventureux.',
                        ],
                    ],
                ],
                'accessoires_gaming' => [
                    'name' => 'Accessoires Gaming',
                    'slug' => 'accessoires-gaming',
                    'description' => 'Manettes, casques, et sièges gaming pour une immersion totale.',
                    'subcategories' => [
                        'manettes' => [
                            'name' => 'Manettes',
                            'slug' => 'manettes',
                            'description' => 'Manettes pour consoles et PC.',
                        ],
                        'casques_gaming' => [
                            'name' => 'Casques Gaming',
                            'slug' => 'casques-gaming',
                            'description' => 'Casques avec micro pour une communication claire.',
                        ],
                        'sieges_gaming' => [
                            'name' => 'Sièges Gaming',
                            'slug' => 'sieges-gaming',
                            'description' => 'Chaises ergonomiques pour longues sessions de jeu.',
                        ],
                    ],
                ],
            ],
        ],
        'supermarche' => [
            'name' => 'Supermarché',
            'slug' => 'supermarche',
            'description' => 'Produits essentiels pour le quotidien, de l’alimentation à l’entretien.',
            'subcategories' => [
                'alimentation' => [
                    'name' => 'Alimentation',
                    'slug' => 'alimentation',
                    'description' => 'Produits alimentaires frais, secs, et boissons pour toute la famille.',
                    'subcategories' => [
                        'produits_frais' => [
                            'name' => 'Produits Frais',
                            'slug' => 'produits-frais',
                            'description' => 'Fruits, légumes, viandes, poissons, et produits laitiers.',
                        ],
                        'produits_secs' => [
                            'name' => 'Produits Secs',
                            'slug' => 'produits-secs',
                            'description' => 'Céréales, pâtes, riz, et conserves pour le garde-manger.',
                        ],
                        'boissons' => [
                            'name' => 'Boissons',
                            'slug' => 'boissons',
                            'description' => 'Eau, jus, sodas, thés, et boissons traditionnelles africaines.',
                        ],
                        'snacks_confiseries' => [
                            'name' => 'Snacks et Confiseries',
                            'slug' => 'snacks-confiseries',
                            'description' => 'Biscuits, bonbons, et snacks pour petits et grands.',
                        ],
                        'produits_bio' => [
                            'name' => 'Produits Bio',
                            'slug' => 'produits-bio',
                            'description' => 'Aliments biologiques et naturels pour une alimentation saine.',
                        ],
                    ],
                ],
                'produits_entretien' => [
                    'name' => 'Produits d’Entretien',
                    'slug' => 'produits-entretien',
                    'description' => 'Produits pour nettoyer et entretenir votre maison.',
                    'subcategories' => [
                        'detergents' => [
                            'name' => 'Détergents',
                            'slug' => 'detergents',
                            'description' => 'Détergents pour sols, vaisselle, et linge.',
                        ],
                        'accessoires_nettoyage' => [
                            'name' => 'Accessoires de Nettoyage',
                            'slug' => 'accessoires-nettoyage',
                            'description' => 'Balais, serpillières, et éponges pour un ménage efficace.',
                        ],
                    ],
                ],
                'hygiene_personnelle' => [
                    'name' => 'Hygiène Personnelle',
                    'slug' => 'hygiene-personnelle',
                    'description' => 'Produits pour l’hygiène corporelle et le soin quotidien.',
                    'subcategories' => [
                        'soins_corps' => [
                            'name' => 'Soins du Corps',
                            'slug' => 'soins-corps',
                            'description' => 'Savons, gels douche, et lotions corporelles.',
                        ],
                        'hygiene_bucco_dentaire' => [
                            'name' => 'Hygiène Bucco-Dentaire',
                            'slug' => 'hygiene-bucco-dentaire',
                            'description' => 'Brosses à dents, dentifrices, et bains de bouche.',
                        ],
                        'produits_intimes' => [
                            'name' => 'Produits Intimes',
                            'slug' => 'produits-intimes',
                            'description' => 'Produits pour l’hygiène intime féminine et masculine.',
                        ],
                    ],
                ],
            ],
        ],
        'beaute_bien_etre' => [
            'name' => 'Beauté et Bien-Être',
            'slug' => 'beaute-bien-etre',
            'description' => 'Produits pour sublimer votre beauté et améliorer votre bien-être.',
            'subcategories' => [
                'soins_visage' => [
                    'name' => 'Soins du Visage',
                    'slug' => 'soins-visage',
                    'description' => 'Crèmes, masques, et nettoyants pour une peau éclatante.',
                    'subcategories' => [
                        'cremes_hydratantes' => [
                            'name' => 'Crèmes Hydratantes',
                            'slug' => 'cremes-hydratantes',
                            'description' => 'Crèmes pour hydrater et protéger le visage.',
                        ],
                        'masques_visage' => [
                            'name' => 'Masques Visage',
                            'slug' => 'masques-visage',
                            'description' => 'Masques pour purifier et revitaliser la peau.',
                        ],
                        'nettoyants_visage' => [
                            'name' => 'Nettoyants Visage',
                            'slug' => 'nettoyants-visage',
                            'description' => 'Gels et mousses pour nettoyer la peau en profondeur.',
                        ],
                    ],
                ],
                'soins_cheveux' => [
                    'name' => 'Soins des Cheveux',
                    'slug' => 'soins-cheveux',
                    'description' => 'Produits pour des cheveux sains et brillants.',
                    'subcategories' => [
                        'shampoings' => [
                            'name' => 'Shampoings',
                            'slug' => 'shampoings',
                            'description' => 'Shampoings pour tous types de cheveux.',
                        ],
                        'apres_shampoings' => [
                            'name' => 'Après-Shampoings',
                            'slug' => 'apres-shampoings',
                            'description' => 'Après-shampoings pour nourrir et démêler les cheveux.',
                        ],
                        'huiles_capillaires' => [
                            'name' => 'Huiles Capillaires',
                            'slug' => 'huiles-capillaires',
                            'description' => 'Huiles pour renforcer et hydrater les cheveux.',
                        ],
                    ],
                ],
                'maquillage' => [
                    'name' => 'Maquillage',
                    'slug' => 'maquillage',
                    'description' => 'Produits de maquillage pour tous les styles et teints.',
                    'subcategories' => [
                        'fond_de_teint' => [
                            'name' => 'Fond de Teint',
                            'slug' => 'fond-de-teint',
                            'description' => 'Fonds de teint pour une couvrance parfaite.',
                        ],
                        'rouges_a_levres' => [
                            'name' => 'Rouges à Lèvres',
                            'slug' => 'rouges-a-levres',
                            'description' => 'Rouges à lèvres pour toutes les occasions.',
                        ],
                        'maquillage_yeux' => [
                            'name' => 'Maquillage Yeux',
                            'slug' => 'maquillage-yeux',
                            'description' => 'Mascaras, eyeliners, et ombres à paupières.',
                        ],
                    ],
                ],
                'parfums' => [
                    'name' => 'Parfums',
                    'slug' => 'parfums',
                    'description' => 'Parfums pour hommes et femmes, aux senteurs uniques.',
                    'subcategories' => [
                        'parfums_femme' => [
                            'name' => 'Parfums Femme',
                            'slug' => 'parfums-femme',
                            'description' => 'Eaux de parfum et eaux de toilette pour femmes.',
                        ],
                        'parfums_homme' => [
                            'name' => 'Parfums Homme',
                            'slug' => 'parfums-homme',
                            'description' => 'Parfums masculins pour un style affirmé.',
                        ],
                    ],
                ],
                'produits_bien_etre' => [
                    'name' => 'Produits Bien-Être',
                    'slug' => 'produits-bien-etre',
                    'description' => 'Produits pour la relaxation et le bien-être personnel.',
                    'subcategories' => [
                        'huiles_essentielles' => [
                            'name' => 'Huiles Essentielles',
                            'slug' => 'huiles-essentielles',
                            'description' => 'Huiles pour aromathérapie et massages.',
                        ],
                        'diffuseurs' => [
                            'name' => 'Diffuseurs',
                            'slug' => 'diffuseurs',
                            'description' => 'Diffuseurs pour huiles essentielles et ambiance.',
                        ],
                        'accessoires_massage' => [
                            'name' => 'Accessoires de Massage',
                            'slug' => 'accessoires-massage',
                            'description' => 'Appareils et outils pour massages relaxants.',
                        ],
                    ],
                ],
            ],
        ],
        'cinematographie' => [
            'name' => 'Cinématographie',
            'slug' => 'cinematographie',
            'description' => 'Équipements pour capturer et créer des contenus visuels époustouflants.',
            'subcategories' => [
                'appareils_photo' => [
                    'name' => 'Appareils Photo',
                    'slug' => 'appareils-photo',
                    'description' => 'Appareils photo reflex, compacts, et hybrides pour tous les niveaux.',
                    'subcategories' => [
                        'reflex' => [
                            'name' => 'Appareils Reflex',
                            'slug' => 'reflex',
                            'description' => 'Appareils photo reflex pour photographes professionnels.',
                        ],
                        'compacts' => [
                            'name' => 'Appareils Compacts',
                            'slug' => 'compacts',
                            'description' => 'Appareils photo compacts pour une utilisation quotidienne.',
                        ],
                    ],
                ],
                'cameras' => [
                    'name' => 'Caméras',
                    'slug' => 'cameras',
                    'description' => 'Caméras vidéo pour films, vlogs, et productions professionnelles.',
                    'subcategories' => [
                        'cameras_professionnelles' => [
                            'name' => 'Caméras Professionnelles',
                            'slug' => 'cameras-professionnelles',
                            'description' => 'Caméras pour tournages professionnels et cinématographiques.',
                        ],
                        'action_cams' => [
                            'name' => 'Action Cams',
                            'slug' => 'action-cams',
                            'description' => 'Caméras d’action pour sports et aventures.',
                        ],
                    ],
                ],
                'materiels_observation' => [
                    'name' => 'Matériels d’Observation',
                    'slug' => 'materiels-observation',
                    'description' => 'Télescopes et jumelles pour l’observation et l’exploration.',
                    'subcategories' => [
                        'telescopes' => [
                            'name' => 'Télescopes',
                            'slug' => 'telescopes',
                            'description' => 'Télescopes pour l’astronomie et l’observation terrestre.',
                        ],
                        'jumelles' => [
                            'name' => 'Jumelles',
                            'slug' => 'jumelles',
                            'description' => 'Jumelles pour la chasse, le camping, et l’observation.',
                        ],
                    ],
                ],
                'accessoires_photo_video' => [
                    'name' => 'Accessoires Photo et Vidéo',
                    'slug' => 'accessoires-photo-video',
                    'description' => 'Accessoires pour optimiser vos prises de vue.',
                    'subcategories' => [
                        'trepieds' => [
                            'name' => 'Trépieds',
                            'slug' => 'trepieds',
                            'description' => 'Trépieds et monopodes pour photos et vidéos stables.',
                        ],
                        'objectifs' => [
                            'name' => 'Objectifs',
                            'slug' => 'objectifs',
                            'description' => 'Objectifs pour appareils photo reflex et hybrides.',
                        ],
                        'sacs_photo' => [
                            'name' => 'Sacs Photo',
                            'slug' => 'sacs-photo',
                            'description' => 'Sacs pour transporter appareils et accessoires.',
                        ],
                    ],
                ],
            ],
        ],
        'enfants_maternite' => [
            'name' => 'Enfants et Maternité',
            'slug' => 'enfants-maternite',
            'description' => 'Produits pour le confort et le bonheur des bébés et jeunes enfants.',
            'subcategories' => [
                'vetements_bebe' => [
                    'name' => 'Vêtements Bébé',
                    'slug' => 'vetements-bebe',
                    'description' => 'Vêtements doux et sécurisés pour nourrissons et bébés.',
                    'subcategories' => [
                        'bodies' => [
                            'name' => 'Bodies',
                            'slug' => 'bodies',
                            'description' => 'Bodies en coton pour bébés.',
                        ],
                        'pyjamas_bebe' => [
                            'name' => 'Pyjamas Bébé',
                            'slug' => 'pyjamas-bebe',
                            'description' => 'Pyjamas confortables pour un sommeil paisible.',
                        ],
                    ],
                ],
                'jouets' => [
                    'name' => 'Jouets',
                    'slug' => 'jouets',
                    'description' => 'Jouets éducatifs et ludiques pour enfants de tous âges.',
                    'subcategories' => [
                        'jouets_premier_age' => [
                            'name' => 'Jouets Premier Âge',
                            'slug' => 'jouets-premier-age',
                            'description' => 'Jouets pour stimuler les nourrissons.',
                        ],
                        'jouets_construction' => [
                            'name' => 'Jouets de Construction',
                            'slug' => 'jouets-construction',
                            'description' => 'Blocs et jeux de construction pour la créativité.',
                        ],
                    ],
                ],
                'poussettes_sieges' => [
                    'name' => 'Poussettes et Sièges',
                    'slug' => 'poussettes-sieges',
                    'description' => 'Poussettes et sièges auto pour la sécurité des enfants.',
                    'subcategories' => [
                        'poussettes' => [
                            'name' => 'Poussettes',
                            'slug' => 'poussettes',
                            'description' => 'Poussettes légères et tout-terrain.',
                        ],
                        'sieges_auto' => [
                            'name' => 'Sièges Auto',
                            'slug' => 'sieges-auto',
                            'description' => 'Sièges auto sécurisés pour bébés et enfants.',
                        ],
                    ],
                ],
                'puericulture' => [
                    'name' => 'Puériculture',
                    'slug' => 'puericulture',
                    'description' => 'Produits essentiels pour les soins des bébés.',
                    'subcategories' => [
                        'biberons' => [
                            'name' => 'Biberons',
                            'slug' => 'biberons',
                            'description' => 'Biberons et accessoires pour l’alimentation des bébés.',
                        ],
                        'chaises_hautes' => [
                            'name' => 'Chaises Hautes',
                            'slug' => 'chaises-hautes',
                            'description' => 'Chaises hautes pour les repas des bébés.',
                        ],
                        'soins_bebe' => [
                            'name' => 'Soins Bébé',
                            'slug' => 'soins-bebe',
                            'description' => 'Produits pour l’hygiène et le soin des bébés.',
                        ],
                    ],
                ],
            ],
        ],
        'librairie' => [
            'name' => 'Librairie',
            'slug' => 'librairie',
            'description' => 'Livres et fournitures pour l’éducation, la culture, et le divertissement.',
            'subcategories' => [
                'livres_scolaires' => [
                    'name' => 'Livres Scolaires',
                    'slug' => 'livres-scolaires',
                    'description' => 'Manuels scolaires pour tous les niveaux éducatifs.',
                    'subcategories' => [
                        'primaires' => [
                            'name' => 'Livres Primaires',
                            'slug' => 'livres-primaires',
                            'description' => 'Manuels pour l’enseignement primaire.',
                        ],
                        'secondaires' => [
                            'name' => 'Livres Secondaires',
                            'slug' => 'livres-secondaires',
                            'description' => 'Manuels pour collèges et lycées.',
                        ],
                    ],
                ],
                'romans_litterature' => [
                    'name' => 'Romans et Littérature',
                    'slug' => 'romans-litterature',
                    'description' => 'Romans, poésie, et œuvres littéraires africaines et internationales.',
                    'subcategories' => [
                        'romans_contemporains' => [
                            'name' => 'Romans Contemporains',
                            'slug' => 'romans-contemporains',
                            'description' => 'Romans modernes et best-sellers.',
                        ],
                        'litterature_africaine' => [
                            'name' => 'Littérature Africaine',
                            'slug' => 'litterature-africaine',
                            'description' => 'Œuvres littéraires par des auteurs africains.',
                        ],
                    ],
                ],
                'livres_techniques' => [
                    'name' => 'Livres Techniques',
                    'slug' => 'livres-techniques',
                    'description' => 'Livres pour la formation professionnelle et technique.',
                    'subcategories' => [
                        'informatique' => [
                            'name' => 'Livres Informatique',
                            'slug' => 'livres-informatique',
                            'description' => 'Livres sur la programmation et les technologies.',
                        ],
                        'ingenierie' => [
                            'name' => 'Livres Ingénierie',
                            'slug' => 'livres-ingenierie',
                            'description' => 'Manuels pour l’ingénierie et les sciences.',
                        ],
                    ],
                ],
                'papeterie' => [
                    'name' => 'Papeterie',
                    'slug' => 'papeterie',
                    'description' => 'Fournitures pour l’école et le bureau.',
                    'subcategories' => [
                        'cahiers' => [
                            'name' => 'Cahiers',
                            'slug' => 'cahiers',
                            'description' => 'Cahiers pour notes et devoirs scolaires.',
                        ],
                        'stylos' => [
                            'name' => 'Stylos',
                            'slug' => 'stylos',
                            'description' => 'Stylos, crayons, et marqueurs pour l’écriture.',
                        ],
                        'sacs_scolaires' => [
                            'name' => 'Sacs Scolaires',
                            'slug' => 'sacs-scolaires',
                            'description' => 'Sacs à dos et cartables pour étudiants.',
                        ],
                    ],
                ],
            ],
        ],
        'energie_solaire_electrique' => [
            'name' => 'Énergie Solaire et Électrique',
            'slug' => 'energie-solaire-electrique',
            'description' => 'Solutions durables pour l’énergie domestique et commerciale.',
            'subcategories' => [
                'panneaux_solaires' => [
                    'name' => 'Panneaux Solaires',
                    'slug' => 'panneaux-solaires',
                    'description' => 'Panneaux solaires pour une énergie propre et renouvelable.',
                    'subcategories' => [
                        'panneaux_monocristallins' => [
                            'name' => 'Panneaux Monocristallins',
                            'slug' => 'panneaux-monocristallins',
                            'description' => 'Panneaux solaires monocristallins à haute efficacité.',
                        ],
                        'panneaux_polycristallins' => [
                            'name' => 'Panneaux Polycristallins',
                            'slug' => 'panneaux-polycristallins',
                            'description' => 'Panneaux solaires polycristallins économiques.',
                        ],
                    ],
                ],
                'batteries' => [
                    'name' => 'Batteries',
                    'slug' => 'batteries',
                    'description' => 'Batteries pour stocker l’énergie solaire et électrique.',
                    'subcategories' => [
                        'batteries_lithium' => [
                            'name' => 'Batteries Lithium',
                            'slug' => 'batteries-lithium',
                            'description' => 'Batteries lithium-ion pour une longue durée de vie.',
                        ],
                        'batteries_plomb' => [
                            'name' => 'Batteries Plomb',
                            'slug' => 'batteries-plomb',
                            'description' => 'Batteries au plomb pour applications solaires.',
                        ],
                    ],
                ],
                'onduleurs' => [
                    'name' => 'Onduleurs',
                    'slug' => 'onduleurs',
                    'description' => 'Onduleurs pour convertir l’énergie solaire en électricité utilisable.',
                    'subcategories' => [
                        'onduleurs_ondes_pures' => [
                            'name' => 'Onduleurs à Ondes Pures',
                            'slug' => 'onduleurs-ondes-pures',
                            'description' => 'Onduleurs à ondes sinusoïdales pures pour appareils sensibles.',
                        ],
                        'onduleurs_hybrides' => [
                            'name' => 'Onduleurs Hybrides',
                            'slug' => 'onduleurs-hybrides',
                            'description' => 'Onduleurs pour systèmes solaires et réseaux électriques.',
                        ],
                    ],
                ],
                'equipements_electriques' => [
                    'name' => 'Équipements Électriques',
                    'slug' => 'equipements-electriques',
                    'description' => 'Câbles, prises, et accessoires pour installations électriques.',
                    'subcategories' => [
                        'cables_electriques' => [
                            'name' => 'Câbles Électriques',
                            'slug' => 'cables-electriques',
                            'description' => 'Câbles pour installations solaires et électriques.',
                        ],
                        'prises_interrupteurs' => [
                            'name' => 'Prises et Interrupteurs',
                            'slug' => 'prises-interrupteurs',
                            'description' => 'Prises et interrupteurs pour la maison et le bureau.',
                        ],
                    ],
                ],
                'sources_lumineuses' => [
                    'name' => 'Sources Lumineuses',
                    'slug' => 'sources-lumineuses',
                    'description' => 'Ampoules, Lampadaires, et accessoires pour installations lumineuses.',
                    'subcategories' => [
                        'ampoules_led' =>[ 'Ampoules LED' ],
                        'ampoules_halogenes' => [ 'Ampoules Halogènes' ],
                        'ampoules_fluorescentes' =>[ 'Ampoules Fluorescentes'],
                        'ampoules_incandescentes' =>[ 'Ampoules Incandescentes'],
                        'lampes_solaires' => ['Lampes Solaires'],
                        'tubes_led' => ['Tubes LED'],
                        'projecteurs' => ['Projecteurs'],


                    ],
                ],
            ],
        ],
        'outillage_epi' => [
            'name' => 'Outillage et EPI',
            'slug' => 'outillage-epi',
            'description' => 'Outils et équipements pour les travaux manuels et la sécurité.',
            'subcategories' => [
                'outillage_electroportatif' => [
                    'name' => 'Outillage Électroportatif',
                    'slug' => 'outillage-electroportatif',
                    'description' => 'Perceuses, scies, et ponceuses pour travaux professionnels.',
                    'subcategories' => [
                        'perceuses' => [
                            'name' => 'Perceuses',
                            'slug' => 'perceuses',
                            'description' => 'Perceuses sans fil et filaires pour tous matériaux.',
                        ],
                        'scies_electriques' => [
                            'name' => 'Scies Électriques',
                            'slug' => 'scies-electriques',
                            'description' => 'Scies sauteuses, circulaires, et à onglets.',
                        ],
                    ],
                ],
                'outillage_stationnaire' => [
                    'name' => 'Outillage Stationnaire',
                    'slug' => 'outillage-stationnaire',
                    'description' => 'Machines fixes pour ateliers et chantiers.',
                    'subcategories' => [
                        'scies_stationnaires' => [
                            'name' => 'Scies Stationnaires',
                            'slug' => 'scies-stationnaires',
                            'description' => 'Scies à ruban et scies sur table.',
                        ],
                        'tours' => [
                            'name' => 'Tours',
                            'slug' => 'tours',
                            'description' => 'Tours pour le travail du bois et du métal.',
                        ],
                    ],
                ],
                'outillage_main' => [
                    'name' => 'Outillage à Main',
                    'slug' => 'outillage-main',
                    'description' => 'Outils manuels pour travaux précis et quotidiens.',
                    'subcategories' => [
                        'tournevis' => [
                            'name' => 'Tournevis',
                            'slug' => 'tournevis',
                            'description' => 'Tournevis plats, cruciformes, et sets complets.',
                        ],
                        'marteaux' => [
                            'name' => 'Marteaux',
                            'slug' => 'marteaux',
                            'description' => 'Marteaux pour clouage et démolition.',
                        ],
                    ],
                ],
                'materiel_chantier' => [
                    'name' => 'Matériel de Chantier',
                    'slug' => 'materiel-chantier',
                    'description' => 'Équipements pour la construction et les travaux publics.',
                    'subcategories' => [
                        'betonnières' => [
                            'name' => 'Bétonnières',
                            'slug' => 'betonnieres',
                            'description' => 'Bétonnières pour mélanger le béton sur chantier.',
                        ],
                        'échafaudages' => [
                            'name' => 'Échafaudages',
                            'slug' => 'echafaudages',
                            'description' => 'Échafaudages pour travaux en hauteur.',
                        ],
                    ],
                ],
                'equipements_protection' => [
                    'name' => 'Équipements de Protection',
                    'slug' => 'equipements-protection',
                    'description' => 'Équipements pour la sécurité des travailleurs.',
                    'subcategories' => [
                        'casques' => [
                            'name' => 'Casques',
                            'slug' => 'casques',
                            'description' => 'Casques de chantier pour une protection optimale.',
                        ],
                        'gants_sécurité' => [
                            'name' => 'Gants de Sécurité',
                            'slug' => 'gants-securite',
                            'description' => 'Gants pour travaux manuels et industriels.',
                        ],
                    ],
                ],
                'materiel_soudure' => [
                    'name' => 'Matériel de Soudure',
                    'slug' => 'materiel-soudure',
                    'description' => 'Postes à souder et accessoires pour travaux de soudure.',
                    'subcategories' => [
                        'postes_soudure' => [
                            'name' => 'Postes à Souder',
                            'slug' => 'postes-souder',
                            'description' => 'Postes à souder MIG, TIG, et à l’arc.',
                        ],
                        'accessoires_soudure' => [
                            'name' => 'Accessoires Soudure',
                            'slug' => 'accessoires-soudure',
                            'description' => 'Masques, électrodes, et fils de soudure.',
                        ],
                    ],
                ],
                'groupes_electrogenes' => [
                    'name' => 'Groupes Électrogènes',
                    'slug' => 'groupes-electrogenes',
                    'description' => 'Générateurs pour une alimentation électrique fiable.',
                    'subcategories' => [
                        'generateurs_portables' => [
                            'name' => 'Générateurs Portables',
                            'slug' => 'generateurs-portables',
                            'description' => 'Générateurs compacts pour usage domestique.',
                        ],
                        'generateurs_industriels' => [
                            'name' => 'Générateurs Industriels',
                            'slug' => 'generateurs-industriels',
                            'description' => 'Générateurs puissants pour chantiers et entreprises.',
                        ],
                    ],
                ],
            ],
        ],
        'jardinage' => [
            'name' => 'Jardinage',
            'slug' => 'jardinage',
            'description' => 'Outils et produits pour créer et entretenir des jardins verdoyants.',
            'subcategories' => [
                'outils_jardin' => [
                    'name' => 'Outils de Jardin',
                    'slug' => 'outils-jardin',
                    'description' => 'Outils manuels et électriques pour le jardinage.',
                    'subcategories' => [
                        'sécateurs' => [
                            'name' => 'Sécateurs',
                            'slug' => 'secateurs',
                            'description' => 'Sécateurs pour tailler arbustes et plantes.',
                        ],
                        'tondeuses' => [
                            'name' => 'Tondeuses',
                            'slug' => 'tondeuses',
                            'description' => 'Tondeuses à gazon manuelles et électriques.',
                        ],
                    ],
                ],
                'plantes_graines' => [
                    'name' => 'Plantes et Graines',
                    'slug' => 'plantes-graines',
                    'description' => 'Graines et plantes pour embellir vos espaces verts.',
                    'subcategories' => [
                        'graines_fleurs' => [
                            'name' => 'Graines de Fleurs',
                            'slug' => 'graines-fleurs',
                            'description' => 'Graines pour fleurs ornementales.',
                        ],
                        'plantes_fruitiers' => [
                            'name' => 'Plantes Fruitières',
                            'slug' => 'plantes-fruitieres',
                            'description' => 'Arbres fruitiers et plants pour jardins.',
                        ],
                    ],
                ],
                'arrosage' => [
                    'name' => 'Arrosage',
                    'slug' => 'arrosage',
                    'description' => 'Systèmes pour arroser vos jardins efficacement.',
                    'subcategories' => [
                        'tuyaux_arrosage' => [
                            'name' => 'Tuyaux d’Arrosage',
                            'slug' => 'tuyaux-arrosage',
                            'description' => 'Tuyaux et arroseurs pour l’irrigation.',
                        ],
                        'systèmes_irrigation' => [
                            'name' => 'Systèmes d’Irrigation',
                            'slug' => 'systemes-irrigation',
                            'description' => 'Systèmes goutte-à-goutte et sprinklers.',
                        ],
                    ],
                ],
                'mobilier_jardin' => [
                    'name' => 'Mobilier de Jardin',
                    'slug' => 'mobilier-jardin',
                    'description' => 'Meubles pour des espaces extérieurs confortables.',
                    'subcategories' => [
                        'tables_jardin' => [
                            'name' => 'Tables de Jardin',
                            'slug' => 'tables-jardin',
                            'description' => 'Tables pour repas en extérieur.',
                        ],
                        'chaises_jardin' => [
                            'name' => 'Chaises de Jardin',
                            'slug' => 'chaises-jardin',
                            'description' => 'Chaises et fauteuils pour jardins et terrasses.',
                        ],
                        'parasols' => [
                            'name' => 'Parasols',
                            'slug' => 'parasols',
                            'description' => 'Parasols pour protection solaire.',
                        ],
                    ],
                ],
            ],
        ],
        'sport_loisirs' => [
            'name' => 'Sport et Loisirs',
            'slug' => 'sport-loisirs',
            'description' => 'Équipements pour rester actif et profiter des loisirs.',
            'subcategories' => [
                'equipements_fitness' => [
                    'name' => 'Équipements Fitness',
                    'slug' => 'equipements-fitness',
                    'description' => 'Matériel pour des entraînements à domicile ou en salle.',
                    'subcategories' => [
                        'tapis_course' => [
                            'name' => 'Tapis de Course',
                            'slug' => 'tapis-course',
                            'description' => 'Tapis de course pour cardio et fitness.',
                        ],
                        'haltères' => [
                            'name' => 'Haltères',
                            'slug' => 'halteres',
                            'description' => 'Haltères pour renforcement musculaire.',
                        ],
                    ],
                ],
                'velos' => [
                    'name' => 'Vélos',
                    'slug' => 'velos',
                    'description' => 'Vélos pour le sport, les loisirs, et le transport.',
                    'subcategories' => [
                        'velos_route' => [
                            'name' => 'Vélos de Route',
                            'slug' => 'velos-route',
                            'description' => 'Vélos pour cyclisme sur route.',
                        ],
                        'vtt' => [
                            'name' => 'VTT',
                            'slug' => 'vtt',
                            'description' => 'Vélos tout-terrain pour aventures.',
                        ],
                    ],
                ],
                'camping_randonnee' => [
                    'name' => 'Camping et Randonnée',
                    'slug' => 'camping-randonnee',
                    'description' => 'Équipements pour explorer la nature en toute sécurité.',
                    'subcategories' => [
                        'tentes' => [
                            'name' => 'Tentes',
                            'slug' => 'tentes',
                            'description' => 'Tentes pour camping et randonnées.',
                        ],
                        'sacs_couchage' => [
                            'name' => 'Sacs de Couchage',
                            'slug' => 'sacs-couchage',
                            'description' => 'Sacs de couchage pour nuits en plein air.',
                        ],
                    ],
                ],
                'sports_equipe' => [
                    'name' => 'Sports d’Équipe',
                    'slug' => 'sports-equipe',
                    'description' => 'Équipements pour football, basketball, et autres sports collectifs.',
                    'subcategories' => [
                        'football' => [
                            'name' => 'Football',
                            'slug' => 'football',
                            'description' => 'Ballons, chaussures, et équipements de football.',
                        ],
                        'basketball' => [
                            'name' => 'Basketball',
                            'slug' => 'basketball',
                            'description' => 'Ballons et paniers pour basketball.',
                        ],
                    ],
                ],
            ],
        ],
        'automobile' => [
            'name' => 'Automobile',
            'slug' => 'automobile',
            'description' => 'Accessoires et pièces pour entretenir et personnaliser vos véhicules.',
            'subcategories' => [
                'accessoires_auto' => [
                    'name' => 'Accessoires Auto',
                    'slug' => 'accessoires-auto',
                    'description' => 'Accessoires pour améliorer le confort et l’esthétique des véhicules.',
                    'subcategories' => [
                        'tapis_voiture' => [
                            'name' => 'Tapis de Voiture',
                            'slug' => 'tapis-voiture',
                            'description' => 'Tapis de sol pour protéger l’intérieur des véhicules.',
                        ],
                        'housse_siege' => [
                            'name' => 'Housses de Siège',
                            'slug' => 'housse-siege',
                            'description' => 'Housses pour sièges auto, en cuir ou tissu.',
                        ],
                        'accessoires_interieur' => [
                            'name' => 'Accessoires Intérieur',
                            'slug' => 'accessoires-interieur',
                            'description' => 'Organisateurs, supports téléphone, et parfums d’ambiance.',
                        ],
                        'accessoires_exterieur' => [
                            'name' => 'Accessoires Extérieur',
                            'slug' => 'accessoires-exterieur',
                            'description' => 'Barres de toit, déflecteurs, et stickers décoratifs.',
                        ],
                    ],
                ],
                'pieces_detachees' => [
                    'name' => 'Pièces Détachées',
                    'slug' => 'pieces-detachees',
                    'description' => 'Pièces de rechange pour la réparation et l’entretien des véhicules.',
                    'subcategories' => [
                        'batteries_auto' => [
                            'name' => 'Batteries Auto',
                            'slug' => 'batteries-auto',
                            'description' => 'Batteries pour voitures et motos.',
                        ],
                        'pneus' => [
                            'name' => 'Pneus',
                            'slug' => 'pneus',
                            'description' => 'Pneus pour tous types de véhicules et conditions.',
                        ],
                        'freins' => [
                            'name' => 'Freins',
                            'slug' => 'freins',
                            'description' => 'Plaquettes, disques, et kits de freinage.',
                        ],
                        'eclairage_auto' => [
                            'name' => 'Éclairage Auto',
                            'slug' => 'eclairage-auto',
                            'description' => 'Ampoules LED, phares, et feux arrière.',
                        ],
                    ],
                ],
                'entretien_vehicule' => [
                    'name' => 'Entretien Véhicule',
                    'slug' => 'entretien-vehicule',
                    'description' => 'Produits pour l’entretien régulier des véhicules.',
                    'subcategories' => [
                        'huiles_moteur' => [
                            'name' => 'Huiles Moteur',
                            'slug' => 'huiles-moteur',
                            'description' => 'Huiles synthétiques et conventionnelles pour moteurs.',
                        ],
                        'produits_nettoyage_auto' => [
                            'name' => 'Produits de Nettoyage Auto',
                            'slug' => 'produits-nettoyage-auto',
                            'description' => 'Shampoings, cires, et nettoyants pour carrosserie.',
                        ],
                        'outils_diagnostic' => [
                            'name' => 'Outils de Diagnostic',
                            'slug' => 'outils-diagnostic',
                            'description' => 'Scanners OBD pour diagnostiquer les pannes.',
                        ],
                    ],
                ],
            ],
        ],
        'bijouterie' => [
            'name' => 'Bijouterie',
            'slug' => 'bijouterie',
            'description' => 'Bijoux et montres pour sublimer votre style avec élégance.',
            'subcategories' => [
                'bijoux' => [
                    'name' => 'Bijoux',
                    'slug' => 'bijoux',
                    'description' => 'Bijoux artisanaux et modernes pour toutes les occasions.',
                    'subcategories' => [
                        'colliers' => [
                            'name' => 'Colliers',
                            'slug' => 'colliers',
                            'description' => 'Colliers en or, argent, et perles africaines.',
                        ],
                        'bracelets' => [
                            'name' => 'Bracelets',
                            'slug' => 'bracelets',
                            'description' => 'Bracelets pour hommes et femmes, en cuir ou métal.',
                        ],
                        'bagues' => [
                            'name' => 'Bagues',
                            'slug' => 'bagues',
                            'description' => 'Bagues de fiançailles, alliances, et bijoux décoratifs.',
                        ],
                        'boucles_oreilles' => [
                            'name' => 'Boucles d’Oreilles',
                            'slug' => 'boucles-oreilles',
                            'description' => 'Boucles d’oreilles élégantes pour tous les styles.',
                        ],
                    ],
                ],
                'montres' => [
                    'name' => 'Montres',
                    'slug' => 'montres',
                    'description' => 'Montres classiques et connectées pour hommes et femmes.',
                    'subcategories' => [
                        'montres_classiques' => [
                            'name' => 'Montres Classiques',
                            'slug' => 'montres-classiques',
                            'description' => 'Montres analogiques pour un style intemporel.',
                        ],
                        'montres_connectees' => [
                            'name' => 'Montres Connectées',
                            'slug' => 'montres-connectees',
                            'description' => 'Montres intelligentes avec suivi santé et notifications.',
                        ],
                    ],
                ],
                'accessoires_bijoux' => [
                    'name' => 'Accessoires Bijoux',
                    'slug' => 'accessoires-bijoux',
                    'description' => 'Boîtes à bijoux et produits d’entretien pour bijoux.',
                    'subcategories' => [
                        'boites_bijoux' => [
                            'name' => 'Boîtes à Bijoux',
                            'slug' => 'boites-bijoux',
                            'description' => 'Boîtes pour ranger et protéger vos bijoux.',
                        ],
                        'produits_entretien_bijoux' => [
                            'name' => 'Produits d’Entretien Bijoux',
                            'slug' => 'produits-entretien-bijoux',
                            'description' => 'Nettoyants pour bijoux en or, argent, et pierres précieuses.',
                        ],
                    ],
                ],
            ],
        ],
         'services' => [
            'name' => 'Services',
            'slug' => 'services',
            'description' => 'Services professionnels pour répondre à vos besoins quotidiens en Afrique.',
            'subcategories' => [
                'reparation' => [
                    'name' => 'Réparation',
                    'slug' => 'reparation',
                    'description' => 'Services de réparation pour appareils électroniques, électroménagers et véhicules.',
                    'subcategories' => [
                        'reparation_electronique' => [
                            'name' => 'Réparation Électronique',
                            'slug' => 'reparation-electronique',
                            'description' => 'Réparation de smartphones, tablettes, ordinateurs, consoles et autres appareils électroniques.',
                        ],
                        'reparation_electromenager' => [
                            'name' => 'Réparation Électroménager',
                            'slug' => 'reparation-electromenager',
                            'description' => 'Réparation de lave-linge, réfrigérateurs, fours, et autres appareils électroménagers.',
                        ],
                        'reparation_vehicule' => [
                            'name' => 'Réparation Véhicule',
                            'slug' => 'reparation-vehicule',
                            'description' => 'Services de mécanique et carrosserie automobile, pour voitures, motos et camions.',
                        ],
                    ],
                ],
                'nettoyage' => [
                    'name' => 'Nettoyage',
                    'slug' => 'nettoyage',
                    'description' => 'Services de nettoyage professionnel pour maisons et bureaux.',
                    'subcategories' => [
                        'nettoyage_general' => [
                            'name' => 'Nettoyage Général',
                            'slug' => 'nettoyage-general',
                            'description' => 'Nettoyage professionnel pour domiciles, bureaux et espaces commerciaux.',
                        ],
                    ],
                ],
                'conseil' => [
                    'name' => 'Conseil',
                    'slug' => 'conseil',
                    'description' => 'Services de conseil pour entreprises et particuliers.',
                    'subcategories' => [
                        'conseil_affaires' => [
                            'name' => 'Conseil en Affaires',
                            'slug' => 'conseil-affaires',
                            'description' => 'Conseils en gestion, marketing, finance et juridique pour entreprises et entrepreneurs.',
                        ],
                        'coaching_personnel' => [
                            'name' => 'Coaching Personnel',
                            'slug' => 'coaching-personnel',
                            'description' => 'Coaching pour le développement personnel, la carrière et le bien-être.',
                        ],
                    ],
                ],
            ],
        ],
    
        'evenements_festivites' => [
            'name' => 'Événements et Festivités',
            'slug' => 'evenements-festivites',
            'description' => 'Produits pour organiser et célébrer des événements mémorables.',
            'subcategories' => [
                'decorations_evenement' => [
                    'name' => 'Décorations Événement',
                    'slug' => 'decorations-evenement',
                    'description' => 'Décorations pour mariages, anniversaires, et fêtes.',
                    'subcategories' => [
                        'ballons' => [
                            'name' => 'Ballons',
                            'slug' => 'ballons',
                            'description' => 'Ballons hélium et décoratifs pour fêtes.',
                        ],
                        'guirlandes' => [
                            'name' => 'Guirlandes',
                            'slug' => 'guirlandes',
                            'description' => 'Guirlandes lumineuses et décoratives.',
                        ],
                    ],
                ],
                'costumes' => [
                    'name' => 'Costumes',
                    'slug' => 'costumes',
                    'description' => 'Costumes pour événements et célébrations.',
                    'subcategories' => [
                        'costumes_enfants' => [
                            'name' => 'Costumes Enfants',
                            'slug' => 'costumes-enfants',
                            'description' => 'Costumes pour enfants pour Halloween et fêtes.',
                        ],
                        'costumes_adultes' => [
                            'name' => 'Costumes Adultes',
                            'slug' => 'costumes-adultes',
                            'description' => 'Costumes pour adultes pour soirées à thème.',
                        ],
                    ],
                ],
                'accessoires_fete' => [
                    'name' => 'Accessoires de Fête',
                    'slug' => 'accessoires-fete',
                    'description' => 'Articles pour animer vos événements.',
                    'subcategories' => [
                        'vaisselle_jetable' => [
                            'name' => 'Vaisselle Jetable',
                            'slug' => 'vaisselle-jetable',
                            'description' => 'Assiettes, gobelets, et couverts pour fêtes.',
                        ],
                        'articles_animation' => [
                            'name' => 'Articles d’Animation',
                            'slug' => 'articles-animation',
                            'description' => 'Pinatas, confettis, et accessoires festifs.',
                        ],
                    ],
                ],
            ],
        ],
        'art_artisanat' => [
            'name' => 'Art et Artisanat',
            'slug' => 'art-artisanat',
            'description' => 'Produits artisanaux et matériels pour la créativité.',
            'subcategories' => [
                'peinture_dessin' => [
                    'name' => 'Peinture et Dessin',
                    'slug' => 'peinture-dessin',
                    'description' => 'Matériel pour artistes peintres et dessinateurs.',
                    'subcategories' => [
                        'peintures' => [
                            'name' => 'Peintures',
                            'slug' => 'peintures',
                            'description' => 'Peintures acryliques, à l’huile, et aquarelles.',
                        ],
                        'pinceaux' => [
                            'name' => 'Pinceaux',
                            'slug' => 'pinceaux',
                            'description' => 'Pinceaux pour tous types de peinture.',
                        ],
                        'toiles' => [
                            'name' => 'Toiles',
                            'slug' => 'toiles',
                            'description' => 'Toiles pour peinture et dessin.',
                        ],
                    ],
                ],
                'artisanat_local' => [
                    'name' => 'Artisanat Local',
                    'slug' => 'artisanat-local',
                    'description' => 'Produits artisanaux africains faits à la main.',
                    'subcategories' => [
                        'sculptures' => [
                            'name' => 'Sculptures',
                            'slug' => 'sculptures',
                            'description' => 'Sculptures en bois, pierre, et métal.',
                        ],
                        'tissus_traditionnels' => [
                            'name' => 'Tissus Traditionnels',
                            'slug' => 'tissus-traditionnels',
                            'description' => 'Tissus wax, bazin, et autres motifs africains.',
                        ],
                    ],
                ],
                'materiel_creation' => [
                    'name' => 'Matériel de Création',
                    'slug' => 'materiel-creation',
                    'description' => 'Outils pour la couture, le tricot, et autres créations.',
                    'subcategories' => [
                        'couture' => [
                            'name' => 'Couture',
                            'slug' => 'couture',
                            'description' => 'Machines à coudre, fils, et aiguilles.',
                        ],
                        'tricot' => [
                            'name' => 'Tricot',
                            'slug' => 'tricot',
                            'description' => 'Laines et accessoires pour tricot.',
                        ],
                    ],
                ],
            ],
        ],
        'musique' => [
            'name' => 'Musique',
            'slug' => 'musique',
            'description' => 'Instruments et accessoires pour les passionnés de musique.',
            'subcategories' => [
                'instruments_musicaux' => [
                    'name' => 'Instruments Musicaux',
                    'slug' => 'instruments-musicaux',
                    'description' => 'Instruments pour tous les genres musicaux.',
                    'subcategories' => [
                        'guitares_musique' => [
                            'name' => 'Guitares',
                            'slug' => 'guitares-musique',
                            'description' => 'Guitares acoustiques, électriques, et basses.',
                        ],
                        'pianos_claviers_musique' => [
                            'name' => 'Pianos et Claviers',
                            'slug' => 'pianos-claviers-musique',
                            'description' => 'Pianos acoustiques et claviers électroniques.',
                        ],
                        'percussions_musique' => [
                            'name' => 'Percussions',
                            'slug' => 'percussions-musique',
                            'description' => 'Djembés, tambours, et batteries.',
                        ],
                    ],
                ],
                'accessoires_musicaux' => [
                    'name' => 'Accessoires Musicaux',
                    'slug' => 'accessoires-musicaux',
                    'description' => 'Accessoires pour instruments et musiciens.',
                    'subcategories' => [
                        'cordes' => [
                            'name' => 'Cordes',
                            'slug' => 'cordes',
                            'description' => 'Cordes pour guitares, violons, et autres instruments.',
                        ],
                        'partitions' => [
                            'name' => 'Partitions',
                            'slug' => 'partitions',
                            'description' => 'Partitions musicales pour tous niveaux.',
                        ],
                        'supports_instruments' => [
                            'name' => 'Supports Instruments',
                            'slug' => 'supports-instruments',
                            'description' => 'Stands et supports pour instruments.',
                        ],
                    ],
                ],
            ],
        ],
        'sante' => [
            'name' => 'Santé',
            'slug' => 'sante',
            'description' => 'Produits pour la santé et les soins personnels.',
            'subcategories' => [
                'materiel_medical' => [
                    'name' => 'Matériel Médical',
                    'slug' => 'materiel-medical',
                    'description' => 'Équipements pour le suivi et les soins médicaux.',
                    'subcategories' => [
                        'tensiometres' => [
                            'name' => 'Tensiomètres',
                            'slug' => 'tensiometres',
                            'description' => 'Tensiomètres pour surveiller la pression artérielle.',
                        ],
                        'glucometres' => [
                            'name' => 'Glucomètres',
                            'slug' => 'glucometres',
                            'description' => 'Appareils pour mesurer la glycémie.',
                        ],
                    ],
                ],
                'complements_alimentaires' => [
                    'name' => 'Compléments Alimentaires',
                    'slug' => 'complements-alimentaires',
                    'description' => 'Vitamines et suppléments pour une santé optimale.',
                    'subcategories' => [
                        'vitamines' => [
                            'name' => 'Vitamines',
                            'slug' => 'vitamines',
                            'description' => 'Vitamines pour renforcer l’immunité et l’énergie.',
                        ],
                        'supplements_nutritionnels' => [
                            'name' => 'Suppléments Nutritionnels',
                            'slug' => 'supplements-nutritionnels',
                            'description' => 'Compléments pour sportifs et régimes spécifiques.',
                        ],
                    ],
                ],
                'premiers_soins' => [
                    'name' => 'Premiers Soins',
                    'slug' => 'premiers-soins',
                    'description' => 'Produits pour les urgences médicales et les soins de base.',
                    'subcategories' => [
                        ' trousses_premiers_soins' => [
                            'name' => 'Trousse de Premiers Soins',
                            'slug' => 'trousses-premiers-soins',
                            'description' => 'Kits pour traiter les blessures mineures.',
                        ],
                        'pansements' => [
                            'name' => 'Pansements',
                            'slug' => 'pansements',
                            'description' => 'Pansements et bandages pour blessures.',
                        ],
                    ],
                ],
            ],
        ],
        'animaux_compagnie' => [
            'name' => 'Animaux de Compagnie',
            'slug' => 'animaux-compagnie',
            'description' => 'Produits pour le bien-être et les soins des animaux domestiques.',
            'subcategories' => [
                'alimentation_animaux' => [
                    'name' => 'Alimentation Animaux',
                    'slug' => 'alimentation-animaux',
                    'description' => 'Nourriture pour chiens, chats, et autres animaux.',
                    'subcategories' => [
                        'croquettes' => [
                            'name' => 'Croquettes',
                            'slug' => 'croquettes',
                            'description' => 'Croquettes pour chiens et chats.',
                        ],
                        'nourriture_humide' => [
                            'name' => 'Nourriture Humide',
                            'slug' => 'nourriture-humide',
                            'description' => 'Pâtées pour animaux de compagnie.',
                        ],
                    ],
                ],
                'accessoires_animaux' => [
                    'name' => 'Accessoires Animaux',
                    'slug' => 'accessoires-animaux',
                    'description' => 'Colliers, laisses, et jouets pour animaux.',
                    'subcategories' => [
                        'colliers_laisses' => [
                            'name' => 'Colliers et Laisses',
                            'slug' => 'colliers-laisses',
                            'description' => 'Colliers et laisses pour promenades.',
                        ],
                        'jouets_animaux' => [
                            'name' => 'Jouets Animaux',
                            'slug' => 'jouets-animaux',
                            'description' => 'Jouets pour divertir chiens et chats.',
                        ],
                    ],
                ],
                'soins_animaux' => [
                    'name' => 'Soins Animaux',
                    'slug' => 'soins-animaux',
                    'description' => 'Produits pour l’hygiène et la santé des animaux.',
                    'subcategories' => [
                        'produits_hygiene_animaux' => [
                            'name' => 'Produits Hygiène Animaux',
                            'slug' => 'produits-hygiene-animaux',
                            'description' => 'Shampoings et brosses pour animaux.',
                        ],
                        'produits_sante_animaux' => [
                            'name' => 'Produits Santé Animaux',
                            'slug' => 'produits-sante-animaux',
                            'description' => 'Compléments et traitements pour animaux.',
                        ],
                    ],
                ],
            ],
        ],
        'jouets_jeux' => [
            'name' => 'Jouets et Jeux',
            'slug' => 'jouets-jeux',
            'description' => 'Jouets et jeux pour divertir et éduquer les enfants.',
            'subcategories' => [
                'jeux_societe' => [
                    'name' => 'Jeux de Société',
                    'slug' => 'jeux-societe',
                    'description' => 'Jeux pour des moments en famille ou entre amis.',
                    'subcategories' => [
                        'jeux_famille' => [
                            'name' => 'Jeux de Famille',
                            'slug' => 'jeux-famille',
                            'description' => 'Jeux pour tous les âges, comme Monopoly et Scrabble.',
                        ],
                        'jeux_cartes' => [
                            'name' => 'Jeux de Cartes',
                            'slug' => 'jeux-cartes',
                            'description' => 'Jeux de cartes classiques et modernes.',
                        ],
                    ],
                ],
                'jouets_educatifs' => [
                    'name' => 'Jouets Éducatifs',
                    'slug' => 'jouets-educatifs',
                    'description' => 'Jouets pour stimuler l’apprentissage des enfants.',
                    'subcategories' => [
                        'jeux_sciences' => [
                            'name' => 'Jeux de Sciences',
                            'slug' => 'jeux-sciences',
                            'description' => 'Kits scientifiques pour enfants curieux.',
                        ],
                        'jeux_construction_educatifs' => [
                            'name' => 'Jeux de Construction Éducatifs',
                            'slug' => 'jeux-construction-educatifs',
                            'description' => 'Lego et autres jeux pour la créativité.',
                        ],
                    ],
                ],
                'poupees_figurines' => [
                    'name' => 'Poupées et Figurines',
                    'slug' => 'poupees-figurines',
                    'description' => 'Poupées et figurines pour le jeu imaginatif.',
                    'subcategories' => [
                        'poupees' => [
                            'name' => 'Poupées',
                            'slug' => 'poupees',
                            'description' => 'Poupées classiques et modernes pour enfants.',
                        ],
                        'figurines_action' => [
                            'name' => 'Figurines d’Action',
                            'slug' => 'figurines-action',
                            'description' => 'Figurines de super-héros et personnages.',
                        ],
                    ],
                ],
            ],
        ],
        'voyage' => [
            'name' => 'Voyage',
            'slug' => 'voyage',
            'description' => 'Équipements pour voyager confortablement et en sécurité.',
            'subcategories' => [
                'valises' => [
                    'name' => 'Valises',
                    'slug' => 'valises',
                    'description' => 'Valises rigides et souples pour tous types de voyages.',
                    'subcategories' => [
                        'valises_cabine' => [
                            'name' => 'Valises Cabine',
                            'slug' => 'valises-cabine',
                            'description' => 'Valises compactes pour bagages à main.',
                        ],
                        'valises_soute' => [
                            'name' => 'Valises Soute',
                            'slug' => 'valises-soute',
                            'description' => 'Valises grandes tailles pour longs voyages.',
                        ],
                    ],
                ],
                'accessoires_voyage' => [
                    'name' => 'Accessoires Voyage',
                    'slug' => 'accessoires-voyage',
                    'description' => 'Accessoires pour faciliter vos déplacements.',
                    'subcategories' => [
                        'coussins_voyage' => [
                            'name' => 'Coussins de Voyage',
                            'slug' => 'coussins-voyage',
                            'description' => 'Coussins pour le cou pour un confort en voyage.',
                        ],
                        'organisateurs_voyage' => [
                            'name' => 'Organisateurs de Voyage',
                            'slug' => 'organisateurs-voyage',
                            'description' => ' trousses et pochettes pour organiser vos affaires.',
                        ],
                    ],
                ],
                'equipements_camping' => [
                    'name' => 'Équipements Camping',
                    'slug' => 'equipements-camping',
                    'description' => 'Matériel pour camper en pleine nature.',
                    'subcategories' => [
                        'tentes_camping' => [
                            'name' => 'Tentes Camping',
                            'slug' => 'tentes-camping',
                            'description' => 'Tentes légères et résistantes pour camping.',
                        ],
                        'equipements_survie' => [
                            'name' => 'Équipements de Survie',
                            'slug' => 'equipements-survie',
                            'description' => 'Kits de survie et outils pour aventures.',
                        ],
                    ],
                ],
            ],
        ],
        'mode_enfant' => [
            'name' => 'Mode Enfant',
            'slug' => 'mode-enfant',
            'description' => 'Vêtements et accessoires pour enfants, alliant style et confort.',
            'subcategories' => [
                'vetements_enfant' => [
                    'name' => 'Vêtements Enfant',
                    'slug' => 'vetements-enfant',
                    'description' => 'Vêtements pour enfants de tous âges.',
                    'subcategories' => [
                        'vetements_fille' => [
                            'name' => 'Vêtements Fille',
                            'slug' => 'vetements-fille',
                            'description' => 'Robes, jupes, et hauts pour filles.',
                        ],
                        'vetements_garcon' => [
                            'name' => 'Vêtements Garçon',
                            'slug' => 'vetements-garcon',
                            'description' => 'Pantalons, t-shirts, et chemises pour garçons.',
                        ],
                    ],
                ],
                'chaussures_enfant' => [
                    'name' => 'Chaussures Enfant',
                    'slug' => 'chaussures-enfant',
                    'description' => 'Chaussures confortables pour enfants actifs.',
                    'subcategories' => [
                        'baskets_enfant' => [
                            'name' => 'Baskets Enfant',
                            'slug' => 'baskets-enfant',
                            'description' => 'Baskets pour le sport et le quotidien.',
                        ],
                        'sandales_enfant' => [
                            'name' => 'Sandales Enfant',
                            'slug' => 'sandales-enfant',
                            'description' => 'Sandales légères pour l’été.',
                        ],
                    ],
                ],
                'accessoires_enfant' => [
                    'name' => 'Accessoires Enfant',
                    'slug' => 'accessoires-enfant',
                    'description' => 'Accessoires pour compléter le look des enfants.',
                    'subcategories' => [
                        'sacs_enfant' => [
                            'name' => 'Sacs Enfant',
                            'slug' => 'sacs-enfant',
                            'description' => 'Sacs à dos et sacs pour enfants.',
                        ],
                        'chapeaux_enfant' => [
                            'name' => 'Chapeaux Enfant',
                            'slug' => 'chapeaux-enfant',
                            'description' => 'Chapeaux et casquettes pour enfants.',
                        ],
                    ],
                ],
            ],
        ],
        'bricolage' => [
            'name' => 'Bricolage',
            'slug' => 'bricolage',
            'description' => 'Matériaux et outils pour rénover et construire vos projets.',
            'subcategories' => [
                'materiaux_construction' => [
                    'name' => 'Matériaux de Construction',
                    'slug' => 'materiaux-construction',
                    'description' => 'Matériaux pour travaux de construction et rénovation.',
                    'subcategories' => [
                        'ciment_beton' => [
                            'name' => 'Ciment et Béton',
                            'slug' => 'ciment-beton',
                            'description' => 'Ciment, béton, et mortier pour chantiers.',
                        ],
                        'bois' => [
                            'name' => 'Bois',
                            'slug' => 'bois',
                            'description' => 'Planches, poutres, et bois pour construction.',
                        ],
                    ],
                ],
                'peinture' => [
                    'name' => 'Peinture',
                    'slug' => 'peinture',
                    'description' => 'Peintures pour murs, plafonds, et meubles.',
                    'subcategories' => [
                        'peinture_interieur' => [
                            'name' => 'Peinture Intérieur',
                            'slug' => 'peinture-interieur',
                            'description' => 'Peintures pour murs et plafonds intérieurs.',
                        ],
                        'peinture_exterieur' => [
                            'name' => 'Peinture Extérieur',
                            'slug' => 'peinture-exterieur',
                            'description' => 'Peintures résistantes pour façades.',
                        ],
                    ],
                ],
                'revetements' => [
                    'name' => 'Revêtements',
                    'slug' => 'revetements',
                    'description' => 'Carrelages, parquets, et autres revêtements de sol.',
                    'subcategories' => [
                        'carrelage' => [
                            'name' => 'Carrelage',
                            'slug' => 'carrelage',
                            'description' => 'Carreaux pour sols et murs.',
                        ],
                        'parquet' => [
                            'name' => 'Parquet',
                            'slug' => 'parquet',
                            'description' => 'Parquets en bois et stratifiés.',
                        ],
                    ],
                ],
            ],
        ],
        'immobilier' => [
            'name' => 'Immobilier',
            'slug' => 'immobilier',
            'description' => 'Équipements et articles pour l’aménagement immobilier.',
            'subcategories' => [
                'equipements_maison' => [
                    'name' => 'Équipements Maison',
                    'slug' => 'equipements-maison',
                    'description' => 'Articles pour équiper maisons et appartements.',
                    'subcategories' => [
                        'serrures' => [
                            'name' => 'Serrures',
                            'slug' => 'serrures',
                            'description' => 'Serrures pour portes et portails.',
                        ],
                        'eclairage_interieur' => [
                            'name' => 'Éclairage Intérieur',
                            'slug' => 'eclairage-interieur',
                            'description' => 'Lampes et luminaires pour la maison.',
                        ],
                    ],
                ],
                'articles_demenagement' => [
                    'name' => 'Articles Déménagement',
                    'slug' => 'articles-demenagement',
                    'description' => 'Produits pour faciliter le déménagement.',
                    'subcategories' => [
                        'cartons_demenagement' => [
                            'name' => 'Cartons Déménagement',
                            'slug' => 'cartons-demenagement',
                            'description' => 'Cartons et boîtes pour emballer vos affaires.',
                        ],
                        'rubans_adhesifs' => [
                            'name' => 'Rubans Adhésifs',
                            'slug' => 'rubans-adhesifs',
                            'description' => 'Rubans pour sceller les cartons.',
                        ],
                    ],
                ],
                'materiel_renovation' => [
                    'name' => 'Matériel Rénovation',
                    'slug' => 'materiel-renovation',
                    'description' => 'Outils et matériaux pour rénover votre maison.',
                    'subcategories' => [
                        'outils_renovation' => [
                            'name' => 'Outils Rénovation',
                            'slug' => 'outils-renovation',
                            'description' => 'Outils pour travaux de rénovation.',
                        ],
                        'materiaux_isolation' => [
                            'name' => 'Matériaux Isolation',
                            'slug' => 'materiaux-isolation',
                            'description' => 'Isolants pour murs et toitures.',
                        ],
                    ],
                ],
            ],
        ],
        'cuisine_gastronomie' => [
            'name' => 'Cuisine et Gastronomie',
            'slug' => 'cuisine-gastronomie',
            'description' => 'Équipements et produits pour cuisiner et savourer des plats.',
            'subcategories' => [
                'ustensiles_cuisine' => [
                    'name' => 'Ustensiles de Cuisine',
                    'slug' => 'ustensiles-cuisine',
                    'description' => 'Outils pour préparer des plats délicieux.',
                    'subcategories' => [
                        'couteaux_cuisine' => [
                            'name' => 'Couteaux de Cuisine',
                            'slug' => 'couteaux-cuisine',
                            'description' => 'Couteaux pour découpe précise.',
                        ],
                        'poeles_casseroles' => [
                            'name' => 'Poêles et Casseroles',
                            'slug' => 'poeles-casseroles',
                            'description' => 'Poêles et casseroles pour tous types de cuisson.',
                        ],
                    ],
                ],
                'livres_recettes' => [
                    'name' => 'Livres de Recettes',
                    'slug' => 'livres-recettes',
                    'description' => 'Livres pour découvrir des recettes africaines et internationales.',
                    'subcategories' => [
                        'recettes_africaines' => [
                            'name' => 'Recettes Africaines',
                            'slug' => 'recettes-africaines',
                            'description' => 'Livres de recettes traditionnelles africaines.',
                        ],
                        'recettes_internationales' => [
                            'name' => 'Recettes Internationales',
                            'slug' => 'recettes-internationales',
                            'description' => 'Livres pour cuisines du monde.',
                        ],
                    ],
                ],
                'equipements_professionnels' => [
                    'name' => 'Équipements Professionnels',
                    'slug' => 'equipements-professionnels',
                    'description' => 'Matériel pour cuisines professionnelles.',
                    'subcategories' => [
                        'fours_professionnels' => [
                            'name' => 'Fours Professionnels',
                            'slug' => 'fours-professionnels',
                            'description' => 'Fours pour restaurants et pâtisseries.',
                        ],
                        'equipements_refrigeration' => [
                            'name' => 'Équipements Réfrigération',
                            'slug' => 'equipements-refrigeration',
                            'description' => 'Réfrigérateurs et congélateurs professionnels.',
                        ],
                    ],
                ],
            ],
        ],
        'education' => [
            'name' => 'Éducation',
            'slug' => 'education',
            'description' => 'Ressources et outils pour l’apprentissage et la formation.',
            'subcategories' => [
                'cours_en_ligne' => [
                    'name' => 'Cours en Ligne',
                    'slug' => 'cours-en-ligne',
                    'description' => 'Formations en ligne pour tous niveaux.',
                    'subcategories' => [
                        'cours_langues' => [
                            'name' => 'Cours de Langues',
                            'slug' => 'cours-langues',
                            'description' => 'Cours pour apprendre l’anglais, le français, et plus.',
                        ],
                        'cours_techniques' => [
                            'name' => 'Cours Techniques',
                            'slug' => 'cours-techniques',
                            'description' => 'Formations en informatique, ingénierie, et autres.',
                        ],
                    ],
                ],
                'materiel_educatif' => [
                    'name' => 'Matériel Éducatif',
                    'slug' => 'materiel-educatif',
                    'description' => 'Outils pédagogiques pour enseignants et étudiants.',
                    'subcategories' => [
                        'tableaux_blancs' => [
                            'name' => 'Tableaux Blancs',
                            'slug' => 'tableaux-blancs',
                            'description' => 'Tableaux pour salles de classe.',
                        ],
                        'materiel_sciences' => [
                            'name' => 'Matériel Sciences',
                            'slug' => 'materiel-sciences',
                            'description' => 'Kits pour expériences scientifiques.',
                        ],
                    ],
                ],
                'fournitures_scolaires' => [
                    'name' => 'Fournitures Scolaires',
                    'slug' => 'fournitures-scolaires',
                    'description' => 'Articles pour étudiants et salles de classe.',
                    'subcategories' => [
                        'cahiers_scolaires' => [
                            'name' => 'Cahiers Scolaires',
                            'slug' => 'cahiers-scolaires',
                            'description' => 'Cahiers pour notes et exercices.',
                        ],
                        'stylos_scolaires' => [
                            'name' => 'Stylos Scolaires',
                            'slug' => 'stylos-scolaires',
                            'description' => 'Stylos et crayons pour l’école.',
                        ],
                    ],
                ],
            ],
        ],
        'electronique_grand_public' => [
            'name' => 'Électronique Grand Public',
            'slug' => 'electronique-grand-public',
            'description' => 'Gadgets et appareils électroniques pour le quotidien.',
            'subcategories' => [
                'gadgets_connectes' => [
                    'name' => 'Gadgets Connectés',
                    'slug' => 'gadgets-connectes',
                    'description' => 'Appareils intelligents pour la maison et le quotidien.',
                    'subcategories' => [
                        'enceintes_intelligentes' => [
                            'name' => 'Enceintes Intelligentes',
                            'slug' => 'enceintes-intelligentes',
                            'description' => 'Enceintes avec assistants vocaux.',
                        ],
                        'ampoules_connectees' => [
                            'name' => 'Ampoules Connectées',
                            'slug' => 'ampoules-connectees',
                            'description' => 'Ampoules contrôlables via smartphone.',
                        ],
                    ],
                ],
                'accessoires_electroniques' => [
                    'name' => 'Accessoires Électroniques',
                    'slug' => 'accessoires-electroniques',
                    'description' => 'Accessoires pour appareils électroniques.',
                    'subcategories' => [
                        'chargeurs' => [
                            'name' => 'Chargeurs',
                            'slug' => 'chargeurs',
                            'description' => 'Chargeurs pour smartphones et tablettes.',
                        ],
                        'cables' => [
                            'name' => 'Câbles',
                            'slug' => 'cables',
                            'description' => 'Câbles USB, HDMI, et autres connectiques.',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
