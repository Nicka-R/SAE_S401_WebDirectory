import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:web_directory/models/personne.dart';

class PersonneDetails extends StatefulWidget {
  final Personne personne;

  const PersonneDetails({super.key, required this.personne});

  @override
  PersonneDetailsState createState() => PersonneDetailsState();
}

class PersonneDetailsState extends State<PersonneDetails> {
  Future<void> _launchEmail(String emailAddress) async {
    final Uri emailLaunchUri = Uri(
      scheme: 'mailto',
      path: emailAddress,
    );
    await launchUrl(emailLaunchUri);
  }

  Future<void> _callPhone(String phoneNumber) async {
    final Uri phoneCallUri = Uri(
      scheme: 'tel',
      path: phoneNumber,
    );
    await launchUrl(phoneCallUri);
  }

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
              backgroundImage: const AssetImage('assets/images/icon.png'),
              onBackgroundImageError: (_, __) => const Icon(Icons.person, size: 100),
            ),
            const SizedBox(height: 15),
            Text(
              '${widget.personne.prenom} ${widget.personne.nom}',
              style: const TextStyle(
                fontSize: 28,
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 20),
            ListTile(
              leading: const Icon(Icons.email, color: Colors.blue),
              title: Row(
                children: [
                  Expanded(
                    child: Text(
                      widget.personne.mail,
                      style: const TextStyle(fontSize: 16),
                    ),
                  ),
                ],
              ),
              onTap: () => _launchEmail(widget.personne.mail),
            ),
            ListTile(
              leading: const Icon(Icons.location_on, color: Colors.red),
              title: Text(
                widget.personne.numBureau.isNotEmpty ? widget.personne.numBureau : 'Numéro de bureau inconnu',
                style: const TextStyle(fontSize: 16),
              ),
            ),
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.account_balance, color: Colors.green),
                  SizedBox(width: 16),
                  Text(
                    'Départements',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.departements
                    .map((departement) => Padding(
                      padding: const EdgeInsets.only(left: 50),
                      child: Text(
                            '- $departement',
                            style: const TextStyle(fontSize: 16),
                          ),
                    ))
                    .toList(),
              ),
            ),
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.work, color: Colors.orange),
                  SizedBox(width: 16),
                  Text(
                    'Services',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.services
                    .map((service) => Padding(
                      padding: const EdgeInsets.only(left: 50),
                      child: Text(
                            '- $service',
                            style: const TextStyle(fontSize: 16),
                          ),
                    ))
                    .toList(),
              ),
            ),
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.phone, color: Colors.teal),
                  SizedBox(width: 16),
                  Text(
                    'Numéros',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.numeros
                    .map((numero) {
                      final String numeroText = numero.numero.isEmpty ? 'Numéro inconnu' : '${numero.libelle} : ${numero.numero}';
                      return Padding(
                        padding: const EdgeInsets.only(left: 35),
                        child: ListTile(
                          title: Text(
                            '- $numeroText',
                            style: const TextStyle(fontSize: 16),
                          ),
                          onTap: () {
                            if (numero.numero.isNotEmpty) {
                              _callPhone(numero.numero);
                            }
                          },
                        ),
                      );
                    })
                    .toList(),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
