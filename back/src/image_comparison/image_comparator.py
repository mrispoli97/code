import os
from img2vec_keras import Img2Vec
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
from pprint import pprint


class Embedder:

    def __init__(self):
        self._model = Img2Vec()

    def get_embedding(self, image_path):
        try:
            x = self._model.get_vec(image_path)
            return x
        except Exception as e:
            print(f"Exception when trying to get embedding from {image_path}: {e}")
            return None


class ImageComparator:

    def __init__(self):
        self._embedder = Embedder()
        self._embeddings = []

    def __len__(self):
        return len(self._embeddings)

    def setup(self, image_paths):

        self._embeddings = []
        for image_path in image_paths:
            embedding = self._embedder.get_embedding(image_path)
            if embedding is not None:
                self._embeddings.append(embedding)
        if len(self._embeddings) == 0:
            raise Exception("Setup failed. Try with different images...")

    def _get_threshold(self):
        return 0.65

    def _get_similarity(self, embedding):
        similarity = np.mean([cosine_similarity([embedding], [reference])[0][0] for reference in self._embeddings])
        return similarity

    def compare(self, image_path):

        embedding = self._embedder.get_embedding(image_path)
        if embedding is None:
            return False

        return self._get_similarity(embedding) > self._get_threshold()


if __name__ == '__main__':
    BASE_DIR_PATH = r'C:\Users\mario\PycharmProjects\text-processing'
    IMAGE_DIR_PATH = os.path.join(BASE_DIR_PATH, 'downloaded')
    EMBEDDINGS_DIR_PATH = os.path.join(BASE_DIR_PATH, 'embeddings')
    images = os.listdir(IMAGE_DIR_PATH)

    img2vec = Img2Vec()
    embeddings = {}
    for image in images:
        image_path = os.path.join(IMAGE_DIR_PATH, image)
        x = img2vec.get_vec(image_path)
        embeddings[image] = x

    X = np.stack(list(embeddings.values()))
    Y = X
    similarity_matrix = cosine_similarity(X, Y)

    matrix = {}
    embeddings = list(embeddings.keys())

    for i in range(0, len(embeddings)):
        matrix[embeddings[i]] = {}
        print(f"{embeddings[i]}: {sum(similarity_matrix[i])}")
        for j in range(0, len(embeddings)):
            matrix[embeddings[i]][embeddings[j]] = similarity_matrix[i][j]

    pprint(matrix)
