from elasticsearch import Elasticsearch
from flask import Flask

app = Flask(__name__)
es = Elasticsearch()


@app.route('/')
def main():
    template = ''
    res = es.search(index="users", body={"query": {"match_all": {}}})
    for hit in res['hits']['hits']:
        template += "<a href='/user/{username}'>{username}</a></br>".format(username=hit['_source']['username'])
    return template


@app.route('/user/<username>')
def profile_view(username):
    template = ''

    res = es.search(index="users", body={
        "query": {
            "query_string": {
                "fields": ["username"],
                "query": username
            }
        }
    })
    
    for hit in res['hits']['hits']:
        template += "Username: {username}</br>".format(username=hit['_source']['username'])
        template += "Email: {email}</a></br>".format(email=hit['_source']['email'])
        return template
    return 'No user found'
