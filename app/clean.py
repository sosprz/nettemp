import re

class clean:
  def __init__(self,val):
    self.val = val

  def clean_rom(self):
    val = self.val.replace('-','_')
    val = re.sub(r'[^A-Za-z0-9_]+', '', val)
    return val

  def clean_name(self):
    val = re.sub(r'[^A-Za-z0-9_.-]+', '', self.val)
    return val

  def clean_value(self):
    val = self.val.replace(',','.')
    val = re.sub(r'[^0-9.]+', '', self.val)
    return val