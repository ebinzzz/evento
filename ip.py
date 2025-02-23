import time
from geopy.geocoders import Nominatim

geolocator = Nominatim(user_agent="my-app")

def get_location(ip_address):
    try:
        location = geolocator.geocode(ip_address)
        if location:
            return {
                "city": location.address.split(", ")[-3],
                "region": location.address.split(", ")[-2].replace(" ", ""),
                "country": location.address.split(", ")[-1],
                "latitude": location.latitude,
                "longitude": location.longitude
            }
        else:
            return None
    except geopy.exc.GeocoderInsufficientPrivileges:
        print("Rate limit exceeded, waiting 3 seconds before trying again.")
        time.sleep(3)
        return get_location(ip_address)
    except Exception as e:
        print(f"Unexpected error: {e}")
        return None

print(get_location("142.250.196.164"))