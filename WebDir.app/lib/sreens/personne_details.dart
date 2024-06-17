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
  late Future<void> _fetchDetailsFuture;

  List<String> _services = [];

  @override
  void initState() {
    super.initState();
    _fetchDetailsFuture = _fetchDetails();
  }

  Future<void> _fetchDetails() async {
    List<String> services = await _service.servicesById(widget.personne.id);

    setState(() {
      _services = services;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('${widget.personne.prenom} ${widget.personne.nom}'),
      ),
      body: FutureBuilder<void>(
        future: _fetchDetailsFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Erreur: ${snapshot.error}'));
          } else {
            return Padding(
              padding: const EdgeInsets.all(16.0),
              child: ListView(
                children: [
                  CircleAvatar(
                    radius: 50,
                    backgroundImage: NetworkImage(widget.personne.img),
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
                  SizedBox(height: 10),
                  Text(
                    'Services:',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: _services
                        .map((service) => Text(
                              '- $service',
                              style: TextStyle(fontSize: 16),
                            ))
                        .toList(),
                  ),
                ],
              ),
            );
          }
        },
      ),
    );
  }
}
