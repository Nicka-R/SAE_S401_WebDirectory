import 'package:WebDirectory/models/personne.dart';
import 'package:WebDirectory/service/personne_service.dart';
import 'package:flutter/material.dart';

class PersonneDepartement extends StatefulWidget {
  final Personne personne;
  final PersonneService personneService = PersonneService();
  PersonneDepartement({super.key, required this.personne});

  @override
  State<PersonneDepartement> createState() => _PersonneDepartementState();
}

class _PersonneDepartementState extends State<PersonneDepartement> {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder<String>(
      future: widget.personneService.departementById(widget.personne.id),
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return Text(
            'Chargement...',
            style: TextStyle(
              fontSize: 16,
              color: Colors.grey[600],
            ),
          );
        } else if (snapshot.hasError) {
          return Text(
            'Erreur : ${snapshot.error}',
            style: TextStyle(
              fontSize: 12,
              color: Colors.grey[600],
            ),
          );
        } else {
          final departement = snapshot.data!;
          return Text(
            'Département : $departement',
            style: TextStyle(
              fontSize: 14,
              color: Colors.grey[800],
              fontWeight: FontWeight.bold,
            ),
          );
        }
      },
    );
  }
}
