import 'package:WebDirectory/models/personne.dart';
import 'package:WebDirectory/service/personne_service.dart';
import 'package:WebDirectory/sreens/personne_preview.dart';
import 'package:flutter/material.dart';

class PersonneMaster extends StatefulWidget {
  PersonneMaster({super.key});

  @override
  State<PersonneMaster> createState() => _PersonneMasterState();
}

class _PersonneMasterState extends State<PersonneMaster> {
  final PersonneService _personneService = PersonneService();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
      ),
      body: FutureBuilder<List<Personne>>(
        future: _personneService.fetchPersonnes(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Erreur: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('Aucune personne disponible'));
          } else {
            return ListView(
              children: _personneService.personnes.map((personne) {
                return PersonnePreview(personne: personne);
              }).toList(),
            );
          }
        },
      ),
    );
  }
}
