import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:web_directory/models/personne.dart';

/// Widget qui permet d'afficher les details d'une personne
class PersonneDetails extends StatefulWidget {
  final Personne personne;

  const PersonneDetails({super.key, required this.personne});

  @override
  PersonneDetailsState createState() => PersonneDetailsState();
}

class PersonneDetailsState extends State<PersonneDetails> {

  /// Fonction qui permet d'envoyer un email
  Future<void> _launchEmail(String emailAddress) async {
    final Uri emailLaunchUri = Uri(
      scheme: 'mailto',
      path: emailAddress,
    );
    await launchUrl(emailLaunchUri);
  }

  /// Fonction qui permet de passer un appel 
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
        title: Text('${widget.personne.prenom} ${widget.personne.nom}',
         style: const TextStyle(
          fontSize: 25 ,
          fontFamily: 'ProximaNova-Medium',
          )),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ListView( /// Liste principale des informations d'une personne
          children: [
            CircleAvatar(
              radius: 50,
              backgroundImage: widget.personne.img.startsWith('http')
                ? NetworkImage(widget.personne.img)
                : AssetImage(widget.personne.img),
              onBackgroundImageError: (_, __) => const Icon(Icons.person, size: 50),
            ),
            const SizedBox(height: 15),
            /// Affichage du nom et prenom de la personne
            Text('${widget.personne.prenom} ${widget.personne.nom}',
              style: const TextStyle(
                fontSize: 30,
                fontFamily: 'ProximaNova-Bold',
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 20),
            /// Affichage de l'email de la personne
            ListTile(
              leading: const Icon(Icons.email, color: Colors.blue),
              title: Row(
                children: [
                  Expanded(
                    child: Text( widget.personne.mail, style: const TextStyle(fontSize: 16)))
                    ]),
              onTap: () => _launchEmail(widget.personne.mail),
            ),
            /// Affichage du numero de bureau de la personne
            ListTile(
              leading: const Icon(Icons.location_on, color: Colors.red),
              title: Text(
                widget.personne.numBureau.isNotEmpty ? widget.personne.numBureau : 'Numéro de bureau inconnu',
                style: const TextStyle(fontSize: 16),
              ),
            ),
            /// Affichage des departements de la personne
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.account_balance, color: Colors.green),
                  SizedBox(width: 16),
                  Text( 'Départements',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.departements /// parcours des departements
                    .map((departement) => Padding(
                      padding: const EdgeInsets.only(left: 50),
                      child: Text( '- $departement', style: const TextStyle(fontSize: 16)))
                    ).toList(),
              ),
            ),
            /// Affichage des services de la personne
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.work, color: Colors.orange),
                  SizedBox(width: 16),
                  Text( 'Services', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold))
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.services /// parcours des services
                    .map((service) => Padding(
                      padding: const EdgeInsets.only(left: 50),
                      child: Text( '- $service', style: const TextStyle(fontSize: 16)))
                    ).toList()
              ),
            ),
            /// Affichage des numeros de la personne
            ListTile(
              title: const Row(
                children: [
                  Icon(Icons.phone, color: Colors.teal),
                  SizedBox(width: 16),
                  Text( 'Numéros', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold))
                ],
              ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: widget.personne.numeros /// parcours des numeros
                    .map((numero) {
                      final String numeroText = numero.numero.isEmpty ? 'Numéro inconnu' : '${numero.libelle} : ${numero.numero}';
                      return Padding(
                        padding: const EdgeInsets.only(left: 35),
                        child: ListTile(
                          title: Text( '- $numeroText', style: const TextStyle(fontSize: 16)),
                          onTap: () {
                            if (numero.numero.isNotEmpty) {
                              _callPhone(numero.numero);
                            }
                          }));
                    }).toList(),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
