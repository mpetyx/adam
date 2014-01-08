__author__ = 'mpetyx'

import json
import re
import sys

from SPARQLWrapper import SPARQLWrapper, JSON
from django.conf import settings


# sys.path.append('./../dbpedia')
# from geoToCountry import getCountry



def mapJson(genre):

    superQuery = """

    PREFIX geo-pos:<http://www.w3.org/2003/01/geo/wgs84_pos#>
    PREFIX umbel-ac:<http://umbel.org/umbel/ac/>
    PREFIX sw-vocab:<http://www.w3.org/2003/06/sw-vocab-status/ns#>
    PREFIX ff:<http://factforge.net/>
    PREFIX music-ont:<http://purl.org/ontology/mo/>
    PREFIX dc-term:<http://purl.org/dc/terms/>
    PREFIX om:<http://www.ontotext.com/owlim/>
    PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    PREFIX pext:<http://proton.semanticweb.org/protonext#>
    PREFIX dc:<http://purl.org/dc/elements/1.1/>
    PREFIX onto:<http://www.ontotext.com/>
    PREFIX geo:<http://www.w3.org/2003/01/geo/wgs84_pos#>
    PREFIX foaf:<http://xmlns.com/foaf/0.1/>
    PREFIX yago:<http://mpii.de/yago/resource/>
    PREFIX xml:<http://www.w3.org/XML/1998/namespace>
    PREFIX umbel:<http://umbel.org/umbel#>
    PREFIX pkm:<http://proton.semanticweb.org/protonkm#>
    PREFIX wordnet16:<http://xmlns.com/wordnet/1.6/>
    PREFIX owl:<http://www.w3.org/2002/07/owl#>
    PREFIX dbpediaowl:<http://dbpedia.org/ontology/>
    PREFIX wordn-sc:<http://www.w3.org/2006/03/wn/wn20/schema/>
    PREFIX nytimes:<http://data.nytimes.com/>
    PREFIX dbp-prop:<http://dbpedia.org/property/>
    PREFIX geonames:<http://sws.geonames.org/>
    PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
    PREFIX dbpedia:<http://dbpedia.org/resource/>
    PREFIX oasis:<http://psi.oasis-open.org/iso/639/#>
    PREFIX geo-ont:<http://www.geonames.org/ontology#>
    PREFIX umbel-en:<http://umbel.org/umbel/ne/wikipedia/>
    PREFIX mo:<http://purl.org/ontology/mo/>
    PREFIX bbc-pont:<http://purl.org/ontology/po/>
    PREFIX lingvoj:<http://www.lingvoj.org/ontology#>
    PREFIX ourvocab:<http://example.org/>
    PREFIX psys:<http://proton.semanticweb.org/protonsys#>
    PREFIX umbel-sc:<http://umbel.org/umbel/sc/>
    PREFIX dbp-ont:<http://dbpedia.org/ontology/>

    SELECT DISTINCT ?s ?title ?listeners ?hits ?performer ?point ?date
    WHERE {
    ?s a mo:Track.
    ?s dc-term:title ?title.
    ?s ourvocab:has_listener_count ?listeners.
    ?s ourvocab:has_playcount ?hits.
    ?s ourvocab:has_releasedate ?date.
    ?s ourvocab:has_tag "%s".

    ?s mo:performer ?pid.

    ?pid foaf:name ?performer.

    ?pid dbp-ont:hometown ?hid.
    ?hid geo:geometry ?point.

    }
    """ % genre

    countQuery  = """
    SELECT (COUNT(*) AS ?count) WHERE { ?s ?p ?o}
    """

    sparql = SPARQLWrapper(settings.SERVER_URL)


    sparql.setQuery(superQuery)

    sparql.setReturnFormat(JSON)

    results = sparql.query().convert()



    finalized_json = {}



    # dumpData = open("kouklaki.json", "w")
    # json.dump(finalized_json, dumpData)
    #
    # dumpData.write(json.dumps(finalized_json))


    return json.dumps(finalized_json)


# mapJson("rock")