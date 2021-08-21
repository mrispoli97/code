class Parser:

    def __init__(self):
        pass

    def get_image_urls(self, data):
        urls = {}
        for elem in data:
            asin = elem['asin']
            image = elem['image']
            if 'medium' in image:
                url = image['medium']
            elif 'large' in image:
                url = image['large']
            elif 'small' in image:
                url = image['small']
            else:
                continue
            urls[asin] = url
        return urls
