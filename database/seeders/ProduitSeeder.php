<?php
// Seeder : 20 catégories × 10 produits = 200 produits quincaillerie

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Support\Str;

class ProduitSeeder extends Seeder {
    public function run(): void {
        $boutique_id = 3; // Remplacez par l'ID de votre boutique

        $catalogue = [
            // ── 1. OUTILLAGE MAIN ──────────────────────────
            ['cat' => 'Outillage main', 'icone' => 'ti-tool', 'produits' => [
                ['nom'=>'Marteau de charpentier 500g','prix_vente'=>3500,'prix_achat'=>2000,'stock'=>50,'desc'=>'Marteau professionnel à tête en acier trempé, manche en bois de hêtre. Idéal pour clouage et construction.'],
                ['nom'=>'Tournevis plat 6mm','prix_vente'=>1200,'prix_achat'=>600,'stock'=>80,'desc'=>'Tournevis à lame plate en acier inoxydable. Manche ergonomique anti-dérapant. Longueur lame : 100mm.'],
                ['nom'=>'Tournevis cruciforme PH2','prix_vente'=>1200,'prix_achat'=>600,'stock'=>80,'desc'=>'Tournevis Phillips n°2 à pointe renforcée. Usage intensif professionnel et domestique.'],
                ['nom'=>'Clé à molette 250mm','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>35,'desc'=>'Clé réglable en acier chromé-vanadium. Ouverture max 30mm. Résistante à la corrosion.'],
                ['nom'=>'Pince multiprise 250mm','prix_vente'=>3800,'prix_achat'=>2000,'stock'=>40,'desc'=>'Pince à mâchoires réglables pour plomberie et électricité. Poignées isolées 1000V.'],
                ['nom'=>'Niveau à bulle 60cm','prix_vente'=>5500,'prix_achat'=>3000,'stock'=>25,'desc'=>'Niveau aluminium 3 bulles (horizontal/vertical/45°). Précision ±0.5mm/m. Graduation métrique.'],
                ['nom'=>'Scie à métaux','prix_vente'=>4200,'prix_achat'=>2200,'stock'=>30,'desc'=>'Scie à monture réglable pour métaux et PVC. Lame 32 dents/pouce. Tension réglable.'],
                ['nom'=>'Mètre ruban 5m','prix_vente'=>1800,'prix_achat'=>900,'stock'=>60,'desc'=>'Mètre ruban magnétique 5m/19mm. Lame en acier, arrêt automatique. Crochet double face.'],
                ['nom'=>'Ciseau à bois 25mm','prix_vente'=>2800,'prix_achat'=>1500,'stock'=>45,'desc'=>'Ciseau à bois en acier inoxydable affûté à froid. Manche choc résistant. Largeur 25mm.'],
                ['nom'=>'Maillet caoutchouc 500g','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>35,'desc'=>'Maillet à têtes caoutchouc interchangeables. Sans rayure sur les surfaces délicates.'],
            ]],

            // ── 2. OUTILLAGE ÉLECTRIQUE ──────────────────────
            ['cat' => 'Outillage électrique', 'icone' => 'ti-bolt', 'produits' => [
                ['nom'=>'Perceuse visseuse 18V','prix_vente'=>45000,'prix_achat'=>30000,'stock'=>15,'desc'=>'Perceuse-visseuse sans fil 18V, 2 batteries Li-Ion 2Ah. Couple max 40Nm, 2 vitesses. Mandrin 13mm.'],
                ['nom'=>'Meuleuse d\'angle 125mm','prix_vente'=>28000,'prix_achat'=>18000,'stock'=>20,'desc'=>'Meuleuse angulaire 900W, disque 125mm. Vitesse 11000 tr/min. Protège-disque réglable.'],
                ['nom'=>'Ponceuse orbitale 230W','prix_vente'=>22000,'prix_achat'=>14000,'stock'=>12,'desc'=>'Ponceuse excentrique 230W, plateau 125mm. Collecte de poussière intégrée. Vitesse variable.'],
                ['nom'=>'Scie circulaire 1400W','prix_vente'=>55000,'prix_achat'=>35000,'stock'=>8,'desc'=>'Scie circulaire 1400W, diamètre lame 185mm. Profondeur de coupe 65mm. Guide parallèle inclus.'],
                ['nom'=>'Pistolet à colle 11mm','prix_vente'=>8500,'prix_achat'=>4500,'stock'=>40,'desc'=>'Pistolet thermofusible 60W pour bâtons colle 11mm. Chauffage rapide 3 min. Livré avec 10 bâtons.'],
                ['nom'=>'Lampe de chantier LED','prix_vente'=>18000,'prix_achat'=>10000,'stock'=>25,'desc'=>'Projecteur LED 50W, 5000 lumens. Éclairage 360°, pied télescopique 1-1.8m. IP44.'],
                ['nom'=>'Décapeur thermique 2000W','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>18,'desc'=>'Pistolet à air chaud 2000W, 2 températures (300°/500°C). Idéal décapage peinture, soudure PVC.'],
                ['nom'=>'Visseuse à choc 18V','prix_vente'=>38000,'prix_achat'=>24000,'stock'=>12,'desc'=>'Visseuse à percussion 18V sans fil. Couple max 180Nm. Livré avec 2 batteries et chargeur.'],
                ['nom'=>'Scie sauteuse 700W','prix_vente'=>32000,'prix_achat'=>20000,'stock'=>10,'desc'=>'Scie sauteuse 700W, course 23mm. Coupe bois 80mm, métal 10mm. 4 modes pendulaires.'],
                ['nom'=>'Aspirateur de chantier 30L','prix_vente'=>42000,'prix_achat'=>28000,'stock'=>8,'desc'=>'Aspirateur eau et poussière 1400W, cuve 30L inox. Filtre HEPA. Accessoires plomberie inclus.'],
            ]],

            // ── 3. VISSERIE & FIXATION ────────────────────────
            ['cat' => 'Visserie & Fixation', 'icone' => 'ti-settings', 'produits' => [
                ['nom'=>'Vis bois TF 5x50 (200pcs)','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>100,'desc'=>'Boîte 200 vis à bois tête fraisée Torx T20, acier zingué. Diamètre 5mm, longueur 50mm.'],
                ['nom'=>'Boulons M8x50 (50pcs)','prix_vente'=>2800,'prix_achat'=>1400,'stock'=>80,'desc'=>'Boîte 50 boulons hexagonaux M8x50 acier classe 8.8 zingué. Avec écrous et rondelles.'],
                ['nom'=>'Chevilles murales 8mm (100pcs)','prix_vente'=>1500,'prix_achat'=>700,'stock'=>120,'desc'=>'Boîte 100 chevilles à expansion nylon 8mm pour béton, brique et aggloméré. Charge max 40kg.'],
                ['nom'=>'Rivets aluminium 4x10 (100pcs)','prix_vente'=>2200,'prix_achat'=>1100,'stock'=>90,'desc'=>'Boîte 100 rivets aveugles aluminium 4x10mm. Épaisseur max 6mm. Pour assemblage tôles.'],
                ['nom'=>'Écrous hexagonaux M10 (50pcs)','prix_vente'=>1800,'prix_achat'=>900,'stock'=>100,'desc'=>'Boîte 50 écrous hexagonaux M10 acier zingué. Haute résistance, pas ISO. Clé 17mm.'],
                ['nom'=>'Rondelles plates M8 (100pcs)','prix_vente'=>1200,'prix_achat'=>600,'stock'=>150,'desc'=>'Boîte 100 rondelles plates M8 acier galvanisé. Diamètre extérieur 16mm, épaisseur 1.5mm.'],
                ['nom'=>'Vis autotaraudeuses 4x20 (100pcs)','prix_vente'=>2500,'prix_achat'=>1200,'stock'=>100,'desc'=>'Boîte 100 vis auto-perceuses pour tôle et profilés métalliques. Tête hexagonale 4x20mm.'],
                ['nom'=>'Tiges filetées M12 1m','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>40,'desc'=>'Tige filetée M12 longueur 1 mètre, acier zingué. Peut être coupée aux dimensions voulues.'],
                ['nom'=>'Cheville Molly M6 (20pcs)','prix_vente'=>3200,'prix_achat'=>1700,'stock'=>60,'desc'=>'Boîte 20 chevilles métal type Molly M6 pour cloisons creuses. Charge 15kg, lame acier.'],
                ['nom'=>'Clous annelés 4x100 (1kg)','prix_vente'=>3800,'prix_achat'=>2000,'stock'=>50,'desc'=>'1kg de clous annelés galvanisés 4x100mm. Meilleure tenue que clous lisses. Charpente.'],
            ]],

            // ── 4. PLOMBERIE ─────────────────────────────────
            ['cat' => 'Plomberie', 'icone' => 'ti-droplet', 'produits' => [
                ['nom'=>'Robinet mélangeur cuisine','prix_vente'=>22000,'prix_achat'=>13000,'stock'=>20,'desc'=>'Mitigeur monocommande cuisine chromé. Bec pivotant 360°. Cartouche céramique 40mm.'],
                ['nom'=>'Tuyau PVC 32mm (1m)','prix_vente'=>1800,'prix_achat'=>900,'stock'=>100,'desc'=>'Tube PVC pression PN10, diamètre 32mm, longueur 1m. Pour eau froide et chaude jusqu\'à 60°C.'],
                ['nom'=>'Coude PVC 32mm 90°','prix_vente'=>800,'prix_achat'=>400,'stock'=>120,'desc'=>'Raccord coude 90° PVC blanc diamètre 32mm. Résistance pression 10 bars. Collage ou joint.'],
                ['nom'=>'Bouchon de vidange','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>35,'desc'=>'Bonde de vidange universelle pour évier inox. Diamètre 90mm, profondeur 60mm. Avec joint.'],
                ['nom'=>'Ruban PTFE 12m','prix_vente'=>500,'prix_achat'=>250,'stock'=>200,'desc'=>'Ruban téflon PTFE 12m pour étanchéité filetages. Largeur 12mm, épaisseur 0.1mm.'],
                ['nom'=>'Collier de serrage 32-50mm','prix_vente'=>600,'prix_achat'=>300,'stock'=>150,'desc'=>'Collier de fixation galvanisé pour tuyaux 32-50mm. Vis inox, charge 50kg. Fixation murale.'],
                ['nom'=>'Flotteur de chasse d\'eau','prix_vente'=>3200,'prix_achat'=>1700,'stock'=>40,'desc'=>'Flotteur universel à manchette pour réservoir WC. S\'adapte à tous réservoirs. Simple pose.'],
                ['nom'=>'Siphon de douche carré','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Siphon douche inox 10x10cm, débit 22L/min. Grille amovible anti-odeur. H=6.5cm minimum.'],
                ['nom'=>'Mastic sanitaire silicone','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>60,'desc'=>'Silicone sanitaire blanc anti-moisissures. Cartouche 310ml. Résistant eau et humidité.'],
                ['nom'=>'Pompe de relevage 400W','prix_vente'=>45000,'prix_achat'=>28000,'stock'=>8,'desc'=>'Pompe immergée vide-cave 400W. Débit 6000L/h. Hauteur refoulement 6m. Flotteur intégré.'],
            ]],

            // ── 5. ÉLECTRICITÉ ────────────────────────────────
            ['cat' => 'Électricité', 'icone' => 'ti-plug', 'produits' => [
                ['nom'=>'Câble électrique 2.5mm² (10m)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>50,'desc'=>'Câble H07V-R souple 2.5mm² rouge. Gaine PVC résistante. Tension 450/750V. 10m en rouleau.'],
                ['nom'=>'Disjoncteur bipolaire 16A','prix_vente'=>5500,'prix_achat'=>3000,'stock'=>40,'desc'=>'Disjoncteur modulaire 2P 16A courbe C. Pouvoir de coupure 6kA. Conforme NF C 61-410.'],
                ['nom'=>'Prise murale 2P+T 16A','prix_vente'=>2800,'prix_achat'=>1500,'stock'=>80,'desc'=>'Prise de courant 2 pôles + terre 16A. Finition blanc ivoire. Montage encastré ou en saillie.'],
                ['nom'=>'Interrupteur va-et-vient','prix_vente'=>2200,'prix_achat'=>1100,'stock'=>70,'desc'=>'Interrupteur va-et-vient 10A 250V. Bornes à vis, section 1.5-2.5mm². Boîtier blanc.'],
                ['nom'=>'Ampoule LED E27 12W','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>100,'desc'=>'Ampoule LED 12W équivalent 90W, culot E27. 1080 lumens, lumière blanche 4000K. Durée 25000h.'],
                ['nom'=>'Rallonge 5 prises 3m','prix_vente'=>6500,'prix_achat'=>3500,'stock'=>45,'desc'=>'Multiprises 5 prises 2P+T avec interrupteur et parafoudre. Câble 3m, 3G1.5mm². 3000W max.'],
                ['nom'=>'Gaine électrique IRL 20mm (3m)','prix_vente'=>1500,'prix_achat'=>750,'stock'=>80,'desc'=>'Conduit IRL 20mm gris annelé flexible. Protection câbles encastrés. Résistance choc IK7.'],
                ['nom'=>'Tableau électrique 12 modules','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>15,'desc'=>'Coffret de distribution 1 rangée 12 modules. Porte transparente, peigne 1P. Rail DIN.'],
                ['nom'=>'Détecteur de mouvement 180°','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>20,'desc'=>'Détecteur présence infrarouge 180°. Portée 12m. Temporisation 5-300s. Montage plafond/mur.'],
                ['nom'=>'Câble RJ45 Cat6 10m','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>30,'desc'=>'Cordon réseau RJ45 Cat6 blindé 10m. Débit 1Gbps. Gaine PVC bleue. Connecteurs dorés.'],
            ]],

            // ── 6. PEINTURE ───────────────────────────────────
            ['cat' => 'Peinture', 'icone' => 'ti-color-swatch', 'produits' => [
                ['nom'=>'Peinture acrylique blanche 5L','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>40,'desc'=>'Peinture intérieure acrylique blanc satin. 5 litres pour 50m². Séchage 2h, lavable.'],
                ['nom'=>'Sous-couche universelle 1L','prix_vente'=>7500,'prix_achat'=>4000,'stock'=>50,'desc'=>'Apprêt universel pour surfaces neuves et peintes. Accroche parfaite sur bois, métal, béton.'],
                ['nom'=>'Rouleau laine de mouton 23cm','prix_vente'=>2800,'prix_achat'=>1400,'stock'=>60,'desc'=>'Rouleau peinture laine naturelle 23cm pour murs et plafonds. Finition sans traces ni projections.'],
                ['nom'=>'Pinceau plat 80mm','prix_vente'=>1800,'prix_achat'=>900,'stock'=>80,'desc'=>'Pinceau queue de morue 80mm, soies naturelles. Idéal peinture glycéro et laque. Lavable.'],
                ['nom'=>'Bac à peinture avec grille','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>50,'desc'=>'Plateau peinture 30x40cm avec grille d\'essorage. Compatible rouleaux 23-33cm. Anti-éclaboussures.'],
                ['nom'=>'Ruban de masquage 25mm','prix_vente'=>1200,'prix_achat'=>600,'stock'=>100,'desc'=>'Masking tape 25mm x 50m. Adhésif repositionnable, ne décolle pas la peinture. UV resistant.'],
                ['nom'=>'Enduit de rebouchage 1kg','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>60,'desc'=>'Enduit plâtre en pâte pour rebouchage fissures et trous. Séchage 3h, ponçable. Pot 1kg.'],
                ['nom'=>'Laque satinée bois 1L','prix_vente'=>9500,'prix_achat'=>5500,'stock'=>35,'desc'=>'Laque alkyde satinée pour bois et fers. Protection longue durée. Séchage 24h. Teinte blanc pur.'],
                ['nom'=>'Brosse de peintre ronde n°8','prix_vente'=>2200,'prix_achat'=>1100,'stock'=>70,'desc'=>'Brosse ronde soies synthétiques n°8. Précision pour angles, boiseries et détails fins.'],
                ['nom'=>'Spatule de peintre inox 15cm','prix_vente'=>1500,'prix_achat'=>750,'stock'=>60,'desc'=>'Spatule enduit lame inox flexible 15cm. Manche caoutchouc, équilibrée. Application enduit.'],
            ]],

            // ── 7. QUINCAILLERIE GÉNÉRALE ─────────────────────
            ['cat' => 'Quincaillerie générale', 'icone' => 'ti-box', 'produits' => [
                ['nom'=>'Charnière acier 3" (paire)','prix_vente'=>2800,'prix_achat'=>1400,'stock'=>60,'desc'=>'Paire de charnières acier galvanisé 3 pouces pour portes intérieures. Livré avec vis.'],
                ['nom'=>'Serrure encastrée 3 points','prix_vente'=>18000,'prix_achat'=>10000,'stock'=>15,'desc'=>'Serrure 3 points cylindre 40+40mm. Avec 3 clés. Axe 92mm, entraxe 72mm. Anti-crochetage.'],
                ['nom'=>'Poignée de porte ronde (paire)','prix_vente'=>8500,'prix_achat'=>4800,'stock'=>25,'desc'=>'Paire poignées rondes chromées avec rosaces. Compatible portes 35-45mm. Avec vis de fixation.'],
                ['nom'=>'Cadenas 50mm acier','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>40,'desc'=>'Cadenas acier trempé 50mm, anse 25mm. 2 clés. Résistant à la coupe et aux intempéries.'],
                ['nom'=>'Colle époxy 5 minutes','prix_vente'=>3200,'prix_achat'=>1700,'stock'=>50,'desc'=>'Colle bi-composant époxy prise 5 min. 2 tubes 25ml. Adhésion métal, bois, pierre, céramique.'],
                ['nom'=>'Fil de fer galvanisé 1mm (50m)','prix_vente'=>3800,'prix_achat'=>2000,'stock'=>35,'desc'=>'Rouleau 50m fil de fer galvanisé Ø1mm. Usage ligature, grillage, attache. Résistant corrosion.'],
                ['nom'=>'Grillage plastifié 1x10m','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>20,'desc'=>'Rouleau grillage soudé vert plastifié, maille 50x50mm. Hauteur 1m, longueur 10m. Fil Ø2mm.'],
                ['nom'=>'Verrou de sûreté','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>30,'desc'=>'Verrou horizontal acier chromé avec bouton. Pêne carré 14mm. Montage facile, vis incluses.'],
                ['nom'=>'Équerre de fixation 50x50mm','prix_vente'=>800,'prix_achat'=>400,'stock'=>100,'desc'=>'Équerre plate zinguée 50x50mm. Épaisseur 1.5mm, 2 trous Ø5mm. Assemblage bois et métal.'],
                ['nom'=>'Crochet à visser 5mm (10pcs)','prix_vente'=>1500,'prix_achat'=>750,'stock'=>80,'desc'=>'Lot 10 crochets à visser galvanisés 5mm. Pour fixation câbles, outils, tableaux. Charge 5kg.'],
            ]],

            // ── 8. BOIS & PANNEAUX ────────────────────────────
            ['cat' => 'Bois & Panneaux', 'icone' => 'ti-trees', 'produits' => [
                ['nom'=>'Planche pin 200x20x2000mm','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Planche sciée pin sylvestre 200x20mm, longueur 2m. Séchée chambre, humidité <18%. Usage intérieur.'],
                ['nom'=>'Contreplaqué 10mm 122x244cm','prix_vente'=>25000,'prix_achat'=>15000,'stock'=>20,'desc'=>'Panneau contreplaqué bouleau 10mm, format 122x244cm. 7 plis, faces poncées. Usage mobilier.'],
                ['nom'=>'MDF 18mm 122x244cm','prix_vente'=>22000,'prix_achat'=>13000,'stock'=>18,'desc'=>'Panneau MDF Médium 18mm, format standard 122x244cm. Surface lisse, idéal pour peinture et plaquage.'],
                ['nom'=>'Tasseau épicéa 45x45mm (2m)','prix_vente'=>3500,'prix_achat'=>2000,'stock'=>50,'desc'=>'Tasseau carré épicéa 45x45mm, longueur 2m. Sec et équarri. Charpente légère, ossature.'],
                ['nom'=>'OSB 15mm 122x244cm','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>22,'desc'=>'Panneau OSB 3 15mm pour milieu humide. Format 122x244cm. Toiture, plancher, mur.'],
                ['nom'=>'Parquet flottant chêne 12mm','prix_vente'=>45000,'prix_achat'=>28000,'stock'=>15,'desc'=>'Carton 2.5m² parquet contrecollé chêne 12mm. Classe 32 AC4. Pose flottante, clipsable.'],
                ['nom'=>'Lambris PVC blanc 10cm (pack 10)','prix_vente'=>12000,'prix_achat'=>7500,'stock'=>30,'desc'=>'Pack 10 lames lambris PVC blanc 10cmx260cm. Épaisseur 8mm. Pose plafond et mur. Hydrofuge.'],
                ['nom'=>'Chevron 63x75mm (3m)','prix_vente'=>7500,'prix_achat'=>4500,'stock'=>25,'desc'=>'Chevron de charpente épicéa 63x75mm, longueur 3m. Sec raboté. Classe C24. Toiture et plancher.'],
                ['nom'=>'Panneau aggloméré 15mm 122x244cm','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>20,'desc'=>'Panneau particules mélaminé blanc 15mm. Format 122x244cm. Mobilier, agencement intérieur.'],
                ['nom'=>'Profil alu en U 20x20mm (3m)','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>40,'desc'=>'Profilé aluminium naturel en U 20x20mm, longueur 3m. Protection arêtes, finition joints.'],
            ]],

            // ── 9. CIMENT & MATÉRIAUX ─────────────────────────
            ['cat' => 'Ciment & Matériaux', 'icone' => 'ti-building', 'produits' => [
                ['nom'=>'Ciment Portland CEM II 50kg','prix_vente'=>12000,'prix_achat'=>8000,'stock'=>100,'desc'=>'Sac ciment Portland composé CEM II/B-L 32.5N, 50kg. Usage courant maçonnerie et béton armé.'],
                ['nom'=>'Sable fin de construction (sac 25kg)','prix_vente'=>3500,'prix_achat'=>2000,'stock'=>150,'desc'=>'Sable de rivière calibré 0/4mm, sac 25kg. Pour mortier, enduit et béton. Lavé et tamisé.'],
                ['nom'=>'Carrelage grès 30x30cm (m²)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>80,'desc'=>'Carrelage grès cérame gris 30x30cm, épaisseur 8mm. Résistance abrasion classe 4. Intérieur/extérieur.'],
                ['nom'=>'Colle carrelage C1 25kg','prix_vente'=>8000,'prix_achat'=>5000,'stock'=>60,'desc'=>'Mortier colle carrelage C1 gris, sac 25kg. Pour grès, faïence et mosaïque sur béton.'],
                ['nom'=>'Joint carrelage gris 5kg','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>50,'desc'=>'Coulis de jointoiement gris clair, sac 5kg. Joints 2-12mm. Résistant humidité et moisissures.'],
                ['nom'=>'Plaque de plâtre BA13 (2.5m²)','prix_vente'=>12000,'prix_achat'=>7500,'stock'=>30,'desc'=>'Plaque plâtre standard BA13 120x250cm. Pour cloisons et plafonds. Bord aminci. 13mm.'],
                ['nom'=>'Enduit de façade 25kg','prix_vente'=>9500,'prix_achat'=>5800,'stock'=>40,'desc'=>'Enduit monocouche fibré, sac 25kg. Finition grattée ou tyrolienne. Résistant gel/dégel.'],
                ['nom'=>'Imperméabilisant murs 5L','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>25,'desc'=>'Hydrofuge de façade silicone, bidon 5L. Traitement préventif infiltrations. 1 bidon = 25m².'],
                ['nom'=>'Isolant laine de verre 45mm (5m²)','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>20,'desc'=>'Rouleau laine de verre 45mm, surface 5m². Résistance thermique R=1.2. Pose murs et combles.'],
                ['nom'=>'Gravier 8/16mm sac 25kg','prix_vente'=>3500,'prix_achat'=>2000,'stock'=>120,'desc'=>'Gravier concassé calcaire 8/16mm, sac 25kg. Pour béton, drainage, voirie et décoration.'],
            ]],

            // ── 10. SÉCURITÉ & EPI ────────────────────────────
            ['cat' => 'Sécurité & EPI', 'icone' => 'ti-shield', 'produits' => [
                ['nom'=>'Casque de chantier blanc','prix_vente'=>8500,'prix_achat'=>4500,'stock'=>30,'desc'=>'Casque protection EN 397, HDPE blanc. Réglage roue, ventilation latérale. Classe E 1000V.'],
                ['nom'=>'Lunettes de protection','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>50,'desc'=>'Lunettes de sécurité EN 166 incolores. Monture polycarbonate, anti-rayures, anti-buée.'],
                ['nom'=>'Gants de travail taille L','prix_vente'=>2800,'prix_achat'=>1400,'stock'=>60,'desc'=>'Gants de manutention cuir synthétique. Renfort paume, poignet élastiqué. EN 388 3121.'],
                ['nom'=>'Masque anti-poussières FFP2','prix_vente'=>1500,'prix_achat'=>750,'stock'=>100,'desc'=>'Masque filtrant FFP2 NR sans valve. Protection poussières, aérosols. Boîte 5 pièces.'],
                ['nom'=>'Chaussures sécurité S3','prix_vente'=>25000,'prix_achat'=>15000,'stock'=>20,'desc'=>'Chaussures de sécurité S3 SRC cuir. Embout acier, semelle anti-perforation. Pointure 40-46.'],
                ['nom'=>'Harnais antichute simple','prix_vente'=>35000,'prix_achat'=>22000,'stock'=>8,'desc'=>'Harnais de sécurité EN 361. Dorsal + sternal. Charge 150kg. Avec longe absorbeur 1.75m.'],
                ['nom'=>'Gilet haute visibilité XL','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>40,'desc'=>'Gilet fluo jaune EN 471 classe 2. Bandes réfléchissantes 3M. 2 poches velcro. Taille XL.'],
                ['nom'=>'Protège-genoux','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>35,'desc'=>'Genouillères de travail EN 14404. Coussin gel double, réglage 3 points. Léger 350g/paire.'],
                ['nom'=>'Bouchons d\'oreilles (10 paires)','prix_vente'=>2500,'prix_achat'=>1200,'stock'=>80,'desc'=>'Bouchons oreilles mousse SNR 37dB, EN 352-2. Boîte 10 paires. Réduction 30dB pratique.'],
                ['nom'=>'Extincteur poudre 6kg','prix_vente'=>22000,'prix_achat'=>13000,'stock'=>15,'desc'=>'Extincteur ABC poudre 6kg. Pression 15 bars. Portée jet 6m. Conforme NF EN 3. 1 an garanti.'],
            ]],

            // ── 11. JARDINAGE ─────────────────────────────────
            ['cat' => 'Jardinage', 'icone' => 'ti-plant', 'produits' => [
                ['nom'=>'Tuyau d\'arrosage 25m 1/2"','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>25,'desc'=>'Tuyau arrosage renforcé 25m, diamètre 1/2". Résistance 15 bars. Raccords laiton inclus.'],
                ['nom'=>'Pelle ronde manche bois','prix_vente'=>7500,'prix_achat'=>4000,'stock'=>30,'desc'=>'Pelle ronde en acier forgé, manche bois hêtre verni. Longueur totale 110cm. Usage intensif.'],
                ['nom'=>'Fourche bêche 4 dents','prix_vente'=>9500,'prix_achat'=>5500,'stock'=>20,'desc'=>'Fourche bêche acier forgé 4 dents plates. Manche frêne 115cm. Travaux profonds.'],
                ['nom'=>'Brouette 90L acier','prix_vente'=>35000,'prix_achat'=>22000,'stock'=>10,'desc'=>'Brouette cuve acier galvanisée 90L. Châssis tube acier Ø22mm. Roue gonflable 3.5/4.00-8.'],
                ['nom'=>'Sécateur professionnel','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Sécateur de jardin à lame bypass forgée. Ouverture max 25mm, ergonomique. Avec étui.'],
                ['nom'=>'Râteau acier 14 dents','prix_vente'=>5500,'prix_achat'=>3000,'stock'=>30,'desc'=>'Râteau de jardin 14 dents acier, manche bois 130cm. Travail sol et gazon. Usage polyvalent.'],
                ['nom'=>'Désherbant total 5L','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>20,'desc'=>'Désherbant total herbicide glyphosate 360g/L, bidon 5L. Action systémique, 1L/100m².'],
                ['nom'=>'Engrais NPK 15-15-15 5kg','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Engrais polyvalent granulé NPK 15-15-15, sac 5kg. Pour pelouse, légumes et fleurs. Soluble.'],
                ['nom'=>'Lance d\'arrosage réglable','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>40,'desc'=>'Lance pistolet 7 fonctions (jet, brouillard, averse). Corps zinc, connexion 1/2". Réglable.'],
                ['nom'=>'Gants jardinage taille M','prix_vente'=>2200,'prix_achat'=>1100,'stock'=>50,'desc'=>'Gants de jardinage latex enduit dos coton. Taille M, doigts renforcés. Machine lavable.'],
            ]],

            // ── 12. SERRURERIE ────────────────────────────────
            ['cat' => 'Serrurerie', 'icone' => 'ti-lock', 'produits' => [
                ['nom'=>'Cylindre de serrure 30+30mm','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>25,'desc'=>'Cylindre européen laiton 30+30mm, 3 clés. Anti-arrachement, anti-perçage. Classe B.'],
                ['nom'=>'Serrure de portail','prix_vente'=>25000,'prix_achat'=>15000,'stock'=>12,'desc'=>'Serrure encastrée portail acier galvanisé. Pêne dormant + demi-tour. Clé carrée et cylindre.'],
                ['nom'=>'Groom ferme-porte surface','prix_vente'=>28000,'prix_achat'=>17000,'stock'=>8,'desc'=>'Ferme-porte automatique EN3 forces 2-4. Vitesse réglable, retardateur. Charge max 100kg.'],
                ['nom'=>'Paumelle réglable 3D 140mm','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Paumelle 3 axes réglable en 3D, acier nickelé 140mm. Porte jusqu\'à 80kg. Conforme CE.'],
                ['nom'=>'Boîte à clés mécanique','prix_vente'=>22000,'prix_achat'=>13000,'stock'=>10,'desc'=>'Coffre à clés mural, combinaison 4 chiffres. Code réinitialisable. Stockage 5 clés.'],
                ['nom'=>'Poignée béquille inox','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>20,'desc'=>'Béquille inox satiné, carré 8mm. Pour serrure entraxe 72mm. Plaque de propreté incluse.'],
                ['nom'=>'Verrou à clé double entrée','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Verrou double entrée 3 clés. Pêne dormant carré 14x14mm. Acier galvanisé, pose encastrée.'],
                ['nom'=>'Judas optique 200° laiton','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>30,'desc'=>'Judas de porte grand angle 200°, laiton doré. Ø14mm, épaisseur porte 35-55mm. HD.'],
                ['nom'=>'Chaîne de sécurité 120cm','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>25,'desc'=>'Chaîne de porte sécurité laiton, longueur 120mm. Vis inox incluses. Complément serrure.'],
                ['nom'=>'Bloque roue antivol U','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>15,'desc'=>'Antivol U acier trempé 120x220mm, Ø14mm. Cylindre haute sécurité 2 clés. Résistance coupe.'],
            ]],

            // ── 13. CHAUFFAGE & CLIMATISATION ─────────────────
            ['cat' => 'Chauffage & Clim', 'icone' => 'ti-temperature', 'produits' => [
                ['nom'=>'Ventilateur de table 40cm','prix_vente'=>22000,'prix_achat'=>13000,'stock'=>20,'desc'=>'Ventilateur oscillant 40cm, 3 vitesses, 60W. Minuterie 2h. Pied réglable 80-130cm. 45dB.'],
                ['nom'=>'Climatiseur split 1.5CV','prix_vente'=>350000,'prix_achat'=>220000,'stock'=>5,'desc'=>'Climatiseur réversible 1.5CV, 12000 BTU. Inverter A++. Installation + 5m de tuyauterie inclus.'],
                ['nom'=>'Radiateur électrique 2000W','prix_vente'=>95000,'prix_achat'=>60000,'stock'=>8,'desc'=>'Radiateur convecteur 2000W, thermostat électronique. Programmation hebdomadaire. Roues.'],
                ['nom'=>'Thermomètre digital','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Thermomètre hygromètre digital -50/+70°C. Écran LCD rétroéclairé. Alarme hi/lo. Pile incluse.'],
                ['nom'=>'Grille de ventilation 200x100mm','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>40,'desc'=>'Grille de ventilation ABS blanc 200x100mm avec volets orientables. Montage encastré.'],
                ['nom'=>'Tuyau d\'évacuation condensat','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>50,'desc'=>'Tube évacuation clim PVC flexible 16mm, longueur 3m. Résistant UV, coupe facile.'],
                ['nom'=>'Support climatiseur mural','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Support mural climatiseur 100kg max. Acier galvanisé, réglable. Pour unité extérieure.'],
                ['nom'=>'Filtre à air climatiseur','prix_vente'=>5500,'prix_achat'=>3000,'stock'=>35,'desc'=>'Filtre universel clim 30x28cm, polyester lavable. Filtration PM2.5. Lot de 2 filtres.'],
                ['nom'=>'Télécommande universelle clim','prix_vente'=>7500,'prix_achat'=>4500,'stock'=>25,'desc'=>'Télécommande universelle compatible 2000 modèles. LCD, modes Froid/Chaud/Ventil/Auto.'],
                ['nom'=>'Courroie de ventilateur','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>30,'desc'=>'Courroie trapézoïdale A56 universelle pour ventilateurs industriels. Caoutchouc haute résistance.'],
            ]],

            // ── 14. PISCINE & EAU ─────────────────────────────
            ['cat' => 'Piscine & Eau', 'icone' => 'ti-swimming', 'produits' => [
                ['nom'=>'Pompe de filtration 0.5CV','prix_vente'=>85000,'prix_achat'=>55000,'stock'=>8,'desc'=>'Pompe centrifuge filtration piscine 0.5CV, débit 6m³/h. Panier préfiltre, hors-gel. 220V.'],
                ['nom'=>'Chlore choc granulés 5kg','prix_vente'=>25000,'prix_achat'=>15000,'stock'=>20,'desc'=>'Chlore choc rapide 60%, granulés 5kg. Traitement curatif algues et bactéries. Dissolution rapide.'],
                ['nom'=>'Tuyau flexible piscine 38mm (3m)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Flexible armé 38mm pour piscine, longueur 3m. PVC spiralé, résistant pression 8 bars.'],
                ['nom'=>'Galet de chlore 200g (5kg)','prix_vente'=>28000,'prix_achat'=>17000,'stock'=>15,'desc'=>'Galets chlore lent 200g, seau 5kg. Dissolution 7 jours. Avec stabilisant, 90% chlore actif.'],
                ['nom'=>'Épuisette téléscopique 5m','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>12,'desc'=>'Épuisette fine pour piscine, manche télescopique 2.5-5m, alu. Filet 35x40cm nylon.'],
                ['nom'=>'Balai de fond piscine','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>15,'desc'=>'Brosse de fond piscine 45cm, monture ABS. Compatible manche télescopique 32/38mm.'],
                ['nom'=>'Testeur pH 3en1','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Testeur piscine mesure pH, chlore libre et acide iso. 50 tests de chaque. Instructions incluses.'],
                ['nom'=>'Anti-algues 1L','prix_vente'=>9500,'prix_achat'=>5800,'stock'=>18,'desc'=>'Algicide piscine 1L, action préventive et curative. Compatible tous types de piscines. 1L/50m³.'],
                ['nom'=>'Cartouche filtrante piscine','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>12,'desc'=>'Cartouche filtrante polyester 7", compatible Intex, Bestway. Filtration 10-15 microns.'],
                ['nom'=>'Pondoir flottant','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>20,'desc'=>'Distributeur flottant chlore/brome 25cm, débit réglable. Pour piscines 20-80m³.'],
            ]],

            // ── 15. TOITURE & ÉTANCHÉITÉ ──────────────────────
            ['cat' => 'Toiture & Étanchéité', 'icone' => 'ti-home', 'produits' => [
                ['nom'=>'Tôle ondulée galva 3m','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>30,'desc'=>'Tôle acier galvanisé 0.4mm, ondulation 18mm, longueur 3m. Pour toiture et bardage.'],
                ['nom'=>'Faîtière tôle galva 2m','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>40,'desc'=>'Faîtière tôle galvanisée 250mm développé, longueur 2m. Épaisseur 0.4mm. Finition naturelle.'],
                ['nom'=>'Membrane EPDM 1.2mm (1m²)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Membrane caoutchouc EPDM 1.2mm pour toiture-terrasse. Étanchéité parfaite -40/+120°C.'],
                ['nom'=>'Visses autoperçantes tôle (100pcs)','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>80,'desc'=>'Vis autoperçantes acier inox pour tôle 5.5x25mm. Tête hexagonale avec rondelle EPDM.'],
                ['nom'=>'Ruban aluminium 50mm (25m)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Ruban adhésif aluminium 50mm x 25m. Résistant chaleur -20/+120°C. Joint toiture et clim.'],
                ['nom'=>'Mousse polyuréthane 750ml','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>50,'desc'=>'Mousse expansive PU 750ml, densité 20kg/m³. Isolation, remplissage, fixation. Ø joint 6cm max.'],
                ['nom'=>'Bitume armé 4mm (rouleau 10m²)','prix_vente'=>28000,'prix_achat'=>17000,'stock'=>10,'desc'=>'Membrane bitumineuse SBS armée polyester 4mm. Rouleau 10m², pose à la flamme. Terrasse.'],
                ['nom'=>'Peinture anticorrosion 1L','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>25,'desc'=>'Peinture primaire anticorrosion rouge oxide 1L. Protection acier et métaux. Sèche 4h.'],
                ['nom'=>'Gouttière PVC beige 4m','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Demi-ronde PVC RAL 1001 beige Ø80mm, longueur 4m. Légère, résistante UV. Montage clips.'],
                ['nom'=>'Descente de gouttière PVC 3m','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>25,'desc'=>'Descente PVC Ø80mm, longueur 3m, RAL 1001. Emboîtable, résistant gel. Bague de liaison.'],
            ]],

            // ── 16. CHAÎNES & CÂBLES ──────────────────────────
            ['cat' => 'Chaînes & Câbles', 'icone' => 'ti-link', 'produits' => [
                ['nom'=>'Chaîne acier galva 6mm (5m)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Chaîne maillon court galvanisé Ø6mm. Charge de travail 700kg. Longueur 5m. Bobine.'],
                ['nom'=>'Câble acier 6mm (10m)','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>20,'desc'=>'Câble acier torsadé 6mm 7x7 fils galvanisé. Charge rupture 1550kg. 10m avec cosses.'],
                ['nom'=>'Manille droite 10mm','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>60,'desc'=>'Manille droite galvanisée Ø10mm, vis inox. WLL 1000kg. Pour assemblage câble/chaîne.'],
                ['nom'=>'Tendeur à crochet M10','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>40,'desc'=>'Tendeur de câble inox M10, longueur 180-290mm. Crochet+anneau. Charge travail 400kg.'],
                ['nom'=>'Élingue câble 2T 1m','prix_vente'=>15000,'prix_achat'=>9000,'stock'=>15,'desc'=>'Élingue câble simple 8mm, charge 2T, longueur 1m. Manchons sertis, extrémités anneau.'],
                ['nom'=>'Croche de levage 2T','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Crochet à verrou de sécurité 2T, acier galvanisé. Ouverture 17mm. Marquage CE.'],
                ['nom'=>'Anneau de levage M16','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>30,'desc'=>'Anneau de levage à vis M16, acier forgé traité. Charge max 2T verticale. Marquage WLL.'],
                ['nom'=>'Câble antivol spiral 8mm 1.5m','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>25,'desc'=>'Câble spiral PVC 8mm, longueur extensible 0.5-1.5m. 2 boucles. Pour vélos et équipements.'],
                ['nom'=>'Poulie simple Ø50mm','prix_vente'=>4500,'prix_achat'=>2500,'stock'=>30,'desc'=>'Poulie à chape galvanisée Ø50mm, gorge 8mm. Axe Ø10mm, charge 200kg. Roulement billes.'],
                ['nom'=>'Moufle 2 brins 1T','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>10,'desc'=>'Moufle de levage 2 brins 1 tonne. Poulies acier, câble 6mm. Démultiplication 2. Crochet.'],
            ]],

            // ── 17. ABRASIFS & CONSOMMABLES ───────────────────
            ['cat' => 'Abrasifs & Consommables', 'icone' => 'ti-sparkles', 'produits' => [
                ['nom'=>'Disque meulage acier 125mm (10pcs)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>40,'desc'=>'Boîte 10 disques abrasifs Ø125x6x22mm pour acier. Grain A30. Dépressé T27 jusqu\'à 12200rpm.'],
                ['nom'=>'Disque tronçonner 125mm (10pcs)','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>50,'desc'=>'Boîte 10 disques à tronçonner 125x1.0x22mm. Finition nette acier et inox. T41.'],
                ['nom'=>'Papier verre P80 (10 feuilles)','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>80,'desc'=>'Lot 10 feuilles papier abrasif corindon P80, 230x280mm. Pour bois, métal, enduit.'],
                ['nom'=>'Toile abrasive P100 (5m)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Rouleau 5m toile abrasive corindon P100, largeur 115mm. Flexible, déchirure résistante.'],
                ['nom'=>'Fil de coupe 2.4mm (15m)','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>45,'desc'=>'Fil nylon carré 2.4mm, longueur 15m pour débroussailleuse universelle. Résistant.'],
                ['nom'=>'Lame de scie sabre bois 150mm','prix_vente'=>2500,'prix_achat'=>1300,'stock'=>60,'desc'=>'Lame réciprocatoire 150mm pour bois avec clous. Bi-métal, 6 dents/pouce. Compatible Bosch/Makita.'],
                ['nom'=>'Foret béton SDS+ 10x260mm','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>35,'desc'=>'Foret carbure SDS+ Ø10x260mm pour béton et pierre. Queue 4 rainures. Tête plaquette TC.'],
                ['nom'=>'Meule de ponçage 60 grains','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>40,'desc'=>'Meule sur tige Ø50mm grain 60 pour touret. Oxyde alumine. Queue Ø6mm, 25mm largeur.'],
                ['nom'=>'Bandes abrasives 100x620mm P120 (10pcs)','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>30,'desc'=>'Lot 10 bandes de ponçage 100x620mm P120. Ponceuse à bandes. Grain corindon, couture renforcée.'],
                ['nom'=>'Disque fibre corindon 180mm P36','prix_vente'=>3200,'prix_achat'=>1700,'stock'=>45,'desc'=>'Disque fibre vulcanisé Ø180mm grain P36 pour dégrosissage métal. Support fibre robuste.'],
            ]],

            // ── 18. MANUTENTION & STOCKAGE ────────────────────
            ['cat' => 'Manutention & Stockage', 'icone' => 'ti-forklift', 'produits' => [
                ['nom'=>'Diable 2 roues 200kg','prix_vente'=>45000,'prix_achat'=>28000,'stock'=>10,'desc'=>'Diable acier 200kg, tube Ø40mm. Plateau bois 40x30cm. Roues gonflables 3.00-4. Pliable.'],
                ['nom'=>'Chariot plateforme 300kg','prix_vente'=>65000,'prix_achat'=>40000,'stock'=>6,'desc'=>'Chariot plateforme acier 300kg. Plateau 600x900mm. 4 roues PU Ø200mm pivotantes. Frein.'],
                ['nom'=>'Rayonnage métal 5 tablettes','prix_vente'=>55000,'prix_achat'=>35000,'stock'=>8,'desc'=>'Étagère métal 5 niveaux 80x40x180cm. Tablettes 200kg chacune. Réglables tous 7.5cm.'],
                ['nom'=>'Caisse plastique 60L','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>30,'desc'=>'Bac de rangement plastique 60L, 57x37x33cm. Empilable, couvercle optionnel. Coloris neutre.'],
                ['nom'=>'Sangle d\'arrimage 5m 250kg','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>40,'desc'=>'Sangle arrimage polyester 25mm x 5m, LC 250kg. Cliquet acier, crochet J. Norme EN 12195-2.'],
                ['nom'=>'Cric hydraulique 3T','prix_vente'=>35000,'prix_achat'=>22000,'stock'=>8,'desc'=>'Cric bouteille hydraulique 3T. Hauteur 195-380mm. Soupape de sécurité. Usage garage.'],
                ['nom'=>'Scotch d\'emballage transparent (6 rouleaux)','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>50,'desc'=>'Pack 6 rouleaux adhésif PP 48x66m. Transparent, résistant. Dispenser fourni. 38 microns.'],
                ['nom'=>'Palette bois 120x80cm','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Palette bois EURO 120x80cm 4 entrées. Charge statique 2T. Pin traité NIMP15. Réutilisable.'],
                ['nom'=>'Film étirable manuel 500m','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>25,'desc'=>'Film PVC étirable manuel 500m, largeur 500mm, épaisseur 23µ. Transparent, pré-étiré 200%.'],
                ['nom'=>'Balance poids lourds 300kg','prix_vente'=>55000,'prix_achat'=>35000,'stock'=>5,'desc'=>'Balance plateforme 300kg/100g. Plateau acier 30x40cm. Afficheur LCD. Piles ou secteur.'],
            ]],

            // ── 19. NETTOYAGE & ENTRETIEN ─────────────────────
            ['cat' => 'Nettoyage & Entretien', 'icone' => 'ti-wash', 'produits' => [
                ['nom'=>'Nettoyeur haute pression 130 bar','prix_vente'=>95000,'prix_achat'=>60000,'stock'=>6,'desc'=>'Nettoyeur HP 1800W, 130 bar, 380L/h. Lance rotative, brosse, jet crayon. Raccord auto.'],
                ['nom'=>'Dégraissant industriel 5L','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>25,'desc'=>'Dégraissant universel puissant 5L. Enlève huile, graisse, goudron. Biodégradable. Dilution 1/10.'],
                ['nom'=>'Balai industriel 60cm','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Balai brosse 60cm poils polypropylène résistants. Manche métal 140cm vissable. Usage intensif.'],
                ['nom'=>'Seau avec essoreuse 12L','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>15,'desc'=>'Seau essoreur 12L plastique PP. Presse-serpillière centrifuge. Compatible raclettes 25-50cm.'],
                ['nom'=>'Gants nitrile jetables L (100pcs)','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>40,'desc'=>'Boîte 100 gants nitrile bleus taille L. Épaisseur 0.1mm, sans poudre. EN 455. Ambidextres.'],
                ['nom'=>'Antirouille primaire 400ml','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>30,'desc'=>'Bombe antirouille primaire grise 400ml. Protection surfaces métalliques. Séchage 30min.'],
                ['nom'=>'Huile de coupe 1L','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Huile de coupe entière 1L. Lubrification et refroidissement usinage métal. Réducteur de chaleur.'],
                ['nom'=>'Serpillière microfibre 60cm','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>30,'desc'=>'Frange microfibre 60cm lavable 300 fois. Absorbe 6x son poids en eau. Manche universal.'],
                ['nom'=>'WD-40 lubrifiant 400ml','prix_vente'=>6500,'prix_achat'=>3800,'stock'=>35,'desc'=>'Dégrippant lubrifiant WD-40 spray 400ml. 5 fonctions : dégripe, lubrifie, protège, déplace eau.'],
                ['nom'=>'Distributeur papier essuie-mains','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>10,'desc'=>'Distributeur essuie-mains Z fold, inox 304 satiné. Capacité 200 feuilles. Serrure sécurité.'],
            ]],

            // ── 20. SIGNALISATION ─────────────────────────────
            ['cat' => 'Signalisation', 'icone' => 'ti-alert-triangle', 'produits' => [
                ['nom'=>'Panneau "Danger" 30x30cm','prix_vente'=>4500,'prix_achat'=>2400,'stock'=>30,'desc'=>'Signalétique danger triangulaire fond jaune 30x30cm. Aluminium 1mm, impression UV. Norme ISO.'],
                ['nom'=>'Cône de signalisation 75cm','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>25,'desc'=>'Cône de chantier PVC souple 75cm. Bandes réfléchissantes 7cm. Lestage sable. Empilable.'],
                ['nom'=>'Ruban de balisage rouge/blanc (100m)','prix_vente'=>3500,'prix_achat'=>1800,'stock'=>40,'desc'=>'Ruban plastique rouge/blanc 70mm x 100m. Balisage chantier et périmètre de sécurité.'],
                ['nom'=>'Panneau "Interdit de fumer"','prix_vente'=>3200,'prix_achat'=>1700,'stock'=>35,'desc'=>'Panneau signalisation Ø20cm "Interdit de fumer". Vinyle adhésif face + alu. Norme NF.'],
                ['nom'=>'Panneau sortie de secours','prix_vente'=>5500,'prix_achat'=>3200,'stock'=>20,'desc'=>'Signalisation sortie secours rétroéclairée 30x10cm. Autonomie 1h. Norme NF X 08-070.'],
                ['nom'=>'Miroir de sécurité Ø400mm','prix_vente'=>18000,'prix_achat'=>11000,'stock'=>10,'desc'=>'Miroir convexe angle mort Ø400mm, inox. Surveillance entrepôt et parkings. Fixation réglable.'],
                ['nom'=>'Extincteur poudre 2kg mural','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>15,'desc'=>'Extincteur ABC poudre 2kg avec support mural. Pression 15 bars. Homologué CE. Annuel.'],
                ['nom'=>'Détecteur de fumée NF','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Détecteur fumée optique certifié NF. Alarme 85dB. Pile 9V incluse. Durée vie 10 ans.'],
                ['nom'=>'Trousse de secours chantier','prix_vente'=>12000,'prix_achat'=>7000,'stock'=>15,'desc'=>'Trousse premiers secours 31 pièces. Conforme DIN 13157. Boîte plastique robuste 26x18cm.'],
                ['nom'=>'Barrière de sécurité rouge 1m','prix_vente'=>8500,'prix_achat'=>5000,'stock'=>20,'desc'=>'Barrière de chantier PVC rouge 1m x 1m. Emboîtable, légère 1.5kg. Signalisation zone danger.'],
            ]],
        ];

        foreach ($catalogue as $catData) {
            // Créer la catégorie
            $categorie = Categorie::updateOrCreate(
                ['boutique_id' => $boutique_id, 'nom' => $catData['cat']],
                [
                    'boutique_id' => $boutique_id,
                    'nom'         => $catData['cat'],
                    'slug'        => Str::slug($catData['cat']),
                    'icone'       => $catData['icone'],
                ]
            );

            // Créer les produits
            foreach ($catData['produits'] as $i => $p) {
                $produit = Produit::updateOrCreate(
                    ['boutique_id' => $boutique_id, 'nom' => $p['nom']],
                    [
                        'boutique_id'   => $boutique_id,
                        'categorie_id'  => $categorie->id,
                        'nom'           => $p['nom'],
                        'description'   => $p['desc'],
                        'prix_vente'    => $p['prix_vente'],
                        'prix_achat'    => $p['prix_achat'],
                        'promo'         => 0,
                        'stock_minimum' => 5,
                        'icone'         => $catData['icone'],
                        'visible'       => true,
                        'nouveau'       => $i < 3, // 3 premiers = nouveaux
                    ]
                );

                // Créer le stock
                Stock::updateOrCreate(
                    ['produit_id' => $produit->id],
                    ['quantite' => $p['stock']]
                );
            }

            echo "✅ {$catData['cat']} — 10 produits créés\n";
        }

        echo "\n🎉 200 produits créés avec succès !\n";
    }
}