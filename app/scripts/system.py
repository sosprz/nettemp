import psutil
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..')))
sys.path.append(dir)
from local_nettemp import insert

cpu=psutil.cpu_percent(percpu=False)
mem=psutil.virtual_memory().percent

rom='system_cpu'
type='system'
value=cpu
name='CPU'
data=insert(rom, type, value, name)
data.request()

rom='system_mem'
type='system'
value=mem
name='Memory'
data=insert(rom, type, value, name)
data.request()



