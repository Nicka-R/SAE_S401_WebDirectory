import 'package:flutter/material.dart';
import 'package:WebDirectory/models/personne.dart';
import 'package:WebDirectory/service/personne_service.dart';

class PersonneDetails extends StatefulWidget {
  final Personne personne;

  PersonneDetails({super.key, required this.personne});

  @override
  _PersonneDetailsState createState() => _PersonneDetailsState();
}

class _PersonneDetailsState extends State<PersonneDetails> {
  final PersonneService _service = PersonneService();  

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('${widget.personne.prenom} ${widget.personne.nom}'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ListView(
          children: [
            CircleAvatar(
              radius: 50,
              backgroundImage: AssetImage('assets/images/icon.png'),
              onBackgroundImageError: (_, __) => Icon(Icons.person, size: 100),
            ),
            SizedBox(height: 20),
            Text(
              '${widget.personne.prenom} ${widget.personne.nom}',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              textAlign: TextAlign.center,
            ),
            SizedBox(height: 10),
            Text(
              'Email: ${widget.personne.mail}',
              style: TextStyle(fontSize: 18),
            ),
            SizedBox(height: 10),
            Text(
              'Numéro de Bureau: ${widget.personne.numBureau}',
              style: TextStyle(fontSize: 18),
            ),
            SizedBox(height: 10),
            Text(
              'Département:',
              style: TextStyle(fontSize: 18),
            ),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: widget.personne.departements
                  .map((departement) => Text(
                        '- $departement',
                        style: TextStyle(fontSize: 16),
                      ))
                  .toList(),
            ),
            SizedBox(height: 10),
            Text(
              'Services:',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: widget.personne.services
                  .map((service) => Text(
                        '- $service',
                        style: TextStyle(fontSize: 16),
                      ))
                  .toList(),
            ),
            SizedBox(height: 10),
            Text(
              'Numéros:',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: widget.personne.numeros
                  .map((numero) => Text(
                        '- $numero',
                        style: TextStyle(fontSize: 16),
                      ))
                  .toList(),
            ),
          ],
        ),
      ),
    );
  }
}

