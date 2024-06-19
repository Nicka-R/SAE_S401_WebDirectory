import 'package:WebDirectory/screens/personne_details.dart';
import 'package:WebDirectory/screens/personne_list_departements.dart';
import 'package:WebDirectory/screens/personne_list_services.dart';
import 'package:flutter/material.dart';
import 'package:WebDirectory/models/personne.dart';

class PersonnePreview extends StatefulWidget {
  final Personne personne;
  const PersonnePreview({super.key, required this.personne});

  @override
  State<PersonnePreview> createState() => _PersonnePreviewState();
}

class _PersonnePreviewState extends State<PersonnePreview> {
  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      child: Card(
        elevation: 4,
        margin: const EdgeInsets.symmetric(vertical: 10, horizontal: 15),
        child: Padding(
          padding: const EdgeInsets.all(15),
          child: Row(
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '${widget.personne.prenom} ${widget.personne.nom}',
                    style: const TextStyle(
                      fontFamily: 'ProximaNova-Medium',
                      fontSize: 18,
                    ),
                  ),
                  const SizedBox(height: 8),
                  PersonneListServices(personne: widget.personne),
                  const SizedBox(height: 8),
                  PersonneListDepartements(personne: widget.personne),
                ],
              ),
            ],
          ),
        ),
      ),
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => PersonneDetails(personne: widget.personne),
          ),
        );
      },
    );
  }
}
