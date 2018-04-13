# d8-api-sample

This repo works using custom module named 'Custom Site configuration'.

Steps:
1. Enable the module. 
2. This provides a new field named 'Site API Key' in Site Configuration form at the bottom.
Path: /admin/config/system/site-information
3. Provides an API URL: /page_data/{apikey}/{nid}
e.g, /page_data/1234567/1
This API URL authenticates the user with the API Key sent in the URL.
Once the user is authenticated, it returns the node data with the node id passed in json format.

If the user is not authenticated,it will return access denied.If the node id is incorrect , it returns 'no data found' message.
