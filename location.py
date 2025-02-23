import socket

def get_ip_address(host):
    try:
        return socket.gethostbyname(host)
    except socket.gaierror:
        return None

website_name = "www.google.com"
ip_address = get_ip_address(website_name)

if ip_address is not None:
    print(f"IP Address: {ip_address}")
else:
    print(f"Unable to get IP Address")