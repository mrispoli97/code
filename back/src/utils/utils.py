import json


def read_json(filepath):
    with open(filepath, 'r', encoding='utf-8') as json_file:
        data = json.load(json_file)
        return data


def save_json(filepath, data):
    with open(filepath, 'w') as f:
        json.dump(data, f, indent=4)
