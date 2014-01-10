__author__ = 'mpetyx'

import json
from SPARQLWrapper import SPARQLWrapper, TURTLE


def query():

    subquery = """
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

    SELECT DISTINCT ?painting_name ?artist_name ?european_country
    WHERE {

    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.

{
      SELECT DISTINCT ?artist_name ?european_country ?painting_name
      WHERE
        {
          ?artist foaf:name ?artist_name.
    ?artist rdf:type dbpedia-owl:Artist.
    ?artist prop:placeOfBirth ?european_country.

       {
      SELECT ?painting_name
      WHERE
        {
         ?painting prop:artist ?artist.
    ?painting rdfs:label ?painting_name.
    ?painting prop:type dbpedia:Oil_painting.
    ?painting rdfs:comment ?description.

        }
GROUP BY ?painting_name
LIMIT 3

    }

        }
GROUP BY ?artist_name
LIMIT 2

    }







    }
        """

    sparql = SPARQLWrapper("http://dbpedia.org/sparql")


    sparql.setQuery(subquery)

    sparql.setReturnFormat(TURTLE)

    results = sparql.query().convert()

    for row in results:
        print row
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