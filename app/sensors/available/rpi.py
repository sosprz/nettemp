import vcgencmd
import io
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
sys.path.append(dir)
from local_nettemp import insert

def is_raspberry_pi(raise_on_errors=False):
    """Checks if Raspberry PI.

    :return:
    """
    try:
        with io.open('/proc/cpuinfo', 'r') as cpuinfo:
            found = False
            for line in cpuinfo:
                if line.startswith('Hardware'):
                    found = True
                    label, value = line.strip().split(':', 1)
                    value = value.strip()
                    if value not in (
                        'BCM2708',
                        'BCM2709',
                        'BCM2835',
                        'BCM2836'
                    ):
                        if raise_on_errors:
                            raise ValueError(
                                'This system does not appear to be a '
                                'Raspberry Pi.'
                            )
                        else:
                            return False
            if not found:
                if raise_on_errors:
                    raise ValueError(
                        'Unable to determine if this system is a Raspberry Pi.'
                    )
                else:
                    return False
    except IOError:
        if raise_on_errors:
            raise ValueError('Unable to open `/proc/cpuinfo`.')
        else:
            return False

    return True


IS_RASPBERRY_PI = is_raspberry_pi()

if IS_RASPBERRY_PI:
 value=(vcgencmd.measure_temp())
 rom = 'raspberrypi'
 type = 'temp'
 name = 'raspberrypi'
 data=insert(rom, type, value, name)
 data.request()




