import os
import json
import yake
import numpy as np
from pathlib import Path
from pprint import pprint
import shutil
from utils import utils
from image_download.image_download import ImageDownloader, GoogleImageDownloader
from image_comparison.image_comparator import ImageComparator
from parse.parse import Parser
from pprint import pprint
import yake
import os


class filterKeywordItems:

    def __init__(self):

        path = os.environ['JSON_PATH'] if 'JSON_PATH' in os.environ else '/var/www/files'
        self.path = path
        # set json directory
        Path(path + '/').mkdir(parents=True, exist_ok=True)

    def doStuff(self, data):

        parser = Parser()
        google_downloader = GoogleImageDownloader()
        image_downloader = ImageDownloader()
        image_comparator = ImageComparator()


        german_search = data['name']
        print("Search [de]: ", german_search)

        if not os.path.exists('tmp/reference'):
            os.makedirs('tmp/reference')
        reference_image_paths = google_downloader.search_and_download_images(german_search, dst='tmp/reference', max=5)

        image_urls = parser.get_image_urls(data['products']['active'])

        # TODO: check each product has an image
        if not os.path.exists('tmp/images'):
            os.makedirs('tmp/images')
        image_paths = image_downloader.download_images(
            urls=[url for url in image_urls.values()],
            dst='tmp/images',
            filenames=[asin + '.png' for asin in image_urls.keys()]
        )
        active_asins = []
        inactive_asins = []
        image_comparator.setup(reference_image_paths)
        for image_path in image_paths:
            _, name = os.path.split(image_path)
            asin, _ = os.path.splitext(name)

            if image_comparator.compare(image_path):
                active_asins.append(asin)
            else:
                inactive_asins.append(asin)

        active_products = []
        inactive_products = []

        for product in data['products']['active']:
            if product['asin'] in active_asins:
                active_products.append(product)
            else:
                inactive_products.append(product)

        data['products']['active'] = active_products
        data['products']['inactive'] = inactive_products

        shutil.rmtree('tmp')
        return data

    def getFileData(self):

        path = self.path + '/elektrokamin-anthrazit.json'
        data = utils.read_json(path)

        return data

    def writeFileData(self, data):

        path = self.path + '/elektrokamin-anthrazit-new.json'
        f = open(path, "w+")
        f.write(json.dumps(data))
        f.close()

        return

    def main(self):

        data = self.getFileData()

        if data:
            data = self.doStuff(data)
            self.writeFileData(data)

        return
