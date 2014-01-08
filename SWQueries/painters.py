__author__ = 'mpetyx'

def query():
    """
    this query searches for oil painter artists for around the europe
    """

    superQuery = """

    PREFIX dbpedia-owl:<http://dbpedia.org/ontology/>
    PREFIX category: <http://dbpedia.org/resource/Category:>
    PREFIX dcterms:<http://purl.org/dc/terms/>
    PREFIX prop:<http://dbpedia.org/property/>
    PREFIX geonames:<http://sws.geonames.org/>
    PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
    PREFIX dbpedia:<http://dbpedia.org/resource/>
    PREFIX geo-ont:<http://www.geonames.org/ontology#>
    PREFIX ourvocab:<http://example.org/>

    SELECT DISTINCT ?artist_name ?painting_name ?european_country ?artist_birthday_year
    WHERE {

    ?artist prop:name ?artist_name.
    ?artist rdf:type dbpedia-owl:Artist.
    ?artist prop:placeOfBirth ?european_country.
    ?artist dbpedia-owl:birthDate ?artist_birthday.

    ?painting prop:artist ?artist.
    ?painting rdfs:label ?painting_name.
    ?painting prop:type dbpedia:Oil_painting.

    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.


     FILTER (lang(?painting_name) = "" || lang(?painting_name) = "en")
     BIND(year(?artist_birthday) AS ?artist_birthday_year)

    }
GROUP BY ?painting_name
LIMIT 200


    """

    return superQuery