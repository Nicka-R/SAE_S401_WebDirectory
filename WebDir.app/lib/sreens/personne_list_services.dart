import 'package:WebDirectory/models/personne.dart';
import 'package:WebDirectory/service/personne_service.dart';
import 'package:flutter/material.dart';


class PersonneListServices extends StatefulWidget {
  final Personne personne;
  final PersonneService personneService = PersonneService();
  PersonneListServices({super.key, required this.personne});

  @override
  State<PersonneListServices> createState() => _PersonneListServicesState();
}

class _PersonneListServicesState extends State<PersonneListServices> {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<String>>(
      future: widget.personneService.serviceById(widget.personne.id),
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
            ' 4 ${snapshot.error}',
            style: TextStyle(
              fontSize: 12,
              color: Colors.grey[600],
            ),
          );
        } else {
          final services = snapshot.data!;
          return Row(
            children:[
              Text(
                'Services : ',
                style: TextStyle(
                  fontSize: 12,
                  color: Colors.grey[600],
                  fontWeight: FontWeight.bold,
                ),
              ),
              ...services.map((service) => Text(
                '$service ',
                style: TextStyle(
                  fontSize: 12,
                  color: Colors.grey[600],
                ),
              ))
            ],
          );
        }
      },
    );
  }
}