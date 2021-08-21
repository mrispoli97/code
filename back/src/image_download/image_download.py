from pprint import pprint
import requests
import os
from urllib.parse import urlparse
from serpapi import GoogleSearch
from utils import utils


class ImageDownloader:

    def __init__(self):
        pass

    def _get_image(self, url):
        response = requests.get(url)
        content = response.content
        return content

    def download_images(self, urls, dst, filenames):
        image_paths = []
        assert (len(urls) == len(filenames))
        for i in range(0, len(urls)):
            url = urls[i]
            filename = filenames[i]
            image_path = self.download_image(url=url, dst=dst, filename=filename)
            if image_path:
                image_paths.append(image_path)
        return image_paths

    def download_image(self, url, dst, filename):
        try:
            img = self._get_image(url)
        except Exception as e:
            print(f"Exception while downloading {url}: {e}")
            return None
        img_path = os.path.join(dst, filename)
        if not os.path.exists(img_path):
            if not os.path.exists(dst):
                os.makedirs(dst)
            with open(img_path, "wb") as file:
                file.write(img)
        return img_path


class GoogleImageDownloader(ImageDownloader):

    def __init__(self, key=None):
        self._key = key if key else '070417290fa84990960719c96dbb7ed089b8431c630096794ffe3b9e8e30447f'

    def search_images(self, text):
        search = GoogleSearch({
            "q": text,
            "api_key": self._key
        })
        result = search.get_dict()

        # utils.save_json(os.path.join(BASE_URL, 'googleAPi', text+" - result.json"), result)
        # result = utils.read_json(
        #     os.path.join(os.path.dirname(os.path.realpath(__file__)), "elektrokamin anthrazit - result.json"))
        images = result['inline_images']
        return ["https://www.google.com" + image['link'] for image in images], [image['thumbnail'] for image in images]

    def search_and_download_images(self, text, dst, max=None):
        image_paths = []
        links, thumbnails = self.search_images(text)
        thumbnails = [thumbnail for thumbnail in thumbnails if urlparse(thumbnail).netloc == 'serpapi.com']
        num_downloaded = len(os.listdir(dst))

        for i in range(0, len(thumbnails)):
            # link = links[i]
            thumbnail = thumbnails[i]
            _, filename = os.path.split(thumbnail)

            try:
                image_path = os.path.join(dst, filename)
                image_paths.append(image_path)
                if not os.path.exists(image_path):
                    self.download_image(thumbnail, dst, filename)
                num_downloaded += 1

            except Exception as e:
                print(e)
                continue

        return image_paths
