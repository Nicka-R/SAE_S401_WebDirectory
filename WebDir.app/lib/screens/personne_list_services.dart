import 'package:flutter/material.dart';
import 'package:web_directory/models/personne.dart';

class PersonneListServices extends StatelessWidget {
  final Personne personne;
  const PersonneListServices({super.key, required this.personne});

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Text(
          'Services : ',
          style: TextStyle(
            fontSize: 14,
            color: Colors.grey[600],
            fontFamily: 'ProximaNova-Regular',
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(width: 4),
        Text(
          personne.services.join(', '),
          style: TextStyle(
            fontSize: 14,
            fontFamily: 'ProximaNova-Regular',
            color: Colors.grey[600],
          ),
        ),
      ],
    );
  }
}
