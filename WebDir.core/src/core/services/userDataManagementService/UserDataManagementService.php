<?php

namespace web\directory\core\services\userDataManagementService;

use web\directory\core\services\userDataManagementService\UserDataManagementException;
use web\directory\core\domain\entities as Entities;

class UserDataManagementService implements UserDataManagementInterface
{
    /**
     * méthode addPerson : permet d'ajouter une personne
     */
    public function addPerson(array $values)
    {
        try {
            // Màj de la personne
            $new_person = new Entities\Personne();

            if (isset($values['nom']) && isset($values['prenom']) && isset($values['mail'])) {
                $new_person->nom = $values['nom'];
                $new_person->prenom = $values['prenom'];
                $new_person->mail = $values['mail'];
                $new_person->num_bureau = $values['num_bureau'] ?? '';
                $new_person->statut = 0;

                // Gestion de l'image
                    $photo = $values['files']['photo'];

                    // Chemin où les images seront stockées
                    $target_dir = BASE_PATH . "/src/user-img/";    // pas :    /var/www/html/public/user-img/Capture d’écran 2024-06-02 à 12.18.00.png
                    //$target_dir = __DIR__ . '/';                    // trouve : /var/www/html/src/core/services/userDataManagementService/Capture.png

                    $target_file = $target_dir . basename($photo->getClientFilename());

                    echo $target_file;

                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Vérifier si le fichier est une image réelle ou une fausse image
                    $check = getimagesize($photo->getStream()->getMetadata('uri'));
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;

                        throw new \Exception("Le fichier n'est pas une image.");
                    }

                    // Vérifier si le fichier existe déjà
                    if (file_exists($target_file)) {
                        $uploadOk = 0;

                        throw new \Exception("Désolé, le fichier existe déjà.");
                    }

                    // Limiter la taille du fichier (ici 5MB)
                    if ($photo->getSize() > 5000000) {
                        $uploadOk = 0;

                        throw new \Exception("Désolé, votre fichier est trop grand.");
                    }

                    // Autoriser certains formats de fichier
                    $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
                    if (!in_array($imageFileType, $allowedFileTypes)) {
                        $uploadOk = 0;

                        throw new \Exception("Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.");
                    }

                    // Vérifier si $uploadOk est défini à 0 par une erreur
                    if ($uploadOk == 0) {
                        throw new \Exception("Désolé, votre fichier n'a pas été uploadé.");
                    } else {
                        $photo->moveTo($target_file);
                        $new_person->img = $target_file;
                    }
                

                $new_person->save();

                // Màj des numéros mobile/fixe
                if (isset($values['numero_mobile'])) {
                    $new_numero = new Entities\Numero();
                    $new_numero->numero = $values['numero_mobile'];
                    $new_numero->id_perso = $new_person->id;
                    $new_numero->libelle = 'Mobile';
                    $new_numero->save();

                    if (isset($values['numero_fixe']) && $values['numero_fixe'] != '') {
                        $new_numero = new Entities\Numero();
                        $new_numero->numero = $values['numero_fixe'];
                        $new_numero->id_perso = $new_person->id;
                        $new_numero->libelle = 'Fixe';
                        $new_numero->save();
                    }
                }

                // Màj des départements
                if (isset($values['departements'])) {
                    $new_person->departement()->attach($values['departements']);
                }

                // Màj des services
                if (isset($values['services'])) {
                    $new_person->service()->attach($values['services']);
                }

                $new_person->save();
            }
        } catch (\Exception $e) {
            throw new UserDataManagementException("Erreur lors de l'ajout de la personne : " . $e->getMessage());
        }
    }
}
