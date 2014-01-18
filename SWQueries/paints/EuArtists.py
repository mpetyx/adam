__author__ = 'mpetyx'

import json
from SPARQLWrapper import SPARQLWrapper, TURTLE


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
    prefix foaf:<http://xmlns.com/foaf/0.1/>

    SELECT DISTINCT ?artist_name ?european_country ?description ?artist_birthday_year
    WHERE {

    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.

    ?artist foaf:name ?artist_name.
    ?artist rdf:type dbpedia-owl:Artist.
    ?artist prop:placeOfBirth ?european_country.
    ?artist dbpedia-owl:birthDate ?artist_birthday.
    ?artist rdfs:comment ?description.


     FILTER (lang(?artist_name) = "" || lang(?artist_name) = "en")
     FILTER (lang(?description) = "" || lang(?description) = "en")
     BIND(year(?artist_birthday) AS ?artist_birthday_year)

    }
    #GROUP BY ?painting_name
    #HAVING (COUNT(?european_country) = 2)
    LIMIT 200


    """

    superQuery2 = """

     PREFIX dbpedia-owl:<http://dbpedia.org/ontology/>
    PREFIX category: <http://dbpedia.org/resource/Category:>
    PREFIX dcterms:<http://purl.org/dc/terms/>
    PREFIX prop:<http://dbpedia.org/property/>
    PREFIX geonames:<http://sws.geonames.org/>
    PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
    PREFIX dbpedia:<http://dbpedia.org/resource/>
    PREFIX geo-ont:<http://www.geonames.org/ontology#>
    PREFIX ourvocab:<http://example.org/>
    prefix foaf:<http://xmlns.com/foaf/0.1/>

    SELECT DISTINCT ?artist_name ?european_country ?description ?artist_birthday_year
    WHERE {

    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.

    ?artist foaf:name ?artist_name.
    ?artist rdf:type dbpedia-owl:Artist.
    ?artist prop:placeOfBirth ?european_country.
    ?artist dbpedia-owl:birthDate ?artist_birthday.
    ?artist rdfs:comment ?description.


     FILTER (lang(?artist_name) = "" || lang(?artist_name) = "en")
     FILTER (lang(?description) = "" || lang(?description) = "en")
     BIND(year(?artist_birthday) AS ?artist_birthday_year)

     FILTER ( COUNT(?european_country)<5)

    }
    #GROUP BY ?painting_name
    #HAVING (COUNT(?european_country) = 2)
    LIMIT 200


    """

    sparql = SPARQLWrapper("http://dbpedia.org/sparql")


    sparql.setQuery(superQuery2)

    sparql.setReturnFormat(TURTLE)

    results = sparql.query().convert()

    print results
    # finalized_json = {}
    #
    #
    #
    # dumpData = open("kouklaki.json", "w")
    # json.dump(finalized_json, dumpData)
    #
    # dumpData.write(json.dumps(finalized_json))


    # return json.dumps(finalized_json)
    #
    # return superQuery

query()