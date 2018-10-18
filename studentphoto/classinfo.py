import re
import requests

resp = requests.get('http://jwzx.cqu.pt/kebiao/index.php')
resp = resp.text.replace('\n','').replace('\r','')
result = re.findall(r'(<div id="kbTabs-bj".+)<div id="kbTabs-kc"', resp)
print(result[0])