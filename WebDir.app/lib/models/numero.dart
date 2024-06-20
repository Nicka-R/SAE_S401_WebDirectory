/// Modèle de gestion d'un numéro de téléphone
class Numero {
  final String libelle;
  final String numero;

  Numero({required this.libelle, required this.numero});

  factory Numero.fromJson(Map<String, dynamic> json) {
    return Numero(
      libelle: json['libelle'],
      numero: json['numero'],
    );
  }
}
