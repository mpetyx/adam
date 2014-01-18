__author__ = 'mpetyx'


"""
find books by european writers over the centruries and bookreads reading
something similar to:
https://www.google.gr/search?q=books+of+asimov&oq=books+of+asim&aqs=chrome.1.69i57j0l5.4540j0j7&sourceid=chrome&espv=210&es_sm=119&ie=UTF-8#es_sm=119&espv=210&q=robots+and+empire&stick=H4sIAAAAAAAAAGOovnz8BQMDgzYHsxCHfq6-gXFRhaUSJ4hlWFxVlq4l4FhakpFfFJLvlJ-f7Z-XU-nA8K9qr8IWPvMdF-dlLW-3XpcsbDT_FgAq8Ba5SAAAAA
"""

import json
from SPARQLWrapper import SPARQLWrapper, TURTLE


def query():

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
    prefix skos: <http://www.w3.org/2004/02/skos/core#>

    SELECT DISTINCT ?book_name ?author_name ?european_country ?description ?author_birthday_year
    WHERE {

    ?european_country dcterms:subject category:Countries_in_Europe.
    ?european_country rdf:type dbpedia-owl:Place.

    ?book prop:author ?author.
    ?book rdfs:label ?book_name.
    ?book rdf:type dbpedia-owl:Book.
    ?book rdfs:comment ?description.

    ?author foaf:name ?author_name.
    ?author rdf:type dbpedia-owl:Artist;
            a  dbpedia-owl:Writer.
    ?author prop:placeOfBirth ?european_country.
    ?author dbpedia-owl:birthDate ?author_birthday.

    # category of literature
    # ?author skos:subject dbpedia:Popular_science.


     FILTER (lang(?book_name) = "" || lang(?book_name) = "en")
     FILTER (lang(?description) = "" || lang(?description) = "en")
     BIND(year(?author_birthday) AS ?author_birthday_year)

    }
    #GROUP BY ?book_name
    #HAVING (COUNT(?european_country) = 2)
    OFFSET 300
    LIMIT 200



    """

    sparql = SPARQLWrapper("http://dbpedia.org/sparql")


    sparql.setQuery(superQuery)

    sparql.setReturnFormat(TURTLE)

    results = sparql.query().convert()

    print results

    # for row in results:
    #     print row
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