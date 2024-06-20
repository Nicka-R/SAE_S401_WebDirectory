import 'package:flutter/material.dart';
import 'package:web_directory/models/personne.dart';

/// Widget qui permet d'afficher la liste des departements d'une personne dans une preview
class PersonneListDepartements extends StatelessWidget {
  final Personne personne;

  const PersonneListDepartements({super.key, required this.personne});

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Text( 'Departements : ', style: TextStyle(
            fontSize: 14,
            color: Colors.grey[600],
            fontFamily: 'ProximaNova-Regular',
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(width: 4),
        /// Affichage des departements de la personne ici
        Text( personne.departements.join(', '), style: TextStyle(
            fontSize: 14,
            fontFamily: 'ProximaNova-Regular',
            color: Colors.grey[600],
          ),
        ),
      ],
    );
  }
}
