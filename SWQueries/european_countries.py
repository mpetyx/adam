__author__ = 'mpetyx'

def query():

    query = """

    PREFIX dbpedia-owl:<http://dbpedia.org/ontology/>
    PREFIX category: <http://dbpedia.org/resource/Category:>
    PREFIX dcterms:<http://purl.org/dc/terms/>
    PREFIX prop:<http://dbpedia.org/property/>
    PREFIX geonames:<http://sws.geonames.org/>
    PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
    PREFIX dbpedia:<http://dbpedia.org/resource/>
    PREFIX geo-ont:<http://www.geonames.org/ontology#>
    PREFIX ourvocab:<http://example.org/>

    SELECT  ?european_country ?description
    WHERE {


    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.
    ?european_country rdfs:comment ?description

    FILTER (lang(?description) = "" || lang(?description) = "en")

    }
LIMIT 200
"""

