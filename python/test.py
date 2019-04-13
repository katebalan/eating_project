# importing the requests library
import requests
import random


URL = "application:80"
# URL = "127.0.0.1:8000"


def separator():
    print '*' * 10


GET_LIST_URL = "http://" + URL + "/api/product"
r = requests.get(url=GET_LIST_URL)
data = r.json()
for i in data:
    print("ID: %s\tNAME: %s"
          % (i['id'], i['name']))


separator()


testProduct = random.sample(data, 1)[0]
GET_ONE_URL = "http://" + URL + "/api/product/" + str(testProduct['id'])
r = requests.get(url=GET_ONE_URL)
data = r.json()
print("ID: %s\tNAME: %s"
          % (data['id'], data['name']))


separator()


PUT_ONE_URL = "http://" + URL + "/api/product/" + str(testProduct['id'])
params = {
    'name': data['name'] + ' ' + str(random.randrange(0, 101))
}
r = requests.put(url=PUT_ONE_URL, data=params)
data = r.json()
print(data)


separator()


r = requests.get(url=GET_ONE_URL)
data = r.json()
print("ID: %s\tNAME: %s"
          % (data['id'], data['name']))


separator()


params = {
    'name': testProduct['name']
}
r = requests.put(url=PUT_ONE_URL, data=params)
data = r.json()
print(data)


separator()


r = requests.get(url=GET_ONE_URL)
data = r.json()
print("ID: %s\tNAME: %s"
          % (data['id'], data['name']))
