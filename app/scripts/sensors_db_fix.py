import os

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
dir = dir+'/data/db/'

def main():
    for count, filename in enumerate(os.listdir(dir)):
        new = filename.replace('-','_')
        os.rename(dir+filename, dir+new)

main()

