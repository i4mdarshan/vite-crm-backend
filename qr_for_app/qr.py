import pyqrcode 
from pyqrcode import QRCode

link = "https://anjaligroups.co.in/crm-web-app/login"

url = pyqrcode.create(link)
url.svg("Anjali_Chemicals_CRM.svg", scale = 8)