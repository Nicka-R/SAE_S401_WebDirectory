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
                $new_person->save();

                // Gestion de l'image
                if (isset($values['files']['photo'])) {
                    $photo = $values['files']['photo'];
            
                    // Chemin où les images seront stockées
                    $target_dir = BASE_PATH . "/src/user-img/";
                    $imageFileType = strtolower(pathinfo($photo->getClientFilename(), PATHINFO_EXTENSION));
                    $target_file = $target_dir . 'user_image_' . $new_person->id . '.' . $imageFileType;
            
                    $uploadOk = 1;
            
                    // Vérification des contraintes sur le fichier
                    $check = getimagesize($photo->getStream()->getMetadata('uri'));
                    if ($check === false) {
                        $uploadOk = 0;
                        throw new \Exception("Le fichier n'est pas une image.");
                    }
            
                    if ($photo->getSize() > 5000000) {
                        $uploadOk = 0;
                        throw new \Exception("Désolé, votre fichier est trop grand.");
                    }
            
                    $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
                    if (!in_array($imageFileType, $allowedFileTypes)) {
                        $uploadOk = 0;
                        throw new \Exception("Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.");
                    }
            
                  
                    $photo->moveTo($target_file);
                    $new_person->img = htmlspecialchars('user_image_' . $new_person->id . '.' . $imageFileType);
                    
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
